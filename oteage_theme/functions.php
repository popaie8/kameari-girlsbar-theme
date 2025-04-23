<?php
/**
 * AJITO テーマ機能
 * 
 * @package AJITO
 * @version 1.1.0
 */

// 直接アクセス禁止
if (!defined('ABSPATH')) {
    exit;
}

// テーマセットアップ
function ajito_theme_setup() {
  // タイトルタグ自動出力
  add_theme_support('title-tag');

  // アイキャッチ画像有効化
  add_theme_support('post-thumbnails');
  
  // HTML5サポート
  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script',
  ));

  // ナビゲーションメニュー登録
  register_nav_menus(array(
    'global' => __('グローバルナビゲーション', 'ajito'),
    'footer' => __('フッターナビゲーション', 'ajito')
  ));
  
  // エディタースタイル追加
  add_editor_style('editor-style.css');
  
  // レスポンシブ埋め込み
  add_theme_support('responsive-embeds');
  
  // アイキャッチ画像サイズ追加
  add_image_size('cast-thumbnail', 300, 450, true);
  add_image_size('news-thumbnail', 800, 450, true);
  add_image_size('gallery-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'ajito_theme_setup');

/**
 * CSS・JavaScript 読み込み
 */
function ajito_enqueue_scripts() {
  // CSS読み込み
  // メインスタイルシート
  wp_enqueue_style('ajito-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));
  
  // レスポンシブスタイル
  wp_enqueue_style('ajito-responsive', get_template_directory_uri() . '/css/responsive.css', array('ajito-style'), filemtime(get_template_directory() . '/css/responsive.css'), 'all');
  
  // slick slider
  if (is_front_page() || is_page('recruit')) {
    wp_enqueue_style('slick-style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css', array(), '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.min.css', array(), '1.8.1');
    wp_enqueue_script('slick-script', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
  }
  
  // JavaScript読み込み
  // jQueryの非同期読み込みを有効化
  wp_script_add_data('jquery', 'defer', true);
  
  // カスタムスクリプト
  wp_enqueue_script('ajito-script', get_template_directory_uri() . '/js/script.min.js', array('jquery'), filemtime(get_template_directory() . '/js/script.min.js'), true);
  wp_script_add_data('ajito-script', 'defer', true);
  
  // インラインスクリプト - CSSの非同期読み込み対策
  $inline_script = "
    // CSS非同期読み込みの表示制御
    function ajito_load_style(url) {
      let link = document.createElement('link');
      link.href = url;
      link.rel = 'stylesheet';
      document.getElementsByTagName('head')[0].appendChild(link);
    }
    
    // 遅延読み込みを最適化
    window.addEventListener('load', function() {
      setTimeout(function() {
        var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
        if ('IntersectionObserver' in window) {
          let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
              if (entry.isIntersecting) {
                let lazyImage = entry.target;
                lazyImage.src = lazyImage.dataset.src;
                if (lazyImage.dataset.srcset) {
                  lazyImage.srcset = lazyImage.dataset.srcset;
                }
                lazyImage.classList.remove('lazy');
                lazyImageObserver.unobserve(lazyImage);
              }
            });
          });
          
          lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
          });
        }
      }, 500);
    });
  ";
  wp_add_inline_script('ajito-script', $inline_script, 'after');
  
  // 条件に応じたスクリプト読み込み
  if (is_singular('cast') || is_post_type_archive('cast')) {
    wp_enqueue_script('ajito-cast', get_template_directory_uri() . '/js/cast.min.js', array('jquery'), filemtime(get_template_directory() . '/js/cast.min.js'), true);
    wp_script_add_data('ajito-cast', 'defer', true);
  }
}
add_action('wp_enqueue_scripts', 'ajito_enqueue_scripts');

/**
 * ヘッダーからの不要なコード削除
 */
function ajito_cleanup_head() {
  // WordPressバージョン削除
  remove_action('wp_head', 'wp_generator');
  // 短縮URL削除
  remove_action('wp_head', 'wp_shortlink_wp_head');
  // RSD削除
  remove_action('wp_head', 'rsd_link');
  // WLW削除
  remove_action('wp_head', 'wlwmanifest_link');
  // 絵文字スクリプト削除
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  // REST API リンク削除
  remove_action('wp_head', 'rest_output_link_wp_head');
}
add_action('after_setup_theme', 'ajito_cleanup_head');

/**
 * preload設定
 */
function ajito_resource_hints($urls, $relation_type) {
  if ('preconnect' === $relation_type) {
    // Google Fonts 用の preconnect
    $urls[] = array(
      'href' => 'https://fonts.googleapis.com',
    );
    $urls[] = array(
      'href' => 'https://fonts.gstatic.com',
      'crossorigin',
    );
  }
  
  if ('preload' === $relation_type && is_front_page()) {
    // ファーストビュー画像のプリロード
    $urls[] = array(
      'href' => get_template_directory_uri() . '/images/ajito-logo.png',
      'as' => 'image',
    );
  }
  
  return $urls;
}
add_filter('wp_resource_hints', 'ajito_resource_hints', 10, 2);

/**
 * モジュール読み込み
 */
$ajito_modules = array(
  '/inc/custom-post-types.php',  // カスタム投稿タイプ
  '/inc/custom-fields.php',      // カスタムフィールド
  '/inc/seo.php',                // SEO設定
  '/inc/security.php',           // セキュリティ強化
  '/inc/performance.php'         // パフォーマンス最適化
);

foreach ($ajito_modules as $module) {
  if (file_exists(get_template_directory() . $module)) {
    require_once get_template_directory() . $module;
  }
}

/**
 * OGP設定
 */
