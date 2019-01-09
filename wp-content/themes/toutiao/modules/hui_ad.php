<?php
/* 
 * post focus
 * ====================================================
*/
function hui_ad()
{
    $orderby = 'link_rating desc, id desc';
    $limit = 1;
    $r = get_bookmarks(array('link_visible' => 'Y','orderby' => $orderby, 'limit' => $limit));
    $html = "";
    foreach ($r as $index) {
        $html .= link_ui($index);
    }
    echo '<div class="hui_link_ad">' . $html . '</div>';
}

function link_ui($link)
{
    $html = '<div class="link_ad_box"><a href="' . $link->link_url . '"><div class="link_ad_img"><em class="ad_icon">广告</em><img src="' . $link->link_image . '"></div><p class="link_ad_title">' . $link->link_description . '</p></a></div>';
    return $html;
}

