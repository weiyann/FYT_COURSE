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
$sql_c = "INSERT INTO `course`(`course_name`, `course_description`, `coach_id`, `is_published`, `creation_date`) VALUES (?, ?, ?, ?, NOW())";
$stmt_c = $pdo->prepare($sql_c);
$stmt_c->execute([
  $_POST['course_name'],
  $_POST['course_description'],
  $coach_id,
  // 使用獲得的 coach_id
  $_POST['is_published'],
]);

$course_id = $pdo->lastInsertId();

// 插入数据到 course_time 表
$sql_t = "INSERT INTO `course_time`(`day_of_week`, `time_period`, `course_id`) VALUES (?, ?, ?)";
$stmt_t = $pdo->prepare($sql_t);
$stmt_t->execute([
  $_POST['day_of_week'],
  $_POST['time_period'],
  $course_id
]);

//根據category 獲取 category_id
$sql_cat = "SELECT ccr.category_id
    FROM course_category_relation ccr
    JOIN category c ON ccr.category_id = c.category_id
    WHERE c.category = ?";
$stmt_cat = $pdo->prepare($sql_cat);
$stmt_cat->execute([$_POST['category']]);

$category_id = $stmt_cat->fetchColumn();
// 插入数据到 course_category_relation 表
$sql_CCR = "INSERT INTO `course_category_relation`(`category_id`,`course_id`) VALUES (?, ?)";
$stmt_CCR = $pdo->prepare($sql_CCR);
$stmt_CCR->execute([
  $category_id,
  $course_id
  // 使用上一个插入操作生成的 course_id
]);