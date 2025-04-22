<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
  
  <!-- Stylesheet -->
  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
  
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="header-inner">
    <h1 class="site-logo">
      <a href="<?php echo esc_url( home_url('/') ); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ajito-logo.png" alt="AJITOロゴ">
      </a>
    </h1>
    
    <div class="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    
    <nav class="global-nav">
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
  </div>
</header>