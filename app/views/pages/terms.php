<?php
require APPROOT . '/views/inc/header.php'; 
$apply=true;
require APPROOT . '/views/inc/navbar.php'; 
$pdfFile = URLROOT. '/public/terms_and_conditions.pdf';
?>

<body>
<section>
    <div class="container py-4 py-xl-5">
        <div class="row">
        <div class="col">
            <embed src="<?php echo $pdfFile; ?>" width="100%" height="600px" type="application/pdf">
        </div>
</div>
    </div>
</section>
<?php require APPROOT . '/views/inc/footer.php'; ?>
</body>