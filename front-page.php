<?php get_header(); ?>

<section class="firstView">
  <div class="slider">
    <img src="<?php echo get_template_directory_uri(); ?>/images/bar-interior.jpg" alt="ファーストビュー">
  </div>
  <div class="textWrap center">
    <p class="tit">
      <span class="rubi">ガールズバーAJITO</span><br>
      <span class="en">KAMEARI GIRLS BAR AJITO</span><br>
      大人が自由に楽しめるアジトがここに
    </p>
  </div>
</section>

<section id="about" class="aboutWrap">
  <div class="inner center">
    <h2 class="section-title gold">About<span class="sub">アバウト</span></h2>
    <div class="flexWrap">
      <div class="imgWrap">
        <img src="<?php echo get_template_directory_uri(); ?>/images/about-placeholder.jpg" alt="店舗画像">
      </div>
      <div class="lead-text">
        <p>
          亀有駅から徒歩数分、ガールズバーAJITOは木目とネオンが調和したビンテージアメリカンな空間です。<br>
          カジュアルかつ洗練された空間で、お一人様でもグループでも気兼ねなく楽しめる場所。<br><br>
          個性豊かなキャストとともに、非日常のような日常を演出します。<br>
          カウンター越しの程よい距離感と、心地よい音楽と照明。<br><br>
          亀有で「自分のアジト」を見つけたい方に最適です。
        </p>
      </div>
    </div>
  </div>
</section>

<section id="cast" class="castListWrap">
  <div class="inner center">
    <h2 class="section-title gold">Cast<span class="sub">キャスト一覧</span></h2>
    <ul class="castList">
      <?php
      $args = array(
        'post_type' => 'cast',
        'posts_per_page' => 4,
        'orderby' => 'date',
        'order' => 'DESC'
      );
      $cast_query = new WP_Query($args);
      if ($cast_query->have_posts()) :
        while ($cast_query->have_posts()) : $cast_query->the_post();
      ?>
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
      <?php
        endwhile;
        wp_reset_postdata();
      else:
      ?>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/images/cast1-placeholder.jpg" alt="キャスト1">
          <p>MIU</p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/images/cast2-placeholder.jpg" alt="キャスト2">
          <p>YUNA</p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/images/cast3-placeholder.jpg" alt="キャスト3">
          <p>SHIORI</p>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/images/cast4-placeholder.jpg" alt="キャスト4">
          <p>AIKA</p>
        </li>
      <?php endif; ?>
    </ul>
    <a href="<?php echo home_url('/cast'); ?>" class="more-btn">もっと見る</a>
  </div>
</section>

<section id="system" class="systemWrap">
  <div class="inner center">
    <h2 class="section-title gold">System<span class="sub">料金案内</span></h2>
    <div class="system-content">
      <table class="new-price-table">
        <tr>
          <th>メンバーお1人様60分</th>
          <th>基本料金</th>
        </tr>
        <tr>
          <td>19:00～19:29</td>
          <td>¥5,000</td>
        </tr>
        <tr>
          <td>19:30～LAST</td>
          <td>¥10,000</td>
        </tr>
        <tr>
          <td>延長料金(30分毎)</td>
          <td>¥4,000</td>
        </tr>
        <tr>
          <td>指名料</td>
          <td>¥3,000</td>
        </tr>
        <tr>
          <td>サービス料</td>
          <td>30%</td>
        </tr>
      </table>
      <div class="payment-info">
        <p>各種カードがご利用いただけます</p>
        <p class="card-list">JCB / VISA / AMEX / DINERS / DC / UC / MASTER</p>
        <p class="note">※別途消費税が加算されます。</p>
      </div>
    </div>
  </div>
</section>

<section id="gallery" class="galleryWrap">
  <div class="inner center">
    <h2 class="section-title gold">Gallery<span class="sub">店内写真</span></h2>
    <div class="gallery-slider">
      <div class="galleryList">
        <div><img src="<?php echo get_template_directory_uri(); ?>/images/gallery1-placeholder.jpg" alt="店内1"></div>
        <div><img src="<?php echo get_template_directory_uri(); ?>/images/gallery2-placeholder.jpg" alt="店内2"></div>
        <div><img src="<?php echo get_template_directory_uri(); ?>/images/gallery3-placeholder.jpg" alt="店内3"></div>
        <div><img src="<?php echo get_template_directory_uri(); ?>/images/gallery1-placeholder.jpg" alt="店内4"></div>
        <div><img src="<?php echo get_template_directory_uri(); ?>/images/gallery2-placeholder.jpg" alt="店内5"></div>
      </div>
    </div>
  </div>
</section>

<section id="access" class="accessWrap">
  <div class="inner center">
    <h2 class="section-title gold">Access<span class="sub">アクセス</span></h2>
    <table class="access-table">
      <tr><th>住所</th><td>〒125-0061 東京都葛飾区亀有5丁目28-2 1F</td></tr>
      <tr><th>電話番号</th><td><a href="tel:03-5849-3269">03-5849-3269</a></td></tr>
      <tr><th>営業時間</th><td>月〜土 20:00〜LAST</td></tr>
    </table>
    <div class="map-wrapper">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3238.669790589303!2d139.85292567677388!3d35.746123792694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018617afc7a3f51%3A0xd8e4a15119a39a9e!2z44CSMTQzLTAwMiDkuJzkvJfpg73luoPooajlupc!5e0!3m2!1sja!2sjp!4v1682505619603!5m2!1sja!2sjp" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

<section id="recruit" class="recruitWrap">
  <div class="inner center">
    <h2 class="section-title gold">Recruit<span class="sub">求人情報</span></h2>
    <div class="lead-text">
      <p>
        未経験でも大歓迎！<br>
        アメリカンビンテージな空間で一緒に楽しく働きませんか？<br>
        体験入店・見学だけでもOK！お気軽にお問い合わせください。
      </p>
    </div>
    <a href="<?php echo home_url('/recruit'); ?>" class="recruit-btn">採用情報を見る</a>
  </div>
</section>

<section id="news" class="newsWrap">
  <div class="inner center">
    <h2 class="section-title gold">News<span class="sub">お知らせ</span></h2>
    <ul class="news-list">
      <?php
      $args = array(
        'post_type' => 'news',
        'posts_per_page' => 5
      );
      $news_query = new WP_Query($args);
      if ($news_query->have_posts()) :
        while ($news_query->have_posts()) : $news_query->the_post();
      ?>
        <li>
          <span class="date"><?php echo get_the_date('Y.m.d'); ?></span>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
      <?php
        endwhile;
        wp_reset_postdata();
      else:
      ?>
        <li>
          <span class="date">2025.04.01</span>
          <a href="#">グランドオープンしました！</a>
        </li>
        <li>
          <span class="date">2025.04.10</span>
          <a href="#">GW期間中の営業について</a>
        </li>
        <li>
          <span class="date">2025.04.15</span>
          <a href="#">新キャスト続々入店中♪</a>
        </li>
      <?php endif; ?>
    </ul>
    <a href="<?php echo home_url('/news'); ?>" class="more-btn">もっと見る</a>
  </div>
</section>

<?php get_footer(); ?>