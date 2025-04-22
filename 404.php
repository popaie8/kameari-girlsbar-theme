<?php get_header(); ?>

<div class="error-page">
  <div class="inner">
    <h1 class="error-title">404</h1>
    <p class="error-text">お探しのページが見つかりませんでした。</p>
    <p class="error-description">
      お探しのページは削除されたか、URLが変更された可能性があります。<br>
      下記リンクからトップページにお戻りください。
    </p>
    <a href="<?php echo home_url(); ?>" class="error-btn">トップページへ戻る</a>
  </div>
</div>

<?php get_footer(); ?>