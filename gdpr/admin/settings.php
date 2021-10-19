<?php 

$localeManager = OSCLocale::newInstance();
$aLocales = $localeManager->listAllEnabled();

osc_add_hook('admin_footer', function(){ ?>
    <script>
    document.addEventListener("DOMContentLoaded", function(){
      
      $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
      $('#myTab-flash a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      });

    });
    </script>
    <style>
        .alert-success,
        .alert-danger {
            padding: 0 .5rem;
            margin-left: 1rem !important;
        }
    </style>
<?php }); ?>

<div class="row">
    <div class="col-md-6">
        <div class="d-flex w-100 pt-2 mb-3">
            <a class="btn btn-primary btn-sm" style="height:inherit;" href="<?php echo osc_route_admin_url('gdpr-admin-dashboard'); ?>"><?php _e('Return to dashboard', 'gdpr'); ?></a>
        </div>
        <div class="d-flex w-100 pt-2 mb-3">
            <div class="col-md-12 mt-3 alert alert-primary align-self-center">
                <p>Some forms requires a bit of customisation in order to add “I agree” checkbox.</p>
                <p class="pt-3 bt-3">Alert form, instructions for manually adding "I agree" checkbox.<a href="<?php echo osc_admin_render_plugin_url('gdpr/admin/help/alerts.php'); ?>" class="btn btn-primary float-right"><b>Create Alert form</b></a></p>
                <p class="pt-3 bt-3">Comments form, instructions for manually adding "I agree" checkbox.<a href="<?php echo osc_admin_render_plugin_url('gdpr/admin/help/comments.php'); ?>" class="btn btn-primary float-right"><b>Create Comment form</b></a></p>
                <p class="pt-3 bt-3">Item post/Item edit form, instructions for manually adding "I agree" checkbox.<a href="<?php echo osc_admin_render_plugin_url('gdpr/admin/help/item-post.php'); ?>" class="btn btn-primary float-right"><b>Item post/Item edit form</b></a></p>
                <p class="pt-3 bt-3">Requirements to support GDPR popup preferences.<a href="<?php echo osc_admin_render_plugin_url('gdpr/admin/help/preferences.php'); ?>" class="btn btn-primary float-right"><b>GDPR preferences</b></a></p>
            </div>
        </div>
        <form class="card" action="<?php echo osc_route_admin_url('gdpr-admin-settings'); ?>" method="POST">
            <input name="paction" value="submit" type="hidden"/>
            <div class="card-body">
                <h2 class="mr-3"><?php _e('Enable Gdpr', 'gdpr'); ?></h2>
                <div class="col-md-12">
                    <div class="row"> 

                        <div class="col-md-12 mb-3">
                            <div class="form-group pt-3">  
                                <label class="d-block custom-switch mb-3">
                                    <input id="gdpr_enabled" type="checkbox" name="gdpr_enabled" value="1" <?php echo (osc_get_preference('gdpr_enabled', 'gdpr')=="1") ? 'checked' : ''; ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><?php _e('Check this to turn on GDPR related features (adding a checkbox to your form).', 'osclass_seo'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group pt-3">

                                <div class="d-flex align-items-center">
                                    <h3 class="font-weight-bold mr-3"><?php _e('Terms and Conditions page', 'gdpr'); ?></h3>
                                    <div class="alert alert-<?php echo (osc_get_preference('terms_page', 'gdpr')!="") ? 'success' : 'danger'; ?> d-inline ml-auto m-0">
                                        <?php if(osc_get_preference('terms_page', 'gdpr')!="") { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: white;fill: currentColor;margin-right:15px;" width="16" height="16" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>
                                        <?php _e('Done', 'gdpr'); ?>
                                        <?php } else { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: white;fill: currentColor;margin-right:15px;" width="16" height="16" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/></svg>
                                        <?php _e('Required', 'gdpr'); ?>
                                        <?php } ?>
                                    </div>
                                </div>

                                <label class="d-block custom-switch mb-3">
                                    <input id="terms_link" type="checkbox" name="terms_is_page" value="1" <?php echo (osc_get_preference('terms_is_page', 'gdpr')=="1") ? 'checked' : ''; ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><?php _e('Check this to use static page instead of a plain url', 'osclass_seo'); ?></span>
                                </label>

                                <div class="box-terms-static" style="<?php echo (osc_get_preference('terms_is_page', 'gdpr')=="1") ? '': 'display:none;'; ?>">
                                    <input type="hidden" name="terms_page" value="<?php echo osc_get_preference('terms_page', 'gdpr'); ?>"/>
                                    <div class="terms-select"></div>
                                </div>
                                <div class="box-terms-link" style="<?php echo (osc_get_preference('terms_is_page', 'gdpr')!="1") ? '': 'display:none;'; ?>">
                                    <input name="terms_link" value="<?php echo (osc_get_preference('terms_is_page', 'gdpr')!="1") ? osc_get_preference('terms_page', 'gdpr') : ''; ?>" type="text" placeholder="https://example.com/terms-and-conditions"/>
                                </div>
                                <div class="col-md-12 mt-3 alert alert-primary align-self-center">
                                    <?php _e('Select your <em>Terms and Conditions</em> you can choose a <em>Static page</em> or <em>Custom link</em> if your host your pages outside.', 'gdpr'); ?>
                                </div>
                                <hr class="mb-3">
                            </div> 

                            <div class="form-group pt-3"> 
                                <div class="d-flex align-items-center">
                                    <h3 class="font-weight-bold mr-3"><?php _e('Privacy Policy page', 'gdpr'); ?></h3>
                                    <div class="alert alert-<?php echo (osc_get_preference('privacy_page', 'gdpr')!="") ? 'success' : 'danger'; ?> d-inline ml-auto m-0">
                                        <?php if(osc_get_preference('privacy_page', 'gdpr')!="") { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: white;fill: currentColor;margin-right:15px;" width="16" height="16" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>
                                        <?php _e('Done', 'gdpr'); ?>
                                        <?php } else { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: white;fill: currentColor;margin-right:15px;" width="16" height="16" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/></svg>
                                        <?php _e('Required', 'gdpr'); ?>
                                        <?php } ?>
                                    </div>
                                </div> 

                                <label class="d-block custom-switch mb-3">
                                    <input id="privacy_link" type="checkbox" name="privacy_is_page" value="1" <?php echo (osc_get_preference('privacy_is_page', 'gdpr')=="1") ? 'checked' : ''; ?> class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><?php _e('Check this to use static page instead of a plain url', 'osclass_seo'); ?></span>
                                </label>

                                <div class="box-privacy-static" style="<?php echo (osc_get_preference('privacy_is_page', 'gdpr')=="1") ? '': 'display:none;'; ?>">
                                    <input type="hidden" name="privacy_page" value="<?php echo osc_get_preference('privacy_page', 'gdpr'); ?>"/>
                                    <div class="privacy-select"></div>
                                </div>
                                <div class="box-privacy-link" style="<?php echo (osc_get_preference('privacy_is_page', 'gdpr')!="1") ? '': 'display:none;'; ?>">
                                    <input name="privacy_link" value="<?php echo (osc_get_preference('privacy_is_page', 'gdpr')!="1") ? osc_get_preference('privacy_page', 'gdpr') : ''; ?>" type="text" placeholder="https://example.com/privacy-policy"/>
                                </div> 
                                <div class="col-md-12 mt-3 alert alert-primary align-self-center">
                                    <?php _e('Select your <em>Privacy Policy</em> page you can choose a <em>Static page</em> or <em>Custom link</em> if your host your pages outside.', 'gdpr'); ?>
                                </div>
                                <hr class="mb-3">                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Update "I agree to terms" text', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <ul id="myTab" class="nav nav-tabs" role="tablist"> 
                            <?php foreach($aLocales as $key => $locale) { 
                            $active = (Params::getParam('locale')=="" && $key===0 || Params::getParam('locale')==$locale['pk_c_code']) ? "active" : "";  ?>  
                            <li class="nav-item"><a class="nav-link <?php echo $active; ?>" href="#tab<?php echo $locale['pk_c_code']; ?>" data-toggle="tab"><?php echo $locale['s_name']; ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                        <?php foreach($aLocales as $key => $locale) { 
                            $active = (Params::getParam('locale')=="" && $key===0 || Params::getParam('locale')==$locale['pk_c_code']) ? "active" : "";  ?>  
                            <div class="pt-3 tab-pane <?php echo $active; ?>" id="tab<?php echo $locale['pk_c_code']; ?>">
                                <div class="form-group">
                                    <textarea class="form-control" name="agree_text[<?php echo $locale['pk_c_code']; ?>]"><?php echo osc_get_preference('agree_text_' . $locale['pk_c_code'], 'gdpr'); ?></textarea>
                                    <p class="text-muted mb-0 p-2"><small><b><?php _e('Example text:', 'gdpr'); ?></b>&nbsp;<?php echo osc_get_preference('agree_text_default', 'gdpr'); ?></small></p>
                                </div> 
                            </div><!-- /.tab-pane -->
                        <?php } ?>
                        </div> 
                    </div>
                    <div class="mb-3 alert alert-primary align-self-center">
                        <p><?php _e('Change "I agree to terms" text, deafult text is ', 'gdpr'); ?><?php echo osc_get_preference('agree_text_default', 'gdpr'); ?></p>
                        <?php _e('Use keywords <code>{TERMS}</code> and <code>{PRIVACY}</code> and will be automatically replaced by your page links.', 'gdpr'); ?></br>
                    </div>
                    <hr class="mb-3">                               
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Flashmessage text', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <ul id="myTab-flash" class="nav nav-tabs" role="tablist"> 
                            <?php foreach($aLocales as $key => $locale) { 
                            $active = (Params::getParam('locale')=="" && $key===0 || Params::getParam('locale')==$locale['pk_c_code']) ? "active" : "";  ?>  
                            <li class="nav-item"><a class="nav-link <?php echo $active; ?>" href="#tab-flash-<?php echo $locale['pk_c_code']; ?>" data-toggle="tab"><?php echo $locale['s_name']; ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                        <?php foreach($aLocales as $key => $locale) { 
                            $active = (Params::getParam('locale')=="" && $key===0 || Params::getParam('locale')==$locale['pk_c_code']) ? "active" : "";  ?>  
                            <div class="pt-3 tab-pane <?php echo $active; ?>" id="tab-flash-<?php echo $locale['pk_c_code']; ?>">
                                <div class="form-group">
                                    <textarea class="form-control" name="error_agree_text[<?php echo $locale['pk_c_code']; ?>]"><?php echo osc_get_preference('error_agree_text_' . $locale['pk_c_code'], 'gdpr'); ?></textarea>
                                    <p class="text-muted mb-0 p-2"><small><b><?php _e('Example text:', 'gdpr'); ?></b>&nbsp;<?php echo osc_get_preference('error_agree_text_default', 'gdpr'); ?></small></p>
                                </div> 
                            </div><!-- /.tab-pane -->
                        <?php } ?>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('GDPR pop up text', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <ul id="myTab-flash" class="nav nav-tabs" role="tablist"> 
                            <?php foreach($aLocales as $key => $locale) { 
                            $active = (Params::getParam('locale')=="" && $key===0 || Params::getParam('locale')==$locale['pk_c_code']) ? "active" : "";  ?>  
                            <li class="nav-item"><a class="nav-link <?php echo $active; ?>" href="#tab-flash-<?php echo $locale['pk_c_code']; ?>" data-toggle="tab"><?php echo $locale['s_name']; ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                        <?php foreach($aLocales as $key => $locale) { 
                            $active = (Params::getParam('locale')=="" && $key===0 || Params::getParam('locale')==$locale['pk_c_code']) ? "active" : "";  ?>  
                            <div class="pt-3 tab-pane <?php echo $active; ?>" id="tab-flash-<?php echo $locale['pk_c_code']; ?>">
                                <div class="form-group">
                                    <textarea class="form-control" name="gdpr_popup[<?php echo $locale['pk_c_code']; ?>]"><?php echo osc_get_preference('gdpr_popup_' . $locale['pk_c_code'], 'gdpr'); ?></textarea>
                                    <p class="text-muted mb-0 p-2"><small><b><?php _e('Example text:', 'gdpr'); ?></b>&nbsp;<?php echo osc_get_preference('gdpr_popup_default', 'gdpr'); ?></small></p>
                                </div> 
                            </div><!-- /.tab-pane -->
                        <?php } ?>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Javascript to disable marketing', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <div class="form-group">
                            <textarea class="form-control" name="gdpr_marketing_js"><?php echo osc_get_preference('gdpr_marketing_js', 'gdpr'); ?></textarea>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Javascript to disable analytics', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <div class="form-group">
                            <textarea class="form-control" name="gdpr_analytics_js"><?php echo osc_get_preference('gdpr_analytics_js', 'gdpr'); ?></textarea>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Javascript to disable preferences', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <div class="form-group">
                            <textarea class="form-control" name="gdpr_preferences_js"><?php echo osc_get_preference('gdpr_preferences_js', 'gdpr'); ?></textarea>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('User cookie expiry (days)', 'gdpr'); ?></h3>
                    
                    <div class="mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="gdpr_cookie_days" value="<?php echo osc_get_preference('gdpr_cookie_days', 'gdpr'); ?>"></input>
                        </div> 
                    </div> 
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><?php _e('Save', 'gdpr'); ?></button>
                </div>
            </div>
        </form> 
    </div>
</div>

<script>


var pages = [];
<?php osc_count_static_pages(); while(osc_has_static_pages()) { ?>
pages.push('<option value="<?php echo osc_static_page_slug(); ?>"><?php echo osc_static_page_title(); ?></option>');
<?php } ?>

$( document ).ready(function() {
    setTimeout(function() {
        var html = '<select class="form-control">';
        html += '<option value="" selected><?php _e('Select page', 'gdpr'); ?></option>';
        for (var i = 0; i < pages.length; i++) {
            html += pages[i];
        }
        html += '</select>';
        
        $('.terms-select').append(html);
        $('.privacy-select').append(html);

        $('.terms-select select').prop('name', 'select_terms_page');
        $('.privacy-select select').prop('name', 'select_privacy_page');

        if($('.terms_page').val()!="") {
            $('.terms-select select').val( $('input[name="terms_page"]').val() );
        }
        if($('.privacy_page').val()!="") {
            $('.privacy-select select').val( $('input[name="privacy_page"]').val() );
        }
    }, 200);

    $('#terms_link').change(function() {
        if(this.checked) { 
            $('.box-terms-static').show();
            $('.box-terms-link').hide();
        } else {
            $('.box-terms-static').hide();
            $('.box-terms-link').show();
        }
    });

    $('#privacy_link').change(function() {
        if(this.checked) { 
            $('.box-privacy-static').show();
            $('.box-privacy-link').hide();
        } else {
            $('.box-privacy-static').hide();
            $('.box-privacy-link').show();
        }
    });
});


</script>