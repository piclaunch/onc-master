<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       piclaunch.com
 * @since      1.0.0
 *
 * @package    Onc_master
 * @subpackage Onc_master/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Onc_master
 * @subpackage Onc_master/admin
 * @author     Piclaunch.com <piclaunch@gmail.com>
 */
class Onc_master_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->onc_master_options = get_option($this->plugin_name);


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Onc_master_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Onc_master_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/onc_master-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Onc_master_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Onc_master_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/onc_master-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Piclaunch Code 
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	  add_options_page( 'ONC Master', 'ONC MASTER (One Signal Notification Control)', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	//saving/update function for our options.

	public function options_update() {
    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 	}


	//validate and sanitize those options:
	 // $_ONC_ENABLE_CATEGORY_TAG= $options['_ONC_ENABLE_CATEGORY_TAG'];
  //       $_ONC_ENABLE_G_ALLSEGMENT= $options['_ONC_ENABLE_G_ALLSEGMENT'];
  //       $_ONC_ENABLE_ALLSEGMENT= $options['_ONC_ENABLE_ALLSEGMENT'];
  //       $_ONC_ENABLE_G_YOASTDSC= $options['_ONC_ENABLE_G_YOASTDSC'];
  //       $_ONC_ENABLE_YOASTDSC= $options['_ONC_ENABLE_YOASTDSC'];
  //       $_onc_debug   = $options['_onc_debug'];        

	public function validate($input) {
	    // All checkboxes inputs        
	    $valid = array();

	    //AMP Ads
	    $valid['_ONC_ENABLE_CATEGORY_TAG'] = (isset($input['_ONC_ENABLE_CATEGORY_TAG']) && !empty($input['_ONC_ENABLE_CATEGORY_TAG'])) ? 1 : 0;
	    $valid['_ONC_ENABLE_G_ALLSEGMENT'] = (isset($input['_ONC_ENABLE_G_ALLSEGMENT']) && !empty($input['_ONC_ENABLE_G_ALLSEGMENT'])) ? 1 : 0;
	    $valid['_ONC_ENABLE_ALLSEGMENT'] = (isset($input['_ONC_ENABLE_ALLSEGMENT']) && !empty($input['_ONC_ENABLE_ALLSEGMENT'])) ? 1 : 0;
	    $valid['_ONC_ENABLE_G_YOASTDSC'] = (isset($input['_ONC_ENABLE_G_YOASTDSC']) && !empty($input['_ONC_ENABLE_G_YOASTDSC'])) ? 1 : 0;
	    $valid['_ONC_ENABLE_YOASTDSC'] = (isset($input['_ONC_ENABLE_YOASTDSC']) && !empty($input['_ONC_ENABLE_YOASTDSC'])) ? 1 : 0;
	    $valid['_ONC_ENABLE_PAGEPUSH'] = (isset($input['_ONC_ENABLE_PAGEPUSH']) && !empty($input['_ONC_ENABLE_PAGEPUSH'])) ? 1 : 0;
	    $valid['_onc_debug'] = (isset($input['_onc_debug']) && !empty($input['_onc_debug'])) ? 1 : 0;
	    return $valid;
	 }



	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/onc_master-admin-display.php' );
	}




function onc_master_onesignal_send_notification_filter($fields, $new_status, $old_status, $post)
{
	//if( !empty($this->onc_master_options['_ONC_ENABLE_CATEGORY_TAG']) ){
	global $post; //GLobal Post variable 
    $categories = get_the_category($post->ID);
    $values = get_post_meta( $post->ID );

    // Change which segment the notification goes to, will always be the first category
    //Change which tag and filter the notification goes to,
    //https://documentation.onesignal.com/reference#section-send-based-on-filters-tags-create-notification
    //https://documentation.onesignal.com/docs/web-push-wordpress-faq
    //$fields['included_segments'] = array('ALL');
    //$ONC_CHK_ALLSEGMENT = isset( $values['ONC_MASTER_META_CHK_ALLSEGMENT'] ) ? esc_attr( $values['ONC_MASTER_META_CHK_ALLSEGMENT'][0] ) : '';
   
 	if(get_post_meta(get_the_ID(), '_ONC_MASTER_META_CHK_ALLSEGMENT', true) == 'yes'){
   	//show relevant content 

	$fields['included_segments'] = array('All');

	}else
	{
	  if(! empty ($categories[2]->slug)){

	  		 $fields['filters'] = array(
	      array("field" => "tag", "key" => $categories[0]->slug, "relation" => "=", "value" => $categories[0]->name),array("operator" => "OR"),
	      array("field" => "tag", "key" => $categories[1]->slug, "relation" => "=", "value" => $categories[1]->name),array("operator" => "OR"),
	      array("field" => "tag", "key" => $categories[2]->slug, "relation" => "=", "value" => $categories[2]->name)
		  
	      );

	  }elseif(! empty ($categories[1]->slug)){
	 $fields['filters'] = array(
	      array("field" => "tag", "key" => $categories[0]->slug, "relation" => "=", "value" => $categories[0]->name),array("operator" => "OR"),
	      array("field" => "tag", "key" => $categories[1]->slug, "relation" => "=", "value" => $categories[1]->name)
		  
	      );
	  }elseif(! empty ($categories[0]->slug)){
	 $fields['filters'] = array(
	      array("field" => "tag", "key" => $categories[0]->slug, "relation" => "=", "value" => $categories[0]->name)		  
	      );
	 }

	 // Add code for PAGE Type POST and suport for custom post type Question 
	 if ($post->post_type == "page" or $post->post_type == "question" )
	 {
	 	$fields['filters'] = array(
	      array("field" => "tag", "key" =>  $post->post_type."_". $post->ID, "relation" => "=", "value" => $post->ID)		  
	      );
	 }


	}


	

    if(!empty($this->onc_master_options['_ONC_ENABLE_G_YOASTDSC'])) 
    	{

      
		$meta_yostdesc_value=get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc', true ) ;
		$meta_1posttitle_value = get_the_title();
			if( ! empty ( $meta_yostdesc_value ) ) {
			 $fields['contents'] = array("en" => $meta_yostdesc_value);
			 $fields['headings'] = array("en" => $meta_1posttitle_value );
			}
		}
    

	
 return $fields;

}




// Available keys for $onesignal_wp_settings: https://github.com/OneSignal/OneSignal-WordPress-Plugin/blob/master/onesignal-settings.php#L5
function onc_master_onesignal_meta_filter($post, $onesignal_wp_settings) {
  // Always leave the checkbox "Send notification on <post type> <action> (e.g. post publish)" unchecked
  return false;
}   


function onesignal_include_post_filter($new_status, $old_status, $post) {
// Code to enable Push for PAGE
	if(!empty($this->onc_master_options['_ONC_ENABLE_PAGEPUSH'])) {
		if ($post->post_type == "page" && $new_status == "publish") {
			return true;
		}
	}
}


// END of Piclaunch Code 







}
