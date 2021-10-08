<?php
/*
Plugin Name: GDPR Osclass plugin
Plugin URI: http://www.osclass.org/
Description: GDPR compliance, add agree box to forms, remove account and download user information
Version: 2.0.2
Author: Osclass
Author URI: http://www.osclass.org/
Short Name: gdpr
Plugin update URI: gdpr
*/

/*
*   This software may not be resold, redistributed or otherwise conveyed to a third party
*/

/* DEFINES */
define('OSCLASS_GDPR_PATH', dirname(__FILE__) . '/' );

// require_once OSCLASS_GDPR_PATH . 'model/ModelOsclassGdpr.php';

require_once OSCLASS_GDPR_PATH . 'class/ModelGdpr.php';
require_once OSCLASS_GDPR_PATH . 'class/CustomZip.php'; 
require_once OSCLASS_GDPR_PATH . 'class/OsclassGdpr.php';
require_once OSCLASS_GDPR_PATH . 'class/OsclassGdprAdmin.php';

function gdpr_call_after_install() {
    osc_set_preference('gdpr_enabled', '0', 'gdpr');
    osc_set_preference('gdpr_cookie_days', '365', 'gdpr');
    osc_set_preference('remove_account_enabled', "0", 'gdpr');
    osc_set_preference('portability_enabled', "0", 'gdpr');

    osc_set_preference('portability_download', "0", 'gdpr');
    osc_set_preference('portability_email_request', "0", 'gdpr');

    osc_set_preference('terms_is_page', '1', 'gdpr');
    osc_set_preference('privacy_is_page', '1', 'gdpr');

    osc_set_preference('agree_text', 'I have read and accept the {TERMS} and the {PRIVACY}', 'gdpr');
    osc_set_preference('agree_text_default', 'I have read and accept the {TERMS} and the {PRIVACY}', 'gdpr');

    osc_set_preference('error_agree_text', 'You must accept our "Terms and Conditions" and "Privacy Policy"', 'gdpr');
    osc_set_preference('error_agree_text_default', 'You must accept our "Terms and Conditions" and "Privacy Policy"', 'gdpr');

    osc_set_preference('gdpr_popup', 'By accepting our cookies you grant us permission to store cookies in your browser. You can find more information about what we do with your data: {TERMS}, {PRIVACY}', 'gdpr', 'STRING');

    osc_set_preference('gdpr_marketing_js', '$(\'div[class*="ads_"\').hide();', 'gdpr');
    osc_set_preference('gdpr_analytics_js', '$(\'div[class*="anl_"\').hide();', 'gdpr');
    osc_set_preference('gdpr_preferences_js', '$(\'div[class*="prf_"\').hide();', 'gdpr');

    osc_set_preference('email_subject_default', 'GDPR Data Request', 'gdpr');
    osc_set_preference('email_text_default', 'Your data is contained in the attached .zip file.', 'gdpr');
}

function gdpr_call_after_uninstall() {
    Preference::newInstance()->delete(array('s_section' => 'gdpr'));
}

osc_register_plugin(osc_plugin_path(__FILE__), 'gdpr_call_after_install');
osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'gdpr_call_after_uninstall');
