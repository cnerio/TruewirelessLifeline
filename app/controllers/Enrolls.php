<?php
class Enrolls extends Controller
{
  public $enrollModel;
  public $APIService;
  public $TG5Api;
  public function __construct()
  {
    $this->enrollModel = $this->model('Enroll');
  }

  public function index2()
  {
    echo $projectRoot = '../public/uploads/';
    //echo $uploadFolder = $projectRoot . '/public/uploads/';
    // if(isLoggedIn()){
    //   redirect('posts');
    // }
    $data = [
      'title' => 'SharePosts',
      'description' => 'Simple social network built on the Emmizy MVC framework',
      'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
      'name' => 'Omonzebaguan Emmanuel',
      'location' => 'Nigeria, Edo State',
      'contact' => '+2348147534847',
      'mail' => 'emmizy2015@gmail.com'
    ];

    $this->view('pages/index', $data);
  }

  public function index()
  {
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $full_url = $_POST['url'];
            parse_str(parse_url($full_url, PHP_URL_QUERY), $params);
            $utms = json_encode($params);
          $data = [
            "first_name" => trim(ucfirst(strtolower($_POST['firstname']))),
            "second_name" => trim(ucfirst(strtolower($_POST['lastname']))),
            // "address1" => trim($_POST['address1']),
            // "address2" => trim($_POST['addess2']),
            // "city" => trim(ucfirst(strtolower($_POST['city']))),
            "state" => strtoupper(trim($_POST['state'] ?? '')),
            "zipcode" => $_POST['zipcode'],
            "url" => $full_url,
            "utms"=>$utms
            
          ];

          $this->view('enrolls/index', $data);
        }else{
          $this->view('enrolls/index');
        }
  }

  public function redirect(){
    $this->view('enrolls/redirect');
  }

  public function ca()
  {
    $data = [
      'title' => 'Contact Us',
      'description' => 'You can contact us through this medium',
      'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
      'name' => 'Omonzebaguan Emmanuel',
      'location' => 'Nigeria, Edo State',
      'contact' => '+2348147534847',
      'mail' => 'emmizy2015@gmail.com'
    ];

    $this->view('enrolls/ca', $data);
  }

  public function genCustomerId2($data, $lastId)
  {
    $flfn = ($data['first_name']) ? strtoupper(substr($data['first_name'], 0, 1)) : "X";
    $flsn = ($data['second_name']) ? strtoupper(substr($data['second_name'], 0, 1)) : "X";
    $fdpn = ($data['zipcode']) ? substr($data['phone_number'], 0, 1) : "0";
    $flea = ($data['state']) ? strtoupper(substr($data['email'], 0, 1)) : "X";
    $num = str_pad($lastId, 4, '0', STR_PAD_LEFT);

    $customerId = "G-" . $flfn . $flsn . $fdpn . $flea . $num;

    return $customerId;
  }

  public function genCustomerId($data, $lastId)
  {
    $flfn = ($data['first_name']) ? strtoupper(substr($data['first_name'], 0, 1)) : "X";
    $flsn = ($data['second_name']) ? strtoupper(substr($data['second_name'], 0, 1)) : "X";
    $fdpn = ($data['phone_number']) ? substr($data['phone_number'], 0, 1) : "0";
    $flea = ($data['email']) ? strtoupper(substr($data['email'], 0, 1)) : "X";
    $num = str_pad($lastId, 4, '0', STR_PAD_LEFT);

    $customerId = "G-" . $flfn . $flsn . $fdpn . $flea . $num;

    return $customerId;
  }

  public function check()
  {
    //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $full_url = $_POST['url'];
        parse_str(parse_url($full_url, PHP_URL_QUERY), $params);
        $utms = json_encode($params);
      $data = [
        "first_name" => trim(ucfirst(strtolower($_POST['firstname']))),
        "second_name" => trim(ucfirst(strtolower($_POST['lastname']))),
        // "address1" => trim($_POST['address1']),
        // "address2" => trim($_POST['addess2']),
        // "city" => trim(ucfirst(strtolower($_POST['city']))),
        "state" => strtoupper(trim($_POST['state'] ?? '')),
        "zipcode" => $_POST['zipcode'],
        "URL" => $full_url,
        "utms"=>$utms
        
      ];
      $AMBTstates = $this->enrollModel->getStates('AMBT');
      //$data['ambtstates']=$AMBTstates;
      
      $TWStates = $this->enrollModel->getStates('GTW');
      //print_r($states);
      //$data['twstates']=$TWStates;
      //exit();
      if (in_array($data['state'], $TWStates)) {
        $data['message']="redirect";
      } else if (in_array($data['state'], $AMBTstates)) {
        //$this->view('enrolls/index',$data);
        $data['message']="success";
      }
      
      if($data['state']=="TX"){
          $twzipcodes = $this->enrollModel->getZipcodes('GTW');
          if(in_array($data['zipcode'],$twzipcodes)){
            //redirect('enrolls/redirect');
            $data['message']="redirect";
          }else{
            $data['message']="success";
          }
        }
      echo json_encode($data);
    }
  }

  public function savestep1()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secret = "6LeNtMcrAAAAAE6ODEJB6dVsGrqLLdvw5LxG8o8Q";
    $responseKey = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
      
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $secret,
            'response' => $responseKey,
            'remoteip' => $remoteip
        ]));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);


      // $context  = stream_context_create($opts);
      // $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
      // $result = json_decode($response);
      //print_r($result);
      if (!$result['success']) {
        $data['status'] = "fail";
        $data['msg']= 'CAPTCHA verification failed';
      }else{
        $phonenumber = preg_replace('/[^0-9]/', '', $_POST['phone']);
        $dob = date("m/d/Y", strtotime($_POST['dobM'] . "/" . $_POST['dobD'] . "/" . $_POST['dobY']));
        if(isset($_POST['customer_id'])){
          $customer_id = $_POST['customer_id'];
        }else{
          $customer_id =null;
        };
        $full_url = $_POST['url'];
        parse_str(parse_url($full_url, PHP_URL_QUERY), $params);
        $utms = json_encode($params);
        $data = [
          "first_name" => trim(ucfirst(strtolower($_POST['firstname']))),
          "second_name" => trim(ucfirst(strtolower($_POST['lastname']))),
          "ssn" => trim($_POST['ssn']),
          "dob" => $dob,
          "email" => trim(strtolower($_POST['email'])),
          "phone_number" => $phonenumber,
          "address1" => trim($_POST['address1']),
          "address2" => trim($_POST['addess2']),
          "city" => trim(ucfirst(strtolower($_POST['city']))),
          "state" => $_POST['state'],
          "zipcode" => $_POST['zipcode'],
          "typeAddress" => $_POST['typeAddress'],
          "shipping_address1" => (isset($_POST['shipaddress1']) ? $_POST['shipaddress1'] : null),
          "shipping_address2" => (isset($_POST['shipaddess2'])) ? $_POST['shipaddess2'] : null,
          "shipping_city" => (isset($_POST['shipcity'])) ? $_POST['shipcity'] : null,
          "shipping_state" => (isset($_POST['shipstate'])) ? $_POST['shipstate'] : null,
          "shipping_zipcode" => (isset($_POST['shipzipcode'])) ? $_POST['shipzipcode'] : null,
          "order_step" => "Step 1",
          "URL" => $full_url,
          "company" => $_POST['company'],
          "utms"=>$utms,
          "utm_source" => (isset($_POST['utm_source'])) ? $_POST['utm_source'] : null,
          "utm_medium" => (isset($_POST['utm_medium'])) ? $_POST['utm_medium'] : null,
          "utm_campaign" => (isset($_POST['utm_campaign'])) ? $_POST['utm_campaign'] : null,
          "utm_content" => (isset($_POST['utm_content'])) ? $_POST['utm_content'] : null,
          "match_type" => (isset($_POST['match_type'])) ? $_POST['match_type'] : null,
          "utm_adgroup" => (isset($_POST['utm_adgroup'])) ? $_POST['utm_adgroup'] : null,
          "gclid" => (isset($_POST['gclid'])) ? $_POST['gclid'] : null,
          "fbclid" => (isset($_POST['fbclid'])) ? $_POST['fbclid'] : null
        ];
        if($customer_id){
          $data['customer_id']=$customer_id;
          
          $this->enrollModel->updateData($data, 'lifeline_records');
            //$data['customer_id'] = $customerId;
            $data['status'] = "success";
            $data['action']="update";
        }else{
          $lastId = $this->enrollModel->saveData($data, 'lifeline_records');
          
          if ($lastId > 0) {
            //$data['lastId']=$lastId;
            $customerId = $this->genCustomerId($data, $lastId);
            $this->enrollModel->updateCusId($lastId, $customerId, 'lifeline_records');
            $data['customer_id'] = $customerId;
            $data['action']="insert";
            $data['status'] = "success";
          } else {
            $data['status'] = "fail";
          }
        }
        
      }
      //print_r($data);
      echo json_encode($data);
    }
  }

  public function savestep2()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      //print_r($_POST);
      $data = [
        "program_benefit" => $_POST['eligibility_program'],
        "nverification_number" => trim($_POST['nv_application_id']),
        "customer_id" => $_POST['customer_id'],
        "current_benefits" => $_POST['current_benefits'],
        "phone_type" => $_POST['type_phone'],
        "order_step" => "Step 2"

      ];

      $this->enrollModel->updateData($data, 'lifeline_records');
      if (!empty($_POST['govId'])) {
        $base64_string = $_POST['govId'];
        $customer_id = $data['customer_id'];
        $filepath = saveBase64File($base64_string, $customer_id, "ID");
        $fileData = [
          "customer_id" => $customer_id,
          "filepath" => $filepath,
          "type_doc" => "ID"
        ];
        $fileData['statusFile'] = ($this->enrollModel->saveData($fileData, 'lifeline_documents')) ? true : false;
      } else {
        $fileData['statusFile'] = true;
      }

      if (!empty($_POST['pob'])) {
        $base64_string_pob= $_POST['pob'];
        $customer_id = $data['customer_id'];
        $filepath2 = saveBase64File($base64_string_pob, $customer_id, "POB");
        $pobData = [
          "customer_id" => $customer_id,
          "filepath" => $filepath2,
          "type_doc" => "POB"
        ];
        $fileData['statusFile'] = ($this->enrollModel->saveData($pobData, 'lifeline_documents')) ? true : false;
      } else {
        $fileData['statusFile'] = true;
      }


      echo json_encode($fileData);
    }
  }

  public function savestep3()
  {
      // Inicia sesi贸n solo si no ha sido iniciada a煤n
  if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }

    // Prevent multiple submissions within a short time
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
        echo json_encode(['error' => 'Form already submitted.']);
        exit;
    }

    // Mark the form as submitted
    $_SESSION['form_submitted'] = true;

    try {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //print_r($_POST);
        $data = [
          "signature_text" => trim($_POST['signaturename']),
          "datetimeConsent" => $_POST['datetimeconsent'],
          "agree_terms" => $_POST['terms'],
          "agree_sms" => $_POST['sms'],
          "agree_pii" => $_POST['know'],
          "customer_id" => $_POST['customer_id'],
          "order_step" => "Step 3"
        ];

        $this->enrollModel->updateData($data, 'lifeline_records');
        $initialData = [
          "initials1" => trim(strtoupper($_POST['initials_1'])),
          "initials2" => trim(strtoupper($_POST['initials_2'])),
          "initials3" => trim(strtoupper($_POST['initials_3'])),
          "initials4" => trim(strtoupper($_POST['initials_4'])),
          "initials5" => trim(strtoupper($_POST['initials_5'])),
          "initials6" => trim(strtoupper($_POST['initials_6'])),
          "initials7" => trim(strtoupper($_POST['initials_7'])),
          "initials8" => trim(strtoupper($_POST['initials_8'])),
          "initials9" => trim(strtoupper($_POST['initials_9'])),
          "customer_id" => $data['customer_id']
        ];

        $initialData['statusfinale'] = ($this->enrollModel->saveData($initialData, 'lifeline_agreement')) ? true : false;
        //echo json_encode($initialData);

        // $customerData = $this->enrollModel->getCustomerData($data['customer_id']);
        $this->APIService = new APIprocess();
        $result = $this->APIService->shockwaveProcess($data['customer_id'], $this->enrollModel);

        $row2 = $this->enrollModel->getCustomerData($data['customer_id']);
        $this->sendNotification($row2[0]);

        echo json_encode($result);
      }
    } catch (Exception $e) {
    echo json_encode(['status' => 'error','msg' => 'An error occurred: ' . $e->getMessage()]);
    } finally {
        // Reset the form submitted flag after a short period or once the request is done
        $_SESSION['form_submitted'] = false;
    }
  }

  public function tryagain($customer_id){
    $this->APIService = new APIprocess();
        $result = $this->APIService->shockwaveProcess($customer_id, $this->enrollModel);

        //$row2 = $this->enrollModel->getCustomerData($customer_id);
        //$this->sendNotification($row2[0]);

        echo json_encode($result);
  }

  public function getdocuments($orderId64=null){

    $data = [
      "orderId"=>$orderId64
    ];
    
    $this->view('enrolls/documents',$data);
  }

  public function saveFiles($base64_string,$customer_id,$fileType){
        $filepath = saveBase64File($base64_string, $customer_id,$fileType);
        $fileData = [
          "customer_id" => $customer_id,
          "filepath" => $filepath,
          "type_doc" => $fileType
        ];
        $fileData['status'] = ($this->enrollModel->saveData($fileData, 'lifeline_documents')) ? true : false;
        return $fileData;
  }

  public function saveStoredDoc(){
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $data = json_decode(file_get_contents('php://input'), true);

      
      if (!isset($data['base64data']) || !isset($data['filename'])) {
          echo json_encode(['success' => false, 'message' => 'Missing data']);
          exit;
      }

      // Remove the base64 header part
      $base64 = $data['base64data'];
      $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
      $base64 = str_replace(' ', '+', $base64);
      $customer_id=$data['customer_id'];
      $imageData = base64_decode($base64);

      $savePath = '../public/uploads/'.$customer_id.'/' . basename($data['filename']);
      file_put_contents($savePath, $imageData);

      echo json_encode(['success' => true, 'message' => 'Image saved', 'path' => $savePath]);
    }
  }

  public function saveDocuments(){
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $data = json_decode(file_get_contents('php://input'), true);
      //echo $data['order_id'];
      
      $customerData = $this->enrollModel->getCustomerbyOrderId(trim($data['order_id']));
      //print_r($customerData);
      $customerId=$customerData[0]['customer_id'];
      
      if($customerData){
        $idFile=$this->saveFiles($data['identity_proof'],$customerId,"ID");
        if($idFile['status']){
          $data['idStatusApi']=$this->sendDocuments($customerId,$data['order_id'],"ID");
        }
        $pobFile=$this->saveFiles($data['benefit_proof'],$customerId,"POB");
        if($pobFile['status']){
          $data['pobStatusApi']=$this->sendDocuments($customerId,$data['order_id'],"POB");
        }
      }else{
        $data['idFileStatus']=$this->saveFiles($data['identity_proof'],$data['order_id'],"ID");
        $data['pobFileStatus']=$this->saveFiles($data['benefit_proof'],$data['order_id'],"POB");
      }
      $data["message"]="Files Upload Susccesfully";
      echo json_encode($data);
    }
  }

  public function sendDocuments($customerId,$orderId,$fileType){
    $this->APIService = new APIprocess();
    //$row = $this->enrollModel->getCustomerData($customerId);
    switch($fileType){
      case "ID":
        $fileID="100001";
        break;
      case "POB":
        $fileID="100000";
        break;
      case "Consent":
        $fileID="100025";
        break;
    }
    //print_r($row);
    $fileData = $this->APIService->getSavedfiles($customerId,$this->enrollModel,$fileType);
    $credentials=$this->enrollModel->getCredentials();
    if($orderId>0){
      if($fileData){
                // Read the image file into a binary string 
                $imageData = file_get_contents($fileData['filepath']);
                $filename = basename($fileData['filepath']);
                // Encode the binary data to base64
                $base64 = base64_encode($imageData);
                $upload=UploadDocument($credentials[0], $orderId, $filename, $base64, $fileID);
                if($upload['status']=="success"){
                  $saveCreateIDLog=[
                    "customer_id"=>$customerId,
                    "url"=>$upload['url'],
                    "request"=>$upload['request'],
                    "response"=>json_encode($upload['response']),
                    "title"=>$upload['title']
                  ];
                  $this->enrollModel->saveData($saveCreateIDLog,'lifeline_apis_log');
                  $fileupdate = ["id_lifeline_doc"=>$fileData['id_lifeline_doc'],"to_unavo"=>1];
                 // $enrollModel->saveData($fileId,'lifeline_documents');
                 $this->enrollModel->updateDocStatus($fileupdate ,'lifeline_documents');
                 //echo "ID FILE UPLOADED";
                 $result=["status"=>"success","msg"=>$fileType." FILE  UPLOADED"];
                }else{
                  $saveCreateIDLog=[
                    "customer_id"=>$customerId,
                    "url"=>$upload['url'],
                    "request"=>$upload['request'],
                    "response"=>json_encode($upload['response']),
                    "title"=>$upload['title']
                  ];
                  $this->enrollModel->saveData($saveCreateIDLog,'lifeline_apis_log');
                //echo "ID FILE COULDN'T BE UPLOAD";
                $result=["status"=>"fail","msg"=>$fileType." FILE COULDN'T BE UPLOAD"];
              }
              }else{
                 $result=["status"=>"fail","msg"=>$fileType." Couldn't be uploaded. File Data not Found"];
              }
    }else{
      $result=["status"=>"fail","msg"=>$fileType." Couldn't be uploaded.Order ID not Found"];
    }

    return $result;
  }

  public function compress($customer_id,$typeFile){
    $this->APIService = new APIprocess();
  $fileData = $this->APIService->getSavedfiles($customer_id,$this->enrollModel,$typeFile);
  //$imageData = file_get_contents($fileData['filepath']);
  $filename = basename($fileData['filepath']);
    $data=[
      "imageFile"=>$fileData['filepath'],
      "filename"=>$filename,
      "customer_id"=>$customer_id
    ];
    //print_r($data);

    $this->view("enrolls/compress",$data);
  }

  public function test($zipcode){
    try {
    $this->TG5Api = new LifelineApiHandler(
        "https://www.vcareapi.com:8080",
        "Demo-GoTrueWirelessNRT",
        "Demo-GoTrueWirelessNRTUser",
        "Demo-GoTrueWi674f2b9w87dg",
        "Demo-933516178627"
    );

    $this->TG5Api->authenticate(); // get token first

    $availability = $this->TG5Api->checkServiceAvailability([
            "action"=> "check_service_availability",
            "zip_code"=> $zipcode,
            "enrollment_type"=> "LIFELINE",
            "is_enrollment"=> "Y",
            "agent_id"=> "ewebsiteapi",
            "external_transaction_id"=> "",
            "source"=> "WEBSITE"
    ]);
    if($availability['msg']=="Success"){
      echo "Zipcode for Telgoo 5";
      $enrollmentId = $availability['data']['enrollment_id'];
      $this->TG5Api->authenticate(); 
      $addressValidation = $this->TG5Api->addressValidation([
        "enrollment_id"=> $enrollmentId,
        "first_name"=> "JOHN",
        "middle_name"=> "",
        "last_name"=> "DOE",
        "address_one"=> "test Street",
        "address_two"=> "",
        "city"=> "Tulsa",
        "state"=> "PR",
        "zip_code"=> $zipcode,
        "is_temp"=> "N",
        "ssn"=> "1234",
        "dob"=> "2004-08-02",
        "mailing_address_one"=> "",
        "mailing_address_two"=> "",
        "mailing_city"=> "",
        "mailing_state"=> "",
        "mailing_zip"=> "",
        "beneficiary_suffix"=> "",
        "beneficiary_first_name"=> "",
        "beneficiary_middle_name"=> "",
        "beneficiary_last_name"=> " ",
        "beneficiary_dob"=> "",
        "beneficiary_ssn"=> "",
        "action"=> "address_validation",
        "external_transaction_id"=> "",
        "agent_id"=> "ewebsiteapi",
        "source"=> "WEBSITE",
        "lifeline_enrollment_type"=> "LIFELINE",
        "address_validation"=>"Y",
        "initial_choosen_enrollment_type"=> "LIFELINE"

    ]);
    echo "<pre>";
    print_r($addressValidation);

    }else{
      echo "Zipcode to Shockwave";
    }
    // $json = json_encode($movie, JSON_PRETTY_PRINT);
    // echo $json;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

  }

  public function sendDocumentsAPI($orderId,$typeDoc)
  {
    //echo $orderId;
    //echo "<br>";
    $customerData = $this->enrollModel->getCustomerbyOrderId($orderId);
    //print_r($customerData);
    $this->APIService = new APIprocess();
    $response=$this->APIService->sendDocuments($customerData[0]['customer_id'],$customerData[0]['order_id'],$typeDoc,$this->enrollModel);

    //print_r($response);
    echo json_encode($response);
  }

 public function getallfilessaved($customerId){
  $getFiles = $this->enrollModel->getAllFiles($customerId);
  return $getFiles;
 }

  public function savescreen()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $base64_string = $_POST['base64screen'];
      $customer_id = $_POST['customer_id'];
      $filepath = saveBase64File($base64_string, $customer_id, "Screenshot");
      $fileData = [
        "customer_id" => $customer_id,
        "filepath" => $filepath,
        "type_doc" => "Screenshot"
      ];
      $fileData['statusScreen'] = ($this->enrollModel->saveData($fileData, 'lifeline_documents')) ? true : false;
      echo json_encode($fileData);
    }
  }

  public function checkZipcode($zipcode, $state, $city)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://api.zippopotam.us/us/' . trim($zipcode),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);


    $curl_error = curl_error($curl);
    $curl_errno = curl_errno($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    // Step 1: Check if cURL itself failed (connection problems, timeouts, DNS, etc.)
    if ($curl_errno) {
      //echo "cURL error: $curl_error"; // This includes many kinds of outages
      $row = [
        "status" => "error",
        "msg" => $curl_error
      ];
      // Optionally log or retry here
    }
    // Step 2: Check if API returned an HTTP error
    elseif ($http_code >= 400) {
      //echo "API HTTP error: $http_code";
      $row = [
        "status" => "error",
        "msg" => "HTTP ERROR CODE: " . $http_code
      ];
      // Optional: you might want to parse $response for error details
    }
    // Step 3: All good
    else {
      $result = json_decode($response, true);
      print_r($result);
      echo $state;
      if ($result['places']) {
        if (strtoupper($state) == $result['places'][0]['state abbreviation'] && trim(ucfirst(strtolower($city))) == $result['places'][0]['place name']) {
          $row = [
            "status" => "success",
            "msg" => "state and city match"
          ];
        } else {
          $row = [
            "status" => "error",
            "msg" => "state and city does not match"
          ];
        }
      } else {
        $row = [
          "status" => "error",
          "msg" => "city and state couldn't be validated "
        ];
      }
    }

    print_r($row);
  }

  public function consentProcess($orderId,$customerId){
    $this->APIService = new APIprocess();
    $consentFile64=$this->APIService->getConsentFile($orderId);
            //$consentFile64 = getConsent64($row[0]);
            //print_r($consentFile64);
             $processData['customer_id']=$customerId;
              $processData['process_status']="generating consent File";
              $this->enrollModel->updateData($processData,'lifeline_records');
            // exit();
            if($consentFile64['status']=="success"){
              $fileData = [
                 "customer_id"=>$customerId,
                 "filepath"=>$consentFile64['URL'],
                 "type_doc"=>"Consent"
               ];
               $this->enrollModel->saveData($fileData,'lifeline_documents');
              $ConsentFileResult = $this->APIService->sendDocuments($customerId,$orderId,"Consent",$this->enrollModel);
              $processData['process_status']=$ConsentFileResult['msg'];
              $this->enrollModel->updateData($processData,'lifeline_records');
                $result=[
                  "status"=>"success",
                  "msg"=>"Order Submitted and Consent file submitted"
                ];
              
            }else{
              //echo "base64 error";
              $result=[
                "status"=>"success",
                "msg"=>"We couldn't create a consent file"
              ];
               $processData['process_status']="Couldn't create a consent file";
              $this->enrollModel->updateData($processData,'lifeline_records');
            }

            echo json_encode($result);
  }

  public function getConsentFile($orderId)
  {

    //echo URLROOT.'/public/files/consentPDF/';
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => URLROOT . '/public/files/consentPDF/',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
            "orderId":' . $orderId . '
        }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    $curl_error = curl_error($curl);
    $curl_errno = curl_errno($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Step 1: Check if cURL itself failed (connection problems, timeouts, DNS, etc.)
    if ($curl_errno) {
      //echo "cURL error: $curl_error"; // This includes many kinds of outages
      $result = [
        "status" => "error",
        "msg" => $curl_error
      ];
      // Optionally log or retry here
    }
    // Step 2: Check if API returned an HTTP error
    elseif ($http_code >= 400) {
      //echo "API HTTP error: $http_code";
      $result = [
        "status" => "error",
        "msg" => "HTTP ERROR CODE: " . $http_code
      ];
      // Optional: you might want to parse $response for error details
    }
    // Step 3: All good
    else {
      $result = json_decode($response, true);
    }
    return $result;
  }

  public function thankyou()
  {
    $this->view('enrolls/thankyou');
  }

  

  public function getprograms()
  {
    $row = $this->enrollModel->getLifelinePrograms();
    //print_r($row);
    echo json_encode($row);
  }

  public function getagreementitems($states)
  {
    $row = $this->enrollModel->getAgreementsItems($states);
    //print_r($row);
    echo json_encode($row);
  }

  public function sendNotification($custmerData)
  {

    //$fullname = ucfirst(strtolower($data['firstname']))." ".ucfirst(strtolower($data['lastname']));
    $message = '<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
  <!-- START MAIN CONTENT AREA -->
  <tr>
    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"><table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
        <tr>
          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top"><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hello!</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">New Lifeline Order has been submitted </p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>First Name: </strong>' . $custmerData['first_name'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Last Name: </strong>' . $custmerData['second_name'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Email: </strong>' . $custmerData['email'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>City: </strong>' . $custmerData['city'] . '</p>
			<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>State: </strong>' . $custmerData['state'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Order ID: </strong>' . $custmerData['order_id'] . '</p>
			
			<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Shockwave API Response: </strong>' . $custmerData['acp_status'] . '</p>
			</td>
        </tr>
      </table>
      </td>
  </tr>
  <!-- END MAIN CONTENT AREA -->
</table>';
    //$message = preg_replace($subtr,$sust,$template );

    $mailer = new PHPMailer_Lib();
    $mail = $mailer->load();
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp-mail.outlook.com';            // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'lifeline@galaxydistribution.com';                     // SMTP username
    $mail->Password   = 'Life@2025$$Galaxy';                               // SMTP password
    $mail->SMTPSecure = 'TLS/StartTLS';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                 // TCP port to connect to
    //Recipients
    $mail->setFrom('lifeline@galaxydistribution.com', 'Galaxy Lileline Orders');
    $mail->addAddress('orders@galaxylifeline.com');
    //$mail->addAddress('lifeline@goknows.com');
    //$mail->addCC('jparker@galaxydistribution.com'); 
    //$mail->addCC('currutia44@gmail.com');      // Add a recipient
    //$mail->addBCC('fhans87@aol.com');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'A new Galaxy lifeline order has been submitted';
    $mail->Body    = $message;
    $mail->CharSet = 'UTF-8';
    $mail->send();
  }
}
