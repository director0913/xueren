
<?php get_header(); ?>
<?php hui_logo(); ?>

<script type="text/javascript" src="/wp-content/themes/toutiao/js/flexible.js"></script>
<script type="text/javascript" src="/wp-content/themes/toutiao/js/iscroll.js"></script>
<script type="text/javascript" src="/wp-content/themes/toutiao/js/navbarscroll.js"></script>
<style type="text/css">
/*@media (max-width: 560px) {
	.wrapper01 {position:relative;height: 36px;width: 100%;overflow: hidden;margin:0 auto;border-bottom:1px solid #ccc}
	.wrapper01 .scroller {position:absolute}
	.wrapper01 .scroller li {height: 36px;color:#333;float: left;line-height: 36px;font-size: .4rem;text-align: center}
	.wrapper01 .scroller li a{color:#333;display:block;margin:0 .3rem}
	.wrapper01 .scroller li.cur a{color:#be0008;}
}*/
</style>
<header class="header">
    <div class="wrapper wrapper01" id="retr">
		<div class="scroller" >
			<?php hui_nav_menu(); ?>
	    </div>
	</div> 
    </header>
 <div class="content-wrap">
	<div class="content">
		<?php 
			if( _hui('ads_index_01_s') ) echo '<div class="ads ads-content">'.hui_get_adcode('ads_index_01').'</div>'; 
		
			if( !$paged && _hui('focusslide_s') ) hui_moloader('hui_focusslide');
		?>
		<?php echo _hui('ads_index_02_s') ? '<div class="ads ads-content">'.hui_get_adcode('ads_index_02').'</div>' : '' ?>
		<?php 
			if( $paged && $paged > 1 ){
				printf('<h3 class="title" style="border-bottom: 1px solid #e0e0e0;margin-bottom:20px; padding-bottom:10px;" ><strong>'.__('所有文章', 'haoui').'</strong> <small class="pull-right">'.__('第', 'haoui').$paged.__('页', 'haoui').'</small></h3>');
			}else{
				printf('<h3 class="title" style="border-bottom: 1px solid #e0e0e0;margin-bottom:20px; padding-bottom:10px;">'.(_hui('recent_posts_number')?'<small class="pull-right">'.__('24小时更新：', 'haoui').hui_get_recent_posts_number().__('篇', 'haoui').' &nbsp; &nbsp; '.__('一周更新：', 'haoui').hui_get_recent_posts_number(7).__('篇', 'haoui').'</small>':'').'<strong>'._hui('index_list_title').'</strong></h3>');
			}

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
			    'ignore_sticky_posts' => 1,
			    'paged' => $paged,

			);
			if( _hui('notinhome') ){
				$pool = array();
				foreach (_hui('notinhome') as $key => $value) {
					if( $value ) $pool[] = $key;
				}
				$args['cat'] = '-'.implode($pool, ',-');
			}
			$args['cat'] = $args['cat'].'21-';
			//var_dump($args);die;
			query_posts($args);

			get_template_part( 'excerpt' ); 
		?>
		<?php echo _hui('ads_index_03_s') ? '<div class="ads ads-content">'.hui_get_adcode('ads_index_03').'</div>' : '' ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>
<script type="text/javascript">
$(function(){
    $('.wrapper').navbarscroll();
    var w=$(window).width();
    if (w>414) {
    	$(".scroller").css("width","80px");
    }

 });
</script>