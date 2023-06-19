<?php
session_start();
require_once("LineLogin.php");

if (!isset($_SESSION['profile'])) {
  header("location: index.php");
  exit;
}

$profile = $_SESSION['profile'];
$userId = $profile->sub;

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

<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h1>Welcome, <?php echo $profile->name; ?></h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
      <div class="card-body">
        <?php if ($isSuccess) : ?>
          <script>
            alert('Message sent successfully.');
          </script>
        <?php endif; ?>
        <p>Email: <?php echo $profile->email; ?></p>
        <p>ID: <?php echo $profile->sub; ?></p>
        <img src="<?php echo $profile->picture; ?>" alt="Profile Picture" class="img-fluid" width="15%">
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
                <img src="./image/bot_qrcode.png" class="img-fluid">
                &nbsp;<a href="" class="btn btn-success">LINE</a>
              </div>
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