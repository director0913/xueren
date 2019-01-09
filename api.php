<?php 
define('PATH', (dirname(__FILE__)).'/');  
require_once(PATH . '/wp-blog-header.php');  
$parm = $_SERVER["QUERY_STRING"];
$info = get_posts($parm);
$ad = '[<script type="text/javascript">var sogou_ad_id=981794;var sogou_ad_content_height=90;</script><script type="text/javascript" src="https://theta.sogoucdn.com/wap/js/wp.js"></script>]';
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
echo json_encode($info,true);
/*请求参数
分类id   category    1
页码数  numberposts  10*/