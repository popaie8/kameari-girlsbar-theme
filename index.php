<?php get_header(); ?>

<main>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article>
      <h2><?php the_title(); ?></h2>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; else : ?>
    <article>
      <h2>投稿が見つかりませんでした</h2>
      <p>申し訳ありませんが、お探しの投稿は見つかりませんでした。</p>
    </article>
  <?php endif; ?>
</main>

<?php get_footer(); ?>