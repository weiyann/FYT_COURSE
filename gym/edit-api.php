<?php
require './parts/connect_db.php';
# 告訴用戶端, 資料格式為 JSON
header('Content-Type: application/json');
$gym_id = isset($_POST['gym_id']) ? intval($_POST['gym_id']) : 0;
//echo json_encode($_POST);

if (empty($gym_id)) {
  $output['errors']['gym_id'] = "沒有 PK";
  echo json_encode($output);
  exit; // 結束程式
}
$output = [
  'postData' => $_POST,
  'success' => false,
  // 'error' => '',
  'errors' => [],
];
# 告訴用戶端, 資料格式為 JSON
header('Content-Type: application/json');


$sql = sprintf("UPDATE gym 
SET
'gym_name'=?,
'gym_address'=?,
'business_time'=?,
'gym_description'=?,
'district_id'=?
where gym_id=?");

$gym_name = $_POST['gym_name'] ?? '';
$gym_address = $_POST['gym_address'] ?? '';
$business_time = $_POST['business_time'] ?? '';
$gym_description = $_POST['gym_description'] ?? '';
$district_id = $_POST['district_id'] ?? '';

$stmt = $pdo->prepare($sql);
$stmt->execute(
  [
    $gym_name,
    $gym_address,
    $business_time,
    $gym_description,
    $district_id,
    $gym_id
  ]
);

$output['rowCount'] = $stmt->rowCount();
$output['success'] = boolval($stmt->rowCount());
echo json_encode($output);
