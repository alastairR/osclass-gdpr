<?php

class OsclassGdprAdmin {
    public function __construct()
    {
        $route = Params::getParam('route');

        osc_add_route('gdpr-admin-dashboard', 'gdpr/admin/dashboard', 'gdpr/admin/dashboard', osc_plugin_folder(__DIR__) . 'admin/dashboard.php');
        osc_add_route('gdpr-admin-settings', 'gdpr/admin/settings', 'gdpr/admin/settings', osc_plugin_folder(__DIR__) . 'admin/settings.php');
        osc_add_route('gdpr-admin-erasure', 'gdpr/admin/erasure', 'gdpr/admin/erasure', osc_plugin_folder(__DIR__) . 'admin/erasure.php');
        osc_add_route('gdpr-admin-portability', 'gdpr/admin/portability', 'gdpr/admin/portability', osc_plugin_folder(__DIR__) . 'admin/portability.php');
        osc_add_route('gdpr-user-email', 'gdpr/user/email', 'gdpr/user/email', osc_plugin_folder(__DIR__) . 'admin/email.php');

        osc_add_hook('add_admin_toolbar_menus', array(&$this, 'add_menu_toolbar'));
        osc_add_filter('admin_title', array(&$this, 'plugin_title'));

        osc_add_hook('init_admin', function(){
            osc_add_admin_submenu_divider('plugins', __('GDPR', 'gdpr'), 'gdpr_div');
            osc_admin_menu_plugins(__('&raquo; Settings', 'gdpr'), osc_route_admin_url('gdpr-admin-dashboard'), 'settings_gdpr');
        }); 

        if(substr($route,0,5) == 'gdpr-') { 
            osc_add_hook('admin_header',        array(&$this, 'init_pageHeader') );
            osc_add_filter('admin_body_class',  array(&$this, 'body_class') );
            osc_add_hook('init_admin',          array(&$this, 'handleForm') );
            
        }
    }

    function add_menu_toolbar() {
        $title = '<i class="bi bi-envelope"></i> ' . __('GDPR', 'gdpr');
        AdminToolbar::newInstance()->add_menu(
                array('id' => 'gdpr',
                    'title' => $title,
                    'href' => osc_route_admin_url('gdpr-user-email'),
                    'meta' => array('class' => 'action-btn action-btn-black')
                )
        );
    }

    function plugin_title($title) {
        switch (Params::getParam('route')) {
            case 'gdpr-admin-dashboard':
                osc_remove_filter('admin_title', 'customPageTitle');
                $title = __('GDPR Options', 'gdpr');
                break;
            case 'gdpr-user-email':
                osc_remove_filter('admin_title', 'customPageTitle');
                $title = __('GDPR email', 'gdpr');
                break;
        }
        return $title;
    }

    function init_pageHeader() {
        osc_remove_hook('admin_page_header', 'customPageHeader');
        
        switch (Params::getParam('route')) {
            case 'gdpr-admin-dashboard':
            case 'gdpr-admin-settings':
            case 'gdpr-admin-erasure':
            case 'gdpr-admin-portability':
                osc_add_hook('admin_page_header', array(&$this,'customPageHeader_settings'), 9); 
                break;
            case 'gdpr-user-email':
                osc_add_hook('admin_page_header', array(&$this,'customPageHeader_email'), 9); 
                break;
        }
    }

    function customPageHeader_email() {
    ?>
        <h1><?php _e('GDPR user email', 'gdpr'); ?></h1>
    <?php
    }

    function customPageHeader_settings() {
    ?>
        <h1><?php _e('GDPR', 'gdpr'); ?></h1>
    <?php
        @include(OSCLASS_GDPR_PATH . 'admin/header.php');
    }

    function body_class($array){
        $array[] = 'market';
        return $array;
    }

