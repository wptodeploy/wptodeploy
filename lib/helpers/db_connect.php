<?php
/*
DB CONFIGURATION
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'db_deploy' ) ) :

    class db_deploy{

        public static function create_deployTable(){
            global $wpdb;

            $table_name = $wpdb->base_prefix.'deploy_list';
            $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

            if ( ! $wpdb->get_var( $query ) == $table_name ) {
                
                $wpdb_collate = $wpdb->collate;

                $sql = "CREATE TABLE `{$wpdb->base_prefix}deploy_list` (
                    id mediumint(8) unsigned NOT NULL auto_increment,
                    post_id bigint(20) NOT NULL,
                    post_url varchar(191) NOT NULL,
                    post_dir varchar(191) NOT NULL,
                    post_type varchar(191) NOT NULL,
                    post_title varchar(191) NULL,
                    created_at datetime NOT NULL,
                    PRIMARY KEY(id),
                    KEY first (post_id)
                ) COLLATE {$wpdb_collate}";

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);

            }

        }

        public static function remove_deployTable(){
            global $wpdb;
            $wpdb->query( "DROP TABLE IF EXISTS `{$wpdb->base_prefix}deploy_list`" );

        }

    }

endif;