function ajito_register_news_post_type() {
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
}