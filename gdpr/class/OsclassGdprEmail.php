<?php

class OsclassGdprEmail {
    public function __construct()
    {

        if(strpos(Params::getParam('file'),'gdpr/admin/')!==false) { 
            //osc_add_hook('admin_header',        array(&$this, '_init_pageHeader') );
            osc_add_filter('admin_body_class',  array(&$this, '_body_class') );
            osc_add_hook('init_admin',          array(&$this, 'handleForm') );
            
        }
    }

    function _init_pageHeader() {
        osc_remove_hook('admin_page_header', 'customPageHeader');
        osc_add_hook('admin_page_header', array(&$this,'_customPageHeader'), 9); 
    }

    function _body_class($array){
        $array[] = 'market';
        return $array;
    }

    function handleForm() {
        if(!osc_is_admin_user_logged_in()) {
            return false;
        }

        $userId = Params::getParam("userid");  
        $email = Params::getParam("email");

        if(Params::getParam('paction')=='download') {
            switch ($file) {    
                case 'gdpr/admin/portability.php':                    
                    $user_id = Params::getParam('user_id');
                    if(!is_numeric($user_id) || $user_id == "") {
                        osc_add_flash_error_message(__('Required: User id', 'gdpr'), 'admin');
                        osc_redirect_to(osc_admin_render_plugin_url('gdpr/admin/portability.php'));    
                    } 

                    $return = OsclassGdpr::newInstance()->dump_user_data($user_id);
                    if($return['success']) {
                        osc_add_flash_ok_message( $return['msg'] , "admin");
                    } else {
                        osc_add_flash_error_message( $return['msg'] , "admin");
                    }
                    
                    osc_redirect_to(osc_admin_render_plugin_url('gdpr/admin/portability.php'));
                    break;
                default:
                    # code...
                    break;
            }
        }
        if(Params::getParam('paction')=='submit') {
            switch ($file) {
                case 'gdpr/admin/settings.php':                    
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

                    osc_add_flash_ok_message(__('Successfully saved', 'gdpr'), 'admin');
                    osc_redirect_to(osc_admin_render_plugin_url('gdpr/admin/settings.php'));
                    break;

                case 'gdpr/admin/erasure.php':                    
                    $remove_account_enabled = Params::getParam('remove_account_enabled');
                    if($remove_account_enabled=="1") {
                        osc_set_preference('remove_account_enabled', "1", 'gdpr');
                    } else {
                        osc_set_preference('remove_account_enabled', "0", 'gdpr');
                    }

                    osc_add_flash_ok_message(__('Successfully saved', 'gdpr'), 'admin');
                    osc_redirect_to(osc_admin_render_plugin_url('gdpr/admin/erasure.php'));
                    break;

                case 'gdpr/admin/portability.php':                    
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
                    

                    osc_add_flash_ok_message(__('Successfully saved', 'gdpr'), 'admin');
                    osc_redirect_to(osc_admin_render_plugin_url('gdpr/admin/portability.php'));
                    break;
                default:
                    # code...
                    break;
            }
            return false;
        }

    }

}

$_OsclassGdprEmail = new OsclassGdprEmail();