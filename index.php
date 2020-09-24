<?php
/*
Plugin Name: Post PDF
Plugin URI: https://devshabab.com
Description: generate pdf for post  
Version: 1.0
Author: shabab
Author URI: https://devshabab.com
License: GPLv2 or later
Text Domain: ppdf
Domain Path: /languages/
*/

define( "PLUGIN_ROOT", plugin_dir_url( __FILE__ ) );
define( "PLUGIN_ASSETS_DIR", plugin_dir_url( __FILE__ ) . "assets/" );
define( "PLUGIN_ASSETS_PUBLIC_DIR", plugin_dir_url( __FILE__ ) . "assets/public" );
define( "PLUGIN_ASSETS_ADMIN_DIR", plugin_dir_url( __FILE__ ) . "assets/admin" );

class Ppdf{
    private $version;
    function __construct(){
		$this->version =time();
		//add_action('init',array($this,'ppdf_plugin_init'));
		add_action('plugins_loaded',array($this,'ppdf_load_textdomain'));
        add_action('wp_enqueue_scripts',array($this,'ppdf_load_front_assets'));
        add_filter('the_content',array($this,'ppdf_add_pdf_btn'));
        //add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
        add_action( 'wp_ajax_ppdf_post_details', array($this,'post_details'));
        add_action( 'wp_ajax_nopriv_ppdf_post_details', array($this,'post_details'));
    }
    /*
    public function ppdf_plugin_init(){
        //wp_register_style('fontawesome-css','//use.fontawesome.com/releases/v5.2.0/css/all.css');
        //wp_register_script('tinyslider-js','//cdn.jsdelivr.net/npm/tiny-slider@2.8.5/dist/tiny-slider.min.js',null,'1.0',true);
    }
    */
    public function ppdf_load_textdomain(){
        load_plugin_textdomain('plugin-textdomain',false,plugin_dir_url(__FILE__)."/languages");
    }

    public function ppdf_load_front_assets(){
        wp_enqueue_style('ppdf-front-main-css',PLUGIN_ASSETS_PUBLIC_DIR."/css/main.css",null,$this->version);
        
        wp_enqueue_script( 'ppdf-front-main-js', PLUGIN_ASSETS_PUBLIC_DIR . "/js/main.js", array(
            'jquery',
        ), $this->version, true );
        
    }
    /*
    public function load_admin_assets($screen){
        $_screen = get_current_screen();
		if ( 'edit.php' == $_screen && ('page' == $_screen->post_type || 'book' == $_screen->post_type) ) {
			wp_enqueue_script( 'plugin-admin-js', PLUGIN_ASSETS_ADMIN_DIR . "/js/admin.js", array( 'jquery' ), $this->version, true );
		}
    }
    */
    public function ppdf_add_pdf_btn($content){
        global $post;
        $pid=$post->ID;
        
        wp_localize_script(
            'ppdf-front-main-js',
            'ppdfdata',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ),
            'root_utl'=>PLUGIN_ROOT,
            'pid'=>$pid,
            'site_url' => get_bloginfo( 'url' )
            )
        );
        
        $label=__('Generate PDF','ppdf');
        $content.=sprintf('<a href="#" class="btn btn-lg red action-button" data-task="ppdf_ajax_call">%s</a>',$label);
        return $content;
    }

    public function post_details(){
        if(isset($_POST['data'])){
            $qry=new WP_Query(array(
                'p'=>$_POST["data"],
                'type'=>'post',
                'post_status' => 'publish',
                'posts_per_page' => 1
            ));
            while($qry->have_posts()){
                $qry->the_post();
                $post_title=get_the_title();
                $post_content=get_the_content();
                $post_thumb=get_the_post_thumbnail_url(get_the_ID(),"full");

                $postDetails=array(
                    'title'=>$post_title,
                    'content'=>$post_content,
                    'thumbnail'=>$post_thumb,
                );
            }
            echo json_encode($postDetails,JSON_PRETTY_PRINT);
            die();
        }
    }
}

new Ppdf();