<footer>
  <div class="inner">
    <div class="footer-logo">
      <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="AJITOロゴ" width="140" loading="lazy">
    </div>
    
    <ul class="sns">
      <li><a href="#" target="_blank" rel="noopener" class="no-scroll"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/instagram-icon.png" alt="Instagram" loading="lazy"></a></li>
      <li><a href="#" target="_blank" rel="noopener" class="no-scroll"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/twitter-icon.png" alt="Twitter" loading="lazy"></a></li>
      <li><a href="#" target="_blank" rel="noopener" class="no-scroll"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/tiktok-icon.png" alt="TikTok" loading="lazy"></a></li>
    </ul>
    
    <nav class="footer-nav">
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
</footer>
</body>
</html>
