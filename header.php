<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  if (is_front_page()) {
    echo '<title>' . esc_html(get_bloginfo('name')) . ' | ' . esc_html(get_bloginfo('description')) . '</title>';
    echo '<meta name="description" content="' . esc_attr(get_bloginfo('description')) . '">';
  } else {
    wp_title('|', true, 'right');
    echo esc_html(get_bloginfo('name'));
  }
  ?>
  
  <!-- プリロード -->
  <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/fonts/NotoSerifJP-Regular.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/fonts/PlayfairDisplay-Regular.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/ajito-logo.png" as="image">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="preconnect" href="https://use.fontawesome.com">
  
  <?php wp_head(); ?>
  
  <!-- クリティカルCSS -->
  <style>
    /* クリティカルCSSここから */
    :root {
      --primary: #ada58b;
      --text-color: #cdcdcd;
      --bg-color: #0a0a0a;
      --bg-dark: #080808;
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Noto Serif JP', serif;
      background: var(--bg-color);
      color: var(--text-color);
      line-height: 1.8;
      overflow-x: hidden;
    }
    
    .skip-link {
      position: absolute;
      top: -100px;
      left: 0;
      background: var(--primary);
      color: #000;
      padding: 10px;
      z-index: 9999;
    }
    
    .skip-link:focus {
      top: 0;
    }
    
    img {
      max-width: 100%;
      height: auto;
      display: block;
    }
    
    .screen-reader-text {
      border: 0;
      clip: rect(1px, 1px, 1px, 1px);
      clip-path: inset(50%);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
      word-wrap: normal !important;
    }
    
    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      transition: var(--transition);
      height: 80px;
    }
    
    .site-header.scrolled {
      background: rgba(0, 0, 0, 0.9);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }
    
    .header-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 80px;
      padding: 0 5%;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .site-logo img {
      height: 60px;
      transition: var(--transition);
    }
    
    .global-nav ul {
      display: flex;
      gap: 30px;
      list-style: none;
    }
    
    .global-nav li a {
      font-family: 'Playfair Display', serif;
      font-size: 15px;
      color: #fff;
      text-decoration: none;
      position: relative;
      padding: 8px 0;
      transition: var(--transition);
    }
    
    .global-nav li a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 1px;
      bottom: 0;
      left: 0;
      background-color: var(--primary);
      transition: width 0.3s ease;
    }
    
    .global-nav li a:hover::after {
      width: 100%;
    }
    
    .menu-toggle {
      display: none;
      cursor: pointer;
      width: 30px;
      height: 20px;
      position: relative;
      z-index: 1001;
    }
    
    .menu-toggle span {
      display: block;
      position: absolute;
      height: 2px;
      width: 100%;
      background: var(--primary);
      opacity: 1;
      left: 0;
      transform: rotate(0deg);
      transition: .25s ease-in-out;
    }
    
    .menu-toggle span:nth-child(1) {
      top: 0px;
    }
    
    .menu-toggle span:nth-child(2), .menu-toggle span:nth-child(3) {
      top: 9px;
    }
    
    .menu-toggle span:nth-child(4) {
      top: 18px;
    }
    
    @media (max-width: 767px) {
      .menu-toggle {
        display: block;
      }
      
      .global-nav {
        position: fixed;
        top: 0;
        right: -100%;
        width: 80%;
        max-width: 300px;
        height: 100vh;
        background: rgba(0, 0, 0, 0.95);
        padding: 80px 20px 20px;
        transition: var(--transition);
        overflow-y: auto;
        z-index: 1000;
      }
      
      .global-nav.open {
        right: 0;
      }
      
      .global-nav ul {
        flex-direction: column;
        gap: 15px;
      }
      
      .menu-toggle.open span:nth-child(1) {
        top: 9px;
        width: 0%;
        left: 50%;
      }
      
      .menu-toggle.open span:nth-child(2) {
        transform: rotate(45deg);
      }
      
      .menu-toggle.open span:nth-child(3) {
        transform: rotate(-45deg);
      }
      
      .menu-toggle.open span:nth-child(4) {
        top: 9px;
        width: 0%;
        left: 50%;
      }
    }
    /* クリティカルCSSここまで */
  </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php _e('コンテンツへスキップ', 'ajito'); ?></a>

<header class="site-header">
  <div class="header-inner">
    <h1 class="site-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/ajito-logo.png" alt="AJITOロゴ" width="140" height="60">
      </a>
    </h1>
    
    <button class="menu-toggle" aria-expanded="false" aria-controls="global-nav" aria-label="メニュー">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </button>
    
    <nav class="global-nav" id="global-nav" aria-label="メインナビゲーション">
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
  </div>
</header>

<main id="content" class="site-content"><?php // メインコンテンツの開始 ?>
