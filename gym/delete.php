<?php
require './parts/connect_db.php';
$gym_id = isset($_GET['gym_id']) ? intval($_GET['gym_id']) : 0;
if(! empty($gym_id)){
  $sql = "DELETE FROM gym WHERE gym_id={$gym_id}";
  $pdo->query($sql);
}
$come_from = 'gym_list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
  $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: $come_from");