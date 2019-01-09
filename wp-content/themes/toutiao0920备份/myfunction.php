<?php 

/* 
 * post related
 * ====================================================
*/
function hui_posts_related($title='', $limit=8, $model='thumb'){
    global $post;

    $exclude_id = $post->ID; 
    $posttags = get_the_tags(); 
    $i = 0;
    echo '<div class="relates'.' relates-model-'.$model.'"><h3 class="title"><strong>'.$title.'</strong></h3><ul>';
    if ( $posttags ) { 
        $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
        $args = array(
            'post_status' => 'publish',
            'tag_slug__in' => explode(',', $tags), 
            'post__not_in' => explode(',', $exclude_id), 
            'ignore_sticky_posts' => 1, 
            'orderby' => 'comment_date', 
            'posts_per_page' => $limit
        );
        query_posts($args); 
        while( have_posts() ) { the_post();
            echo '<li><a'.hui_target_blank().' href="'.get_permalink().'">';

            if( $model == 'thumb' ){
                echo hui_get_thumbnail();
            }

            echo get_the_title().get_the_subtitle().'</a></li>';

            $exclude_id .= ',' . $post->ID; $i ++;
        };
        wp_reset_query();
    }
    if ( $i < $limit ) { 
        $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
        $args = array(
            'category__in' => explode(',', $cats), 
            'post__not_in' => explode(',', $exclude_id),
            'ignore_sticky_posts' => 1,
            'orderby' => 'comment_date',
            'posts_per_page' => $limit - $i
        );
        query_posts($args);
        while( have_posts() ) { the_post();
            echo '<li><a'.hui_target_blank().' href="'.get_permalink().'">';

            if( $model == 'thumb' ){
                echo hui_get_thumbnail();
            }

            echo get_the_title().get_the_subtitle().'</a></li>';

            $i ++;
        };
        wp_reset_query();
    }
    if ( $i == 0 ){
        echo '暂无内容！';
    }
    
    echo '</ul></div>';
}

?>