<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');   
//猎奇 抓取
ini_set('max_execution_time', '0');
set_time_limit(0);

//插入数据
class insertData{
	function insertPost($data,$term_taxonomy_id=''){
		global $wpdb;
		$post_date = date('Y-m-d H:i:s',time());
		$post_date_gmt = date('Y-m-d H:i:s',time());
		$parm['post_author']           = '7';
		$parm['post_date']             = $post_date;
		$parm['post_date_gmt']         = $post_date_gmt;
		$parm['post_content']          = $data['info']?$data['info']:'';
		$parm['post_title']            = wp_strip_all_tags($data['title'])?wp_strip_all_tags($data['title']):'';
		$parm['post_excerpt']          = wp_strip_all_tags($data['post_excerpt'])?wp_strip_all_tags($data['post_excerpt']):'';
		$parm['post_status']           = 'publish';
		$parm['comment_status']        = 'closed';
		$parm['ping_status']           = 'open';
		$parm['post_password']         = '';
		$parm['post_name']             = wp_strip_all_tags($data['title'])?wp_strip_all_tags($data['title']):'';
		$parm['to_ping']               = 'inherit';
		$parm['pinged']                = '';
		$parm['post_modified']         = $post_date;
		$parm['post_modified_gmt']     = $post_date_gmt;
		$parm['post_content_filtered'] = '';
		$parm['post_parent']           = '';
		$parm['menu_order']            = 0;
		$parm['post_type']             = 'post';
		$parm['post_mime_type']        = '';
		$parm['comment_count']         = 0;
		$id = wp_insert_post($parm);
		$wpdb -> update("wp_term_relationships", array("term_taxonomy_id" => $term_taxonomy_id, "term_order" => 0),array("object_id" => $id,), array("%d", "%d", "%d"),array("%d"));
	}
	function is_exist($title){
		global $wpdb;            
	    $titles = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'
	                AND post_title = '{$title}' "; 
	    return $wpdb->get_results($titles); 
	}
}
