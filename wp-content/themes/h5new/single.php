<?php get_header(); ?>
<article class="article">
<section class="articles">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><?php the_title(); ?></h2>
<section class="article_info">作者：<?php the_author() ?> &nbsp; 发布：<?php the_time('Y-m-d H:i') ?> &nbsp; 分类：<?php the_category(', ') ?> &nbsp; 阅读：<?php if(function_exists(the_views)) { the_views(' 次', true);}?> &nbsp; <?php comments_popup_link ('抢沙发','1条评论','%条评论'); ?> &nbsp; <?php edit_post_link('编辑', ' [ ', ' ] '); ?></section>

<section class="context"><?php the_content('Read more...'); ?><p class="staylink">本文固定链接: <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_permalink() ?> | <?php bloginfo('name');?></a></p></section>

</section>
<section class="articles">
<span class="help">如果您觉得本文的内容对您的学习有所帮助：<a href="http://me.alipay.com/scientihark" target="_blank" title="小小捐助巨大帮助">小小捐助巨大帮助</a></span>
</section>
<section class="articles">
<div class="author_pic">
<a href="#" title="<?php the_author_description(); ?>"><?php echo get_avatar( get_the_author_email(), '48' ); ?></a>
</section>


<section class="articles">
<?php previous_post_link('【上一篇】%link') ?><br/><?php next_post_link('【下一篇】%link') ?>
</section>



<section class="articles">
<?php include('includes/related.php'); ?>
<div class="clear"></div>
</section>


<section class="articles">
<?php comments_template(); ?>
</section>
<section id="backtotop"><a class="returntop" href="javascript:;">回到顶部</a></section>
	<?php endwhile; else: ?>
	<?php endif; ?>

</article>

<?php include('r-sidebar.php'); ?>
<?php get_footer(); ?>
