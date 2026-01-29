<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$apply = false;
$powered = null;
require APPROOT . '/views/inc/navbar.php';
?>
<style>
    .preview-img {
        max-height: 150px;
        margin-top: 10px;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
    }
</style>
<?php if($data['customer_id']){ ?>
<section class="py-5 mt-5" id="thankyou" style="display: none;">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3 class="mb-3">Thank You</h3>
                <p class="text-muted">
                    Thank you! We’ve received your documents and will now continue with the enrollment process.
                </p>
            </div>
        </div>
    </div>
</section>
<section class="py-5 mt-5" id="uploadSection">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-3">Hello <?php echo $data['first_name'].' '.$data['last_name']; ?>,</h2>
                <p class="text-muted">
                    We're received your application for our Lifeline program. To proceed with your enrollment, we need to verify your eligibility by collecting some important documents.</p>

                <p class="text-muted">
                    Please upload the following documents. Make sure the images are clear and all information is visible. Accepted formats: JPG, PNG, PDF.
                </p>

                <form id="uploadForm">
                    <!-- Proof of Identity -->
                    <div class="mb-3">
                        <label for="identityProof" class="form-label">Proof of Identity</label>
                        <input class="form-control" type="file" id="identityProof" accept=".jpg,.jpeg,.png,.pdf" capture="camera" required>
                        <div class="form-text">Example: ID card, driver's license, passport.</div>
                        <div id="identityPreview" class="mt-2"></div>
                    </div>

                    <!-- Proof of Benefit -->
                    <div class="mb-3">
                        <label for="benefitProof" class="form-label">Proof of Benefit</label>
                        <input class="form-control" type="file" id="benefitProof" accept=".jpg,.jpeg,.png,.pdf"  capture="camera" required>
                        <div class="form-text">Example: eligibility letter or benefit notice.</div>
                        <div id="benefitPreview" class="mt-2"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $data['customer_id']; ?>">
                    <div id="response" class="mt-3 text-success"></div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php } else { ?>
<section class="py-5 mt-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3 class="mb-3">Error</h3>
                <p class="text-muted">
                    Invalid access.<?php echo $data['msg']; ?> Please start your enrollment process again. <a href="<?php echo URLROOT; ?>">Click here to begin.</a>
                </p>
            </div>
        </div>  
    </div>
</section>
<?php } ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
    let identityBase64 = '';
    let benefitBase64 = '';

    function previewAndConvert(inputId, previewId, setBase64Callback, clearBase64Callback) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    input.addEventListener('change', function () {
        const file = input.files[0];
        if (!file) return;

        preview.innerHTML = '';

        const ftype = file.type;
        if (ftype.startsWith('image/')) {
            const img = new Image();
            const reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
            };

            img.onload = function () {
                const canvas = document.createElement('canvas');
                const MAX_WIDTH = 800;
                const scaleSize = MAX_WIDTH / img.width;

                canvas.width = MAX_WIDTH;
                canvas.height = img.height * scaleSize;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                // Compress the image to JPEG (you can change quality here)
                const compressedBase64 = canvas.toDataURL('image/jpeg', 0.7); // 0.7 = 70% quality

                // Send compressed base64 string
                setBase64Callback(compressedBase64);

                // Preview
                const element = document.createElement('img');
                element.classList.add('preview-img');
                element.src = compressedBase64;

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.className = 'btn btn-sm btn-danger remove-btn';
                removeBtn.type = 'button';
                removeBtn.onclick = () => {
                    input.value = '';
                    preview.innerHTML = '';
                    clearBase64Callback();
                };

                preview.appendChild(element);
                preview.appendChild(removeBtn);
            };

            reader.readAsDataURL(file);
        } else if (ftype === 'application/pdf') {
            const reader = new FileReader();
            reader.onload = function (e) {
                const base64String = e.target.result;
                setBase64Callback(base64String);

                const element = document.createElement('p');
                element.textContent = `PDF selected: ${file.name}`;

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.className = 'btn btn-sm btn-danger remove-btn';
                removeBtn.type = 'button';
                removeBtn.onclick = () => {
                    input.value = '';
                    preview.innerHTML = '';
                    clearBase64Callback();
                };

                preview.appendChild(element);
                preview.appendChild(removeBtn);
            };
            reader.readAsDataURL(file);
        } else {
            const element = document.createElement('p');
            element.textContent = 'Unsupported file type.';
            preview.appendChild(element);
        }
    });
}


    // function previewAndConvert(inputId, previewId, setBase64Callback, clearBase64Callback) {
    //     const input = document.getElementById(inputId);
    //     const preview = document.getElementById(previewId);

    //     input.addEventListener('change', function() {
    //         const file = input.files[0];
    //         const ftype = input.files[0].type;
    //         if (!file) return;

    //         // Clear previous preview
    //         preview.innerHTML = '';

    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             const base64String = e.target.result;
    //             setBase64Callback(base64String);

    //             let element;
    //             if (file.type.startsWith('image/')) {
    //                 element = document.createElement('img');
    //                 element.classList.add('preview-img');
    //                 element.src = base64String;
    //             } else if (file.type === 'application/pdf') {
    //                 element = document.createElement('p');
    //                 element.textContent = `PDF selected: ${file.name}`;
    //             } else {
    //                 element = document.createElement('p');
    //                 element.textContent = 'Unsupported file type.';
    //             }

    //             const removeBtn = document.createElement('button');
    //             removeBtn.textContent = 'Remove';
    //             removeBtn.className = 'btn btn-sm btn-danger remove-btn';
    //             removeBtn.type = 'button';
    //             removeBtn.onclick = () => {
    //                 input.value = '';
    //                 preview.innerHTML = '';
    //                 clearBase64Callback();
    //             };

    //             preview.appendChild(element);
    //             preview.appendChild(removeBtn);
    //         };
            
    //                 reader.readAsDataURL(file);
            
            
    //     });
    // }

    // Setup listeners for both file inputs
    previewAndConvert(
        'identityProof',
        'identityPreview',
        b64 => identityBase64 = b64,
        () => identityBase64 = ''
    );
    previewAndConvert(
        'benefitProof',
        'benefitPreview',
        b64 => benefitBase64 = b64,
        () => benefitBase64 = ''
    );

    // Handle form submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!identityBase64 || !benefitBase64) {
            alert("Please upload both required documents.");
            return;
        }

        const data = {
            identity_proof: identityBase64,
            benefit_proof: benefitBase64,
            customer_id: $("#customer_id").val()
        };

        fetch('<?php echo URLROOT; ?>/enrolls/saveDocuments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                $("#uploadSection").hide();
                $("#thankyou").show();
                //document.getElementById('response2').textContent = response.message || 'Upload successful!';
            })
            .catch(err => {
                console.error(err);
                document.getElementById('response').textContent = 'Upload failed. Please try again.';
            });
    });
</script>

</body>

</html>