<?php
/*
 * list excerpt
 * ====================================================
*/

$etype = _hui('list_type');

//$article_ad = '<article class="excerpt feed_ads"><script type="text/javascript">
//	</script>
//	<script type="text/javascript" src="https://theta.sogoucdn.com/wap/js/wp.js"></script></article>';
$article_ad = '<div id="sogou_wap_953846"></div>
<script>
	var sogou_div = document.getElementById("sogou_wap_953846"); 
	window.sogou_un = window.sogou_un || [];
	window.sogou_un.push({id: "953846",ele:sogou_div});
</script>
<script async="async" src="https://theta.sogoucdn.com/wap/js/aw.js"></script>';
$ad1 = '<div id="sogou_wap_959346"></div>
<script>
	var sogou_div = document.getElementById("sogou_wap_959346"); 
	window.sogou_un = window.sogou_un || [];
	window.sogou_un.push({id: "959346",ele:sogou_div,w:20,h:6});
</script>
<script async="async" src="https://theta.sogoucdn.com/wap/js/aw.js"></script><div id="sogou_wap_959346"></div><div id="sogou_wap_959346"></div>
<script>
	var sogou_div = document.getElementById("sogou_wap_959346"); 
	window.sogou_un = window.sogou_un || [];
	window.sogou_un.push({id: "959346",ele:sogou_div,w:20,h:6});
</script>
<script async="async" src="https://theta.sogoucdn.com/wap/js/aw.js"></script><div id="sogou_wap_959346"></div>
';
$ad2= '<div id="sogou_wap_959347"></div>
<script>
	var sogou_div = document.getElementById("sogou_wap_959347"); 
	window.sogou_un = window.sogou_un || [];
	window.sogou_un.push({id: "959347",ele:sogou_div,w:20,h:6});
</script>
<script async="async" src="https://theta.sogoucdn.com/wap/js/aw.js"></script><div id="sogou_wap_959347"></div>
<script>
	var sogou_div = document.getElementById("sogou_wap_959347"); 
	window.sogou_un = window.sogou_un || [];
	window.sogou_un.push({id: "959347",ele:sogou_div,w:20,h:6});
</script>
<script async="async" src="https://theta.sogoucdn.com/wap/js/aw.js"></script>';
$article_index = 0;
global $kk;
$kk = 1;
while ( have_posts() ) : the_post();
if (is_home() && in_category('20') ) continue;
	$article_index += 1;
	$classname = '';
	$focuscode = '';

	if( $etype !== 'none' ){
	    $img_number = hui_post_images_number();
	    $has_thumb = has_post_thumbnail();

	    if( $etype == 'thumb' ){
	        $imgSingle = true;

	        if( $has_thumb || $img_number>0 ){
	            $classname = ' excerpt-one';
	        }
	    }else if( $etype == 'more' || $etype == 'multi' || $etype == 'four' ){
	        $imgSingle = false;

	        if( $has_thumb || ($img_number>0 && $img_number<3) ){
	            $classname = ' excerpt-one';
	        }else if( !$has_thumb && $img_number>=3){
	            $classname = ' excerpt-multi';
	        }
	    }

	    $focuscode = hui_get_thumbnail( $imgSingle, false );
	    $focuscode = $focuscode ? '<p class="focus"><a'.hui_target_blank().' href="'.get_permalink().'" class="thumbnail">'.$focuscode.'</a></p>' : '';
	}


	$author = get_the_author();
	if( _hui('author_link') ){
	    $author = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.$author.'</a>';
	}

	$p_meta = _hui('post_plugin');
	if ($kk==1) {
		echo $ad1;
	}
	
	echo '<article class="excerpt'.$classname.'">';
	    echo ' ';echo ' ',
	     '<p class="title_1"><a'.hui_target_blank().' href="'.get_permalink().'" title="'.get_the_title()._hui('connector').get_bloginfo('name').'">'.get_the_title().get_the_subtitle().'</a></p>',$focuscode;
	    // '<p class="note">'.hui_get_excerpt_content().'</p>';

	echo '</article>';
	if($article_index == 2){
		echo $article_ad.'<div style="border-bottom:1px solid #ccc;height:2px;width:100%;margin:20px 0;"></div>';
	}
	$kk++;

endwhile;
echo $ad2;