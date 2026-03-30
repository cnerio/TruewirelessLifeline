<?php
echo $queryString = $_SERVER['QUERY_STRING']; // e.g., "utm_source=google&utm_medium=cpc"
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$full_url = $protocol . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$full_url = "http://localhost/galaxylifeline/enrolls?utm_source=google&utm_medium=cpc";
//echo $queryString;

require APPROOT . '/views/inc/header.php'; ?>
<?php
$apply = true;
$powered = '';
require APPROOT . '/views/inc/navbar.php';
?>

<header class="pt-5 mb-5">
    <div class="container pt-4 pt-xl-5">
        <div class="row pt-5">
            <div class="col-md-6 text-center text-md-start mx-auto">
                <div class="text-center">
                    <h1 class="display-4 fw-bold">Get your <span class="underline">FREE</span> Government Wireless Service&nbsp;now!.</h1>
                    <p class="fs-5 text-muted mb-2">High-Speed Data, Unlimited Talk & Text.</p>
                    <!-- <div class="my-2"><a class="btn btn-primary fs-5 py-2 px-4" role="button" href="<?php //echo URLROOT; 
                                                                                                            ?>/enrolls?<?php //echo $queryString; 
                                                                                                                        ?>">Apply Now!</a></div> -->
                    <div class="my-2">
                        <button class="btn btn-primary fs-5 py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Apply Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <div class="text-center position-relative"><img class="img-fluid" src="<?php echo URLROOT; ?>/public/img/illustrations/meeting.svg" style="width: 800px;"></div>
            </div>
        </div>
    </div>
</header>
<section>
    <div class="container py-4 py-xl-5">
        <div class="row">
            <div class="col-md-6">
                <h3 class="display-6 fw-bold pb-md-4">How to <span class="underline">Qualify</span></h3>
                <p>You can qualify if you participate in government assistance programs such as:</p>
            </div>
            <div class="col-md-6">
                <ul>
                    <li>Supplemental Nutrition Assistance Program (Food Stamps or&nbsp;SNAP)</li>
                    <li>Medicaid</li>
                    <li>Supplemental Security Income&nbsp;(SSI)</li>
                    <li>Federal Public Housing Assistance (Section&nbsp;8)</li>
                    <li>Veterans Pension or Survivors Benefit&nbsp;Programs</li>
                    <li>Bureau of Indian Affairs General&nbsp;Assistance</li>
                    <li>Tribally-Administered Temporary Assistance for Needy Families&nbsp;(TTANF)</li>
                    <li>Food Distribution Program on Indian Reservations&nbsp;(FDPIR)</li>
                    <li>Head Start (if income eligibility criteria are&nbsp;met)</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="py-4 py-xl-5">
    <div class="container">
        <div class="text-white bg-black border rounded border-0 border-black d-flex flex-column justify-content-between flex-lg-row p-4 p-md-5">
            <div class="pb-2 pb-lg-1">
                <h2 class="fw-bold text-secondary mb-2"> Do you receive government benefits?</h2>
                <p class="mb-0">Just fill out this enrollment form.</p>
            </div>
            <!-- <div class="my-2"><a class="btn btn-light fs-5 py-2 px-4" role="button" href="<?php //echo URLROOT; 
                                                                                                ?>/enrolls?<?php //echo $queryString; 
                                                                                                            ?>">Apply Now !</a></div> -->
            <div class="my-2">
                <button class="btn btn-light fs-5 py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Apply Now</button>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Let's Check</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="checkform" action="<?php echo URLROOT; ?>/enrolls<?php //echo $queryString; ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name <span class="requiredmark">*</span></label>
                                <input type="text" id="firstname" name="firstname" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Last Name <span class="requiredmark">*</span></label>
                                <input type="text" id="lastname" name="lastname" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="requiredmark">*</span></label>
                                <input type="text" id="email" name="email" class="form-control">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="address2">Apartment or Unit Number</label>
                                <input type="text" id="address2" name="addess2" class="form-control">
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City <span class="requiredmark">*</span></label>
                                <input type="text" id="city" name="city" class="form-control">
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">State <span class="requiredmark">*</span></label>
                                <select name="state" id="state" class="form-select" onchange="stateChanged()">
                                    <option value="">Select a state</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                    <option value="DC">District of Columbia</option>

                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zipcode">Zipcode <span class="requiredmark">*</span></label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control zipcode" maxlength="5" pattern="^[0-9]{5}$" placeholder="00000">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="url" name="url" value="<?php echo $full_url;?>">
                    <input type="hidden" id="agent" name="agent" value="<?php echo $data['agent']; ?>">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button id="submitform" type="Submit" class="btn btn-primary" value="">Check</button>
                    <input type="hidden" id="powered" name="powered" value="">
                    <input type="hidden" id="enrollment_id" name="enrollment_id" value="">
                    <input type="hidden" id="customer_id" name="customer_id" value="">
                    <input type="hidden" id="is_tribal" name="is_tribal" value="">
                    <div id="response"></div>
                </div>
            </form>
        </div>
    </div>
