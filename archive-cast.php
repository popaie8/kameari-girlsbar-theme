<?php get_header(); ?>

<div class="archive-header">
  <div class="inner">
    <h1 class="archive-title">Cast</h1>
    <div class="archive-description">
      <p>個性豊かなキャスト達をご紹介します。是非お気に入りを見つけてください。</p>
    </div>
  </div>
</div>

<div class="archive-content cast-archive">
  <div class="inner">
    <ul class="castList">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
            <?php else : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/images/cast-placeholder.jpg" alt="<?php the_title(); ?>">
            <?php endif; ?>
            <p><?php the_title(); ?></p>
          </a>
        </li>
      <?php endwhile; else : ?>
        <p>現在キャストの登録はありません。</p>
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