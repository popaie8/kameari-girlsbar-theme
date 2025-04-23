<?php
/*
Template Name: 出勤情報
*/
get_header(); ?>

<div class="schedule-page">
  <div class="schedule-hero">
    <div class="inner">
      <h1 class="schedule-hero-title">Schedule</h1>
      <p class="schedule-hero-subtitle">出勤情報</p>
    </div>
  </div>
  
  <div class="schedule-content">
    <div class="inner">
      <?php
      // 最新の出勤情報を取得
      $schedules = get_posts(array(
        'post_type' => 'schedule',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
      ));
      
      if (!empty($schedules)) {
        $schedule = $schedules[0];
        $schedule_date = get_post_meta($schedule->ID, 'schedule_date', true);
        $date_obj = new DateTime($schedule_date);
        
        // 日付から一週間の日付を計算
        $days_of_week = array(
          'mon' => array('ja' => '月', 'date' => ''),
          'tue' => array('ja' => '火', 'date' => ''),
          'wed' => array('ja' => '水', 'date' => ''),
          'thu' => array('ja' => '木', 'date' => ''),
          'fri' => array('ja' => '金', 'date' => ''),
          'sat' => array('ja' => '土', 'date' => ''),
          'sun' => array('ja' => '日', 'date' => '')
        );
        
        // 開始日が月曜日になるよう調整
        $start_day_of_week = $date_obj->format('N'); // 1 (月) から 7 (日)
        if ($start_day_of_week != 1) {
          $diff = $start_day_of_week - 1;
          $date_obj->modify('-' . $diff . ' days');
        }
        
        // 各曜日の日付を計算
        $i = 0;
        foreach ($days_of_week as $day_key => &$day_info) {
          $day_date = clone $date_obj;
          $day_date->modify('+' . $i . ' days');
          $day_info['date'] = $day_date->format('m/d');
          $i++;
        }
        
        // キャスト一覧取得
        $casts = get_posts(array(
          'post_type' => 'cast',
          'posts_per_page' => -1,
          'orderby' => 'title',
          'order' => 'ASC'
        ));
        
        if (!empty($casts)) {
          // 週間出勤表示
          echo '<div class="schedule-table-wrapper">';
          echo '<table class="schedule-table">';
          
          // ヘッダー行
          echo '<thead><tr><th class="cast-name">キャスト</th>';
          foreach ($days_of_week as $day_key => $day_info) {
            echo '<th class="day-column">' . esc_html($day_info['ja']) . '<span class="day-date">' . esc_html($day_info['date']) . '</span></th>';
          }
          echo '</tr></thead>';
          
          // ボディ
          echo '<tbody>';
          foreach ($casts as $cast) {
            $cast_id = $cast->ID;
            echo '<tr>';
            
            // キャスト名とサムネイル
            echo '<td class="cast-name">';
            echo '<a href="' . esc_url(get_permalink($cast_id)) . '" class="cast-schedule-link">';
            if (has_post_thumbnail($cast_id)) {
              echo get_the_post_thumbnail($cast_id, 'thumbnail', array('class' => 'cast-schedule-thumb', 'loading' => 'lazy', 'alt' => esc_attr($cast->post_title)));
            } else {
              echo '<img src="' . esc_url(get_template_directory_uri()) . '/images/cast-placeholder.jpg" alt="' . esc_attr($cast->post_title) . '" class="cast-schedule-thumb" loading="lazy">';
            }
            echo '<span class="cast-schedule-name">' . esc_html($cast->post_title) . '</span>';
            echo '</a></td>';
            
            // 各曜日の出勤情報
            foreach ($days_of_week as $day_key => $day_info) {
              $time_key = 'schedule_' . $day_key . '_' . $cast_id;
              $time_value = get_post_meta($schedule->ID, $time_key, true);
              
              $status_class = 'status-off';
              if (!empty($time_value) && $time_value != '休み' && $time_value != '-') {
                $status_class = 'status-on';
              }
              
              echo '<td class="schedule-time ' . $status_class . '">' . esc_html($time_value) . '</td>';
            }
            
            echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
          echo '</div>';
          
          // 凡例
          echo '<div class="schedule-legends">';
          echo '<p class="schedule-updated">更新日: ' . esc_html(get_the_date('Y年m月d日', $schedule->ID)) . '</p>';
          echo '<p class="schedule-note">※出勤情報は変更になる場合がございます。詳しくはお電話にてご確認ください。</p>';
          echo '</div>';
        } else {
          echo '<p class="no-casts">現在キャストの登録がありません。</p>';
        }
      } else {
        echo '<p class="no-schedule">現在出勤情報の登録がありません。</p>';
      }
      ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
