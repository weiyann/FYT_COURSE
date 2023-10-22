<?php
require './parts/connect_db.php';
$gym_id = isset($_GET['gym_id']) ? intval($_GET['gym_id']) : 0;
if(! empty($gym_id)){
  $sql = "DELETE FROM gym WHERE gym_id={$gym_id}";
  $pdo->query($sql);
}
header('Location: gym_list.php');