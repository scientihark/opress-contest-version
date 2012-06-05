<?php get_header(); ?>
<article class="article">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="articles">
<div class="post_date"><span class="date_m"><?php echo date('M',get_the_time('U'));?></span><span class="date_d"><?php the_time('d') ?></span><span class="date_y"><?php the_time('Y') ?></span></section>
<section class="articles">
<h2><?php the_title(); ?></h2>
        <section class="context"><?php the_content('Read more...'); ?></section>
</section>

<section class="articles">
<?php comments_template(); ?>
</section>

	<?php endwhile; else: ?>
	<?php endif; ?>
<section id="backtotop"><a class="returntop" href="javascript:;">回到顶部</a></section>
</article>

<?php include('r-sidebar.php'); ?>
<?php get_footer(); ?>
