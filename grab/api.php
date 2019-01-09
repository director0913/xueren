<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/../wp-blog-header.php');  
$key = $_GET['key']?$_GET['key']: '';
if (md5('shouxin')!=$key) {
   header('HTTP/1.1 404 Not Found');die;
 } 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$category = (get_query_var('category')) ? get_query_var('category') : '';
$offset = ($paged-1)*10?($paged-1)*10:0;
$args = array(
    'numberposts'     => 10,
    'offset'          => $offset,
    'category'        => $category,
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'include'         => '',
    'exclude'         => '',
    'meta_key'        => '',
    'meta_value'      => '',
    'post_type'       => 'post',
    'post_mime_type'  => '',
    'post_parent'     => '',
    'post_status'     => 'publish' );
    		//var_dump($args);die;
$info = get_posts($args);
$ad = '';
if (!$ad) {
  echo json_encode($info,true);
}else{
  if ($info) {
    foreach ($info as $k => $v) {
      if ($k==2) {
        $info = wpjam_array_push($info,$ad,$k);
        break;
      }
    }
    foreach ($info as $k => $v) {
      if ($k==6) {
        $info = wpjam_array_push($info,$ad,$k);
        break;
      }
    }
    foreach ($info as $k => $v) {
      if ($k==10) {
        $info = wpjam_array_push($info,$ad,$k);
        break;
      }
    }
  }
  echo json_encode($info,true);
}

function wpjam_array_push($array, $data=null, $key=false){
  $data  = (array)$data;
  $offset  = ($key===false)?false:array_search($key, array_keys($array));
  $offset  = ($offset)?$offset:false;
  if($offset){
    return array_merge(
      array_slice($array, 0, $offset),
      $data,
      array_slice($array, $offset)
    );
  }else{  // 没指定 $key 或者找不到，就直接加到末尾
    return array_merge($array, $data);
  }
}

/*请求参数
分类id   category    1
页码数  numberposts  10*/