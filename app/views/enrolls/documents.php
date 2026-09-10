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
                    <div class="mb-3">
                        <label class="form-label">Proof of Benefit</label>
                        <div id="benefitDropzone" class="border border-2 border-dashed rounded p-4 text-center bg-light" style="cursor: pointer; min-height: 180px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <input type="file" id="benefitProof" accept=".jpg,.jpeg,.png,.pdf" capture="camera" multiple hidden>
                            <div class="mb-2">
                                <i class="fa fa-cloud-upload-alt fa-2x text-primary"></i>
                            </div>
                            <p class="mb-2 text-muted">Drag & drop files here or click to browse</p>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="benefitBrowseBtn">Choose files</button>
                            <div class="form-text mt-2">Example: eligibility letter or benefit notice. You can upload more than one file.</div>
                        </div>
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
    let benefitFiles = [];
    let benefitBase64Map = {};

    function fileKey(file) {
        return `${file.name}-${file.size}-${file.lastModified}`;
    }

    function convertFileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const src = e.target.result;

                if (file.type.startsWith('image/')) {
                    const img = new Image();
                    img.onload = function () {
                        const canvas = document.createElement('canvas');
                        const MAX_WIDTH = 800;
                        const scaleSize = MAX_WIDTH / img.width;

                        canvas.width = MAX_WIDTH;
                        canvas.height = img.height * scaleSize;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        resolve(canvas.toDataURL('image/jpeg', 0.7));
                    };
                    img.src = src;
                    return;
                }

                if (file.type === 'application/pdf') {
                    resolve(src);
                    return;
                }

                reject(new Error('Unsupported file type.'));
            };

            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function appendBenefitFiles(newFiles) {
        const seen = new Set(benefitFiles.map(fileKey));

        newFiles.forEach((file) => {
            const key = fileKey(file);
            if (!seen.has(key)) {
                benefitFiles.push(file);
                seen.add(key);

                convertFileToBase64(file)
                    .then((base64) => {
                        benefitBase64Map[key] = base64;
                    })
                    .catch(() => {
                        benefitBase64Map[key] = null;
                    });
            }
        });

        renderBenefitFiles();
    }

    function renderBenefitFiles() {
        const preview = document.getElementById('benefitPreview');
        preview.innerHTML = '';

        if (!benefitFiles.length) {
            return;
        }

        benefitFiles.forEach((file) => {
            const key = fileKey(file);
            const item = document.createElement('div');
            item.className = 'd-flex align-items-center justify-content-between border rounded p-2 mt-2';

            const fileLabel = document.createElement('span');
            fileLabel.textContent = file.name;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-outline-danger';
            removeBtn.textContent = 'Remove';
            removeBtn.onclick = () => {
                benefitFiles = benefitFiles.filter((f) => fileKey(f) !== key);
                delete benefitBase64Map[key];
                renderBenefitFiles();
            };

            item.appendChild(fileLabel);
            item.appendChild(removeBtn);
            preview.appendChild(item);
        });
    }

    const benefitInput = document.getElementById('benefitProof');
    const benefitDropzone = document.getElementById('benefitDropzone');
    const benefitBrowseBtn = document.getElementById('benefitBrowseBtn');

    benefitBrowseBtn.addEventListener('click', function () {
        benefitInput.click();
    });

    benefitDropzone.addEventListener('click', function (event) {
        if (event.target === benefitDropzone || event.target.closest('#benefitDropzone')) {
            benefitInput.click();
        }
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        benefitDropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            benefitDropzone.classList.add('border-primary');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        benefitDropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            benefitDropzone.classList.remove('border-primary');
        });
    });

    benefitDropzone.addEventListener('drop', function (e) {
        const files = e.dataTransfer.files;
        if (files && files.length) {
            appendBenefitFiles(Array.from(files));
        }
    });

    benefitInput.addEventListener('change', function () {
        if (this.files && this.files.length) {
            appendBenefitFiles(Array.from(this.files));
            this.value = '';
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const benefitPayload = benefitFiles
            .map(file => benefitBase64Map[fileKey(file)])
            .filter(Boolean);

        if (benefitPayload.length === 0) {
            alert("Please upload at least one benefit document.");
            return;
        }

        const data = {
            identity_proof: '',
            benefit_proof: benefitPayload,
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
            })
            .catch(err => {
                console.error(err);
                document.getElementById('response').textContent = 'Upload failed. Please try again.';
            });
    });
</script>

</body>

</html>