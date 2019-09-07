<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       piclaunch.com
 * @since      1.0.0
 *
 * @package    Onc_master
 * @subpackage Onc_master/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Onc_master
 * @subpackage Onc_master/public
 * @author     Piclaunch.com <piclaunch@gmail.com>
 */
class Onc_master_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->onc_master_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/onc_master-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/onc_master-public.js', array( 'jquery' ), $this->version, false );

	}



//Piclaunch Code Starts
	
	// Method for code to send tag
	function onc_master_onePushScript() { 
		//Check if Flag show AMP Auto Add is on
	 	if( !empty($this->onc_master_options['_ONC_ENABLE_CATEGORY_TAG']) ){

		?>
	<script>
	    <?php global $post; //GLobal Post variable 
	    $categories = get_the_category( $post->ID ); // Get the Category info from POST ID 
	    ?>
	  var OneSignal = OneSignal || [];
	OneSignal.push(function() {
    <?php  if(! empty ($categories[2]->slug)){ ?>
    	OneSignal.sendTag("<?php echo $categories[0]->slug; ?>","<?php echo $categories[0]->name; ?>"); 
		OneSignal.sendTag("<?php echo $categories[1]->slug; ?>","<?php echo $categories[1]->name; ?>"); 
		OneSignal.sendTag("<?php echo $categories[2]->slug; ?>","<?php echo $categories[2]->name; ?>"); 
    <?php }elseif(! empty ($categories[1]->slug)){ ?>
    	OneSignal.sendTag("<?php echo $categories[0]->slug; ?>","<?php echo $categories[0]->name; ?>"); 
		OneSignal.sendTag("<?php echo $categories[1]->slug; ?>","<?php echo $categories[1]->name; ?>"); 
     <?php }elseif(! empty ($categories[0]->slug)){ ?>
    	 OneSignal.sendTag("<?php echo $categories[0]->slug; ?>","<?php echo $categories[0]->name; ?>"); 
    <?php }?>
    <?php if ($post->post_type == "page" or $post->post_type == "question" or $post->post_type == "post"){ ?>	
	OneSignal.sendTag("<?php echo $post->post_type."_".$post->ID; ?>","<?php echo $post->ID; ?>"); 
	 <?php }?>
	    <?php 
	    if(($this->onc_master_options['_onc_debug']) == 1)
	    {
	    	?>
	    	 console.log ("<?php echo "______________________________DEBUG ONC_MASTER____________________________" ; ?> ") ;
	    	 console.log ("<?php echo  $categories[0]->name; ?> ") ;
	    	 console.log ("<?php echo $post->post_type; ?>") ;
	    	 
	    	<?php
	    }

	    ?>

	});

	</script>
	<?php
	}
}

	//Piclaunch Code Ends


}
