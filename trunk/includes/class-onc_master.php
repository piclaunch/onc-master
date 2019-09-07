<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       piclaunch.com
 * @since      1.0.0
 *
 * @package    Onc_master
 * @subpackage Onc_master/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Onc_master
 * @subpackage Onc_master/includes
 * @author     Piclaunch.com <piclaunch@gmail.com>
 */

class Onc_master{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Onc_master_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'onc_master';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Onc_master_Loader. Orchestrates the hooks of the plugin.
	 * - Onc_master_i18n. Defines internationalization functionality.
	 * - Onc_master_Admin. Defines all hooks for the admin area.
	 * - Onc_master_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-onc_master-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-onc_master-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-onc_master-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-onc_master-public.php';

		$this->loader = new Onc_master_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Onc_master_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Onc_master_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Onc_master_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );


		//Piclaunch COde start

		// Save/Update our plugin options
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');

							// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );


		//add_filter('onesignal_send_notification', 'onesignal_send_notification_filter', 10, 4);

		/**
		* Send notifications based on category, Onesignal
		*/
		$this->loader->add_action('onesignal_send_notification', $plugin_admin, 'onc_master_onesignal_send_notification_filter' );

		$this->loader->add_filter('onesignal_meta_box_send_notification_checkbox_state', $plugin_admin, 'onc_master_onesignal_meta_filter', 10, 2);

		$this->loader->add_filter('onesignal_include_post', $plugin_admin, 'onesignal_include_post_filter', 10, 3);




		// Add Meta box for the POST PAGE
		// delete $this->loader->add_action('add_meta_boxes', $plugin_admin, 'onc_master_cd_meta_box_add' );
		add_action( 'add_meta_boxes', array( $this, 'onc_master_cd_meta_box_add' ) );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin,'global_notice_meta_box' );
		//save POST 
		//Delete $this->loader->add_action('save_post', $plugin_admin,'onc_master_cd_meta_box_save' );
		add_action( 'save_post', array( $this, 'onc_master_cd_meta_box_save' ) );
		
		//TEST meta
		// Add the post meta box to the post editor
		add_action( 'add_meta_boxes', array( $this, 'add_notice_metabox' ) );
		add_action( 'save_post', array( $this, 'save_notice' ) );
		add_action( 'admin_footer', array( $this,'my_action_javascript' )); // Write our JS below here
		add_action('wp_ajax_my_update_pm', array( $this, 'my_ajax_cb_wpse_108143')); 

		//End Test emta

		//Piclaunch Code ends

	}
		// Meta box on POST PAGE
// AJAX Call to update META

	function my_ajax_cb_wpse_108143() {

		$pid =  $_POST['id'];
		$value = $_POST['_ONC_MASTER_META_CHK_ALLSEGMENT'];
			

   // $cote = get_post_meta($pid, '_ONC_MASTER_META_CHK_ALLSEGMENT', true) ;

     if( $value == 'yes' ) {

        update_post_meta($pid, '_ONC_MASTER_META_CHK_ALLSEGMENT', 'yes');
        // $value = "Yes";
    } else {
        
        update_post_meta($pid, '_ONC_MASTER_META_CHK_ALLSEGMENT', 'no');
        // $value = "No";
    }

  	$response = array('pid'=>$pid,'Act'=>$value);
    echo wp_send_json($response);
    wp_die(); // this is required to terminate immediately and return a proper response
  }

	function my_action_javascript() { ?>
	<script type="text/javascript" >

	$('._ONC_MASTER_META_CHK_ALLSEGMENT').click(function() {
		
		var spinObj = $(".ONC_MASTER_spinner"); 
		spinObj.addClass('is-active');
		spinObj.css("float","left");


    // alert($(this).attr('id'));  //-->this will alert id of checked checkbox.
       if(this.checked){       
       	 var data = {
			'action': 'my_update_pm',
			'id': '<?php echo get_the_ID() ; ?>',
			'_ONC_MASTER_META_CHK_ALLSEGMENT' : 'yes'			
		};     
       }
       	else{       		
       		 var data = {
			'action': 'my_update_pm',
			'id': '<?php echo get_the_ID() ; ?>',
			'_ONC_MASTER_META_CHK_ALLSEGMENT' : 'no'			
		};
       }

       		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			
			// alert('Got this from the server: ' + response.Act + ' For POST:  ' + response.pid);
			spinObj.removeClass('is-active');
			spinObj.css("float","right");
		});
   });
    	
	
	</script> <?php
}
// AJAX Call to update META END

	function onc_master_cd_meta_box_add()
{	
    add_meta_box( 'ONC_MASTER_META_BOX_ID', 
				 __( 'ONC Master', 'onc_master' ),
			array( $this, 'onc_master_cd_meta_box_cb' ),				 
				  'post', 'normal', 'high' );
}



