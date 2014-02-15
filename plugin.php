<?php
/*
Plugin Name: Webmaster.Net Post Quality Analyzer
Plugin URI: http://triagis.com 
Description: Liteweight backend solution to quickly analyze the quality of your Wordpress posts 
Version: 1.04 
Author: Webmaster.Net 
Author URI: http://webmaster.net
Author Email: contact@webmaster.net
*/
/*

= 1.04 =
Fixed function error
*/
set_time_limit(0);
register_activation_hook(__FILE__, 'activate_post_analyzer');
//callback function
function activate_post_analyzer()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "post_analyzer";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
 
			  `pa_id` int(11) NOT NULL AUTO_INCREMENT,
 
			  `word_count` int(11) DEFAULT NULL,
 
			  `no_images` int(11) DEFAULT NULL,
 
			  `headlines` int(11) DEFAULT NULL,
 
			  `paragraph` int(11) DEFAULT NULL,
  
			  `date_updated` int(11) DEFAULT NULL,
 
			  `post_id` int(11) NOT NULL,
 
			  PRIMARY KEY (`pa_id`),
 
			  KEY `post_id` (`post_id`)
 

			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        //reference to upgrade.php file
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
register_deactivation_hook(__FILE__, 'deactivate_post_analyzer');
function deactivate_post_analyzer()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "post_analyzer";
    mysql_query("DROP TABLE IF EXISTS $table_name");
}
function video_xml($content, $tag)
{
    $doc = new DOMDocument();
    $doc->loadHTML($content);
    $xml  = simplexml_import_dom($doc);
    $data = $xml->xpath('//' . $tag);
    return $data;
}
function post_analyzer()
{
    global $wpdb;
    global $post;
    $analyse_posts = get_posts(array(
        'post_type' => 'post',
        'posts_per_page' => '-1',
        'orderby' => 'ID',
        'order' => 'ASC'
    ));
    apply_filters('get_the_date', @$the_date);
    $loop_c = 0;
    //echo "<pre>";print_r($rev_posts); exit();
    mysql_query("delete from " . $wpdb->prefix . "post_analyzer");
    if (count($analyse_posts) > 0) {
        foreach ($analyse_posts as $post) {
            setup_postdata($post);
            $pid         = $post->ID;
            $content     = apply_filters('get_the_content', get_the_content());
            $postDate    = strtotime($post->post_date);
            $arr_words   = explode(' ', strip_tags($content));
            $count_words = count($arr_words);
            $img_arr     = video_xml($content, 'img');
            $count_img   = count($img_arr);
            $arry_lines  = preg_split("/\r?\n/", $content);
            $count_p     = count($arry_lines);
            $tag         = array(
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6'
            );
            $tags        = 0;
            foreach ($tag as $key => $val) {
                $t_arr = video_xml($content, $val);
                $tags  = $tags + count($t_arr);
            }
            $date = ceil(abs(time() - $postDate) / 86400);
            //echo '='.$date.'=';
            $qry  = "insert into " . $wpdb->prefix . "post_analyzer (word_count, no_images, headlines, paragraph, date_updated, post_id) values('$count_words', '$count_img', '$tags', '$count_p', '$date', '$pid')";
            mysql_query($qry);
        }
    }
 
    exit;
}
function savecsv($CSV_string)
{
    //update_post_meta($post->ID, "post_slider_video", $post->post_name.".mp4");
    $csv_name = date('Y-m-d'); //.'-'.time();
    $file     = WP_PLUGIN_DIR . "/post-analyzer/csv/" . $csv_name . ".csv"; //For avoiding cache in the client and on the server
    $fh       = fopen($file, 'w');
    fputcsv($fh, $CSV_string, ",", '/n');
    fclose($fh);
} 
// create custom plugin settings menu
add_action('admin_menu', 'panalyzer_create_menu');
function panalyzer_create_menu()
{
    //create new top-level menu
    add_menu_page('Post Analyzer Plugin Settings', 'Webmaster.Net Post Analyzer', 'administrator', 'panalyzer_main_menu', 'panalyzer_settings_page', plugins_url('/images/icon.png', __FILE__));
    add_submenu_page('panalyzer_main_menu', 'Analyzer Setting', 'Settings', 'administrator', 'gps-settings', 'panalyzer_settings_function');
    add_submenu_page('panalyzer_main_menu', 'Post CSV', 'Post CSV', 'administrator', 'gps-csv', 'gps_csv_function');
    add_submenu_page('panalyzer_main_menu', 'Training Session', 'Training Session', 'administrator', 'gps-training', 'gps_training_function');
    //call register settings function
    add_action('admin_init', 'register_mysettings');
}
function gps_training_function()
{
    include("views/training.php");
}
function gps_csv_function()
{
    include("views/csv.php");
}
function panalyzer_settings_function()
{
    include("inc/custom-meta-configuration.php");
}
function register_mysettings()
{
    //register our settings
}
function panalyzer_settings_page()
{
    include plugin_dir_path(__FILE__) . '/views/admin-page.php';
}
add_action('wp_ajax_analyze_post', 'post_analyzer');
add_action('wp_ajax_nopriv_analyze_post', 'post_analyzer'); //for users that are not logged in.
 