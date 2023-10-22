<?php
require './parts/connect_db.php';

// 取得資料的 PK
$gym_id = isset($_GET['gym_id']) ? intval($_GET['gym_id']) : 0;

if (empty($gym_id)) {
  header('Location: gym_list.php');
  exit;
} else {
  $sql = "SELECT * FROM gym WHERE gym_id={$gym_id}";
  $row = $pdo->query($sql)->fetch();
  if(empty($row)){
    header('Location: gym_list.php');
    exit;
  }
}

$title = '編輯健身房';

$sql_d = 'SELECT * FROM district';
$option_d = $pdo->query($sql_d)->fetchAll();
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>
<style>
  form .form-text{
    color: red;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">編輯健身房資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="gym_name" class="form-label">健身房名稱</label>
              <input type="text" class="form-control" id="gym_name" name="gym_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="gym_description" class="form-label">介紹</label>
              <textarea class="form-control" name="gym_description" id="gym_description" cols="30" rows="5"></textarea>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="business_time" class="form-label">營業時間</label>
              <input type="text" class="form-control" id="business_time" name="business_time">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
            <div>地址</div>
              <div class="input-group mb-2">               
                <label for="district_id"></label>
                <select class="form-select form-control" id="district_name" name="district_id" style="width:140px">
                  <option>--請選擇縣市--</option>
                  <?php foreach ($option_d as $o): ?>
                    <option value="<?= $o['district_id'] ?>">
                      <?= $o['district_name'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <span class="input-group-text">縣/市</span>
                <label for="gym_address" class="form-label"></label>
                <input type="text" class="form-control w-50" id="gym_address" name="gym_address" placeholder="請輸入地址">                
              </div>
              <div class="form-text">
                  <div class="district-text"></div>
                  <div class="address-text"></div>
                </div>
              <!--
              <div class="form-floating">
                <label for="district_name">地址</label>
                <select class="form-select form-control" id="district_name" name="district_name">
                  <option>--請選擇縣市--</option>
                  <?php foreach ($option_d as $o): ?>
                    <option value="<?= $o['district_id'] ?>">
                      <?= $o['district_name'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <div class="form-text"></div><span>縣/市</span>
              </div>
              <label for="gym_address" class="form-label"></label>
              <input type="text" class="form-control" id="gym_address" name="gym_address">
              <div class="form-text"></div>
            </div>
                  -->
            <button type="submit" class="btn btn-primary">送出</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- End of Main Content -->

<!-- Footer -->
<!--
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Your Website 2020</span>
    </div>
  </div>
</footer>
-->
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include './parts/scripts.php' ?>

<script>
  const gym_name_in =document.form1.gym_name;
  const gym_description_in =document.form1.gym_description;
  const business_time_in =document.form1.business_time;
  const district_id_in =document.form1.district_id;
  const gym_address_in =document.form1.gym_address;
  const fields = [gym_name_in, gym_description_in, business_time_in];


  function sendData(e) {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    // 外觀要回復原來的狀態
    fields.forEach(field => {
      field.style.border = '1px solid #CCCCCC';
      field.nextElementSibling.innerHTML = '';
    })
    district_id_in.style.border = '1px solid #CCCCCC';
    $('.district-text').text('');
    gym_address_in.style.border = '1px solid #CCCCCC';
    $('.address-text').text('');

    // TODO: 資料在送出之前, 要檢查格式
    
    let isPass = true; // 有沒有通過檢查

    if (gym_name_in.value < 1) {
      isPass = false;
      gym_name_in.style.border = '2px solid red';
      gym_name_in.nextElementSibling.innerHTML = '請填寫正確的健身房名稱'
    }
    if (gym_description_in.value < 1) {
      isPass = false;
      gym_description_in.style.border = '2px solid red';
      gym_description_in.nextElementSibling.innerHTML = '請填寫正確的介紹'
    }
    if (business_time_in.value < 1) {
      isPass = false;
      business_time_in.style.border = '2px solid red';
      business_time_in.nextElementSibling.innerHTML = '請填寫正確的營業時間'
    }
    if (district_id_in.value == '--請選擇縣市--') {
      isPass = false;
      district_id_in.style.border = '2px solid red';
      $('.district-text').text('請選擇縣市');
    }
    if (gym_address_in.value < 1) {
      isPass = false;
      gym_address_in.style.border = '2px solid red';
      $('.address-text').text('請輸入地址');
    }

    if (!isPass) {
      return; // 沒有通過就不要發送資料
    }
    const fd = new FormData(document.form1);
    fetch('gym_add-api.php', {
        method: 'POST',
        body: fd, // 送出的格式會自動是 multipart/form-data
      }).then(r => r.json())
      .then(data => {
        console.log({
          data
        });if (data.success) {
          alert('資料編輯成功');
          //location.href = "./gym_list.php"
        }
      })
      .catch(ex => console.log(ex))
  }
</script>
<?php include './parts/html-foot.php' ?>