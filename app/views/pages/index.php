<?php
echo $queryString = $_SERVER['QUERY_STRING']; // e.g., "utm_source=google&utm_medium=cpc"
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$full_url = $protocol . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$full_url = "http://localhost/galaxylifeline/enrolls?utm_source=google&utm_medium=cpc";
//echo $queryString;

require APPROOT . '/views/inc/header.php'; ?>
<?php
$apply = true;
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
        <div class="text-white bg-primary border rounded border-0 border-primary d-flex flex-column justify-content-between flex-lg-row p-4 p-md-5">
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
                    <!-- <div class="row pt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address1">Street Address <span class="requiredmark">*</span></label>
                                <input type="text" id="address1" name="address1" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address2">Apartment or Unit Number</label>
                                <input type="text" id="address2" name="addess2" class="form-control">
                            </div>
                        </div>
                    </div> -->
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
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button id="submitform" type="Submit" class="btn btn-primary" value="">Check</button>
                    <div id="response"></div>
                </div>
            </form>
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
                address1: {
                    required: true
                },
                city: {
                    required: true

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
                //console.log(resObj)
                if(resObj.message=="success"){
                    form.submit();
                }else if(resObj.message=="redirect"){
                    window.location.href ="<?php echo URLROOT;?>/enrolls/redirect";
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