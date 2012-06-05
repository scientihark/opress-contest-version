<h3>朋友的足迹</h3>
<ul>
<?php
$counts = $wpdb->get_results("SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 1 MONTH ) AND user_id='0' AND comment_author_email != '' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 15");
foreach ($counts as $count) {
$a = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($count->comment_author_email)) . '.jpg';
$c_url = $count->comment_author_url;
$mostactive .= '<li class="mostactive">' . '<a href="'. $c_url . '" title="' . $count->comment_author . ' (留下'. $count->cnt . '个脚印)" target="_blank" rel="external nofollow"><img src="' . $a . '" alt="' . $count->comment_author . ' (留下'. $count->cnt . '个脚印)" class="avatar" /></a></li>';
}
echo $mostactive;
?>
</ul>
  
