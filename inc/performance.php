<?php
/**
 * パフォーマンス最適化モジュール
 * 
 * サイトの読み込み速度を向上させるための設定です。
 *
 * @package AJITO
 * @since 1.1.0
 */

// 直接アクセス禁止
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 画像のレスポンシブ対応
 */
function ajito_add_image_size_attributes($content) {
    $pattern = '/<img (.*?)>/i';
    
    $content = preg_replace_callback($pattern, function($matches) {
        // srcset と sizes 属性が既に存在する場合はそのまま返す
        if (strpos($matches[1], 'srcset') !== false || strpos($matches[1], 'loading') !== false) {
            return $matches[0];
        }
        
        // src 属性を取得
        $src_pattern = '/src=[\'"](.*?)[\'"]/i';
        preg_match($src_pattern, $matches[1], $src_matches);
        
        if (empty($src_matches)) {
            return $matches[0];
        }
        
        $src = $src_matches[1];
        
        // WordPressのアップロード画像かどうかを確認
        $upload_dir = wp_upload_dir();
        $base_url = $upload_dir['baseurl'];
        
        if (strpos($src, $base_url) === false) {
            // WordPressのアップロード画像ではない場合、loading="lazy" のみ追加
            if (strpos($matches[1], 'loading=') === false) {
                return str_replace('<img', '<img loading="lazy"', $matches[0]);
            }
            return $matches[0];
        }
        
        // 画像IDを取得
        $attachment_id = attachment_url_to_postid($src);
        
        if (!$attachment_id) {
            // 添付ファイドIDが取得できない場合、loading="lazy" のみ追加
            if (strpos($matches[1], 'loading=') === false) {
                return str_replace('<img', '<img loading="lazy"', $matches[0]);
            }
            return $matches[0];
        }
        
        // srcset と sizes 属性を取得
        $srcset = wp_get_attachment_image_srcset($attachment_id, 'full');
        $sizes = wp_get_attachment_image_sizes($attachment_id, 'full');
        
        // srcset と sizes 属性を追加
        $img = str_replace('<img', '<img loading="lazy"', $matches[0]);
        
        if ($srcset) {
            $img = str_replace('>', ' srcset="' . esc_attr($srcset) . '">', $img);
        }
        
        if ($sizes) {
            $img = str_replace('>', ' sizes="' . esc_attr($sizes) . '">', $img);
        }
        
        return $img;
    }, $content);
    
    return $content;
}
add_filter('the_content', 'ajito_add_image_size_attributes', 999);
add_filter('post_thumbnail_html', 'ajito_add_image_size_attributes', 999);
add_filter('widget_text', 'ajito_add_image_size_attributes', 999);

/**
 * Font Awesome の非同期読み込み
 */
function ajito_async_fontawesome() {
    if (wp_script_is('font-awesome', 'enqueued')) {
        // Font Awesome が読み込まれている場合
        wp_script_add_data('font-awesome', 'defer', true);
    }
}
add_action('wp_enqueue_scripts', 'ajito_async_fontawesome', 20);

/**
 * CSSを最適化（インラインCSS化）
 */
function ajito_critical_css() {
    // クリティカルCSSファイルのパス
    $critical_css_path = get_template_directory() . '/css/critical.css';
    
    if (file_exists($critical_css_path) && is_front_page()) {
        $critical_css = file_get_contents($critical_css_path);
        if ($critical_css) {
            echo '<style id="critical-css">' . $critical_css . '</style>';
        }
    }
}
add_action('wp_head', 'ajito_critical_css', 1);

/**
 * WebP画像フォーマットのサポート
 */
function ajito_webp_support() {
    // WebP画像が生成されているか確認
    $upload_dir = wp_upload_dir();
    $webp_dir = trailingslashit($upload_dir['basedir']) . 'webp';
    
    if (is_dir($webp_dir)) {
        // pictureタグを使用したWebP対応を有効化
        add_filter('the_content', 'ajito_convert_to_picture_tag');
        add_filter('post_thumbnail_html', 'ajito_convert_to_picture_tag');
    }
}
add_action('init', 'ajito_webp_support');

/**
 * imgタグをpictureタグに変換
 */
