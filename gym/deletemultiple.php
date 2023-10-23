<?php
require './parts/connect_db.php';
if (isset($_GET['gym_ids'])) {
  $gymIds = explode(',', $_GET['gym_ids']);
  $placeholders = implode(',', array_fill(0, count($gymIds), '?'));

  $deleteSql = "DELETE FROM gym WHERE gym_id IN ($placeholders)";
  $stmt = $pdo->prepare($deleteSql);
  $stmt->execute($gymIds);

}


$come_from = 'gym_list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
  $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: $come_from");
