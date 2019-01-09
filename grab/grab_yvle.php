<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');   
//猎奇 抓取
$url = 'http://yule.360.cn/feeds/getListByTag?tag=%E6%98%8E%E6%98%9F&pn=';
ini_set('max_execution_time', '0');
set_time_limit(0);
global $wpdb; 
//var_dump($wpdb);die;
function getTitle($url){
	global $wpdb; 
	$DX_Auto_Save_Images = new DX_Auto_Save_Images1();
	$info = [];
	for ($i=1; $i < 10; $i++) { 
		$listInfo = file_get_contents($url.$i);
		$listInfo = json_decode($listInfo);
		if ($listInfo->data->list) {
			foreach ($listInfo->data->list as $k => $v) {
				$info['title'] = $v->text;
				$info['href'] = $v->url?$v->url:'';
				if ($info['href']) {
					$info['info'] = getInfo($info['href']);
					if ($info['info'] && !is_exist($info['title'])) {
						$id = insertPost($info);
						if ($id) {
							$info['info'] = $DX_Auto_Save_Images->post_save_images($info['info'],$id);
							$titles = "UPDATE  $wpdb->posts SET  post_content = ".$info['info']." WHERE ID='$id' "; 
    						$wpdb->get_results($titles); 
						}
					}	
				}
			}
		}
	}
	return $info;


	
}
// 获取页码
function getPages($url){
	$html = file_get_html($url);
	$pages[]['href'] = $url;
	foreach($html->find('div.pagebar a') as $k => $v) {
		if ($k<5) {
			if ($v->href) {
				$pages[$k+1]['href'] = $v->href;
			}
		}	
	}
	return $pages;
}
function getInfo($url){
	$html = file_get_html($url);
	if ($html) {
		$info = $html->find('div.box03_left',0)->innertext ;
		return $info;
	}
	return '';
}
function getAll($url){
//	$pages = getPages($url);
	$title = getTitle($url);
	return $title;
}
function insertPost($v){
	global $wpdb;
	$post_date = date('Y-m-d H:i:s',time());
	$post_date_gmt = date('Y-m-d H:i:s',time());
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
	$parm['post_name']             = wp_strip_all_tags($v['title'])?wp_strip_all_tags($v['title']):'';
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
	
	$wpdb -> insert("wp_posts", $parm);
	$id = $wpdb ->insert_id;
	$parmRea['term_taxonomy_id'] = 1;
	$parmRea['term_order'] = 0;
	$parmRea['object_id'] = $id;
	$wpdb -> insert("wp_term_relationships", $parmRea);


	return $id;
}
function is_exist($title){
	global $wpdb;            
    $titles = "SELECT post_title FROM $wpdb->posts WHERE  post_title = '$title' "; 
    return $wpdb->get_results($titles); 
}
$res = getAll($url);
die;
