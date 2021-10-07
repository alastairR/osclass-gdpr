<?php
$locale = osc_locale_code();
?>
<form action="<?php echo osc_route_admin_url('gdpr-user-email'); ?>" method="POST">
    <input name="paction" value="submit" type="hidden"/>
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <?php _e('User id or email', 'gdpr'); ?>
                        </div>
                        <div class="form-controls">
                            <input id="userid" name="userid" type="text" style="width:50%;" value=""></input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <?php _e("Email subject", 'gdpr'); ?>
                        </div>
                        <div class="form-controls">
                            <input id="emailSubject" name="emailSubject" type="text" style="width:50%;" value="<?php echo osc_get_preference('email_subject_' . $locale, 'gdpr'); ?>"></input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <?php _e("Email text", 'gdpr'); ?>
                        </div>
                        <div class="form-controls">
                            <textarea id="emailText" name="emailText" rows=10 style="width:50%;"><?php echo osc_get_preference('email_text_' . $locale, 'gdpr'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <?php _e("Test run", 'gdpr'); ?>
                        </div>
                        <div class="form-controls">
                            <input type="checkbox" name="testRun"> <?php _e('Email to admin', 'gdpr'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-controls">
                            <button type="submit" class="btn btn-submit" id="button_email" ><?php _e('Send Email', 'gdpr'); ?></button>
                        </div>
                    </div>            
                </div>
            </fieldset>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div id="results" style="padding-top: 30px;">
    </div>
</form>
