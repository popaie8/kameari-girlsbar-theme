jQuery(document).ready(function($) {
  // スクロール時のヘッダー背景変更
  $(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
      $('.site-header').addClass('scrolled');
    } else {
      $('.site-header').removeClass('scrolled');
    }
  });
  
  // ハンバーガーメニュートグル
  $('.menu-toggle').click(function() {
    $(this).toggleClass('open');
    $('.global-nav').toggleClass('open');
    
    // アクセシビリティのためにaria-expanded属性を更新
    if ($(this).hasClass('open')) {
      $(this).attr('aria-expanded', 'true');
    } else {
      $(this).attr('aria-expanded', 'false');
    }
  });
  
  // スムーススクロール
  $('a[href^="#"]').click(function() {
    if ($(this).hasClass('no-scroll')) return true; // 外部リンクやSNSアイコンなどのスクロールを無効化
    
    var speed = 800;
    var href = $(this).attr('href');
    var target = $(href == '#' || href == '' ? 'html' : href);
    
    if (target.length) {
      var position = target.offset().top - 80;
      
      $('html, body').animate({scrollTop: position}, speed, 'swing');
      
      // SPメニューを閉じる
      if (window.innerWidth < 768) {
        $('.menu-toggle').removeClass('open').attr('aria-expanded', 'false');
        $('.global-nav').removeClass('open');
      }
      
      return false;
    }
  });
  
  // ギャラリースライダー初期化
  if ($('.gallery-slider .galleryList').length) {
    $('.gallery-slider .galleryList').slick({
      dots: true,
      arrows: true,
      autoplay: true,
      autoplaySpeed: 4000,
      slidesToShow: 3,
      slidesToScroll: 1,
      centerMode: true,
      centerPadding: '0',
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2,
            centerMode: false
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            centerMode: false
          }
        }
      ]
    });
  }
  
  // FAQのトグル機能
  $('.faq-question').click(function() {
    $(this).next('.faq-answer').slideToggle(300);
    $(this).parent('.faq-item').toggleClass('open');
  });
  
  // 画像の遅延読み込み（既存のimg要素にloading="lazy"を追加）
  $('img').each(function() {
    if (!$(this).attr('loading')) {
      $(this).attr('loading', 'lazy');
    }
  });
});
