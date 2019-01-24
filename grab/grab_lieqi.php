<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');  
//猎奇 抓取
$url = 'https://www.kqiwen.com/list/2.html';
ini_set('max_execution_time', '0');
set_time_limit(0);

global $post;
function getTitle($pages){
	$info = [];
	$DX_Auto_Save_Images = new DX_Auto_Save_Images1();

	foreach ($pages as $k1 => $v1) {
		if ($v1['href']) {
			$html = file_get_html($v1['href']);
			foreach($html->find('div.imgr p') as $k => $v) {
				$info['post_excerpt'] = $v->plaintext;
			}

			foreach($html->find('div.imgr h2 a') as $k => $v) {
				$info['title'] = $v->plaintext;
				$info['href'] = $v->href?$v->href:'';
				$info['info'] = $info['href']?getInfo($v->href):'';
				$a = is_exist($info['title']);
				if ($info['info']) {
					//$info['info'] = $DX_Auto_Save_Images->post_save_images($info['info'],$id);
					if ($info['title'] && !is_exist($info['title'])) {
						$id = insertPost($info);
						if ($id) {
							$my_post['ID'] = $id;
							$info['info'] = guolv($info['info']);
							$info['info'] = $DX_Auto_Save_Images->post_save_images($info['info'],$id);
							$my_post['post_content'] = $info['info'];
							wp_update_post( $my_post );
						}
						
					}
				}
			}	
		}
	}

	return $info;
}
function guolv($str){
    $str = preg_replace( "@<script(.*?)</script>@is", "", $str );
    $str = preg_replace( "@<iframe(.*?)</iframe>@is", "", $str );
    $str = preg_replace( "@<style(.*?)</style>@is", "", $str );
    $str = preg_replace( "@<(.*?)>@is", "", $str );
    //# 代表换行
    $str =str_replace("#","<br>",$str);
    return $str;
}

// 获取页码
function getPages($url){

	$html = file_get_html($url);
	$pages[]['href'] = $url;
	foreach($html->find('div.pagebar a') as $k => $v) {

		if ($k<2) {
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
		$info = $html->find('div.article_content',0)->innertext ;
		return $info;
	}
	return '';
}
function getAll($url){

	$pages = getPages($url);
	$title = getTitle($pages);
	return $title;
}
function insertPost($v){

	global $wpdb;
	$post_date = date('Y-m-d H:i:s',time());
	$post_date_gmt = date('Y-m-d H:i:s',time());
	$parm['post_author']           = '7';
	$parm['post_date']             = $post_date;
	$parm['post_date_gmt']         = $post_date;
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
	$parm['post_modified_gmt']     = $post_date;
	$parm['post_content_filtered'] = '';
	$parm['post_parent']           = '';
	$parm['menu_order']            = 0;
	$parm['post_type']             = 'post';
	$parm['post_mime_type']        = '';
	$parm['comment_count']         = 0;

	$wpdb -> insert("wp_posts", $parm);
	$id = $wpdb ->insert_id;
	$parmRea['term_taxonomy_id'] = 9;
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
