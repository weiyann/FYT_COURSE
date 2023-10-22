<?php
require './parts/connect_db.php';

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
echo json_encode([
  'postData' => $_POST,
  'rowCount' => $stmt->rowCount(),
]);