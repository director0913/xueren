<?php get_header(); ?>
<?php hui_logo(); ?>


<header class="header">
     <div class="wrapper wrapper01" id="retr">
		<div class="scroller" >
	     <?php hui_nav_menu(); ?>
	    </div>
	  </div> 
	</header>
<div class="content-wrap">
	<div class="content">
		<?php echo _hui('ads_cat_01_s') ? '<div class="ads ads-content">'.hui_get_adcode('ads_cat_01').'</div>' : '' ?>
		<?php 
		$pagedtext = '';
		if( $paged && $paged > 1 ){
			$pagedtext = ' <small>'.__('第', 'haoui').$paged.__('页', 'haoui').'</small>';
		}
		echo '<h1 class="title"><strong><a href="'.get_category_link( get_cat_ID( single_cat_title('',false) ) ).'">', single_cat_title(), '</a></strong>'.$pagedtext.'</h1>';

		get_template_part( 'excerpt' ); 
		?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>
<script type="text/javascript" src="/wp-content/themes/toutiao/js/flexible.js"></script>
<script type="text/javascript" src="/wp-content/themes/toutiao/js/iscroll.js"></script>
<script type="text/javascript" src="/wp-content/themes/toutiao/js/navbarscroll.js"></script>
<script type="text/javascript">
$(function(){
    $('.wrapper').navbarscroll();
    var w=$(window).width();
   
    if (w>414) {
        
    	$(".scroller").css("width","80px");
    }
 });
</script>