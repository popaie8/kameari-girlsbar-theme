<?php get_header(); ?>

<div class="archive-header">
  <div class="inner">
    <h1 class="archive-title">News</h1>
    <div class="archive-description">
      <p>最新のお知らせやイベント情報をご確認ください。</p>
    </div>
  </div>
</div>

<div class="archive-content">
  <div class="inner">
    <ul class="news-archive-list">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li>
          <article class="news-item">
            <div class="news-meta">
              <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="news-date"><?php echo get_the_date('Y.m.d'); ?></time>
            </div>
            <h2 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="news-excerpt">
              <?php the_excerpt(); ?>
            </div>
            <a href="<?php the_permalink(); ?>" class="news-more">詳細を見る</a>
          </article>
        </li>
      <?php endwhile; else : ?>
        <p>現在お知らせはありません。</p>
      <?php endif; ?>
    </ul>
    
    <?php the_posts_pagination(array(
      'prev_text' => '&laquo;',
      'next_text' => '&raquo;',
      'mid_size'  => 2,
    )); ?>
  </div>
</div>

<?php get_footer(); ?>