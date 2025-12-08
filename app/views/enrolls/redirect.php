<?php require APPROOT . '/views/inc/header.php'; ?>
<?php 
$apply=false;
require APPROOT . '/views/inc/navbar.php'; 
?>



<div class="container mt-5">
    <div class="row pt-5">
        <div class="col-md-8 text-center text-md-start mx-auto mt-5">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-5"><span class="underline">Good News!</span>.</h1>
                <p class="fs-5 text-muted mb-5">We currently do not have coverage in this area.<br />
      but you may qualify with our partner True Wireless.</p>
                 <div class="mb-3">
                    <p>Please wait to be redirected and fill the form. <span id="count">5</span> seconds...</p>
                 </div>
            </div>
        </div>
    </div>
</div>
<script>
    let seconds = 5;
    const targetUrl = "https://gotruewireless.com/Signup.php"; // 🔗 change this to your URL
    const countEl = document.getElementById("count");

    const timer = setInterval(() => {
      seconds--;
      countEl.textContent = seconds;

      if (seconds <= 0) {
        clearInterval(timer);
        window.location.href = targetUrl;
      }
    }, 1000);
  </script>
<?php require APPROOT . '/views/inc/footer.php'; ?>