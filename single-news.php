<?php get_header(); ?>

<div class="news-single">
  <div class="inner">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="news-article">
        <header class="news-header">
          <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="news-date"><?php echo get_the_date('Y.m.d'); ?></time>
          <h1 class="news-title"><?php the_title(); ?></h1>
        </header>
        
        <?php if (has_post_thumbnail()) : ?>
          <div class="news-thumbnail">
            <?php the_post_thumbnail('full'); ?>
          </div>
        <?php endif; ?>
        
        <div class="news-content">
          <?php the_content(); ?>
        </div>
      </article>
      
      <div class="news-navigation">
        <div class="prev"><?php previous_post_link('%link', '&laquo; 前のお知らせ'); ?></div>
        <div class="next"><?php next_post_link('%link', '次のお知らせ &raquo;'); ?></div>
      </div>
      
    <?php endwhile; else : ?>
      <p>お知らせが見つかりませんでした。</p>
    <?php endif; ?>
    
    <a href="<?php echo home_url('/news'); ?>" class="more-btn">一覧に戻る</a>
  </div>
</div>

<?php get_footer(); ?>