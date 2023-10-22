<?php
require './parts/connect_db.php';
$pageName = 'course_add';
$title = '課程新增';

$sql_coa = 'SELECT member_name FROM coach join member on coach.member_id = member.member_id';
$option_coa = $pdo->query($sql_coa)->fetchAll();

$sql_cat = 'SELECT * FROM category ORDER BY category_id';
$stmt_cat = $pdo->query($sql_cat);
$option_cat = $stmt_cat->fetchAll();
?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>
<style>
  form .form-text {
    color: red;
  }

  /* .cat-select{
    border: 2px solid red;
  } */
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
        <h5 class="card-title">新增課程資料</h5>

        <form name="form1" onsubmit="sendData(event)">
          <div class="mb-3">
            <label for="course_name" class="form-label">課程名稱</label>
            <input type="text" class="form-control" id="course_name" name="course_name">
            <div class="form-text"></div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <label for="member_name">教練姓名</label>
              <select class="form-select form-control" id="member_name" name="member_name">
                <option selected>請選擇教練姓名</option>
                <?php foreach ($option_coa as $o_coa): ?>
                  <option value="<?= $o_coa['member_name'] ?>">
                    <?= $o_coa['member_name'] ?>
                  </option>
                <?php endforeach ?>
              </select>
              <div class="form-text"></div>
            </div>
            <div class="form-text"></div>
          </div>
          <!--
          <div class="mb-3">
            <label for="category_id" class="form-label">課程分類id</label>
            <input type="text" class="form-control" id="category_id" name="category_id">
            <div class="form-text"></div>
          </div>
-->
          <div class="cat-container">
            <div>課程分類</div>
            <div class="mb-3">
              <button type="button" class="btn btn-warning" onclick="addCat()">新增課程分類</button>
            </div>
            <div class="form-floating cat-box">
              <label for="category"></label>
              <select class="form-select form-control cat-select" id="category" name="category[]">
                <option selected>請選擇課程分類</option>
                <?php foreach ($option_cat as $o): ?>
                  <option value="<?= $o['category_id'] ?>">
                    <?= $o['category'] ?>
                  </option>
                <?php endforeach ?>
              </select>
              <div class="form-text"></div>
            </div>
          </div>

          <div class="time-container">
            <div class="mb-3">
              <button type="button" class="btn btn-warning" onclick="addTime()">新增時間</button>
            </div>
            <div class="time-box border border-secondary">
              <div class="form-floating">
                <label for="day_of_week">上課星期</label>
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
            </div>
          </div>
          <div class="mb-3">
            <label for="course_description" class="form-label">課程描述</label>
            <textarea class="form-control" name="course_description" id="course_description" cols="30"
              rows="3"></textarea>
            <div class="form-text"></div>
          </div>
          <div class="form-floating">
            <label for="is_published">上架狀態</label>
            <select class="form-select form-control" id="is_published" name="is_published">
              <option selected>上架</option>
              <option>未上架</option>
            </select>
          </div>
          <!--
          <div class="mb-3">
            <label for="is_published" class="form-label">上架狀態</label>
            <input type="text" class="form-control" id="is_published" name="is_published">
            <div class="form-text"></div>
          </div>
          -->

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
const course_name_in = document.form1.course_name;
    const member_name_in = document.form1.member_name;
    const category_in = document.form1.category;
    const time_in = document.form1.time_period;
    const description_in = document.form1.course_description;
    const fields = [course_name_in, member_name_in, category_in, time_in, description_in];


  function sendData(e) {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    
    // 外觀要回復原來的狀態
    fields.forEach(field => {
      field.style.border = '1px solid #ccc';
      field.nextElementSibling.innerHTML = '';
    })

    // TODO: 資料在送出之前, 要檢查格式
    let isPass = true;


    if (course_name_in.value < 1) {
      isPass = false;
      course_name_in.style.border = '2px solid red';
      course_name_in.nextElementSibling.innerHTML = '請填寫正確的課程名稱'
    }
    if (member_name_in.value == '請選擇教練姓名') {
      isPass = false;
      member_name_in.style.border = '2px solid red';
      member_name_in.nextElementSibling.innerHTML = '請選擇正確的教練姓名'
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
    fetch('course_add-api3.php', {
      method: 'POST',
      body: fd, // 送出的格式會自動是 multipart/form-data
    }).then(r => r.json())
      .then(data => {
        console.log({
          data
        });
        if (data.success) {
          alert('資料新增成功');
          //location.href = "./course_list.php"
        } else {
          alert('錯誤')
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
            <select class="form-select form-control cat-select" id="category" name="category[]">
              <option selected>請選擇課程分類</option>
              <?php foreach ($option_cat as $o): ?>
                    <option value="<?= $o['category_id'] ?>">
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
    const $el = $(e.target);
    $el.closest('.cat-box').remove();
  }

</script>
<?php include './parts/html-foot.php' ?>