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


$sql = sprintf("INSERT INTO `gym`( `gym_name`, `gym_address`, `business_time`, `gym_description`, `district_id`, `created_at`)
VALUES (?,?,?,?,?,now())");


$stmt = $pdo->prepare($sql);
$stmt->execute([
$_POST['gym_name'],
$_POST['gym_address'],
$_POST['business_time'],
$_POST['gym_description'],
$_POST['district_id'],
]
);
$output['success'] = boolval($stmt->rowCount());
echo json_encode($output);
