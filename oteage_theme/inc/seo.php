<?php
/**
 * SEO optimizations for AJITO
 */

// Add schema.org structured data for local business
function ajito_add_schema_markup() {
  if (!is_front_page()) return;
  
  $schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'BarOrPub',
    'name' => 'ガールズバーAJITO',
    'alternateName' => 'KAMEARI GIRLS BAR AJITO',
    'image' => get_template_directory_uri() . '/images/ajito-logo.png',
    'url' => home_url(),
    'telephone' => '03-5849-3269',
    'description' => '亀有駅から徒歩数分、ガールズバーAJITOは木目とネオンが調和したビンテージアメリカンな空間です。',
    'address' => array(
      '@type' => 'PostalAddress',
      'streetAddress' => '亀有5丁目28-2 1F',
      'addressLocality' => '葛飾区',
      'addressRegion' => '東京都',
      'postalCode' => '125-0061',
      'addressCountry' => 'JP'
    ),
    'geo' => array(
      '@type' => 'GeoCoordinates',
      'latitude' => '35.7461237292694',
      'longitude' => '139.85292467677388'
    ),
    'openingHoursSpecification' => array(
      '@type' => 'OpeningHoursSpecification',
      'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
      'opens' => '20:00',
      'closes' => '05:00'
    ),
    'priceRange' => '¥¥'
  );
  
  echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
}
add_action('wp_head', 'ajito_add_schema_markup');

// Add custom meta tags
function ajito_add_meta_tags() {
  // Mobile viewport
  echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
  
  // Chrome theme color
  echo '<meta name="theme-color" content="#0a0a0a">' . "\n";
  
  // Add canonical URL to avoid duplicate content
  if (is_singular()) {
    echo '<link rel="canonical" href="' . get_permalink() . '">' . "\n";
  }
}
add_action('wp_head', 'ajito_add_meta_tags');

// Optimize title tag
function ajito_custom_title($title) {
  if (is_single() && 'cast' == get_post_type()) {
    $title['title'] = get_the_title() . ' | キャスト | ' . get_bloginfo('name');
  }
  
  if (is_single() && 'news' == get_post_type()) {
    $title['title'] = get_the_title() . ' | お知らせ | ' . get_bloginfo('name');
  }
  
  if (is_post_type_archive('cast')) {
    $title['title'] = 'キャスト一覧 | ' . get_bloginfo('name');
  }
  
  if (is_post_type_archive('news')) {
    $title['title'] = 'お知らせ一覧 | ' . get_bloginfo('name');
  }
  
  return $title;
}
add_filter('document_title_parts', 'ajito_custom_title');