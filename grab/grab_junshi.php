<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');   
//历史 这个是接口
$url = 'http://www.miercn.com/zbs/getDatanew?type=1&page=';
$api = 'http://www.miercn.com/zbs/getDatanew?type=1&page=';
set_time_limit(0);
// 获取页码
function getPages($url){
	$DX_Auto_Save_Images = new DX_Auto_Save_Images1();
	$info = [];
	for ($i=1; $i < 10; $i++) { 
		$listInfo = file_get_contents($url.$i);
		$listInfo = json_decode($listInfo);
		if ($listInfo->list) {
			foreach ($listInfo->list as $k => $v) {
				$info['title'] = $v->title;
				$info['href'] = $v->url?$v->url:'';
				if ($info['href']) {
					$info['info'] = getInfo($info['href']);
					if ($info['info'] && !is_exist($info['title'])) {
						$id = insertPost($info);
						if ($id) {
							$my_post['ID'] = $id;
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
function getInfo($url){
	$html = file_get_html($url);
	if ($html) {
		$info = $html->find('div[id=J-contain_detail_cnt]',0)->innertext ;
		return $info;
	}
	return '';
}
function getAll($url){
	$title = getPages($url);
	return $title;
}
function insertPost($v){
	global $wpdb;
	$script="'<script[^>]*?>.*?</script>'si ";
	$style="'<style[^>]*?>.*?</style>'si ";
  	$v['info']=preg_replace("$script","",$v['info']);
  	$v['info']=preg_replace("$style","",$v['info']);
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
	$wpdb -> insert("wp_posts", $parm);
	$id = $wpdb ->insert_id;
	$parmRea['term_taxonomy_id'] = 23;
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
$res = getAll($api);
die;
