<?php
// テーマセットアップ
function ajito_theme_setup() {
  // タイトルタグ自動出力
  add_theme_support('title-tag');

  // アイキャッチ画像有効化
  add_theme_support('post-thumbnails');

  // ナビゲーションメニュー登録
  register_nav_menus(array(
    'global' => 'グローバルナビゲーション',
    'footer' => 'フッターナビゲーション'
  ));
  
  // エディタースタイル追加
  add_editor_style('editor-style.css');
}
add_action('after_setup_theme', 'ajito_theme_setup');

// CSS・JavaScript 読み込み
function ajito_enqueue_scripts() {
  // メインスタイルシート
  wp_enqueue_style('ajito-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));
  
  // slick slider (CDNから読み込む)
  wp_enqueue_style('slick-style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array(), '1.8.1');
  wp_enqueue_script('slick-script', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
  
  // カスタムスクリプト（非同期読み込み）
  wp_enqueue_script('ajito-script', get_template_directory_uri() . '/js/script.js', array('jquery', 'slick-script'), filemtime(get_template_directory() . '/js/script.js'), true);
  wp_script_add_data('ajito-script', 'async', true);
}
add_action('wp_enqueue_scripts', 'ajito_enqueue_scripts');

// モジュール読み込み
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/custom-fields.php';
require_once get_template_directory() . '/inc/seo.php';

// OGP設定
function ajito_meta_ogp() {
  if( is_front_page() || is_home() || is_singular() ){
    global $post;
    $ogp_title = '';
    $ogp_description = '';
    $ogp_url = '';
    $ogp_image = '';
    $site_name = get_bloginfo('name');
    
    if( is_front_page() || is_home() ){
      $ogp_title = get_bloginfo('name');
      $ogp_description = get_bloginfo('description');
      $ogp_url = home_url();
      $ogp_image = get_template_directory_uri().'/images/ogp.jpg';
    } elseif( is_singular() ){
      setup_postdata($post);
      $ogp_title = $post->post_title;
      $ogp_description = mb_substr(get_the_excerpt(), 0, 100);
      $ogp_url = get_permalink();
      if( has_post_thumbnail() ){
        $image_id = get_post_thumbnail_id();
        $image = wp_get_attachment_image_src($image_id, 'full');
        $ogp_image = $image[0];
      } else {
        $ogp_image = get_template_directory_uri().'/images/ogp.jpg';
      }
    }
    
    // OGPタグ出力
    echo '<meta property="og:title" content="'.esc_attr($ogp_title).'" />' . "\n";
    echo '<meta property="og:description" content="'.esc_attr($ogp_description).'" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:url" content="'.esc_url($ogp_url).'" />' . "\n";
    echo '<meta property="og:image" content="'.esc_url($ogp_image).'" />' . "\n";
    echo '<meta property="og:site_name" content="'.esc_attr($site_name).'" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
  }
}
add_action('wp_head', 'ajito_meta_ogp');

// Add image alt text automatically for SEO
function ajito_auto_image_alt($content) {
  global $post;
  $pattern = "/<img(.*?)alt=('|\")?(.*?)('|\")(.*?)>/i";
  $replacement = '<img$1alt="$3"$5>';
  
  // If alt is empty, use post title
  $content = preg_replace_callback($pattern, function($matches) use ($post) {
    if(empty($matches[3])) {
      return '<img' . $matches[1] . 'alt="' . esc_attr($post->post_title) . '"' . $matches[5] . '>';
    } else {
      return $matches[0];
    }
  }, $content);
  
  return $content;
}
add_filter('the_content', 'ajito_auto_image_alt');

// 投稿タイプのパーマリンク構造を変更
function ajito_fix_post_type_permalinks() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action('init', 'ajito_fix_post_type_permalinks', 99);

// 画像の遅延読み込み追加
function ajito_add_lazy_loading($content) {
  $content = preg_replace('/<img(.*?)>/i', '<img$1 loading="lazy">', $content);
  return $content;
}
add_filter('the_content', 'ajito_add_lazy_loading');

// テーブルにキャプションを追加
function ajito_add_table_caption($content) {
  $content = preg_replace('/<table class="new-price-table">/i', '<table class="new-price-table"><caption>料金表</caption>', $content);
  $content = preg_replace('/<table class="access-table">/i', '<table class="access-table"><caption>店舗情報</caption>', $content);
  return $content;
}
add_filter('the_content', 'ajito_add_table_caption');

// エラーに404ページをカスタム
function ajito_custom_404_page() {
  if (is_404()) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part('404');
    exit();
  }
}
add_action('template_redirect', 'ajito_custom_404_page');
