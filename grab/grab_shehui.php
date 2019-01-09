<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');   

$url = 'http://society.huanqiu.com/societylaw/';
ini_set('max_execution_time', '0');
set_time_limit(0);

//var_dump($wpdb);die;
function getTitle($url){
	// $url[0]['href'] = $pages;
	// $pages = [];
	// $pages =$url;
	$DX_Auto_Save_Images = new DX_Auto_Save_Images1();
	$info = [];
	for ($i=1; $i < 10 ; $i++) { 
		if ($i==1) {
			$url = $url;
		}else{
			$url = $url.$i.'html';
		}
		$html = file_get_html($url);
			foreach($html->find('ul.listPicBox li h5') as $k => $v) {
				$info['plaintext'] = $v->plaintext;
			}
			foreach($html->find('ul.listPicBox li h3 a') as $k => $v) {
				$info['title'] = $v->title;
				$info['href'] = $v->href?$v->href:'';
				if ($info['href']) {
					$info['info'] = getInfo($v->href);
					if ($info['info']) {
						$info['info'] = $DX_Auto_Save_Images->post_save_images($info['info']);
						if ($info['info'] && !is_exist($info['title'])) {
							insertPost($info);
						}
					}
				}	
			}
	}
}
function getInfo($url){
	$html = file_get_html($url);
	if ($html) {
		$info = $html->find('div.la_con',0)->innertext ;
		return $info;
	}
	return '';
}
function getAll($url){
	$title = getTitle($url);
	return $title;
}
function insertPost($v){
	global $wpdb;
	$post_date = date('Y-m-d H:i:s',time());
	$post_date_gmt = date('Y-m-d H:i:s',time());
	$script="'<script[^>]*?>.*?</script>'si ";
	$style="'<style[^>]*?>.*?</style>'si ";
  	$v['info']=preg_replace("$script","",$v['info']);
  	$v['info']=preg_replace("$style","",$v['info']);
	$parm['post_author']           = '7';
	$parm['post_date']             = $post_date;
	$parm['post_date_gmt']         = $post_date_gmt;
	$parm['post_content']          = ($v['info']);
	$parm['post_title']            = wp_strip_all_tags($v['title']);
	$parm['post_excerpt']            = wp_strip_all_tags($v['post_excerpt']);
	$parm['post_status']           = 'publish';
	$parm['comment_status']        = 'closed';
	$parm['ping_status']           = 'open';
	$parm['post_password']         = '';
	$parm['post_name']             = wp_strip_all_tags($v['title']);
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
	//var_dump($parm);die;
	$id = wp_insert_post($parm);
	$id = $wpdb -> update("wp_term_relationships", array("term_taxonomy_id" => 6, "term_order" => 0),array("object_id" => $id,), array("%d", "%d", "%d"),array("%d"));
}
function is_exist($title){
	global $wpdb;            
    $titles = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'
                AND post_title = '{$title}' "; 
    return $wpdb->get_results($titles); 
}
$res = getAll($url);
die;
