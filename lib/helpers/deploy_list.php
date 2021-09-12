<?php
/*
Deploy save and list
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'list_deploy' ) ) :

    class list_deploy {

        static function on_update($post_id, $post, $update){
            global $post, $wpdb;

            if($update):

                $tableName = $wpdb->base_prefix.'deploy_list';

                $permalink = get_the_permalink($post_id);
                $parsedUrl = parse_url($permalink);
                $post_dir = $parsedUrl['path'];

                $info = array(
                    'post_id'       => $post_id,
                    'post_url' => $permalink,
                    'post_dir' => $post_dir,
                    'post_type' => $post->post_type,
                    'post_title' => get_the_title($post_id),
                    'created_at' => gmdate('Y-m-d H:i:s'),
                );

                $result = $wpdb->update($tableName, $info, array('post_id' => $info["post_id"]));

                if ($result === FALSE || $result < 1) {
                    $wpdb->insert($tableName, $info);
                }

            endif;            

        }

        static function save_html($permalink, $subfolder, $newUrl){

            $directory = $subfolder ? WPTODEPLOY_FOLDER.$subfolder : WPTODEPLOY_FOLDER;

            if(!file_exists($directory)){
                wp_mkdir_p($directory);
            }

            array_map( 'unlink', array_filter((array) glob($directory.'/*') ) );

            $copy = file_get_contents($permalink);

            $new = str_replace([WPTODEPLOY_SITEURL], [$newUrl], $copy);

            //MINIFY
            $new = preg_replace('/>\s*</', '><', $new);

            file_put_contents($directory.'index.html', $new);
        }

        static function s3_up(){
            require(WPTODEPLOY_ABSPATH . 'vendor/autoload.php');

            $credentials = new Aws\Credentials\Credentials(WPTODEPLOY_OPTIONS['aws_access_key_id'], WPTODEPLOY_OPTIONS['aws_access_key']);

            $s3 = new Aws\S3\S3Client([
                'version' => 'latest',
                'region'  => WPTODEPLOY_OPTIONS['s3_region'],
                'credentials' => $credentials
            ]);

            try {
                // Send a PutObject request and get the result object.
                $insert = $s3->uploadDirectory(WPTODEPLOY_FOLDER, WPTODEPLOY_OPTIONS['s3_bucket'], null);
            
            } catch (\Exception $e) {
            
                throw $e;
                return false;
            }

            $objects = $s3->getPaginator('ListObjects', ['Bucket' => WPTODEPLOY_OPTIONS['s3_bucket']]);
    
            foreach ($objects as $listResponse) {
                $items = $listResponse->search("Contents[?starts_with(Key,'1/')]");
                foreach($items as $item) {
                    //echo $item['Key'] . '<br>';
                    $s3->putObjectAcl([
                        'Bucket' => WPTODEPLOY_OPTIONS['s3_bucket'],
                        'Key' => $item['Key'],
                        'ACL' => 'public-read'
                    ]);
                }
            }

        }

    }

endif;