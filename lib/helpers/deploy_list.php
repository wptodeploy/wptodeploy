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

                if($post->post_type != 'page'){

                    if(self::cpt_has_archive($post->post_type)){

                        $cptUrl = get_post_type_archive_link('novidade');
                        $cptParsedUrl = parse_url($cptUrl);
                        $cpt_dir = $cptParsedUrl['path'];

                        $infoCpt = array(
                            'post_id' => '0',
                            'post_url' => $cptUrl,
                            'post_dir' => $cpt_dir,
                            'post_type' => 'base_'.$post->post_type,
                            'post_title' => $post->post_type,
                            'created_at' => gmdate('Y-m-d H:i:s'),
                        );

                        $result = $wpdb->update($tableName, $infoCpt, array('post_type' => $infoCpt["post_type"]));

                        if ($result === FALSE || $result < 1) {
                            $wpdb->insert($tableName, $infoCpt);
                        }

                        $html = file_get_contents($cptUrl);
                        //Create a new DOM document
                        $dom = new DOMDocument;

                        //Parse the HTML. The @ is used to suppress any parsing errors
                        //that will be thrown if the $html string isn't valid XHTML.
                        @$dom->loadHTML($html);

                        //Get all links. You could also use any other tag name here,
                        //like 'img' or 'table', to extract other tags.
                        $links = $dom->getElementsByTagName('a');

                        //Iterate over the extracted links and display their URLs
                        foreach ($links as $link){
                            if(strpos($link->getAttribute('href'), $cpt_dir.'page') !== false){

                                $pageParsedUrl = parse_url($link->getAttribute('href'));
                                $page_dir = $pageParsedUrl['path'];

                                $infopage = array(
                                    'post_id' => '0',
                                    'post_url' => $link->getAttribute('href'),
                                    'post_dir' => $page_dir,
                                    'post_type' => 'page_'.$post->post_type,
                                    'post_title' => 'Page '.$link->nodeValue,
                                    'created_at' => gmdate('Y-m-d H:i:s'),
                                );
        
                                $result = $wpdb->update($tableName, $infopage, array('post_url' => $infopage["post_url"]));
        
                                if ($result === FALSE || $result < 1) {
                                    $wpdb->insert($tableName, $infopage);
                                }

                            }
                            
                        }

                    }

                }

            endif;            

        }

        static function save_html($permalink, $subfolder, $newUrl){

            self::delete_directory(WPTODEPLOY_FOLDER);

            $subDirActive = WPTODEPLOY_OPTIONS['ativa-subdiretorio'];

            if($subDirActive == 'on'){
                $subDir = WPTODEPLOY_OPTIONS['subdiretorio'];
                $deployFolder = WPTODEPLOY_FOLDER.'/'.$subDir;
            } else {
                $deployFolder = WPTODEPLOY_FOLDER;
            }

            $directory = $subfolder ? $deployFolder.$subfolder : $deployFolder;

            if(!file_exists($directory)){
                wp_mkdir_p($directory);
            }

            //array_map( 'unlink', array_filter((array) glob($directory.'/*') ) );

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

            $subDirActive = WPTODEPLOY_OPTIONS['ativa-subdiretorio'];

            if($subDirActive == 'on'){
                $subDir = WPTODEPLOY_OPTIONS['subdiretorio'];
                $deployFolder = $subDir;
            } else {
                $deployFolder = '/';
            }
            
            
            $dir = WPTODEPLOY_FOLDER . (WPTODEPLOY_OPTIONS['ativa-subdiretorio'] == 'on' ? '/'.WPTODEPLOY_OPTIONS['subdiretorio'] : '');

            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

            foreach ($rii as $file) {
                if ($file->isDir()){ 
                    continue;
                }
                
                $s3->putObjectAcl([
                    'Bucket' => WPTODEPLOY_OPTIONS['s3_bucket'],
                    'Key' => explode('static-deploy/', $file->getPathname())[1],
                    'ACL' => 'public-read'
                ]);
 
            }
    		
            /*
            foreach ($objects as $listResponse) {
                $items = $listResponse->search("Contents[?starts_with(Key,'".$deployFolder."')]");
                foreach($items as $item) {
                    $s3->putObjectAcl([
                        'Bucket' => WPTODEPLOY_OPTIONS['s3_bucket'],
                        'Key' => $item['Key'],
                        'ACL' => 'public-read'
                    ]);
                }
            }
			*/
            self::delete_directory(WPTODEPLOY_FOLDER);

        }

        static function delete_directory($directory) {
            /*
            foreach(glob("{$directory}/*") as $file)
            {
                if(is_dir($file)) { 
                    self::delete_directory($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($directory);

            if(!file_exists(WPTODEPLOY_FOLDER)){
                wp_mkdir_p(WPTODEPLOY_FOLDER);
            }*/
        }

        static function cpt_has_archive( $post_type ) {
            if( !is_string( $post_type ) || !isset( $post_type ) )
            return false;
            
            // find custom post types with archvies
            $args = array(
            'has_archive' => true,
            '_builtin' => false,
            );
            $output = 'names';
            $archived_custom_post_types = get_post_types( $args, $output );
            
            // if there are no custom post types, then the current post can't be one
            if( empty( $archived_custom_post_types ) )
            return false;
            
            // check if post type is a supports archives
            if ( in_array( $post_type, $archived_custom_post_types ) ) {
            return true;
            } else {
            return false;
            }
            
            // if all else fails, return false
            return false;	
            
            }

            static function add_page($url){
                global $wpdb;

                $tableName = $wpdb->base_prefix.'deploy_list';

                $permalink = $url;
                $parsedUrl = parse_url($permalink);
                $post_dir = $parsedUrl['path'];

                $info = array(
                    'post_id'       => 0,
                    'post_url' => $permalink,
                    'post_dir' => $post_dir,
                    'post_type' => 'custom_page',
                    'post_title' => 'Custom Page',
                    'created_at' => gmdate('Y-m-d H:i:s'),
                );

                $result = $wpdb->update($tableName, $info, array('post_url' => $info["post_url"]));

                if ($result === FALSE || $result < 1) {
                    $wpdb->insert($tableName, $info);
                }
            }

    }

endif;