function ajito_meta_ogp() {
  if (is_front_page() || is_home() || is_singular()) {
    global $post;
    $ogp_title = '';
    $ogp_description = '';
    $ogp_url = '';
    $ogp_image = '';
    $site_name = get_bloginfo('name');
    
    if (is_front_page() || is_home()) {
      $ogp_title = get_bloginfo('name');
      $ogp_description = get_bloginfo('description');
      $ogp_url = home_url();
      $ogp_image = get_template_directory_uri().'/images/ogp.jpg';
    } elseif (is_singular()) {
      setup_postdata($post);
      $ogp_title = $post->post_title;
      $ogp_description = mb_substr(get_the_excerpt(), 0, 100);
      $ogp_url = get_permalink();
      if (has_post_thumbnail()) {
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
    echo '<meta name="twitter:site" content="@ajito_kameari" />' . "\n";
  }
}
add_action('wp_head', 'ajito_meta_ogp');

/**
 * 画像のalt属性を自動設定
 */
function ajito_auto_image_alt($content) {
  global $post;
  $pattern = "/<img(.*?)alt=('|\")?(.*?)('|\")(.*?)>/i";
  
  // alt属性が空の場合、投稿タイトルを使用
  $content = preg_replace_callback($pattern, function($matches) use ($post) {
    if (empty($matches[3])) {
      return '<img' . $matches[1] . 'alt="' . esc_attr($post->post_title) . '"' . $matches[5] . '>';
    } else {
      return $matches[0];
    }
  }, $content);
  
  return $content;
}
add_filter('the_content', 'ajito_auto_image_alt');

/**
 * 投稿タイプのパーマリンク構造を変更
 */
function ajito_fix_post_type_permalinks() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action('init', 'ajito_fix_post_type_permalinks', 99);

/**
 * 画像の遅延読み込み
 */
function ajito_add_lazy_loading($content) {
  // img要素にloading="lazy"属性とdata-src属性を追加
  $content = preg_replace('/<img(.*?)src=["\'](.*?)["\'](.+?)>/i', '<img$1src="$2"$3 loading="lazy">', $content);
  return $content;
}
add_filter('the_content', 'ajito_add_lazy_loading');

/**
 * カスタム検索フォーム
 */
function ajito_search_form($form) {
  $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url('/')) . '">
    <div class="search-wrap">
      <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__('検索...', 'ajito') . '" aria-label="' . esc_attr__('検索', 'ajito') . '">
      <button type="submit" id="searchsubmit" aria-label="' . esc_attr__('検索を実行', 'ajito') . '">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      </button>
    </div>
  </form>';
  
  return $form;
}
add_filter('get_search_form', 'ajito_search_form');

/**
 * テーブルにキャプションを追加
 */
function ajito_add_table_caption($content) {
  $content = preg_replace('/<table class="new-price-table">/i', '<table class="new-price-table"><caption>料金表</caption>', $content);
  $content = preg_replace('/<table class="access-table">/i', '<table class="access-table"><caption>店舗情報</caption>', $content);
  $content = preg_replace('/<table class="shop-info-table">/i', '<table class="shop-info-table"><caption>店内情報</caption>', $content);
  return $content;
}
add_filter('the_content', 'ajito_add_table_caption');

/**
 * エラーページに404ページをカスタム
 */
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

/**
 * WebP サポートの追加
 */
function ajito_webp_upload_mimes($existing_mimes) {
  $existing_mimes['webp'] = 'image/webp';
  return $existing_mimes;
}
add_filter('mime_types', 'ajito_webp_upload_mimes');

/**
 * レスポンシブ画像ヘルパー関数
 */
function ajito_responsive_image($attachment_id, $size = 'full', $attr = array()) {
  if (!$attachment_id) {
    return '';
  }
  
  $html = '';
  $image = wp_get_attachment_image_src($attachment_id, $size);
  
  if ($image) {
    $image_src = $image[0];
    $image_width = $image[1];
    $image_height = $image[2];
    
    $srcset = wp_get_attachment_image_srcset($attachment_id, $size);
    $sizes = wp_get_attachment_image_sizes($attachment_id, $size);
    
    $attr = wp_parse_args($attr, array(
      'src' => $image_src,
      'width' => $image_width,
      'height' => $image_height,
      'loading' => 'lazy',
      'alt' => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))),
    ));
    
    if ($srcset) {
      $attr['srcset'] = $srcset;
    }
    
    if ($sizes) {
      $attr['sizes'] = $sizes;
    }
    
    $attr = array_map('esc_attr', $attr);
    $html = '<img';
    
    foreach ($attr as $name => $value) {
      $html .= ' ' . $name . '="' . $value . '"';
    }
    
    $html .= '>';
  }
  
  return $html;
}

/**
 * アクセシビリティ向上: スキップリンク追加
 */
function ajito_skip_link() {
  echo '<a class="skip-link screen-reader-text" href="#content">' . esc_html__('コンテンツへスキップ', 'ajito') . '</a>';
}
add_action('wp_body_open', 'ajito_skip_link');

/**
 * コメント排除（必要ない場合）
 */
function ajito_disable_comments() {
  // コメント機能を無効化
  add_filter('comments_open', '__return_false', 20, 2);
  add_filter('pings_open', '__return_false', 20, 2);
  
  // 既存のコメントを非表示
  add_filter('comments_array', '__return_empty_array', 10, 2);
  
  // 管理画面のコメントメニューを削除
  if (is_admin()) {
    add_action('admin_menu', function () {
      remove_menu_page('edit-comments.php');
    });
    
    // ダッシュボードのコメントウィジェットを削除
    add_action('wp_dashboard_setup', function () {
      remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    });
  }
}
add_action('init', 'ajito_disable_comments');
