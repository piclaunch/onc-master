<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       piclaunch.com
 * @since      1.0.0
 *
 * @package    Onc_master
 * @subpackage Onc_master/admin/partials
 */
?>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap" style="float: left; width: 70%;">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>    

    <form method="post" name="picana_options" action="options.php">

    <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $_ONC_ENABLE_CATEGORY_TAG= $options['_ONC_ENABLE_CATEGORY_TAG'];
        $_ONC_ENABLE_G_ALLSEGMENT= $options['_ONC_ENABLE_G_ALLSEGMENT'];
        $_ONC_ENABLE_ALLSEGMENT= $options['_ONC_ENABLE_ALLSEGMENT'];
        $_ONC_ENABLE_G_YOASTDSC= $options['_ONC_ENABLE_G_YOASTDSC'];
        $_ONC_ENABLE_YOASTDSC= $options['_ONC_ENABLE_YOASTDSC'];
        $_ONC_ENABLE_PAGEPUSH= $options['_ONC_ENABLE_PAGEPUSH'];
        $_onc_debug   = $options['_onc_debug'];        
        
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>

<style>
.accordion {
    background-color: #0073aa;
    color: #fff;
    cursor: pointer;
    padding: 18px;
    margin-bottom: 0px;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
    -webkit-appearance: menulist;
}

.active, .accordion:hover {
    background-color: #0073aa4d; 
}

.panel {
    padding: 0 18px 10px 18px;
    display: none;
    background-color: white;
    overflow: hidden;
}
</style>

      <div  class="container" >
      <div class="row" style=" border-bottom: thick solid #00b7f9;">
        <div class="span6" style="font-size: 20px;margin-left: 1px;color: #28bbf0;font-weight: bolder; ">
          <a href="http://piclaunch.com/" rel="home"  target="_blank"><img src="<?php echo plugins_url( 'img/logo.png', __FILE__ ); ?>" alt="ONC Master" style="width:150px;vertical-align: middle;padding-right: 10px;margin-bottom: 0.75em;border-right: thick solid #00b7f9"> OneSignal Notification Controller </a>
         
         <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" class="twitter-mention-button twitter-mention-button-rendered twitter-tweet-button" style="position: static; visibility: visible; width: 133px; height: 20px;" title="Twitter Tweet Button" src="http://platform.twitter.com/widgets/tweet_button.d7c36168330549096322ed9760147cf7.en.html#dnt=false&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Fpiclaunch.com%2Fpinq%2F&amp;screen_name=piclaunch&amp;size=m&amp;time=1510593489908&amp;type=mention" data-screen-name="piclaunch"></iframe><script async="" src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div>
      </div>
  <p>Built by Piclaunch <a href="http://www.piclaunch.com/"></a>,write to us if if you have any issue at piclaunch@gmail.com or visit <a href="http://www.piclaunch.com/">Piclaunch Support</a></p>


          <?php  if($_onc_debug == 1) { ?>
                    <p class="accordion">Debugging Info</p>
                        <div class="panel">
                              <?php print_r($options); echo "<br>"; $file = plugins_url( 'img/logo.png', __FILE__ ); echo $file;
                              ; $url = plugins_url( $path,$this->plugin_name ); echo $url."/Onc_master/img/logo.png";?>
                        </div>

            <?php  }?> 


        
<!-- AMP Auto Add Flag -->
<p class="accordion">PAGE Push Enable </p>
<div class="panel">
      <fieldset >
        <p>Enable Push for PAGE In your site, enable on Publish status.</p>
        <legend class="screen-reader-text">
            <span>Send by Dafault to All Segment</span>
        </legend>
        <label for="<?php echo $this->plugin_name;?>-_ONC_ENABLE_PAGEPUSH">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-_ONC_ENABLE_PAGEPUSH" name="<?php echo $this->plugin_name; ?>[_ONC_ENABLE_PAGEPUSH]" value="1" <?php checked($_ONC_ENABLE_PAGEPUSH, 1); ?> />
            <span><?php esc_attr_e('Enable Push on PAGE on Publish', $this->plugin_name); ?></span>
        </label>
    </fieldset>
</div>