function ajito_convert_to_picture_tag($content) {
    $pattern = '/<img(.*?)src=[\'"](.*?)[\'"](.*?)>/i';
    
    return preg_replace_callback($pattern, function($matches) {
        $img_tag = $matches[0];
        $atts = $matches[1] . $matches[3];
        $src = $matches[2];
        
        // JPG/PNGファイルのみ対象とする
        if (!preg_match('/\.(jpe?g|png)$/i', $src)) {
            return $img_tag;
        }
        
        // WebP画像のパスを生成
        $webp_src = preg_replace('/\.(jpe?g|png)$/i', '.webp', $src);
        
        // WebP画像が存在するか確認
        $upload_dir = wp_upload_dir();
        $base_url = $upload_dir['baseurl'];
        $base_dir = $upload_dir['basedir'];
        
        if (strpos($src, $base_url) !== 0) {
            return $img_tag;
        }
        
        $file_path = str_replace($base_url, $base_dir, $src);
        $webp_path = str_replace($base_url, $base_dir, $webp_src);
        
        if (!file_exists($webp_path)) {
            return $img_tag;
        }
        
        // pictureタグに変換
        $picture_tag = '<picture>';
        $picture_tag .= '<source srcset="' . esc_attr($webp_src) . '" type="image/webp">';
        $picture_tag .= '<img src="' . esc_attr($src) . '"' . $atts . '>';
        $picture_tag .= '</picture>';
        
        return $picture_tag;
    }, $content);
}

/**
 * ブラウザキャッシュ設定
 */
function ajito_browser_cache_headers() {
    $file_types = array(
        // 1年間キャッシュする静的ファイル
        array(
            'expiry' => 31536000, // 1年
            'ext' => array('jpg', 'jpeg', 'png', 'gif', 'webp', 'ico', 'svg', 'woff', 'woff2')
        ),
        // 1週間キャッシュするCSSとJS
        array(
            'expiry' => 604800, // 1週間
            'ext' => array('css', 'js')
        )
    );
    
    $file_url = $_SERVER['REQUEST_URI'];
    $file_ext = pathinfo($file_url, PATHINFO_EXTENSION);
    
    foreach ($file_types as $type) {
        if (in_array($file_ext, $type['ext'])) {
            header('Cache-Control: public, max-age=' . $type['expiry']);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $type['expiry']) . ' GMT');
            header('Pragma: public');
            break;
        }
    }
}
add_action('template_redirect', 'ajito_browser_cache_headers');

/**
 * 不要なクエリ文字列を削除
 */
function ajito_remove_query_strings($src) {
    if (strpos($src, 'ver=') && !strpos($src, 'admin')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'ajito_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'ajito_remove_query_strings', 10, 1);

/**
 * メディアファイルの最適化（自動圧縮）
 */
function ajito_optimize_images($metadata) {
    if (!isset($metadata['file'])) {
        return $metadata;
    }
    
    // ImageMagickが利用可能な場合のみ実行
    if (!class_exists('Imagick')) {
        return $metadata;
    }
    
    $upload_dir = wp_upload_dir();
    $file = trailingslashit($upload_dir['basedir']) . $metadata['file'];
    
    // 画像ファイルのみ処理
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, array('jpg', 'jpeg', 'png'))) {
        return $metadata;
    }
    
    try {
        $image = new Imagick($file);
        
        // 最適化設定
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $image->setImageCompression(Imagick::COMPRESSION_JPEG);
                $image->setImageCompressionQuality(85);
                break;
            case 'png':
                $image->setImageCompression(Imagick::COMPRESSION_ZIP);
                $image->setImageCompressionQuality(95);
                break;
        }
        
        // ストリップメタデータ
        $image->stripImage();
        
        // 保存
        $image->writeImage($file);
        
        // WebP版の生成
        $webp_file = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file);
        $webp_relative_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $metadata['file']);
        $image->setImageFormat('webp');
        $image->setImageCompressionQuality(85);
        $image->writeImage($webp_file);
        
        // メモリ解放
        $image->clear();
        $image->destroy();
        
    } catch (Exception $e) {
        // エラーが発生しても続行
        error_log('画像最適化エラー: ' . $e->getMessage());
    }
    
    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'ajito_optimize_images', 10, 1);

/**
 * インラインリソースの最適化
 */
