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

$tempId = '7+1';

$sql_c = "INSERT INTO `course`(
  `course_name`, `course_description`, `coach_id`, `is_published`, `creation_date`
  ) VALUES (
    ?, ?, ?, ?, NOW()
  )";
$sql_t = "INSERT INTO `course_time`(`day_of_week`, `time_period`, `course_id`) VALUES (?,?,?)";
$sql_CCR="INSERT INTO `course_category_relation`(`course_id`, `category_id`) VALUES (?,?)";

$stmt_c = $pdo->prepare($sql_c);
$stmt_t = $pdo->prepare($sql_t);
$stmt_CCR=$pdo->prepare($sql_CCR);

$stmt_c->execute([
  $_POST['course_name'],
  $_POST['course_description'],
  $_POST['coach_id'],
  $_POST['is_published'],
]);
$stmt_t->execute([
  $_POST['day_of_week'],
  $_POST['time_period'],
  $_POST['course_id'],
]);
$stmt_CCR->execute([
  $_POST['course_id'],
  $_POST['category_id'],
]);
$output['success'] = boolval($stmt_c->rowCount());
$output['success'] = boolval($stmt_t->rowCount());
$output['success'] = boolval($stmt_CCR->rowCount());
echo json_encode($output);
