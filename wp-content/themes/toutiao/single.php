<?php get_header(); ?>
<?php function formatTime($date) {
$str = '';
$timer = strtotime($date);
$diff = $_SERVER['REQUEST_TIME'] - $timer;
$day = floor($diff / 86400);
$free = $diff % 86400;
if($day > 0) {
return $day."天前";
}else{
if($free>0){
$hour = floor($free / 3600);
$free = $free % 3600;
if($hour>0){
return $hour."小时前";
}else{
if($free>0){
$min = floor($free / 60);
$free = $free % 60;
if($min>0){
return $min."分钟前";
}else{
if($free>0){
return $free."秒前";
}else{
return '刚刚';
}
}
}else{
return '刚刚';
}
}
}else{
return '刚刚';
}
}
}?>
<!--<div class="mbmav">
<header class="header">
	<?php hui_nav_menu(); ?>
	</header>
</div>-->
      <div class="singlehd">
      <div class="logoimg"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo _hui('logo_src')?>" /></a>
<?php if( _hui('breadcrumbs_single_s') ){ ?><?php echo hui_breadcrumbs() ?><?php } ?></div>
  </div>
<style>
body{background-color: #fafafc;}
.mainbar,.singlehd{display:none;}
.content{margin-left:0px;padding:0;}
.singlehd{  border-bottom:1px solid #e5e5e5; padding-bottom:5px; padding-top:10px; background-color:#fafafc}

.article-meta .user_info{padding-bottom: 10px; border-bottom: 1px solid #ebebeb;}
.user_info .name_1{
    margin: 0;
    line-height: 17px;
    font-size: 12px;
    color: #9b9b9b;
}
.user_info .time_1{margin-left:10px;}
.avatar{border-radius: 50%}
.user_info .avatar_box{display: inline-block; float: left; margin-right:10px;}
.relates .title{
	margin: 5px 5px 5px 0;
    display: inline-block;
    border-left: 4px solid #e65f5f;
    height: 18px;
    line-height: 18px;
}
.relates .title .title_t{
    font-size:18px;
    color:#262626;
    margin-left: 6px;
    line-height: 18px;
    height: 18px;
    vertical-align: middle;
}
.relates .excerpt{
	border-bottom: 1px solid #dedee4;
    /* padding: 8px 0px 10px 0px;
    min-height:110px; */
    margin:13px 0 0px;
}
.relates .excerpt:last-child{
	border-bottom: none;
}
.relates .excerpt .focus{
    margin-top: 2px;
}
.relates .excerpt a{
	font-size: 17px;
    line-height: 18px;
    margin: 0px;
    color:#111;
    display: flex;
    width: 100%;
    line-height: 22px;
}
/* .relates .excerpt .title_1{
    padding: 3px 0px;
} */
.relates .excerpt-multi .title_1{
    padding: 3px 0px;
}
.relates .excerpt-one .title_1{
    padding:3px 0px;
    width:60%;
    float:left;
}
.relates .excerpt .item .thumb-span img{
	width:108px;
    height:70px;
}
.thumbnail .item{
    height:90px;
    overflow:hidden;
    margin:0 1px;
    padding:0;
    flex:1;
    width:95px;
}
.excerpt-one .focus .item {
    width:108px;
    height:70px;
}
.feed_ad{
    margin-top: 15px;
    margin-bottom: 15px;
}
.relates .feed_ads{
    padding: 8px 0px 15px 0px;
}
.content_ad {
    margin-left: -5px;
    width: 100%;
    overflow: hidden;
}
</style>
<div class="content-wrap" >
	<div class="content">
        <div class="wrapper">
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
        <h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); echo get_the_subtitle(); ?></a></h1>
	      <ul class="article-meta">
				<?php $author = get_the_author();
	    	if( _hui('author_link') ){
	        	$author = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.$author.'</a>'; } ?>
					<div class="user_info">
						<!--<div class="avatar_box"><?php /*echo get_avatar( get_the_author_email(), '32' );*/?></div>-->
						<div>
							<p class="name_1"><?php echo $author ?><span class="time_1"><?php echo formatTime( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span></p>
						</div>
					</div>
					<!--<?php echo __('发布于', 'haoui') ?> -->
					<!--<li><?php echo __('分类：', 'haoui');the_category(' / '); ?></li>
					<?php echo _hui('post_from_s') && hui_get_post_from() ? '<li>'.hui_get_post_from().'</li>' : '' ?>
					<li><?php echo hui_get_views() ?></li>
					<li><?php echo hui_get_comment_number() ?></li>-->
					<li><?php edit_post_link('['.__('编辑', 'haoui').']'); ?></li>
				</ul>
		</header>
		<!-- <?php if( _hui('ads_post_01_s') ) echo '<div class="ads ads-content ads-post">'.hui_get_adcode('ads_post_01').'</div>'; ?> -->
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<div class="readall_box" style="display: none;">
  			<div class="read_more_mask"></div>
  			<div class="read_more_btn"><span class="read_all">阅读全文</span></div>
         </div>
         


		<script type="text/javascript">

			$(document).ready(function(){
			    var init_cover = function(){
                    var x_height = $(window).height();
                    var div_height = $(".article-content").height();
                    if(div_height> 1.5*x_height){
                        //alert(11)
                        $(".article-content").css({"height":1.5*x_height+"px","overflow":"hidden"});
                        $(".readall_box").css("display","block");
                        $(".read_more_btn").click(function(){$('.readall_box').css("display","none");$(".article-content").css({"height":"auto","overflow":"auto"})});
                    }
                };
                init_cover();
			});
		</script>
		<!-- <?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="article-paging">&after=</div>&next_or_number=number'); ?>
		<?php endwhile;  ?>
		<div class="article-social">
			<?php echo hui_get_post_like($class='action action-like'); ?>
			<?php if( _hui('post_link_single_s') ) hui_post_link(); ?>
		</div> -->
		<!--
        <div class="gohome"><a href="<?php bloginfo('url'); ?>">返回首页</a></div>
		<div class="action-share bdsharebuttonbox">
			<?php echo hui_get_share() ?>
		</div>
		<div class="article-tags">
			<?php the_tags(__('标签：', 'haoui'),'',''); ?>

		</div>-->
    </div>
        <?php hui_moloader('hui_ad'); ?>
        <?php
            $from = $_GET['from'];
            if($from == 'gionee_screen_2'){
                if( _hui('ads_tag_01_s') ) echo '<div class="ad_wrapper"><div class="ads ads-content ads-tag">'.hui_get_adcode('ads_tag_01').'</div></div>';
            }
            if($from == 'gionee_screen'){
                if( _hui('ads_post_02_s') ) echo '<div class="ad_wrapper"><div class="ads ads-content ads-related">'.hui_get_adcode('ads_post_02').'</div></div>';
            }elseif($from == 'gionee_browser'){
                if( _hui('ads_post_01_s') ) echo '<div class="ad_wrapper"><div class="ads ads-content ads-post">'.hui_get_adcode('ads_post_01').'</div></div>';
            }else{
                if( _hui('ads_post_02_s') ) echo '<div class="ad_wrapper"><div class="ads ads-content ads-related">'.hui_get_adcode('ads_post_01').'</div></div>';
            }
        ?>
        <?php if( _hui('post_related_s') ) {
            echo '<div class="related_wrapper">';
            hui_posts_related( _hui('related_title'), _hui('post_related_n'), (_hui('post_related_model') ? _hui('post_related_model') : 'thumb') );
            echo '</div>';
        } ?>
        <?php
            $from = $_GET['from'];
            if($from == 'gionee_screen'){
                if( _hui('ads_post_02_s') ) echo '<div class="ad_wrapper_1"><div class="ads ads-content ads-related">'.hui_get_adcode('ads_post_02').'</div></div>';
            }elseif($from == 'gionee_browser'){
                if( _hui('ads_post_01_s') ) echo '<div class="ad_wrapper_1"><div class="ads ads-content ads-post">'.hui_get_adcode('ads_post_01').'</div></div>';
            }else{
                if( _hui('ads_post_02_s') ) echo '<div class="ad_wrapper_1"><div class="ads ads-content ads-related">'.hui_get_adcode('ads_post_02').'</div></div>';
            }
        ?>
		<?php if( _hui('ads_post_03_s') ) echo '<div class="ad_wrapper"><div class="ads ads-content ads-comment">'.hui_get_adcode('ads_post_03').'</div></div>'; ?><!--评论上-->
		
	</div>


</div>
<?php get_sidebar(); get_footer(); ?>
