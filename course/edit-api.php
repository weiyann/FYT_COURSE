<?php
require './parts/connect_db.php';
# 告訴用戶端, 資料格式為 JSON
header('Content-Type: application/json');
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;


if (empty($course_id)) {
  $output['errors']['course_id'] = "沒有 PK";
  echo json_encode($output);
  exit; // 結束程式
}

$output = [
  'postData' => $_POST,
  'success' => false,
  // 'error' => '',
  'errors' => [],
];




// 獲取 member_id
$sql_member = "SELECT member_id FROM member WHERE member_name = ?";
$stmt_member = $pdo->prepare($sql_member);
$stmt_member->execute([$_POST['member_name']]);

$member_id = $stmt_member->fetchColumn(); // fetchColumn()預設返回查詢成功第一列的值，fetchColumn(1)返回第二列

// 根据 member_id 獲取 coach_id
$sql_coach = "SELECT coach_id FROM coach WHERE member_id = ?";
$stmt_coach = $pdo->prepare($sql_coach);
$stmt_coach->execute([$member_id]);

$coach_id = $stmt_coach->fetchColumn();

// 插入数据到 course 表
$sql_c = "UPDATE `course`
SET
  `course_name` = ?,
  `course_description` = ?,
  `coach_id` = ?,
  `is_published` = ?
WHERE course_id=?";
$stmt_c = $pdo->prepare($sql_c);
$stmt_c->execute([
  $_POST['course_name'],
  $_POST['course_description'],
  $coach_id,
  // 使用獲得的 coach_id
  $_POST['is_published'],
  $course_id
]);

//$course_id = $pdo->lastInsertId(); // 拿到最後一次建立的course_id


$timePeriods = $_POST['time_period'];
$daysOfWeek = $_POST['day_of_week'];

foreach ($timePeriods as $index => $timePeriod) {
  $dayOfWeek = $daysOfWeek[$index];

  $sql_t = "UPDATE course_time 
  SET 
  day_of_week=?,
  time_period=?
  WHERE course_id=?";
  
  $stmt_t = $pdo->prepare($sql_t);
  $stmt_t->execute([
    $dayOfWeek,
    $timePeriod,
    $course_id
  ]);
}

$categorys = $_POST['category'];

foreach ($categorys as $category_id) {

  $sql_CCR ="UPDATE course_category_relation 
  SET
  `category_id`=?
  WHERE course_id=?";
  $stmt_CCR = $pdo->prepare($sql_CCR);
  $stmt_CCR->execute([$category_id, $course_id]);
}
//$output['success'] = boolval($stmt_member->rowCount() && $stmt_t->rowCount() && $stmt_CCR->rowCount());
$output['success'] = [boolval($stmt_member->rowCount()),boolval($stmt_t->rowCount()),boolval($stmt_CCR->rowCount())];

echo json_encode($output);