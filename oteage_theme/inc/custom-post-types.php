<?php
/**
 * Register Custom Post Types for AJITO
 */

function ajito_register_post_types() {
  // Register News Post Type
  register_post_type('news', array(
    'labels' => array(
      'name' => 'お知らせ',
      'singular_name' => 'お知らせ',
      'add_new' => '新規追加',
      'add_new_item' => 'お知らせを追加',
      'edit_item' => 'お知らせを編集',
      'new_item' => '新規お知らせ',
      'all_items' => 'すべてのお知らせ',
      'view_item' => 'お知らせを表示',
      'search_items' => 'お知らせを検索',
      'not_found' => 'お知らせが見つかりませんでした',
      'not_found_in_trash' => 'ゴミ箱にお知らせはありません',
      'menu_name' => 'お知らせ'
    ),
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-megaphone',
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'rewrite' => array('slug' => 'news', 'with_front' => false),
    'show_in_rest' => true,  // Enable Gutenberg editor
  ));
  
  // Register Cast Post Type
  register_post_type('cast', array(
    'labels' => array(
      'name' => 'キャスト',
      'singular_name' => 'キャスト',
      'add_new' => '新規追加',
      'add_new_item' => 'キャストを追加',
      'edit_item' => 'キャストを編集',
      'new_item' => '新規キャスト',
      'all_items' => 'すべてのキャスト',
      'view_item' => 'キャストを表示',
      'search_items' => 'キャストを検索',
      'not_found' => 'キャストが見つかりませんでした',
      'not_found_in_trash' => 'ゴミ箱にキャストはありません',
      'menu_name' => 'キャスト'
    ),
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-groups',
    'supports' => array('title', 'editor', 'thumbnail'),
    'rewrite' => array('slug' => 'cast', 'with_front' => false),
    'show_in_rest' => true,
  ));
  
  // Register Schedule Post Type
  register_post_type('schedule', array(
    'labels' => array(
      'name' => '出勤情報',
      'singular_name' => '出勤情報',
      'add_new' => '新規追加',
      'add_new_item' => '出勤情報を追加',
      'edit_item' => '出勤情報を編集',
      'new_item' => '新規出勤情報',
      'all_items' => 'すべての出勤情報',
      'view_item' => '出勤情報を表示',
      'search_items' => '出勤情報を検索',
      'not_found' => '出勤情報が見つかりませんでした',
      'not_found_in_trash' => 'ゴミ箱に出勤情報はありません',
      'menu_name' => '出勤情報'
    ),
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-calendar-alt',
    'supports' => array('title'),
    'rewrite' => array('slug' => 'schedule', 'with_front' => false),
    'show_in_rest' => true,
  ));
}
add_action('init', 'ajito_register_post_types');
