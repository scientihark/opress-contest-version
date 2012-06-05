<?php get_header(); ?>
<article class="article">
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
<section <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<div class="post_date"><span class="date_m"><?php echo date('M',get_the_time('U'));?></span><span class="date_d"><?php the_time('d') ?></span><span class="date_y"><?php the_time('Y') ?></span><div class="comments_num"><?php comments_popup_link ('Nan','1','%'); ?></div></div>
<section class="articlepost">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="new"><?php include('includes/new.php'); ?></span></h2>
<?php include('includes/articlepic.php'); ?>
<div class="entry_post"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 365,"..."); ?></div>
<div class="clear"></div>
<div class="postinfo"><div class="info">作者：<?php the_author() ?> -分类：<?php the_category(', ') ?> - 阅读：<?php if(function_exists(the_views)) { the_views(' 次', true);}?> - <?php the_tags('标签：', ', ', ''); ?></div><span class="more"><a href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>" rel="bookmark">阅读全文</a></span></div>
</section></section><div class="clear"></div>
		<?php endwhile; else: ?>
<div class="left">
<section class="article">
<h3 class="center">非常抱歉，无法搜索到与之相匹配的信息。</h3>
</section></div>
		<?php endif; ?> 
<div class="navigation"><?php pagination($query_string); ?></div>
</article>
<section id="backtotop"><a class="returntop" href="javascript:;">回到顶部</a></section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
