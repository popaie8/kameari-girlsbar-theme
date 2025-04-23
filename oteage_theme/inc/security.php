<?php
/**
 * セキュリティ強化モジュール
 * 
 * WordPress のセキュリティを強化するための設定です。
 *
 * @package AJITO
 * @since 1.1.0
 */

// 直接アクセス禁止
if (!defined('ABSPATH')) {
    exit;
}

/**
 * XMLRPCを完全に無効化
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * X-Frame-Options ヘッダー設定
 */
function ajito_add_security_headers() {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // 開発環境では無効にすることがあるため、条件分岐
    if (!defined('AJITO_DEV_MODE') || !AJITO_DEV_MODE) {
        header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' https://cdn.jsdelivr.net https://www.google.com https://www.gstatic.com; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com https://cdn.jsdelivr.net; img-src \'self\' data: https://www.google.com https://www.gstatic.com; font-src \'self\' https://fonts.gstatic.com; frame-src https://www.google.com');
    }
}
add_action('send_headers', 'ajito_add_security_headers');

/**
 * ログインページのエラーメッセージをカスタマイズ
 */
function ajito_login_error_message() {
    return 'ログイン情報が正しくありません。';
}
add_filter('login_errors', 'ajito_login_error_message');

/**
 * 管理画面へのアクセス制限（IP制限が必要な場合）
 */
function ajito_restrict_admin_access() {
    // サイトがリモートサーバーにある場合のみ実行
    if (!in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
        // 許可IPアドレスリストの定義（必要に応じて設定）
        $allowed_ips = array(
            // 例: '123.456.789.101',
        );
        
        // IP制限を適用する場合はコメントアウトを解除
        /*
        if (!empty($allowed_ips) && !in_array($_SERVER['REMOTE_ADDR'], $allowed_ips) && is_admin()) {
            wp_die('この操作は許可されていません。');
        }
        */
    }
}
add_action('init', 'ajito_restrict_admin_access');

/**
 * ログイン試行回数制限機能
 */
function ajito_limit_login_attempts() {
    if (!is_user_logged_in() && isset($_POST['log'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $transient_name = 'login_attempts_' . md5($ip);
        $login_attempts = get_transient($transient_name);
        
        if ($login_attempts === false) {
            set_transient($transient_name, 1, HOUR_IN_SECONDS);
        } else if ($login_attempts < 5) {
            set_transient($transient_name, $login_attempts + 1, HOUR_IN_SECONDS);
        } else {
            wp_die('ログイン試行回数が多すぎます。1時間後に再度お試しください。');
        }
    }
}
add_action('login_form_login', 'ajito_limit_login_attempts');

/**
 * カスタムパスワードリセットURLを使用
 */
function ajito_custom_password_reset_url($url, $user_id, $key) {
    if (strpos($url, 'wp-login.php') !== false) {
        $url = str_replace('wp-login.php', 'reset-password', $url);
    }
    return $url;
}
// カスタムログインページを使用する場合にコメントアウトを解除
// add_filter('lostpassword_url', 'ajito_custom_password_reset_url', 10, 3);

/**
 * REST APIを制限（ログインユーザーのみ使用可能）
 */
function ajito_restrict_rest_api($result) {
    // ログイン済みユーザーまたは特定のエンドポイントのみ許可
    if (!is_user_logged_in()) {
        // WordPress コアのエンドポイントは許可
        $current_route = $result->get_matched_route();
        
        // 許可するエンドポイント
        $allowed_routes = array(
            '/wp/v2/pages',
            '/wp/v2/posts',
            '/wp/v2/cast',
            '/wp/v2/news',
            '/wp/v2/schedule',
        );
        
        $is_allowed = false;
        
        if ($current_route) {
            foreach ($allowed_routes as $route) {
                if (strpos($current_route, $route) === 0) {
                    $is_allowed = true;
                    break;
                }
            }
        }
        
        if (!$is_allowed) {
            return new WP_Error(
                'rest_forbidden',
                __('アクセスが拒否されました。'),
                array('status' => 401)
            );
        }
    }
    
    return $result;
}
// REST APIを制限する場合にコメントアウトを解除
// add_filter('rest_authentication_errors', 'ajito_restrict_rest_api');

/**
 * SVGアップロード許可（必要な場合のみ）
 */
function ajito_allow_svg_upload($mimes) {
    // SVGをサニタイズするプラグインが必要
    if (current_user_can('administrator')) {
        $mimes['svg'] = 'image/svg+xml';
    }
    return $mimes;
}
// SVGアップロードを許可する場合にコメントアウトを解除
// add_filter('upload_mimes', 'ajito_allow_svg_upload');

/**
 * アップロードファイルのサニタイズ
 */
function ajito_sanitize_file_name($filename) {
    // 日本語ファイル名をローマ字に変換
    if (function_exists('sanitize_file_name')) {
        $filename = sanitize_file_name($filename);
    }
    
    // 小文字に変換
    $filename = strtolower($filename);
    
    // 特殊文字を削除
    $filename = preg_replace('/[^a-z0-9._-]/', '', $filename);
    
    return $filename;
}
add_filter('sanitize_file_name', 'ajito_sanitize_file_name', 10);

/**
 * WP-JSONリンクを非表示
 */
function ajito_remove_wp_json_links() {
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
}
add_action('after_setup_theme', 'ajito_remove_wp_json_links');

/**
 * ユーザー列挙を禁止
 */
function ajito_disable_user_enumeration() {
    if (isset($_GET['author']) && !is_admin()) {
        wp_redirect(home_url(), 301);
        exit;
    }
}
add_action('template_redirect', 'ajito_disable_user_enumeration');

/**
 * サニタイズヘルパー関数
 */
function ajito_sanitize_data($data, $type = 'text') {
    switch ($type) {
        case 'email':
            return sanitize_email($data);
        case 'url':
            return esc_url_raw($data);
        case 'int':
            return intval($data);
        case 'float':
            return floatval($data);
        case 'textarea':
            return sanitize_textarea_field($data);
        case 'html':
            return wp_kses_post($data);
        case 'text':
        default:
            return sanitize_text_field($data);
    }
}

/**
 * エスケープヘルパー関数
 */
function ajito_escape_data($data, $type = 'html') {
    switch ($type) {
        case 'attr':
            return esc_attr($data);
        case 'url':
            return esc_url($data);
        case 'js':
            return esc_js($data);
        case 'textarea':
            return esc_textarea($data);
        case 'html':
        default:
            return esc_html($data);
    }
}