<!-- AMP Auto Add Flag -->
<p class="accordion">Filter </p>
<div class="panel">
      <fieldset >
        <p>This setting will make sure that your message is being sent to all of your users.</p>
        <legend class="screen-reader-text">
            <span>Send by Dafault to All Segment</span>
        </legend>
        <label for="<?php echo $this->plugin_name;?>-_ONC_ENABLE_G_ALLSEGMENT">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-_ONC_ENABLE_G_ALLSEGMENT" name="<?php echo $this->plugin_name; ?>[_ONC_ENABLE_G_ALLSEGMENT]" value="1" <?php checked($_ONC_ENABLE_G_ALLSEGMENT, 1); ?> />
            <span><?php esc_attr_e('Send by Dafault to All Segment', $this->plugin_name); ?></span>
        </label>
    </fieldset>
</div>

  <!-- AMP Add post POST Flag -->
<p class="accordion">Enable Category TAG</p>
<div class="panel">
    <fieldset>
      <p>This will create Tag of your existing and new users based on category they visits, this will help you identify which content needs to be sent to which user of your website.</p>
        <legend class="screen-reader-text">
            <span>Enable Category Tag</span>
        </legend>
        <label for="<?php echo $this->plugin_name;?>-_ONC_ENABLE_CATEGORY_TAG">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-_ONC_ENABLE_CATEGORY_TAG" name="<?php echo $this->plugin_name; ?>[_ONC_ENABLE_CATEGORY_TAG]" value="1" <?php checked($_ONC_ENABLE_CATEGORY_TAG, 1); ?> />
            <span><?php esc_attr_e('Enable Category Tag', $this->plugin_name); ?></span>
        </label>
    </fieldset>   
</div>

<!-- Auto Ads for NON AMP Page -->
<p class="accordion">Notification Message </p>
<div class="panel">
      <fieldset>
      <p>Want to send more meaningfull data, use Yoast Description if availble to be sent as part of your notification content.</p>
        <legend class="screen-reader-text">
            <span>Send Yoast Description if available</span>
        </legend>
        <label for="<?php echo $this->plugin_name;?>-_ONC_ENABLE_G_YOASTDSC">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-_ONC_ENABLE_G_YOASTDSC" name="<?php echo $this->plugin_name; ?>[_ONC_ENABLE_G_YOASTDSC]" value="1" <?php checked($_ONC_ENABLE_G_YOASTDSC, 1); ?> />
            <span><?php esc_attr_e('Send Yoast Description if available', $this->plugin_name); ?></span>
        </label>
    </fieldset>  
</div>
  <fieldset>
      <p>Enable debug only to check your vlaue :</p>
        <legend class="screen-reader-text">
            <span>Show AMP Auto Ads on website</span>
        </legend>
        <label for="<?php echo $this->plugin_name;?>-_onc_debug">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-_onc_debug" name="<?php echo $this->plugin_name; ?>[_onc_debug]" value="1" <?php checked($_onc_debug, 1); ?> />
            <span><?php esc_attr_e('Debug Admin Only', $this->plugin_name); ?></span>
        </label>
    </fieldset> 


    <!-- SAVE CALL -->
    <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    </form>
  
</div>
<div class="wrapright" style="float: right; width: 28%;">  
    <br>
    <span><?php esc_attr_e('Request for help , happy to help!', $this->plugin_name); ?></span>        
     <br>
    <?php deliver_mail();
    html_form_code(); ?>
</div>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
</script>

<?php

function html_form_code() {
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo 'Your Name (required) <br/>';
    echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : "Admin" ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Email (required) <br/>';
    echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : get_option('admin_email') ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Subject (required) <br/>';
    echo '<input type="text" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : 'ONC Master Help' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Message (required) <br/>';
    echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="cf-submitted" value="Request Help"></p>';
    echo '</form>';
}

function deliver_mail() {

    // if the submit button is clicked, send the email
    if ( isset( $_POST['cf-submitted'] ) ) {

        // sanitize form values
        $name    = sanitize_text_field( $_POST["cf-name"] );
        $email   = sanitize_email( $_POST["cf-email"] );
        $subject = sanitize_text_field( $_POST["cf-subject"] );
        $subject .= " From: ";
        $subject .= get_site_url();
        $message = esc_textarea( $_POST["cf-message"] );
        $message .= " Email from " .  $email ;

        // get the blog administrator's email address
        $to = "piclaunch@gmail.com";

        $headers = "From: $name <$email>" . "\r\n";

        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $subject, $message, $headers ) ) {
            echo '<div>';
            echo '<p>Thanks for contacting me, expect a response soon.</p>';
            echo '</div>';
        } else {
            echo 'An unexpected error occurred';
        }
    }
}
?>