</div>



<div id="cookie-notice" class="fixed-bottom p-4" style="display: none; z-index: 1050;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 p-3 bg-white border-top border-primary border-4">
          <div class="card-body d-md-flex align-items-center justify-content-between">
            <div class="me-md-4 mb-3 mb-md-0 text-start">
              <h5 class="fw-bold mb-1">We value your privacy</h5>
              <p class="small text-muted mb-0">
                We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.
              </p>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
              <button id="accept-cookies" class="btn btn-dark px-4 rounded-pill fw-bold btn-sm">Accept All</button>
              <!-- <a href="/cookie-policy" class="btn btn-outline-secondary px-3 rounded-pill btn-sm d-flex align-items-center">Read More</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<style>
    .error {
    color: #8a1f11;
    display: inline-block;
    /* margin-left: 1.5em; */
    font-size: 12px;
}
    </style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const cookieNotice = document.getElementById('cookie-notice');
    const acceptBtn = document.getElementById('accept-cookies');

    // 1. Check if the user has already accepted
    if (!localStorage.getItem('cookiesAccepted')) {
        // Show the banner with a slight delay for better UX
        setTimeout(() => {
            cookieNotice.style.display = 'block';
            cookieNotice.classList.add('show-banner');
        }, 1000);
    }

    // 2. Functional Button Logic
    acceptBtn.addEventListener('click', function() {
        // Save the choice in the browser's local storage
        localStorage.setItem('cookiesAccepted', 'true');

        // Smoothly hide the banner
        cookieNotice.classList.remove('show-banner');
        cookieNotice.classList.add('hide-banner');

        // Remove from DOM after animation finishes (500ms)
        setTimeout(() => {
            cookieNotice.style.display = 'none';
        }, 500);
    });
});
//    document.addEventListener("DOMContentLoaded", function() {
//     const cookieNotice = document.getElementById('cookie-notice');
//     const acceptBtn = document.getElementById('accept-cookies');

//     // 1. Check if user has already accepted cookies
//     if (!localStorage.getItem('cookiesAccepted')) {
//         // Show banner after a 1-second delay for better UX
//         setTimeout(() => {
//             cookieNotice.style.display = 'block';
//             // Optional: You can add an animation class here
//         }, 1000);
//     }

//     // 2. Handle the "Accept" click
//     acceptBtn.addEventListener('click', function() {
//         localStorage.setItem('cookiesAccepted', 'true');
//         cookieNotice.style.fadeOut(); // If using jQuery, otherwise:
//         cookieNotice.style.display = 'none';
//     });
// });


    //var form = $("#checkForm");
    $(document).ready(function() {
        $("#checkform").validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
            rules: {
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                state: {
                    required: true
                },
                zipcode: {
                    required: true,
                    zipcodeMatch: true
                }
            }
        });

        $.validator.addMethod("zipcodeMatch", function (value, element, params) {
    let zipcode = $("#zipcode").val();
    //let city = $("#city").val().toLowerCase();
    let state = $("#state").val();
    let valid = false;

    // Usamos la validación asincrónica de jQuery Validation
    let done = this.optional(element);

    $.ajax({
      url: "https://api.zippopotam.us/us/" + zipcode,
      dataType: "json",
      async: false, // Necesario para trabajar con jQuery Validate directamente
      success: function (data) {
        let place = data.places[0];
        let apiCity = place["place name"].toLowerCase();
        let apiState = place["state abbreviation"];
        //console.log(state+apiState)
        //if (city == apiCity || state == apiState) {
        if (state == apiState) {
          valid = true;
        }
      },
      error: function () {
        valid = false;
      }
    });

    return done || valid;
  }, "State does not match to your Zip Code.");
    });
$("#submitform").on("click",function(event){
        event.preventDefault();
        // Correct ID: #checkForm (with capital F)
        const form = $("#checkform");

        if (form.valid()) {
          console.log("Formulario válido ✅");
          //form.submit(); // This will trigger actual form submission
           $.ajax({
            url: "<?php echo URLROOT; ?>/enrolls/check",   // 🔗 backend script
            type: "POST",
            data: form.serialize(), // serialize form fields
            success: function(response) {
                //$("#response").html(response);
                
                resObj = JSON.parse(response);
                console.log(resObj)
                $("#powered").val(resObj.powered);
                $("#enrollment_id").val(resObj.enrollment_id);
                $("#is_tribal").val(resObj.is_tribal);
                $("#customer_id").val(resObj.customer_id);
                //console.tab("resObj:",resObj);
                //exit();
                if(resObj.status=="success"){
                    form.submit();
                }else{
                    window.location.href = "<?php echo URLROOT; ?>/enrolls/noservicearea";
                }
            },
            error: function(xhr, status, error) {
                //$("#response").html("Error: " + error);
            }
            });
        } else {
          console.log("Formulario con errores ❌");
        }

    })
    
</script>