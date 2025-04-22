<?php get_header(); ?>

<div class="cast-single">
  <div class="inner">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 class="section-title gold"><?php the_title(); ?><span class="sub">キャスト詳細</span></h1>
      
      <div class="cast-profile">
        <div class="cast-image">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', array('alt' => get_the_title(), 'loading' => 'lazy')); ?>
          <?php else : ?>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/cast-placeholder.jpg" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
          <?php endif; ?>
        </div>
        
        <div class="cast-details">
          <h2 class="cast-name"><?php the_title(); ?></h2>
          
          <div class="cast-meta">
            <?php if (get_post_meta($post->ID, 'age', true)) : ?>
            <dl>
              <dt>年齢：</dt>
              <dd><?php echo esc_html(get_post_meta($post->ID, 'age', true)); ?></dd>
            </dl>
            <?php endif; ?>
            
            <?php if (get_post_meta($post->ID, 'height', true)) : ?>
            <dl>
              <dt>身長：</dt>
              <dd><?php echo esc_html(get_post_meta($post->ID, 'height', true)); ?></dd>
            </dl>
            <?php endif; ?>
            
            <?php if (get_post_meta($post->ID, 'hobby', true)) : ?>
            <dl>
              <dt>趣味：</dt>
              <dd><?php echo esc_html(get_post_meta($post->ID, 'hobby', true)); ?></dd>
            </dl>
            <?php endif; ?>
            
            <?php if (get_post_meta($post->ID, 'favorite', true)) : ?>
            <dl>
              <dt>好きなもの：</dt>
              <dd><?php echo esc_html(get_post_meta($post->ID, 'favorite', true)); ?></dd>
            </dl>
            <?php endif; ?>
          </div>
          
          <div class="cast-description">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
      
      <div class="cast-navigation">
        <div class="prev"><?php previous_post_link('%link', '&laquo; 前のキャスト'); ?></div>
        <div class="next"><?php next_post_link('%link', '次のキャスト &raquo;'); ?></div>
      </div>
      
    <?php endwhile; else : ?>
      <p>キャスト情報が見つかりませんでした。</p>
    <?php endif; ?>
    
    <a href="<?php echo esc_url(home_url('/cast')); ?>" class="more-btn">一覧に戻る</a>
  </div>
</div>

<?php get_footer(); ?>
