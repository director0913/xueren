<?php
/*
 * list excerpt
 * ====================================================
*/

$etype = _hui('list_type');
$article_ad = _hui('ads_search_01_m');
$article_ad = "<article class='excerpt excerpt-multi'>".$article_ad."</article>";

$info_ad1 = _hui('info_ad1');
$info_ad1 = "<article class='excerpt excerpt-multi'>".$info_ad1."</article>";

$info_ad2 = _hui('info_ad2');
$info_ad2 = "<article class='excerpt excerpt-multi'>".$info_ad2."</article>";




$article_index = 0;
while ( have_posts() ) : the_post();
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

	echo '<article class="excerpt'.$classname.'">';
	    echo ' ';echo ' ',
	     '<p class="title_1"><a'.hui_target_blank().' href="'.get_permalink().'" title="'.get_the_title()._hui('connector').get_bloginfo('name').'">'.get_the_title().get_the_subtitle().'</a></p>',$focuscode;

	echo '</article>';
	if($article_index == 1){
		echo $article_ad;
	}
	if($article_index == 3){
		echo $info_ad1;
	}
	if($article_index == 5){
		echo $info_ad2;
	}

endwhile;
