<?php require APPROOT . '/views/inc/header.php'; ?>
<?php 
$apply=false;
$powered = "";
require APPROOT . '/views/inc/navbar.php'; 
?>



<div class="container mt-5">
    <div class="row pt-5">
        <div class="col-md-8 text-center text-md-start mx-auto mt-5">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-5"><span class="underline">Thank You!</span>.</h1>
                <p class="fs-5 text-muted mb-5">We’ve received your application.<br />
       Our team will review your information shortly.</p>
                 <div class="mb-3"><a href="<?php echo URLROOT; ?>" class="btn btn-primary" type="submit">Back to Home </a></div>
            </div>
        </div>
    </div>
</div>

<!-- Document reminder modal -->
<div class="modal fade" id="documentReminderModal" tabindex="-1" aria-labelledby="documentReminderLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="documentReminderLabel">Missing Documents</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You may speed up your application process by submitting your Lifeline documents now!.</p>
        <!-- <p>We notice you did not submit your ID/POB documents. Please click the button below to upload documentation.</p> -->
      </div>
      <div class="modal-footer">
        <a id="uploadDocumentsBtn" href="#" class="btn btn-primary">Upload Documents</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var customerId = '<?php echo isset($data['customer_id']) ? $data['customer_id'] : ''; ?>';
    var hasIdOrPobDocument = <?php echo isset($data['hasIdOrPobDocument']) && $data['hasIdOrPobDocument'] ? 'true' : 'false'; ?>;

    if (customerId && !hasIdOrPobDocument) {
      var uploadButton = document.getElementById('uploadDocumentsBtn');
      uploadButton.href = '<?php echo URLROOT; ?>/enrolls/getdocuments/' + encodeURIComponent(customerId);

      var documentReminderModal = new bootstrap.Modal(document.getElementById('documentReminderModal'));
      documentReminderModal.show();
    }
  });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>