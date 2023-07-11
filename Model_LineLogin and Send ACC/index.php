<?php
session_start();
require_once("./LineLogin.php");

if (isset($_GET['orderID'])) {
  $orderID = $_GET['orderID'];
  $_SESSION['orderID'] = $orderID;
} else {

}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.72.0">
  <title>ttomoru </title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://ttomoru.com/Line_Login/CSS/style.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>
    .mySlides {
        display: block;
        margin-left: auto;
        margin-right: auto;
        transition: transform 0.3s ease;
    }
    
    .mySlides:hover {
        transform: scale(1.1);
    }

    .logout-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: red;
        transition: opacity 0.3s ease;
    }
    
    .logout-btn:hover {
        opacity: 0.7;
    }
      /* Add styles for video containers */
    .video-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }
    
    .video-container video {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    
    .video-layer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    .video-layer video {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    .carousel-text {
  display: none;
}

.carousel-text.active {
  display: block;
  
}

.carousel-content {
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  color: #FD0032 ;
  font-size: 24px;
  text-align: center;
  font-size: 36px; /* Increase the font size */
  font-family: 'Arial', sans-serif; /* Change the font to Arial or any desired font */
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add text shadow */
  font-weight: bold;
}


</style>

<body>
  <!-- Add the video container and video element -->
  <div class="video-container">
    <video src="https://ttomoru.com/Line_Login/vdo/movie.mp4" autoplay loop muted></video>
  </div>
  <div class="carousel-text active">
  <span class="carousel-content slide-left-animation">TTOMORU WELCOME</span>
</div>
<div class="carousel-text">
  <span class="carousel-content slide-left-animation">If you're ready, go get the code</span>
</div>
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
      <!-- Icon -->
      <div class="fadeIn first icon">
        
      </div>
      <!-- Login Form -->
      <form>
      <div class="w3-content w3-section " style="max-width:500px">
        <img class="mySlides w3-animate-zoom" src="https://cdn-icons-png.flaticon.com/512/5977/5977590.png" style="width:30%">
        <img class="mySlides w3-animate-zoom" src="https://storage.googleapis.com/techsauce-prod/uploads/2019/03/WeTV_Logo.jpg" style="width:50%">
        <img class="mySlides w3-animate-zoom" src="https://www.citypng.com/public/uploads/preview/-1159629574507zqo9azzc.png?v=2023061001" style="width:30%">
        <img class="mySlides w3-animate-zoom" src="https://cpc.ais.co.th/CPC-FE-WEB/api/contents/upload//d/i/s/n/e/disney%20logo.png?rand=0.4769652299799142" style="width:50%">
      </div style="margin-top:10%;">
      <?php 
        if(!isset($_SESSION['profile'])) {
            $line = new LineLogin();
            $link = $line->getLink();
        }
    ?>
        <a href="<?php echo $link; ?>" class="btn btn-success" style="width:60%"><img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/LINE_New_App_Icon_%282020-12%29.png" style="width:15%;"> Line Login</a>
        <br><br><p>เข้าสู่ระบบด้วยไลน์เพื่อรับรหัส</p>
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        
        <a href="logout.php?orderID= <?php $orderID ?>" class="logout-btn">
        <i class="fas fa-undo-alt"></i>RESET
        </a> 
        *หากเกิดปัญหาการเข้าสู่ระบบ 
        <h4>ttomoru.com</h4>
      </div>
    </div>
  </div>
  </div>
  <script>
     var myIndex = 0;
    carousel();

    function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      myIndex++;
      if (myIndex > x.length) {
        myIndex = 1
      }
      x[myIndex - 1].style.display = "block";
      setTimeout(carousel, 2500);
    }
  </script>
<script>
  // Store the titles in an array
  var titles = ["ttomoru welcome", "ถ้าคุณพร้อมแล้วไปรับรหัสกันได้เลย"];

  // Function to change the page title
  function changeTitle() {
    var currentTitle = document.title;
    var currentIndex = titles.indexOf(currentTitle);
    var newIndex = (currentIndex + 1) % titles.length;
    document.title = titles[newIndex];
  }

  // Example usage: switch title every 3 seconds
  setInterval(changeTitle, 3000);
</script>
  <script>
    // ... your existing code ...

var textElements = document.getElementsByClassName("carousel-text");
var textIndex = 0;

function switchText() {
  for (var i = 0; i < textElements.length; i++) {
    textElements[i].classList.remove("active");
  }
  textIndex++;
  if (textIndex >= textElements.length) {
    textIndex = 0;
  }
  textElements[textIndex].classList.add("active");
}

setInterval(switchText, 5000);

  </script>


</body>

</html>