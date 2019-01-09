<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');   

function is_exist(){
	global $wpdb;            
    $titles = "INSERT INTO wp_posts (post_author,post_title,post_content,post_excerpt,to_ping,pinged,post_content_filtered)  VALUES (1,'aa','aaa','1','2','1','12')"; 
    return $wpdb->get_results($titles); 
}
is_exist();
die;