function onc_master_cd_meta_box_cb($post )
{
     $options = get_option($this->plugin_name);

        // Cleanup
        $_ONC_ENABLE_CATEGORY_TAG= $options['_ONC_ENABLE_CATEGORY_TAG'];
        $_ONC_ENABLE_G_ALLSEGMENT= $options['_ONC_ENABLE_G_ALLSEGMENT'];
        $_ONC_ENABLE_ALLSEGMENT= $options['_ONC_ENABLE_ALLSEGMENT'];
        $_ONC_ENABLE_G_YOASTDSC= $options['_ONC_ENABLE_G_YOASTDSC'];
        $_ONC_ENABLE_YOASTDSC= $options['_ONC_ENABLE_YOASTDSC'];
        $_onc_debug   = $options['_onc_debug'];        


    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_meta( $post->ID );

    if ($_ONC_ENABLE_G_ALLSEGMENT == 1)
    {
    	 $ONC_CHK_ALLSEGMENT  = 'yes';
    }else{


    $ONC_CHK_ALLSEGMENT = isset( $values['_ONC_MASTER_META_CHK_ALLSEGMENT'] ) ? esc_attr( $values['_ONC_MASTER_META_CHK_ALLSEGMENT'][0] ) : ''; // for all segment
    }
    $ONC_CHK_USE1STIMG = isset( $values['_ONC_MASTER_META_CHK_USE1STIMG'] ) ? esc_attr( $values['_ONC_MASTER_META_CHK_USE1STIMG'][0] ) : ''; // for 1st iamge 

// get 1st image in post https://i0.wp.com/whatsq.com/wp-content/uploads/2018/01/Shiva.jpg?resize=768%2C497
		$first_img = '';
		  ob_start();
		  ob_end_clean();
		 preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/U', $post->post_content, $matches);
		 $first_img = isset( $matches[1][0] ) ? $matches[1][0] : null;

	  if(empty($first_img)) {
	   // $first_img = "/path/to/default.png";
	  }
 

//End of getting 1st iamge in post


    $t =   $first_img ; //get_the_excerpt(); //get_the_title(); //get_the_ID();
    $text = isset( $values['onc_master_meta_box_text'] ) ? $values['onc_master_meta_box_text'] : '';
    $selected = isset( $values['onc_master_meta_box_select'] ) ? esc_attr( $values['onc_master_meta_box_select'][0] ) : '';
    $check = isset( $values['onc_master_meta_box_check'] ) ? esc_attr( $values['onc_master_meta_box_check'][0] ) : '';
    $meta_yostdesc_value=get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc', true ) ;
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'onc_master_meta_box_nonce', '_onc_master_meta_box_nonce' );


		// if(get_post_meta(get_the_ID(), '_ONC_MASTER_META_CHK_ALLSEGMENT', true) == 'yes'){
		//    //show relevant content 
		// echo " Message will be sent to all.";
		// }else{
		// echo " Message will be not be sent to all.";
		// }
    ?>
    <p class="hidden">
        <label for="onc_master_meta_box_text">Text Label</label>
        <input type="text" name="onc_master_meta_box_text" id="onc_master_meta_box_text" value="<?php  print_r($options); echo "<br>"; echo $post->post_type . " ID :" .$post->ID;   ?>" />
        
    </p>
	<p class="hidden">
        <label for="_ONC_MASTER_META_CHK_USE1STIMG">IMAGE URL: </label>
        <input type="text" name="_ONC_MASTER_META_CHK_USE1STIMG" id="_ONC_MASTER_META_CHK_USE1STIMG" value="<?php  echo $first_img; ?>" />        
    </p>


    
     <p>
     	<span class="ONC_MASTER_spinner spinner"></span>
        <input type="checkbox" class="_ONC_MASTER_META_CHK_ALLSEGMENT" id="_ONC_MASTER_META_CHK_ALLSEGMENT" name="_ONC_MASTER_META_CHK_ALLSEGMENT" <?php checked( $ONC_CHK_ALLSEGMENT, 'yes' ); ?> />
        <label for="_ONC_MASTER_META_CHK_ALLSEGMENT">Send Notification For ALL (By PASS All other Filters)</label>
    </p>

    <?php    
}


function onc_master_cd_meta_box_save( $post_id ){
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['_onc_master_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['_onc_master_meta_box_nonce'], 'onc_master_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )  
    );
     
    // Make sure your data is set before trying to save it
    if( isset( $_POST['onc_master_meta_box_text'] ) )
        update_post_meta( $post_id, 'onc_master_meta_box_text', wp_kses( $_POST['onc_master_meta_box_text'], $allowed ) );         
   
         
    // saving check-boxes alternative 
    // $chk = isset( $_POST['onc_master_meta_box_check'] ) && $_POST['onc_master_meta_box_select'] ? 'yes' : 'no';
    //update_post_meta( $post_id, 'onc_master_meta_box_check', $chk );


// For ALL SEGEMNT SAVE
 if( isset( $_POST[ '_ONC_MASTER_META_CHK_ALLSEGMENT' ] ) ) {
        update_post_meta( $post_id, '_ONC_MASTER_META_CHK_ALLSEGMENT', 'yes' );
    } else {
        update_post_meta( $post_id, '_ONC_MASTER_META_CHK_ALLSEGMENT', 'no' );
    }
    
    //FOR 1st Iamge :
    
    
    
     if( isset( $_POST[ '_ONC_MASTER_META_CHK_USE1STIMG' ] ) ) {
        update_post_meta( $post_id, '_ONC_MASTER_META_CHK_USE1STIMG', wp_kses( $_POST['_ONC_MASTER_META_CHK_USE1STIMG'], $allowed  ));
        // update_post_meta( $post_id, '_ONC_MASTER_META_CHK_USE1STIMG',  $_POST['_ONC__META_CHK_USE1STIMG']);
    } 
    
    
}

	//TEST MENTA 

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Onc_master_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//Piclaunch Code
		
		//$this->loader->add_action( 'amp_post_template_head', $plugin_public, 'amp_post_adLab' );
		//$this->loader->add_action( 'ampforwp_body_beginning', $plugin_public, 'amp_post_adlab_body' );
		//$this->loader->add_action('ampforwp_after_post_content',$plugin_public,'amp_custom_banner_extension_insert_banner');
		//$this->loader->add_action( 'wp_head', $plugin_public, 'auto_add_nonAMP' );
		$this->loader->add_action('wp_footer', $plugin_public, 'onc_master_onePushScript' );



		//Piclaunch Code  End	

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Onc_master_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
