<?php get_header(); ?>

<section class="firstView">
  <div class="slider">
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bar-interior.jpg" alt="AJITOファーストビュー" width="1920" height="1080">
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
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/about-placeholder.jpg" alt="AJITO店舗画像" width="600" height="400" loading="lazy">
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
          <a href="<?php echo esc_url(get_permalink()); ?>">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('full', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy')); ?>
            <?php else : ?>
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/cast-placeholder.jpg" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" width="300" height="450">
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
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/cast1-placeholder.jpg" alt="キャスト1" loading="lazy" width="300" height="450">
          <p>MIU</p>
        </li>
        <li>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/cast2-placeholder.jpg" alt="キャスト2" loading="lazy" width="300" height="450">
          <p>YUNA</p>
        </li>
        <li>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/cast3-placeholder.jpg" alt="キャスト3" loading="lazy" width="300" height="450">
          <p>SHIORI</p>
        </li>
        <li>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/cast4-placeholder.jpg" alt="キャスト4" loading="lazy" width="300" height="450">
          <p>AIKA</p>
        </li>
      <?php endif; ?>
    </ul>
    <div class="cast-links">
      <a href="<?php echo esc_url(home_url('/cast')); ?>" class="more-btn">もっと見る</a>
      <a href="<?php echo esc_url(home_url('/schedule')); ?>" class="more-btn schedule-btn">出勤情報</a>
    </div>
  </div>
</section>

<section id="system" class="systemWrap">
  <div class="inner center">
    <h2 class="section-title gold">System<span class="sub">料金案内</span></h2>
    <div class="system-content">
      <table class="new-price-table">
        <caption>料金表</caption>
        <tr>
          <th scope="col">コース</th>
          <th scope="col">料金</th>
        </tr>
        <tr>
          <td>1SET50分飲み放題</td>
          <td>¥3,000</td>
        </tr>
        <tr>
          <td>延長30分</td>
          <td>¥3,000</td>
        </tr>
        <tr>
          <td>延長60分</td>
          <td>¥4,000</td>
        </tr>
        <tr>
          <td>TAX</td>
          <td>20%</td>
        </tr>
      </table>
      
      <div class="shop-info-wrap">
        <h3 class="shop-info-title">店舗情報</h3>
        <table class="shop-info-table">
          <caption>店内情報</caption>
          <tr>
            <th scope="row">在籍女の子数</th>
            <td>16名</td>
          </tr>
          <tr>
            <th scope="row">在籍スタッフ</th>
            <td>20代前半</td>
          </tr>
          <tr>
            <th scope="row">席数</th>
            <td>カウンター11席</td>
          </tr>
          <tr>
            <th scope="row">キャスト衣装</th>
            <td>私服</td>
          </tr>
          <tr>
            <th scope="row">カラオケ</th>
            <td>DAM</td>
          </tr>
          <tr>
            <th scope="row">飲み放題ドリンク</th>
            <td>ビール、焼酎、ウイスキー</td>
          </tr>
        </table>
      </div>
      
      <div class="payment-info">
        <h3>ご利用可能な決済方法</h3>
        <div class="payment-methods">
          <div class="payment-method-group">
            <h4>クレジットカード</h4>
            <div class="payment-icons">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-jcb.png" alt="JCBカード" loading="lazy" width="40" height="30">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-visa.png" alt="VISAカード" loading="lazy" width="40" height="30">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-mastercard.png" alt="Mastercardカード" loading="lazy" width="40" height="30">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-amex.png" alt="American Expressカード" loading="lazy" width="40" height="30">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-diners.png" alt="Diners Clubカード" loading="lazy" width="40" height="30">
            </div>
            <p class="card-list">JCB / VISA / Mastercard / American Express / Diners Club</p>
          </div>
          <div class="payment-method-group">
            <h4>電子決済</h4>
            <div class="payment-icons">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-paypay.png" alt="PayPay" loading="lazy" width="40" height="30">
            </div>
            <p class="card-list">PayPay</p>
          </div>
          <div class="payment-method-group">
            <h4>交通系・電子マネー</h4>
            <div class="payment-icons">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-suica.png" alt="Suica" loading="lazy" width="40" height="30">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-pasmo.png" alt="PASMO" loading="lazy" width="40" height="30">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/payment-ic-card.png" alt="交通系ICカード" loading="lazy" width="40" height="30">
            </div>
            <p class="card-list">Suica / PASMO / Kitaca / manaca / TOICA / SUGOCA / nimoca / ICOCA</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="gallery" class="galleryWrap">
  <div class="inner center">
    <h2 class="section-title gold">Gallery<span class="sub">店内写真</span></h2>
    <div class="gallery-slider">
      <div class="galleryList">
        <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/gallery1-placeholder.jpg" alt="AJITO店内1" loading="lazy" width="400" height="300"></div>
        <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/gallery2-placeholder.jpg" alt="AJITO店内2" loading="lazy" width="400" height="300"></div>
        <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/gallery3-placeholder.jpg" alt="AJITO店内3" loading="lazy" width="400" height="300"></div>
        <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/gallery1-placeholder.jpg" alt="AJITO店内4" loading="lazy" width="400" height="300"></div>
        <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/gallery2-placeholder.jpg" alt="AJITO店内5" loading="lazy" width="400" height="300"></div>
      </div>
    </div>
  </div>
</section>

<section id="access" class="accessWrap">
  <div class="inner center">
    <h2 class="section-title gold">Access<span class="sub">アクセス</span></h2>
    <table class="access-table">
      <caption>店舗情報</caption>
      <tr><th scope="row">住所</th><td>〒125-0061 東京都葛飾区亀有5丁目28-2 1F</td></tr>
      <tr><th scope="row">電話番号</th><td><a href="tel:03-5849-3269">03-5849-3269</a></td></tr>
      <tr><th scope="row">営業時間</th><td>月〜土 20:00〜LAST</td></tr>
    </table>
    
    <!-- Google評価の表示 -->
    <div class="google-rating">
      <div class="stars" aria-label="Google評価 5段階中4.5">
        <span class="star" aria-hidden="true">★</span><span class="star" aria-hidden="true">★</span><span class="star" aria-hidden="true">★</span><span class="star" aria-hidden="true">★</span><span class="star half" aria-hidden="true">★</span>
      </div>
      <p>Google レビュー 4.5/5.0 (30件の評価)</p>
      <div class="rating-actions">
        <a href="https://g.co/kgs/w9qLB4X" target="_blank" rel="noopener" class="review-btn">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/google-review-icon.png" alt="Google レビュー" width="20" height="20" loading="lazy">
          レビューを見る
        </a>
        <a href="https://www.google.com/maps/dir/?api=1&destination=ガールズバーAJITO+亀有" class="directions-btn" target="_blank" rel="noopener">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/directions-icon.png" alt="経路案内" width="16" height="16" loading="lazy">
          ここへの経路
        </a>
      </div>
    </div>
    
    <div class="map-wrapper">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3237.2986257033417!2d139.84441227723516!3d35.76804017255934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188f66b72b7859%3A0x60ca23a89e3b96e3!2sAJITO!5e0!3m2!1sja!2sjp!4v1745350124913!5m2!1sja!2sjp" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="AJITOのGoogleマップ"></iframe>
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
    <a href="<?php echo esc_url(home_url('/recruit')); ?>" class="recruit-btn">採用情報を見る</a>
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
          <span class="date"><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
          <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
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
    <a href="<?php echo esc_url(home_url('/news')); ?>" class="more-btn">もっと見る</a>
  </div>
</section>

<?php get_footer(); ?>
