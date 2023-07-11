<?php
session_start();

require_once("./config_db.php");
require_once("./LineLogin.php");
$product_names = $_SESSION['product_name'];
$profile = $_SESSION['profile'];
$userId = md5($profile->sub);
$email = $profile->email;
$name = $profile->name;
$orderID = $_SESSION['orderID'];

if (!isset($_SESSION['profile'])) {
  header("location: ./index.php");
  exit;
}

$isSuccess = isset($_GET['success']) && $_GET['success'] === 'true';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
</head>

<body style="background-image: url('https://www.ttomoru.com/wp-content/uploads/2023/06/bg-main2.jpg);">
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h1>Welcome, <?php echo $profile->name; ?></h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
      <div class="card-body">
        <?php if ($isSuccess) : ?>
          <script>
            alert('ระบบได้ทำการแจ้งสถานะไปยังไลน์ของลูกค้าสำเร็จแล้ว โดยลูกค้าจะได้รับรหัสผ่านอัตโนมัติเมื่อทางเราตรวจสอบการชำระเงินเสร็จสมบูรณ์ หากไม่ได้รับให้ทำการติดที่....');
          </script>
        <?php endif; ?>
        <p><b>Order ID:</b> <?php echo $orderID; ?></p>
        <?php
            echo "<p><b>Order Name:</b> ";

            // Check if the array is empty
            if (!empty($product_names)) {
                // Get the last element of the array
                $lastElement = end($product_names);

                // Iterate through the array
               foreach ($product_names as $value) {
                   echo $value;

                   // Check if the current value is not the last element
                    if ($value !== $lastElement) {
            echo ', ';
                   }
                }
              }

              echo "</p>";
              ?>

        <p><b>Name:</b> <?php echo $name; ?></p>
        <p><b>Email:</b> <?php echo $email; ?></p>
        <h6><b>สถานะการจ่ายเงิน: </b><label style="color: <?php echo $color ?>"><?php echo $text_status; ?></label></h6>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary  float-md-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
          ยืนยันการชำระและขอรับรหัส
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ขั้นตอนการขอรับรหัส</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h3>ขั้นตอนการขอรับรหัส<h5>หลังทำการชำระให้ทำการแอดไลน์เพื่อรับรหัส</h5>
                </h3>
                <p>เพิ่มเพื่อนด้วย QR Code<br>
					1. คลิกขวาที่รูป "LINE เพิ่มเพื่อน"<br>
					2. สแกนคิวอาร์โค้ด<br>
					3. คลิกที่ "เพิ่ม"<br>
          4. หลังจากระบบตรวจสอบสถานะการชำระแล้วจะส่งรหัสไปยังแชทไลน์อัตโนมัติ</p>
              <a href="https://lin.ee/YFSP9vN"><img src="https://scdn.line-apps.com/n/line_add_friends/btn/th.png" alt="เพิ่มเพื่อน" height="36" border="0"></a>
              <p style="color:red;"> *กรุณาใช้ไลน์เดียวกับที่ลงทะเบียนในระบบเท่านั้น!! </p>
              <div class="modal-footer">
                <label>ฉันได้ทำการแอดไลน์เป็นที่เรียบร้อย</label>
                <input type="checkbox" id="myCheckbox">
                <a href="sendcode.php" id="myButton" class="btn btn-primary" style="background-color: grey;">ยืนยันการรับรหัส</a>

                <script>
                  // Get the checkbox and button elements
                  const checkbox = document.getElementById('myCheckbox');
                  const button = document.getElementById('myButton');

                  // Add event listener for the checkbox click event
                  checkbox.addEventListener('click', function() {
                    if (checkbox.checked) {
                      // Checkbox is checked, enable the button and change its color
                      button.style.backgroundColor = '';
                      button.classList.remove('disabled');
                      button.classList.add('btn-primary');
                    } else {
                      // Checkbox is unchecked, disable the button and change its color
                      button.style.backgroundColor = 'grey';
                      button.classList.remove('btn-primary');
                      button.classList.add('disabled');
                    }
                  });

                  // Check the initial state of the checkbox and update the button accordingly
                  if (checkbox.checked) {
                    button.style.backgroundColor = '';
                    button.classList.remove('disabled');
                    button.classList.add('btn-primary');
                  } else {
                    button.style.backgroundColor = 'grey';
                    button.classList.remove('btn-primary');
                    button.classList.add('disabled');
                  }
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>

</html>