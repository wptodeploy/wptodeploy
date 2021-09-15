<?php
/**
 * Plugin Name: WP to Deploy
 * Plugin URI:  https://wptodeploy.in/
 * Description: Convert WP to HTML and deploy to AWS or save zip file.
 * Version:     0.0.2
 * Author:      Arthur Campos & Thafarel Dias
 * Author URI:  https://wptodeploy.in/
 * Text Domain: wp-to-deploy
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no WpToDeploy class exists - exit

if ( ! class_exists( 'WpToDeploy' ) ) :

    final class WpToDeploy{

        public $version = '0.0.1';
        public $db_version = '0.0.1';


        public function __construct(){
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
            dash_deploy::load_admin_styles();
        }

          /**
         * Define constant if not already set.
         *
         */
        public function define( $name, $value ) {
            if ( ! defined( $name ) ) {
            define( $name, $value );
            }
        }

        public static function public_stylesheets() {
            return plugin_dir_url( __FILE__ ) . 'assets/styles/';
          }
        
        public static function public_javascripts() {
            return plugin_dir_url( __FILE__ ) . 'assets/js/';
        }
        
        public static function images_url() {
            return plugin_dir_url( __FILE__ ) . 'assets/images/';
        }

        public static function wptdp_deploy(){
            global $wpdb;
            $tableName = $wpdb->base_prefix.'deploy_list';
            $row = $wpdb->get_results( "SELECT * FROM $tableName");
            $newUrl = WPTODEPLOY_OPTIONS['deploy-url'];

            if(!empty($row)){
                foreach($row as $r){
                    list_deploy::save_html($r->post_url, $r->post_dir, $newUrl);
                }

                list_deploy::s3_up();

                $wpdb->query("TRUNCATE TABLE $tableName");

                list_deploy::delete_directory(WPTODEPLOY_FOLDER);

                echo json_encode( array('success' => true, 'msg' => 'Deploy realizado com sucesso!') );

            } else {
                echo json_encode( array('success' => false, 'msg' => 'Nenhum item encontrado.') );
            }

            exit;
            
        }

        public static function wptdp_custompage(){
            $url = $_POST['url'];

            list_deploy::add_page($url);

            echo json_encode( array('success' => true, 'msg' => 'Página adicionada com sucesso!') );

            exit;

        }

        public static function wptdp_removePage(){
            global $wpdb;
            $tableName = $wpdb->base_prefix.'deploy_list';
            $id = $_POST['id'];
            $row = $wpdb->get_results( "SELECT * FROM $tableName WHERE id LIKE $id");

            if(!empty($row)){
                $wpdb->delete( $tableName, array( 'id' => $id ) );

                echo json_encode( array('success' => true, 'msg' => 'Deploy realizado com sucesso!') );

            } else {
                echo json_encode( array('success' => false, 'msg' => 'Nenhum item encontrado.') );
            }

            exit;

        }

        public function includes(){
            
            //XBOX
            include_once( WPTODEPLOY_ABSPATH . 'lib/xbox/xbox.php' );
            //HELPERS
            include_once( WPTODEPLOY_ABSPATH . 'lib/helpers/db_connect.php' );
            include_once( WPTODEPLOY_ABSPATH . 'lib/helpers/deploy_list.php' );
            //PAGES
            include_once( WPTODEPLOY_ABSPATH . 'pages/dashboard.php' );
        }

        public function init_hooks(){
            register_activation_hook(__FILE__, [$this, 'on_activate']);
            register_deactivation_hook(__FILE__, [$this, 'on_deactivate']);
            add_action( 'xbox_init', [dash_deploy::class, 'page_home'] );
            add_action('admin_bar_menu', [dash_deploy::class, 'topbar_btn'], 100);
            add_action('admin_footer', [dash_deploy::class, 'deploy_loader']);
            add_action( 'save_post', [list_deploy::class, 'on_update'], 10, 3 );

            //AJAX DEPLOY
            add_action('wp_ajax_nopriv_wptdp_deploy', [$this, 'wptdp_deploy']);
            add_action('wp_ajax_wptdp_deploy', [$this, 'wptdp_deploy']);

            //AJAX REMOVE PAGE
            add_action('wp_ajax_nopriv_wptdp_removePage', [$this, 'wptdp_removePage']);
            add_action('wp_ajax_wptdp_removePage', [$this, 'wptdp_removePage']);

            //AJAX NEW PAGE
            add_action('wp_ajax_nopriv_wptdp_custompage', [$this, 'wptdp_custompage']);
            add_action('wp_ajax_wptdp_custompage', [$this, 'wptdp_custompage']);

        }

        public function define_constants(){
            $siteurl = get_site_option( 'siteurl' );

            $this->define( 'WPTODEPLOY_ABSPATH', dirname( __FILE__ ) . '/' );
            $this->define( 'WPTODEPLOY_VERSION', $this->version );
            $this->define( 'WPTODEPLOY_DBVERSION', $this->db_version );
            $this->define( 'WPTODEPLOY_FOLDER', ABSPATH . 'wp-content/static-deploy' );
            $this->define( 'WPTODEPLOY_URL', plugins_url('/wp-to-deploy'));
            $this->define( 'WPTODEPLOY_SITEURL', $siteurl);
            $this->define('WPTODEPLOY_OPTIONS', get_option('wp-to-deploy'));
            $this->define('WPTODEPLOY_SCRIPTS', $this->public_javascripts());
            $this->define('WPTODEPLOY_STYLES', $this->public_stylesheets());
        }


        function on_activate(){
            //register_uninstall_hook(__FILE__, [$this, 'on_uninstall']);
            db_deploy::create_deployTable();
            if(!file_exists(WPTODEPLOY_FOLDER)){
                wp_mkdir_p(WPTODEPLOY_FOLDER);
            }
        }
        public function on_deactivate(){
        }
        public function on_uninstall(){
            db_deploy::remove_deployTable();
        }

    }

endif;

$WPTODEPLOY = new WpToDeploy;