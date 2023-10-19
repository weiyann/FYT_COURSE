<?php
require './parts/connect_db.php';

$output = [
  'postData' => $_POST,
  'success' => false,
  // 'error' => '',
  'errors' => [],
];

# 告訴用戶端, 資料格式為 JSON
header('Content-Type: application/json');

$tempId = '7+1'; // 課程id


// 获取 member_id
$sql_member = "SELECT member_id FROM member WHERE member_name = ?";
$stmt_member = $pdo->prepare($sql_member);
$stmt_member->execute([$_POST['member_name']]);

if ($stmt_member->rowCount() > 0) {
  $member_id = $stmt_member->fetchColumn();

  // 根据 member_id 获取 coach_id
  $sql_coach = "SELECT coach_id FROM coach WHERE member_id = ?";
  $stmt_coach = $pdo->prepare($sql_coach);
  $stmt_coach->execute([$member_id]);

  if ($stmt_coach->rowCount() > 0) {
    $coach_id = $stmt_coach->fetchColumn();

    // 插入数据到 course 表
    $sql_c = "INSERT INTO `course`(`course_name`, `course_description`, `coach_id`, `is_published`, `creation_date`) VALUES (?, ?, ?, ?, NOW())";
    $stmt_c = $pdo->prepare($sql_c);
    $stmt_c->execute([
      $_POST['course_name'],
      $_POST['course_description'],
      $coach_id, // 使用获得的 coach_id
      $_POST['is_published'],
    ]);

    // 插入数据到 course_time 表
    $sql_t = "INSERT INTO `course_time`(`day_of_week`, `time_period`, `course_id`) VALUES (?, ?, ?)";
    $stmt_t = $pdo->prepare($sql_t);
    $stmt_t->execute([
      $_POST['day_of_week'],
      $_POST['time_period'],
      $pdo->lastInsertId(), // 使用上一个插入操作生成的 course_id
    ]);

    // 插入数据到 course_category_relation 表
    $sql_CCR = "INSERT INTO `course_category_relation`(`course_id`, `category_id`) VALUES (?, ?)";
    $stmt_CCR = $pdo->prepare($sql_CCR);
    $stmt_CCR->execute([
      $pdo->lastInsertId(), // 使用上一个插入操作生成的 course_id
      $_POST['category_id'],
    ]);

    $output['success'] = true;
  }
}
$output['success'] = boolval($stmt_c->rowCount());
$output['success'] = boolval($stmt_t->rowCount());
$output['success'] = boolval($stmt_CCR->rowCount());
echo json_encode($output);
