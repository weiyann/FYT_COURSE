<?php
require './parts/connect_db.php';
$pageName = 'course_list';
$title = '課程管理列表';

$sql = "SELECT * FROM course ORDER BY course_id DESC LIMIT 0, 20";
$rows = $pdo->query($sql)->fetchAll();
?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <pre><?php
  print_r($rows);
  ?></pre>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Your Website 2020</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include './parts/scripts.php' ?>


<?php include './parts/html-foot.php' ?>