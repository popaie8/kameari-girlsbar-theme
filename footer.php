<footer>
  <div class="inner">
    <div class="footer-logo">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="AJITOロゴ" width="140">
    </div>
    
<ul class="sns">
  <li><a href="#" target="_blank" rel="noopener" class="no-scroll"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram-icon.png" alt="Instagram"></a></li>
  <li><a href="#" target="_blank" rel="noopener" class="no-scroll"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-icon.png" alt="Twitter"></a></li>
  <li><a href="#" target="_blank" rel="noopener" class="no-scroll"><img src="<?php echo get_template_directory_uri(); ?>/images/tiktok-icon.png" alt="TikTok"></a></li>
</ul>
    
    <nav class="footer-nav">
      <ul>
        <li><a href="<?php echo home_url('/#about'); ?>">About</a></li>
        <li><a href="<?php echo home_url('/#cast'); ?>">Cast</a></li>
        <li><a href="<?php echo home_url('/#system'); ?>">System</a></li>
        <li><a href="<?php echo home_url('/#gallery'); ?>">Gallery</a></li>
        <li><a href="<?php echo home_url('/#access'); ?>">Access</a></li>
        <li><a href="<?php echo home_url('/#recruit'); ?>">Recruit</a></li>
        <li><a href="<?php echo home_url('/#news'); ?>">News</a></li>
      </ul>
    </nav>
    
    <p class="copyright">&copy; <?php echo date('Y'); ?> Girl's Bar AJITO. All Rights Reserved.</p>
  </div>

  <?php wp_footer(); ?>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // スクロール時のヘッダー背景変更
    window.addEventListener('scroll', function() {
      const header = document.querySelector('.site-header');
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
    
    // ハンバーガーメニュートグル
    const menuToggle = document.querySelector('.menu-toggle');
    const globalNav = document.querySelector('.global-nav');
    
    if (menuToggle) {
      menuToggle.addEventListener('click', function() {
        this.classList.toggle('open');
        globalNav.classList.toggle('open');
      });
    }
    
    // スムーススクロール
    const navLinks = document.querySelectorAll('.global-nav a, .footer-nav a');
    
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.indexOf('#') !== -1) {
          const targetId = href.split('#')[1];
          if (targetId) {
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
              e.preventDefault();
              const offset = 80; // ヘッダーの高さ分調整
              const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - offset;
              
              window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
              });
              
              // SPメニューを閉じる
              if (window.innerWidth < 768) {
                menuToggle.classList.remove('open');
                globalNav.classList.remove('open');
              }
            }
          }
        }
      });
    });
  });
</script>
</body>
</html>