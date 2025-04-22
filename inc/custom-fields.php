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

// Register meta boxes for Schedule post type
function ajito_register_schedule_meta_boxes() {
  add_meta_box(
    'schedule_details',
    '週間出勤表',
    'ajito_schedule_details_callback',
    'schedule',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'ajito_register_schedule_meta_boxes');

// Callback for Schedule details meta box
function ajito_schedule_details_callback($post) {
  wp_nonce_field('ajito_schedule_details', 'ajito_schedule_details_nonce');
  
  $schedule_date = get_post_meta($post->ID, 'schedule_date', true);
  if (empty($schedule_date)) {
    $schedule_date = date('Y-m-d');
  }
  
  // Get all casts
  $casts = get_posts(array(
    'post_type' => 'cast',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
  ));
  
  echo '<table class="form-table">
    <tr>
      <th><label for="schedule_date">週の開始日</label></th>
      <td><input type="date" id="schedule_date" name="schedule_date" value="' . esc_attr($schedule_date) . '" class="regular-text"></td>
    </tr>
  </table>';
  
  $days = array('mon' => '月', 'tue' => '火', 'wed' => '水', 'thu' => '木', 'fri' => '金', 'sat' => '土', 'sun' => '日');
  
  echo '<h3>各キャストの出勤状況</h3>';
  echo '<table class="widefat fixed" style="margin-top: 10px;">';
  echo '<thead><tr>';
  echo '<th>キャスト名</th>';
  foreach ($days as $day_key => $day_label) {
    echo '<th>' . esc_html($day_label) . '</th>';
  }
  echo '</tr></thead>';
  
  echo '<tbody>';
  foreach ($casts as $cast) {
    $cast_id = $cast->ID;
    echo '<tr>';
    echo '<td>' . esc_html($cast->post_title) . '</td>';
    
    foreach ($days as $day_key => $day_label) {
      $time_key = 'schedule_' . $day_key . '_' . $cast_id;
      $time_value = get_post_meta($post->ID, $time_key, true);
      echo '<td><input type="text" name="' . esc_attr($time_key) . '" value="' . esc_attr($time_value) . '" placeholder="例: 20:00-LAST" style="width:100%;"></td>';
    }
    
    echo '</tr>';
  }
  echo '</tbody></table>';
  
  echo '<p class="description">出勤時間を入力してください。例: 20:00-LAST、休み、etc.</p>';
}

// Save Schedule custom fields
function ajito_save_schedule_details($post_id) {
  if (!isset($_POST['ajito_schedule_details_nonce']) || !wp_verify_nonce($_POST['ajito_schedule_details_nonce'], 'ajito_schedule_details')) {
    return;
  }
  
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }
  
  if (isset($_POST['schedule_date'])) {
    update_post_meta($post_id, 'schedule_date', sanitize_text_field($_POST['schedule_date']));
  }
  
  // Save schedule for each cast
  $casts = get_posts(array(
    'post_type' => 'cast',
    'posts_per_page' => -1
  ));
  
  $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
  
  foreach ($casts as $cast) {
    $cast_id = $cast->ID;
    
    foreach ($days as $day) {
      $time_key = 'schedule_' . $day . '_' . $cast_id;
      
      if (isset($_POST[$time_key])) {
        update_post_meta($post_id, $time_key, sanitize_text_field($_POST[$time_key]));
      }
    }
  }
}
add_action('save_post_schedule', 'ajito_save_schedule_details');
