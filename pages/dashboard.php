<?php
/*
Plugin Dashboard
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'dash_deploy' ) ) :

    class dash_deploy{

        public static function page_home(){

            global $wpdb;
            $tableName = $wpdb->base_prefix.'deploy_list';

            $row = $wpdb->get_results( "SELECT * FROM $tableName");
            $tabela = '';
            if($row){
                foreach($row as $r){
                    $tabela .= '<tr id="'.$r->id.'">';
                    $tabela .= '<td>'.$r->post_url.'</td>';
                    $tabela .= '<td>'.$r->post_dir.'</td>';
                    $tabela .= '<td>'.$r->post_type.'</td>';
                    $tabela .= '<td>'.$r->created_at.'</td>';
                    $tabela .= '<td><button type="button" id="removeTD" data-id="'.$r->id.'"><i class="icon-sw-off"></i></button></td>';
                    $tabela .= '</tr>';
                }
            }

            $options = array(
                'id' => 'wp-to-deploy',
                'title' => 'Wp to Deploy',
                'menu_title' => 'Wp to Deploy',
                'icon' => WPTODEPLOY_URL.'/assets/images/miniLogo.svg',//Menu icon
                'skin' => 'bluepurple',// Skins: blue, lightblue, green, teal, pink, purple, bluepurple, yellow, orange'
                'layout' => 'boxed',//wide
                'header' => array(
                    'icon' => '<img src="'.WPTODEPLOY_URL.'/assets/images/logo.svg" style="max-width: 50px;"/>',
                    'desc' => __( 'Convert WP to HTML and deploy to AWS or save zip file.', 'wp-to-deploy' ),
                ),
                'import_message' => __( 'Settings imported. This is just an example. No data imported.', 'wp-to-deploy' ),
                'capability' => 'edit_published_posts',
            );
        
            $xbox = xbox_new_admin_page( $options );
        
            $xbox->add_main_tab( array(
                'name' => 'Main tab',
                'id' => 'main-tab',
                'items' => array(
                    'geral' => '<i class="xbox-icon xbox-icon-image"></i>General',
                    'deplist' => '<i class="xbox-icon xbox-icon-list-alt"></i>Deploy List',
                    'import' => '<i class="xbox-icon xbox-icon-database"></i>Import/Export',
                ),
            ));
                //GERAL
                $xbox->open_tab_item('geral');
                    $xbox->add_tab( array(
                        'name' => 'Geral',
                        'id' => 'geral-tabs',
                        'items' => array(
                            'geral-options' => __( 'General Options', 'wp-to-deploy' ),
                            'geral-amazon' => __( 'Amazon S3', 'wp-to-deploy' ),
                        ),
                    ));
                    //GERAL OPTIONS
                    $xbox->open_tab_item('geral-options');
                        $xbox->add_field(array(
                            'id' => 'deploy-url',
                            'name' => __( 'URL to Deploy', 'wp-to-deploy' ),
                            'type' => 'text',
                            'desc' => __( 'Project destination URL.', 'wp-to-deploy' ),
                        ));
                        $xbox->open_mixed_field(array('name' => __( 'Subdirectory', 'wp-to-deploy' )));
                            $xbox->add_field(array(
                                'name' => __( 'Enable', 'wp-to-deploy' ),
                                'id' => 'ativa-subdiretorio',
                                'type' => 'switcher',
                                'default' => 'off',
                            ));
                            $xbox->add_field(array(
                                'id' => 'subdiretorio',
                                'name' =>  __( 'Subdirectory', 'wp-to-deploy' ),
                                'type' => 'text',
                                'grid' => '5-of-6',
                                'desc' => 'Subdirectory in deploy folder.',
                                'options' => array(
                                    'show_if' => array('ativa-subdiretorio', '=', 'on')
                                )
                            ));
                        $xbox->close_mixed_field();
                        
                    $xbox->close_tab_item('geral-options');
                    //END GERAL OPTIONS
                    //AMAZON OPTIONS
                    $xbox->open_tab_item('geral-amazon');
                        $xbox->add_field(array(
                            'id' => 's3_bucket',
                            'name' => __('S3 Bucket', 'wp-to-deploy'),
                            'type' => 'text',
                        ));
                        $xbox->add_field(array(
                            'id' => 'aws_access_key_id',
                            'name' => __('AWS Access Key ID', 'wp-to-deploy'),
                            'type' => 'text',
                        ));
                        $xbox->add_field(array(
                            'id' => 'aws_access_key',
                            'name' => __('AWS Secret Access Key', 'wp-to-deploy'),
                            'type' => 'text',
                        ));
                        $xbox->add_field(array(
                            'id' => 's3_region',
                            'name' => __('S3 Region', 'wp-to-deploy'),
                            'type' => 'select',
                            'items' => array(
                                'us-east-1' => 'US East (N. Virginia)',
                                'us-east-2' => 'US East (Ohio)',
                                'us-west-1' => 'US West (N. California)',
                                'us-west-2' => 'US West (Oregon)',
                                'af-south-1' => 'Africa (Cape Town)',
                                'ap-east-1' => 'Asia Pacific (Hong Kong)',
                                'ap-south-1' => 'Asia Pacific (Mumbai)',
                                'ap-northeast-1' => 'Asia Pacific (Tokyo)',
                                'ap-southeast-1' => 'Asia Pacific (Singapore)',
                                'ap-southeast-2' => 'Asia Pacific (Sydney)',
                                'ap-northeast-2' => 'Asia Pacific (Seoul)',
                                'ap-northeast-3' => 'Asia Pacific (Osaka)',
                                'ca-central-1' => 'Canada (Central)',
                                'cn-north-1' => 'China (Beijing)',
                                'cn-northwest-1' => 'China (Ningxia)',
                                'eu-central-1' => 'Europe (Frankfurt)',
                                'eu-west-1' => 'Europe (Ireland)',
                                'eu-west-2' => 'Europe (London)',
                                'eu-west-3' => 'Europe (Paris)',
                                'eu-south-1' => 'Europe (Milan)',
                                'eu-north-1' => 'Europe (Stockholm)',
                                'sa-east-1' => 'South America (São Paulo)',
                                'me-south-1' => 'Middle East (Bahrain)',
                                'us-gov-east-1' => 'AWS GovCloud (US-East)',
                                'us-gov-west-1' => 'AWS GovCloud (US-West)'
                            ),
                        ));
                    $xbox->close_tab_item('geral-amazon');
                    //END AMAZON
        
                $xbox->close_tab('geral-tabs');
        
                $xbox->close_tab_item('geral');
                //END GERAL
                //DEPLOY LIST
                $xbox->open_tab_item('deplist');
                    $section_header_1 = $xbox->add_section( array(
                        'name' => 'Deploy List',
                        'id' => 'section-deplist',
                        'options' => array(
                            'toggle' => true,
                        )
                    ));
                        $section_header_1->add_field( array(
                            'name' => 'List of pages to deploy',
                            'id' => 'pages-list',
                            'type' => 'html',
                            'content' => '
                            <style>table {
                                font-family: arial, sans-serif;
                                border-collapse: collapse;
                                width: 100%;
                              }
                              
                              td, th {
                                border: 1px solid #e2e5ea;
                                text-align: left;
                                padding: 8px!important;
                              }
                              
                              tr:nth-child(even) {
                                background-color: #f1f2f5;
                              }
                              .xbox-field.xbox-field-id-pages-list {
                                width: 100%;
                            }
                            .deploy{
                                padding: 15px 0;
                                text-align: center;
                            }
                              </style>
                            <table width="100%" id="tabela_deploy">
                            <thead>
                            <tr>
                              <th>URL</th>
                              <th>Slug</th>
                              <th>PostType</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            '.$tabela.'
                            </tbody>
                          </table>
                          <div class="deploy">
                            <button type="button" class="xbox-form-btn xbox-btn xbox-btn-bluepurple" id="deployBtn"> Deploy List </button>
                        </div>
                                    ',
                        ));
                        $section_header_1->add_field( array(
                            'name' => 'Custom page to deploy',
                            'id' => 'custom-page',
                            'type' => 'html',
                            'content' => '<button type="button" class="xbox-form-btn xbox-btn xbox-btn-green" id="addCustomPage"> Add Custom Page to Deploy </button>',
                        ));
        
                $xbox->close_tab_item('deplist');
        
                $xbox->open_tab_item('import');
                    $xbox->add_import_field(array(
                        'name' => 'Select file',
                        'options' => array(
                            'import_from_file' => true,
                            'import_from_url' => true,
                            'width' => '200px'
                        )
                    ));
        
                    $xbox->add_export_field(array(
                        'name' => 'Export',
                        'desc' => __( 'Download and make a backup of your options.', 'wp-to-deploy' ),
                    ));
                $xbox->close_tab_item('import');
        
            $xbox->close_tab('main-tab');
         
        }

        public static function load_admin_styles(){
            if(is_admin()){
                    add_action( 'admin_enqueue_scripts', function(){
                        wp_enqueue_script( 'deploy_ajax', WPTODEPLOY_SCRIPTS . 'deploy_ajax.js', array( 'jquery' ));
                    });

                    add_action( 'admin_enqueue_scripts', function(){
                        wp_enqueue_style( 'deploy_styles', WPTODEPLOY_STYLES . 'deploy.css');
                    } );
            }
        }

        public static function deploy_loader(){
            ?>
                        <div class="deploy_loader">
                            <div class="content">
                                <img src="<?php echo WPTODEPLOY_URL.'/assets/images/loader.gif'; ?>" alt="Loader">
                                <h1><?php echo __('Deploying pages', 'wp-to-deploy') ?></h1>
                                <p><?php echo __('Please do not refresh this page.', 'wp-to-deploy') ?></p>
                            </div>
                        </div>

                        <div class="custom_page_deploy">
                        <div class="loader_dep">
                                    <img src="<?php echo WPTODEPLOY_URL.'/assets/images/loader.gif'; ?>" alt="Loader">
                                </div>
                            <div class="cont">
                                <button class="closeDep"><i class="icon-sw-off"></i></button>
                                <div style="text-align:center; margin-bottom: 30px">
                                <h2>Add new page to deploy</h2>
                                </div>
                                <form action="" id="createCustomPage">
                                    <div class="form-group">
                                                <input type="text" name="url" placeholder="URL" id="url">
                                        </div>
                                    <div class="deploy_submit">
                                        <button type="submit" class="xbox-form-btn xbox-btn xbox-btn-bluepurple" style="margin-top:0;width: 160px"> Add Page </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <?php
        }

        public static function topbar_btn($admin_bar){
            global $pagenow, $wpdb;
            if(is_admin()){
            $tableName = $wpdb->base_prefix.'deploy_list';
            $row = $wpdb->get_results( "SELECT * FROM $tableName");

            $admin_bar->add_menu( array( 'id'=>'deployBtn','title'=>'Deploy List ('.count($row).')','href'=>'#' ) );
            }
        }

    }

endif;