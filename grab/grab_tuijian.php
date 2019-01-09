<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
require_once(PATH . '../grab/simple_html_dom.php'); 
require_once(PATH . '../grab/grab_down_img.php');   
//北京推荐 这个是接口
$url = 'https://pc.api.btime.com/btimeweb/getInfoFlow?channel=recommend&request_pos=channel&citycode=local_110100_110000&refresh=3&req_count=3&refresh_type=2&pid=3&from=&page_refresh_id=111d46c8-b33e-11e8-b989-0cc47a56fbb8&_=1536393979383';
$api = 'https://pc.api.btime.com/btimeweb/getInfoFlow?channel=recommend&request_pos=channel&citycode=local_110100_110000&refresh=3&req_count=3&refresh_type=2&pid=3&from=&page_refresh_id=111d46c8-b33e-11e8-b989-0cc47a56fbb8&_=1536393979383';
ini_set('max_execution_time', '0');
set_time_limit(0);
// 获取页码
function getPages($url){
	$info = [];
	$DX_Auto_Save_Images = new DX_Auto_Save_Images1();
	for ($i=1; $i < 3; $i++) { 
		$listInfo = file_get_contents($url.$i);
		$listInfo = json_decode($listInfo);

		if ($listInfo->data) {

			foreach ($listInfo->data as $k => $v) {

				$info['title'] = $v->data->title;
				$info['href'] = $v->url?$v->url:'';			
				if ($info['href']) {

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
		$info = $html->find('div[id=content-pure]',0)->innertext ;
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
	//var_dump($parm);die;
	$id = wp_insert_post($parm);
	$id = $wpdb -> update("wp_term_relationships", array("term_taxonomy_id" => 22, "term_order" => 0),array("object_id" => $id,), array("%d", "%d", "%d"),array("%d"));
}
function is_exist($title){
	global $wpdb;            
    $titles = "SELECT post_title FROM $wpdb->posts WHERE  post_title = '$title' "; 
    return $wpdb->get_results($titles); 
}
$res = getAll($api);
die;
