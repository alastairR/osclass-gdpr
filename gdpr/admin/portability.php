<?php
$localeManager = OSCLocale::newInstance();
$aLocales = $localeManager->listAllEnabled();

?>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex w-100 pt-2 mb-3">
            <a class="btn btn-primary btn-sm" style="height:inherit;" href="<?php echo osc_route_admin_url('gdpr-admin-dashboard'); ?>"><?php _e('Return to dashboard', 'gdpr'); ?></a>
        </div>
        <form class="card" action="<?php echo osc_route_admin_url('gdpr-admin-portability'); ?>" method="POST">
            <input name="paction" value="submit" type="hidden"/>
            <div class="card-body">
                <h2 class="mr-3"><?php _e('Right to data portability', 'gdpr'); ?></h2>
                <div class="col-md-12">
                    <div class="form-group pt-3">  
                        <label class="d-block custom-switch mb-3">
                            <input id="portability_enabled" type="checkbox" name="portability_enabled" value="1" <?php echo (osc_get_preference('portability_enabled', 'gdpr')=="1") ? 'checked' : ''; ?> class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"><?php _e('Check this to automatically add "Download" section under <em>user menu</em>.', 'gdpr'); ?></span>
                        </label>
                    </div>
                </div>
 
                <ul style="list-style-type: none;">
                    <li>
                        <label class="selectgroup-item">
                        <input type="radio" name="portability_download" value="1" class="selectgroup-input" <?php echo (osc_get_preference('portability_download', 'gdpr')=="1") ? 'checked' : ''; ?> >
                        <span class="selectgroup-button">Download file, users by clicking "download" all data will be generated on the fly.</span>
                        </label>
                    </li>
                    
                    <li>
                        <label class="selectgroup-item">
                        <input type="radio" name="portability_download" value="0" class="selectgroup-input" <?php echo (osc_get_preference('portability_download', 'gdpr')=="0") ? 'checked' : ''; ?> >
                        <span class="selectgroup-button">Request data via email, users by clicking "download" will send and email to the admin email address requesting all user data. Admin will need to use the GDPR admin toolbar button to send the user's data.</span>
                        </label> 
                    </li>
                </ul>

                <div class="col-md-12 mt-3 alert alert-primary align-self-center">
                    <?php _e('Users will be able to download all data collected by Osclass. Bear in mind that some plugins may store information and won\'t be downloaded, unless they implement the "gdpr_dump_user_data" filter.', 'gdpr_osclas'); ?>
                </div>  

                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Data dump email subject', 'gdpr'); ?></h3>
                    
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
                                    <input type="text" class="form-control" name="email_subject[<?php echo $locale['pk_c_code']; ?>]" value="<?php echo osc_get_preference('email_subject_' . $locale['pk_c_code'], 'gdpr'); ?>">
                                    <p class="text-muted mb-0 p-2"><small><b><?php _e('Example text:', 'gdpr'); ?></b>&nbsp;<?php echo osc_get_preference('email_subject_default', 'gdpr'); ?></small></p>
                                </div> 
                            </div><!-- /.tab-pane -->
                        <?php } ?>
                        </div> 
                    </div>
                </div>
                <div class="col-md-12"> 
                    <h3 class="font-weight-bold mr-3"><?php _e('Data dump email message text', 'gdpr'); ?></h3>
                    
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
                                    <textarea class="form-control" name="email_text[<?php echo $locale['pk_c_code']; ?>]"><?php echo osc_get_preference('email_text_' . $locale['pk_c_code'], 'gdpr'); ?></textarea>
                                    <p class="text-muted mb-0 p-2"><small><b><?php _e('Example text:', 'gdpr'); ?></b>&nbsp;<?php echo osc_get_preference('email_text_default', 'gdpr'); ?></small></p>
                                </div> 
                            </div><!-- /.tab-pane -->
                        <?php } ?>
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
<div class="row">
    <div class="col-md-6"> 
        <form class="card" action="<?php echo osc_route_admin_url('gdpr-admin-portability'); ?>" method="POST">
            <input name="paction" value="download" type="hidden"/>
            <div class="card-body">
                <h2 class="mr-3"><?php _e('Download user data manually', 'gdpr'); ?></h2>
                <div class="col-md-12">
                    <div class="form-group pt-3">  
                        <input placeholder="user id goes here" name="user_id" value="" type="text"/>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><?php _e('Download', 'gdpr'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>