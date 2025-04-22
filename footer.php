</main><!-- #content -->

<footer class="site-footer">
  <div class="inner">
    <div class="footer-logo">
      <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="AJITOロゴ" width="140" height="60" loading="lazy">
    </div>
    
    <ul class="sns">
      <li><a href="#" target="_blank" rel="noopener" class="no-scroll" aria-label="Instagram">
        <span class="icon-instagram" aria-hidden="true"></span>
        <span class="screen-reader-text">Instagram</span>
      </a></li>
      <li><a href="#" target="_blank" rel="noopener" class="no-scroll" aria-label="Twitter">
        <span class="icon-twitter" aria-hidden="true"></span>
        <span class="screen-reader-text">Twitter</span>
      </a></li>
      <li><a href="#" target="_blank" rel="noopener" class="no-scroll" aria-label="TikTok">
        <span class="icon-tiktok" aria-hidden="true"></span>
        <span class="screen-reader-text">TikTok</span>
      </a></li>
    </ul>
    
    <nav class="footer-nav" aria-label="フッターナビゲーション">
      <ul>
        <li><a href="<?php echo esc_url(home_url('/#about')); ?>">About</a></li>
        <li><a href="<?php echo esc_url(home_url('/#cast')); ?>">Cast</a></li>
        <li><a href="<?php echo esc_url(home_url('/#system')); ?>">System</a></li>
        <li><a href="<?php echo esc_url(home_url('/#gallery')); ?>">Gallery</a></li>
        <li><a href="<?php echo esc_url(home_url('/#access')); ?>">Access</a></li>
        <li><a href="<?php echo esc_url(home_url('/#recruit')); ?>">Recruit</a></li>
        <li><a href="<?php echo esc_url(home_url('/#news')); ?>">News</a></li>
        <li><a href="<?php echo esc_url(home_url('/schedule')); ?>">Schedule</a></li>
      </ul>
    </nav>
    
    <p class="copyright">&copy; <?php echo date('Y'); ?> Girl's Bar AJITO. All Rights Reserved.</p>
  </div>

  <?php wp_footer(); ?>
  
  <script>
    // ページの読み込みが完了したら実行
    document.addEventListener('DOMContentLoaded', function() {
      // Lazy Load for images
      var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
      
      if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              let lazyImage = entry.target;
              lazyImage.src = lazyImage.dataset.src;
              lazyImage.classList.remove("lazy");
              lazyImageObserver.unobserve(lazyImage);
            }
          });
        });
        
        lazyImages.forEach(function(lazyImage) {
          lazyImageObserver.observe(lazyImage);
        });
      } else {
        // Fallback for browsers that don't support IntersectionObserver
        let active = false;
        
        const lazyLoad = function() {
          if (active === false) {
            active = true;
            
            setTimeout(function() {
              lazyImages.forEach(function(lazyImage) {
                if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                  lazyImage.src = lazyImage.dataset.src;
                  lazyImage.classList.remove("lazy");
                  
                  lazyImages = lazyImages.filter(function(image) {
                    return image !== lazyImage;
                  });
                  
                  if (lazyImages.length === 0) {
                    document.removeEventListener("scroll", lazyLoad);
                    window.removeEventListener("resize", lazyLoad);
                    window.removeEventListener("orientationChange", lazyLoad);
                  }
                }
              });
              
              active = false;
            }, 200);
          }
        };
        
        document.addEventListener("scroll", lazyLoad);
        window.addEventListener("resize", lazyLoad);
        window.addEventListener("orientationChange", lazyLoad);
      }
      
      // Smooth scroll for in-page links
      var scrollLinks = document.querySelectorAll('a[href^="#"]:not(.no-scroll)');
      scrollLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          
          var targetId = this.getAttribute('href');
          var targetElement = document.querySelector(targetId);
          
          if (targetElement) {
            var headerHeight = document.querySelector('.site-header').offsetHeight;
            var targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
            
            window.scrollTo({
              top: targetPosition,
              behavior: 'smooth'
            });
            
            // Close mobile menu if open
            var menuToggle = document.querySelector('.menu-toggle');
            var globalNav = document.querySelector('.global-nav');
            
            if (menuToggle && menuToggle.classList.contains('open')) {
              menuToggle.classList.remove('open');
              menuToggle.setAttribute('aria-expanded', 'false');
              globalNav.classList.remove('open');
            }
          }
        });
      });
      
      // Mobile menu toggle
      var menuToggle = document.querySelector('.menu-toggle');
      var globalNav = document.querySelector('.global-nav');
      
      if (menuToggle && globalNav) {
        menuToggle.addEventListener('click', function() {
          this.classList.toggle('open');
          globalNav.classList.toggle('open');
          
          if (this.classList.contains('open')) {
            this.setAttribute('aria-expanded', 'true');
          } else {
            this.setAttribute('aria-expanded', 'false');
          }
        });
      }
      
      // Header scroll effect
      var header = document.querySelector('.site-header');
      
      if (header) {
        var checkScroll = function() {
          if (window.scrollY > 50) {
            header.classList.add('scrolled');
          } else {
            header.classList.remove('scrolled');
          }
        };
        
        window.addEventListener('scroll', checkScroll);
        // 初期表示時にもチェック
        checkScroll();
      }
    });
  </script>
</footer>
</body>
</html>
