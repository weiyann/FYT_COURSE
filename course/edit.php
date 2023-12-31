<?php
require './parts/connect_db.php';
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
if (empty($course_id)) {
  header('Location: course_list.php');
  exit; // 結束程式
}

$sql = "SELECT 
c.course_id, 
c.course_name, 
c.course_description, 
m.member_name, 
c.creation_date, 
c.is_published, 
ct.day_of_week, 
ct.time_period, 
cat.category
FROM course c
INNER JOIN course_time ct ON c.course_id = ct.course_id
INNER JOIN course_category_relation ccr ON c.course_id = ccr.course_id
INNER JOIN category cat ON ccr.category_id = cat.category_id
INNER JOIN coach co ON c.coach_id = co.coach_id
INNER JOIN member m ON co.member_id = m.member_id
WHERE c.course_id={$course_id}
GROUP BY c.course_id";
$row = $pdo->query($sql)->fetch();


$pageName = 'course_edit';
$title = '課程編輯';

$sql_t = "SELECT 
ct.time_period, 
ct.day_of_week,
ct.course_id
FROM course_time ct
where course_id={$course_id}
ORDER BY ct.course_id";
$rows_t = $pdo->query($sql_t)->fetchAll();
//print_r($rows_t);

$sql_cat = "SELECT cat.category, ccr.course_id 
FROM category cat 
INNER JOIN course_category_relation ccr ON cat.category_id = ccr.category_id
where course_id={$course_id}
ORDER BY ccr.course_id";
$rows_cat = $pdo->query($sql_cat)->fetchAll();

$sql_cat2 = 'SELECT * FROM category ORDER BY category_id';
$stmt_cat = $pdo->query($sql_cat2);
$option_cat = $stmt_cat->fetchAll();
?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>
<style>
  form .form-text {
    color: red;
  }
</style>


<!-- Begin Page Content -->
<div class="container-fluid">

  <?php echo date("Ymd"); ?>
