<?php
/**
 * Custom Fields for AJITO
 */

// Register meta boxes for Cast post type
function ajito_register_cast_meta_boxes() {
  add_meta_box(
    'cast_details',
    'キャスト詳細',
    'ajito_cast_details_callback',
    'cast',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'ajito_register_cast_meta_boxes');

// Callback for Cast details meta box
function ajito_cast_details_callback($post) {
  wp_nonce_field('ajito_cast_details', 'ajito_cast_details_nonce');
  
  $age = get_post_meta($post->ID, 'age', true);
  $height = get_post_meta($post->ID, 'height', true);
  $hobby = get_post_meta($post->ID, 'hobby', true);
  $favorite = get_post_meta($post->ID, 'favorite', true);
  
  echo '<table class="form-table">
    <tr>
      <th><label for="age">年齢</label></th>
      <td><input type="text" id="age" name="age" value="' . esc_attr($age) . '" class="regular-text"></td>
    </tr>
    <tr>
      <th><label for="height">身長</label></th>
      <td><input type="text" id="height" name="height" value="' . esc_attr($height) . '" class="regular-text"></td>
    </tr>
    <tr>
      <th><label for="hobby">趣味</label></th>
      <td><input type="text" id="hobby" name="hobby" value="' . esc_attr($hobby) . '" class="regular-text"></td>
    </tr>
    <tr>
      <th><label for="favorite">好きなもの</label></th>
      <td><input type="text" id="favorite" name="favorite" value="' . esc_attr($favorite) . '" class="regular-text"></td>
    </tr>
  </table>';
}

// Save Cast custom fields
function ajito_save_cast_details($post_id) {
  if (!isset($_POST['ajito_cast_details_nonce']) || !wp_verify_nonce($_POST['ajito_cast_details_nonce'], 'ajito_cast_details')) {
    return;
  }
  
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }
  
  if (isset($_POST['age'])) {
    update_post_meta($post_id, 'age', sanitize_text_field($_POST['age']));
  }
  
  if (isset($_POST['height'])) {
    update_post_meta($post_id, 'height', sanitize_text_field($_POST['height']));
  }
  
  if (isset($_POST['hobby'])) {
    update_post_meta($post_id, 'hobby', sanitize_text_field($_POST['hobby']));
  }
  
  if (isset($_POST['favorite'])) {
    update_post_meta($post_id, 'favorite', sanitize_text_field($_POST['favorite']));
  }
}
add_action('save_post_cast', 'ajito_save_cast_details');