    function handleForm() {
        if(!osc_is_admin_user_logged_in()) {
            return false;
        }

        $route = Params::getParam('route');

        $file = Params::getParam("file");


        if(Params::getParam('paction')=='download') {
            switch ($route) {    
                case 'gdpr-admin-portability':                    
                    $user_id = Params::getParam('user_id');
                    if(!is_numeric($user_id) || $user_id == "") {
                        osc_add_flash_error_message(__('Required: User id', 'gdpr'), 'admin');
                        osc_redirect_to(osc_route_admin_url('gdpr-admin-portability'));    
                    } 

                    $return = OsclassGdpr::newInstance()->dump_user_data($user_id);
                    if($return['success']) {
                        osc_add_flash_ok_message( $return['msg'] , "admin");
                    } else {
                        osc_add_flash_error_message( $return['msg'] , "admin");
                    }

                    osc_redirect_to(osc_route_admin_url('gdpr-admin-portability'));
                    break;
                default:
                    # code...
                    break;
            }
        }
        if(Params::getParam('paction')=='submit') {
            switch ($route) {
                case 'gdpr-admin-settings':                    
                    $gdpr_enabled = Params::getParam('gdpr_enabled');
                    if($gdpr_enabled=="1") {
                        osc_set_preference('gdpr_enabled', "1", 'gdpr');
                    } else {
                        osc_set_preference('gdpr_enabled', "0", 'gdpr');
                    }

                    $terms_is_page = Params::getParam('terms_is_page');
                    if($terms_is_page=="1") {
                        $terms_page = Params::getParam('select_terms_page');
                    } else {
                        $terms_page = Params::getParam('terms_link');
                    }
                    osc_set_preference('terms_page', $terms_page, 'gdpr');

                    $privacy_is_page = Params::getParam('privacy_is_page');
                    if($privacy_is_page=="1") {
                        $privacy_page = Params::getParam('select_privacy_page');
                    } else {
                        $privacy_page = Params::getParam('privacy_link');
                    }
                    osc_set_preference('privacy_page', $privacy_page, 'gdpr');

                    osc_set_preference('terms_is_page',     Params::getParam('terms_is_page'),      'gdpr');
                    osc_set_preference('privacy_is_page',   Params::getParam('privacy_is_page'),    'gdpr');


                    $agree_text = Params::getParam('agree_text', false, false, false);
                    foreach($agree_text as $locale => $text) {
                        osc_set_preference('agree_text_' . $locale, $text, 'gdpr');
                    }

                    $error_agree_text = Params::getParam('error_agree_text', false, false, false);
                    foreach($error_agree_text as $locale => $text) {
                        osc_set_preference('error_agree_text_' . $locale, $text, 'gdpr');
                    }

                    $popup_text = Params::getParam('gdpr_popup', false, false, false);
                    foreach($popup_text as $locale => $text) {
                        osc_set_preference('gdpr_popup_' . $locale, $text, 'gdpr');
                    }

                    osc_set_preference('gdpr_marketing_js',     Params::getParam('gdpr_marketing_js'),      'gdpr');
                    osc_set_preference('gdpr_analytics_js',   Params::getParam('gdpr_analytics_js'),    'gdpr');
                    osc_set_preference('gdpr_preferences_js',   Params::getParam('gdpr_preferences_js'),    'gdpr');
                    osc_set_preference('gdpr_cookie_days',   Params::getParam('gdpr_cookie_days'),    'gdpr');

                    osc_add_flash_ok_message(__('Successfully saved', 'gdpr'), 'admin');
                    osc_redirect_to(osc_route_admin_url('gdpr-admin-settings'));
                    break;

                case 'gdpr-admin-erasure':                    
                    $remove_account_enabled = Params::getParam('remove_account_enabled');
                    if($remove_account_enabled=="1") {
                        osc_set_preference('remove_account_enabled', "1", 'gdpr');
                    } else {
                        osc_set_preference('remove_account_enabled', "0", 'gdpr');
                    }

                    osc_add_flash_ok_message(__('Successfully saved', 'gdpr'), 'admin');
                    osc_redirect_to(osc_route_admin_url('gdpr-admin-erasure'));
                    break;

                case 'gdpr-admin-portability':                    
                    $portability_enabled = Params::getParam('portability_enabled');
                    if($portability_enabled=="1") {
                        osc_set_preference('portability_enabled', "1", 'gdpr');
                    } else {
                        osc_set_preference('portability_enabled', "0", 'gdpr');
                    }

                    $portability_download = Params::getParam('portability_download');
                    if($portability_download=="1") {
                        osc_set_preference('portability_download', "1", 'gdpr');
                    } else {
                        osc_set_preference('portability_download', "0", 'gdpr');
                    } 

                    $email_subject = Params::getParam('email_subject', false, false, false);
                    foreach($email_subject as $locale => $text) {
                        osc_set_preference('email_subject_' . $locale, $text, 'gdpr');
                    }
                    $email_text = Params::getParam('email_text', false, false, false);
                    foreach($email_text as $locale => $text) {
                        osc_set_preference('email_text_' . $locale, $text, 'gdpr');
                    }


                    osc_add_flash_ok_message(__('Successfully saved', 'gdpr'), 'admin');
                    osc_redirect_to(osc_route_admin_url('gdpr-admin-portability'));
                    break;
                case 'gdpr-user-email':
                    $user_id = Params::getParam('userid');
                    if($user_id == "") {
                        osc_add_flash_error_message(__('Required: User id', 'gdpr'), 'admin');
                        osc_redirect_to(osc_route_admin_url('gdpr-user-email'));    
                    }
                    if (is_numeric($user_id)) {
                        $user = User::newInstance()->findByPrimaryKey($user_id);
                    } else {
                        $user = User::newInstance()->findByEmail($user_id);
                    }
                    if (!$user) {
                        osc_add_flash_error_message(__('User not found', 'gdpr'), 'admin');
                        osc_redirect_to(osc_route_admin_url('gdpr-user-email'));    
                    }
                    $return = OsclassGdpr::newInstance()->dump_user_data($user['pk_i_id'], true);
                    if (!$return['success']) {
                        osc_add_flash_error_message($return['msg'], 'admin');
                        osc_redirect_to(osc_route_admin_url('gdpr-user-email'));    
                    }
                    
                    $_title = osc_apply_filter('email_title', osc_apply_filter('gdpr_email_title', Params::getParam('emailSubject'), $user));
                    $_body  = osc_apply_filter('email_description', osc_apply_filter('gdpr_email_description', Params::getParam('emailText'), $user));

                    $words   = array();
                    $words[] = array(
                        '{USER_NAME}',
                        '{USER_EMAIL}'
                    );
                    $words[] = array(
                        $user['s_name'],
                        $user['s_email']
                    );
                    $title = osc_apply_filter('gdpr_email_title_after', osc_mailBeauty($_title, $words), $user);
                    $body  = osc_apply_filter('gdpr_email_description_after', osc_mailBeauty($_body, $words), $user);

                    $testRun = Params::getParam('testRun');
                    $params = osc_apply_filter('gdpr_email_params', array(
                        'subject'  => $title,
                        'from'     => _osc_from_email_aux(),
                        'to'       => ($testRun == 'on' ? _osc_from_email_aux() : $user['s_email']),
                        'to_name'  => $user['s_name'],
                        'body'     => $body,
                        'alt_body' => $body
                    ));
                    $params['attachment'] = array();
                    $params['attachment']['path'] = $return['file'];
                    $params['attachment']['name'] = basename($return['file']);

                    try {
                        osc_sendMail($params);
                        $msg = $user['s_email'].", ".$user['s_name'];
                        osc_add_flash_ok_message( __('Email sent '). $msg , "admin");
                    } catch (phpmailerException $e) {
                        $msg = "Email fail to:".$user['s_email'].", ".$user['s_name'].", ".$e->getMessage();
                        osc_add_flash_error_message( $msg , "admin");
                    }
                    
                    osc_redirect_to(osc_route_admin_url('gdpr-user-email'));
                    break;
                default:
                    # code...
                    break;
            }
            return false;
        }

    }

}

$_OsclassGdprAdmin = new OsclassGdprAdmin();