</div>
<!-- /.container-fluid -->
<div class="row">
  <div class="col">
    <div class="card">

      <div class="card-body">
        <h5 class="card-title">編輯課程資料</h5>

        <form name="form1" onsubmit="sendData(event)">
        <input type="hidden" name="course_id" value="<?= $row['course_id'] ?>">
          <div class="mb-3">
            <label for="course_name" class="form-label">課程名稱</label>
            <input type="text" class="form-control" id="course_name" name="course_name"
              value=<?= htmlentities($row['course_name']) ?>>
            <div class="form-text"></div>
          </div>

          <div class="mb-3">
            <label for="member_name" class="form-label">教練姓名</label>
            <input type="text" class="form-control" id="member_name" name="member_name"
              value=<?= htmlentities($row['member_name']) ?>>
            <div class="form-text"></div>
          </div>
          <div class="cat-container">
            <div>課程分類</div>
            <div class="mb-3">
              <button type="button" class="btn btn-warning" onclick="addCat()">新增課程分類</button>
            </div>
            <?php foreach ($rows_cat as $index => $r_cat): ?>
              <div class="form-floating cat-box">
                <label for="category"></label>
                <?php if ($index > 0): ?>
                  <div class="btn btn-danger" onclick="removeCat(event)">刪除分類</div>
                <?php endif ?>
                <select class="form-select form-control" id="category" name="category[]">
                  <option selected>請選擇課程分類</option>
                  <?php foreach ($option_cat as $o): ?>
                    <option <?= $o['category'] == $r_cat['category'] ? 'selected' : '' ?> value="<?= $o['category_id'] ?>">
                      <?= $o['category'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <div class="form-text"></div>
              </div>
            <?php endforeach ?>
          </div>

          <div class="time-container">
            <div class="mb-3">
              <button type="button" class="btn btn-warning" onclick="addTime()">新增時間</button>
            </div>
            <?php foreach ($rows_t as $index => $rt): ?>
              <div class="time-box border border-secondary">
                <div class="form-floating">
                  <label for="day_of_week">上課星期</label>
                  <?php if ($index > 0): ?>
                    <button type="button" class="btn btn-danger" onclick="removeTime(event)">刪除時間</button>
                  <?php endif ?>
                  <select class="form-select form-control" id="day_of_week" name="day_of_week[]">
                    <option <?= $rt['day_of_week'] == '星期一' ? 'selected' : '' ?>>星期一</option>
                    <option <?= $rt['day_of_week'] == '星期二' ? 'selected' : '' ?>>星期二</option>
                    <option <?= $rt['day_of_week'] == '星期三' ? 'selected' : '' ?>>星期三</option>
                    <option <?= $rt['day_of_week'] == '星期四' ? 'selected' : '' ?>>星期四</option>
                    <option <?= $rt['day_of_week'] == '星期五' ? 'selected' : '' ?>>星期五</option>
                    <option <?= $rt['day_of_week'] == '星期六' ? 'selected' : '' ?>>星期六</option>
                    <option <?= $rt['day_of_week'] == '星期日' ? 'selected' : '' ?>>星期日</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="time_period" class="form-label">上課時間</label>
                  <input type="time" class="form-control" id="time_period" name="time_period[]"
                    value=<?= $rt['time_period'] ?>>
                  <div class="form-text"></div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
          <div class="mb-3">
            <label for="course_description" class="form-label">課程描述</label>
            <textarea class="form-control" name="course_description" id="course_description" cols="30"
              rows="3"><?= htmlentities($row['course_description']) ?></textarea>
            <div class="form-text"></div>
          </div>
          <div class="form-floating">
            <label for="is_published">上架狀態</label>
            <select class="form-select form-control" id="is_published" name="is_published">
              <option <?= ($row['is_published'] == '上架') ? 'selected' : '' ?>>上架</option>
              <option <?= ($row['is_published'] == '未上架') ? 'selected' : '' ?>>未上架</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
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

<script>



  function sendData(e) {
    e.preventDefault(); // 不要讓表單以傳統的方式送出
    const course_name_in = document.form1.course_name;
    const member_name_in = document.form1.member_name;
    const category_in = document.form1.category;
    const time_in = document.form1.time_period;
    const description_in = document.form1.course_description;
    const fields = [course_name_in, member_name_in, category_in, time_in, description_in];

    // 外觀要回復原來的狀態
    /*
    fields.forEach(field => {
      field.style.border = '1px solid #ccc';
      field.nextElementSibling.innerHTML = '';
    })
    */
    // TODO: 資料在送出之前, 要檢查格式
    let isPass = true;


    if (course_name_in.value < 1) {
      isPass = false;
      course_name_in.style.border = '2px solid red';
      course_name_in.nextElementSibling.innerHTML = '請填寫正確的課程名稱'
    }
    if (member_name_in.value < 1) {
      isPass = false;
      member_name_in.style.border = '2px solid red';
      member_name_in.nextElementSibling.innerHTML = '請填寫正確的教練姓名'
    }
    if (category_in.value == '請選擇課程分類') {
      isPass = false;
      category_in.style.border = '2px solid red';
      category_in.nextElementSibling.innerHTML = '請選擇課程分類'
    }
    if (!time_in.value) {
      isPass = false;
      time_in.style.border = '2px solid red';
      time_in.nextElementSibling.innerHTML = '請選擇課程時間'
    }
    if (description_in.value < 1) {
      isPass = false;
      description_in.style.border = '2px solid red';
      description_in.nextElementSibling.innerHTML = '請輸入課程描述'
    }

    if (!isPass) {
      return;
    }
    // 建立只有資料的表單
    const fd = new FormData(document.form1);
    fetch('edit-api.php', {
      method: 'POST',
      body: fd, // 送出的格式會自動是 multipart/form-data
    }).then(r => r.json())
      .then(data => {
        console.log({
          data
        });
        if (data.success) {
          alert('資料編輯成功');
          //location.href = "./list.php"
        }else {
          alert('資料沒有修改')
          
        }
      })
      .catch(ex => console.log(ex));
  }

  const time_container = $('.time-container');
  const cat_container = $('.cat-container');

  const timeTpl = () => {
    return `<div class="time-box border border-secondary">
    <div class="form-floating">
              <label for="day_of_week">上課星期
              <button type="button" class="btn btn-danger" onclick="removeTime(event)">刪除時間</button>
              </label>
              <select class="form-select form-control" id="day_of_week" name="day_of_week[]">
                <option selected>星期一</option>
                <option>星期二</option>
                <option>星期三</option>
                <option>星期四</option>
                <option>星期五</option>
                <option>星期六</option>
                <option>星期日</option>
              </select>
            </div>
  
    <div class="mb-3">
            <label for="time_period" class="form-label">上課時間</label>
            <input type="time" class="form-control" id="time_period" name="time_period[]">
            <div class="form-text"></div>
          </div>
          </div>`
  }
  function addTime() {
    time_container.append(timeTpl())
  }
  function removeTime(e) {
    const $el = $(e.target);
    $el.closest('.time-box').remove();
  }

  const catTpl = () => {
    return `<div class="form-floating cat-box">
            <label for="category">
            <button type="button" class="btn btn-danger" onclick="removeCat(event)">刪除分類</button></label>
            <select class="form-select form-control" id="category" name="category[]">
              <option selected>請選擇課程分類</option>
              <?php foreach ($option_cat as $o): ?>
                                  <option>
                                    <?= $o['category'] ?>
                                  </option>
              <?php endforeach ?>
            </select>
          </div>`
  }
  function addCat() {
    cat_container.append(catTpl())
  }
  function removeCat(e) {
    const $el = $(e.currentTarget);
    $el.closest('.cat-box').remove();
  }

</script>
<?php include './parts/html-foot.php' ?>