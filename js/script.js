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
  });
  
 // スムーススクロール
$('a[href^="#"]').click(function() {
  if ($(this).hasClass('no-scroll')) return true; // 外部リンクやSNSアイコンなどのスクロールを無効化
  
  var speed = 800;
  var href = $(this).attr('href');
  var target = $(href == '#' || href == '' ? 'html' : href);
  var position = target.offset().top - 80;
  
  $('html, body').animate({scrollTop: position}, speed, 'swing');
  
  // SPメニューを閉じる
  if (window.innerWidth < 768) {
    $('.menu-toggle').removeClass('open');
    $('.global-nav').removeClass('open');
  }
  
  return false;
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
});