function ajito_minify_inline_resources($content) {
    if (is_admin() || !is_main_query()) {
        return $content;
    }
    
    // インラインCSSを最小化
    $content = preg_replace_callback('/<style[^>]*>(.*?)<\/style>/s', function($matches) {
        $css = $matches[1];
        // コメント削除
        $css = preg_replace('/\/\*.*?\*\//s', '', $css);
        // 連続する空白を削除
        $css = preg_replace('/\s+/', ' ', $css);
        // スペースを削除
        $css = str_replace(array(' {', '{ ', ' }', '} ', ': ', ' :', '; ', ' ;'), array('{', '{', '}', '}', ':', ':', ';', ';'), $css);
        
        return '<style>' . $css . '</style>';
    }, $content);
    
    // インラインJavaScriptを最小化
    $content = preg_replace_callback('/<script[^>]*>(.*?)<\/script>/s', function($matches) {
        $js = $matches[1];
        // 行コメント削除（//から行末まで）
        $js = preg_replace('/\/\/.*$/m', '', $js);
        // ブロックコメント削除（/* ... */）
        $js = preg_replace('/\/\*.*?\*\//s', '', $js);
        // 連続する空白を削除
        $js = preg_replace('/\s+/', ' ', $js);
        
        return '<script>' . trim($js) . '</script>';
    }, $content);
    
    return $content;
}
add_filter('the_content', 'ajito_minify_inline_resources', 999);

/**
 * 読み込みの優先順位を設定
 */
function ajito_set_resource_priorities() {
    global $wp_scripts, $wp_styles;
    
    // スクリプトの優先順位設定
    if (!is_admin() && isset($wp_scripts->registered['jquery'])) {
        $wp_scripts->registered['jquery']->deps = array_diff($wp_scripts->registered['jquery']->deps, array('jquery-core', 'jquery-migrate'));
        $wp_scripts->registered['jquery-core']->src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js';
        $wp_scripts->add_data('jquery-core', 'defer', true);
    }
    
    // タイプ属性の削除（HTML5対応）
    function ajito_remove_type_attr($tag) {
        return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
    }
    add_filter('style_loader_tag', 'ajito_remove_type_attr', 10, 1);
    add_filter('script_loader_tag', 'ajito_remove_type_attr', 10, 1);
}
add_action('wp_enqueue_scripts', 'ajito_set_resource_priorities', 999);

/**
 * GMapsを遅延読み込み
 */
function ajito_defer_google_maps() {
    if (is_front_page() || is_page('access')) {
        ?>
        <script>
        // Google Mapsの遅延読み込み
        document.addEventListener('DOMContentLoaded', function() {
            var mapElement = document.querySelector('.map-wrapper');
            if (mapElement) {
                var observer = new IntersectionObserver(function(entries) {
                    if (entries[0].isIntersecting) {
                        var iframe = mapElement.querySelector('iframe');
                        if (iframe && !iframe.src) {
                            iframe.src = iframe.dataset.src;
                        }
                        observer.disconnect();
                    }
                });
                observer.observe(mapElement);
            }
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'ajito_defer_google_maps', 50);

/**
 * スライダーの最適化
 */
function ajito_optimize_slider() {
    if (is_front_page()) {
        ?>
        <script>
        // スライダーの遅延初期化
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof jQuery !== 'undefined' && typeof jQuery.fn.slick !== 'undefined') {
                    jQuery('.gallery-slider .galleryList').slick({
                        dots: true,
                        arrows: true,
                        autoplay: true,
                        autoplaySpeed: 4000,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        centerMode: true,
                        centerPadding: '0',
                        lazyLoad: 'ondemand',
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
            }, 1000); // スライダー初期化を1秒遅延
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'ajito_optimize_slider', 30);

/**
 * HTTPからHTTPSへのリダイレクト
 */
function ajito_force_https() {
    if (!is_ssl() && !is_admin() && !wp_doing_ajax() && !wp_doing_cron()) {
        $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        wp_redirect($redirect_url, 301);
        exit();
    }
}
add_action('template_redirect', 'ajito_force_https');

/**
 * Prefetchの実装
 */
function ajito_add_dns_prefetch() {
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">';
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">';
    echo '<link rel="dns-prefetch" href="//ajax.googleapis.com">';
    echo '<link rel="dns-prefetch" href="//cdn.jsdelivr.net">';
    echo '<link rel="dns-prefetch" href="//www.google.com">';
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">';
}
add_action('wp_head', 'ajito_add_dns_prefetch', 0);

/**
 * 管理バーを無効化（フロントエンド表示時）
 */
function ajito_disable_admin_bar_for_performance() {
    if (!is_admin() && !current_user_can('manage_options')) {
        add_filter('show_admin_bar', '__return_false');
    }
}
add_action('init', 'ajito_disable_admin_bar_for_performance');
