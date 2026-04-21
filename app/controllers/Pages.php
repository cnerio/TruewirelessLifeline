<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    
    public function index($agent=NULL){
      // if(isLoggedIn()){
      //   redirect('posts');
      // }
      $data = [
        'agent'   => strtolower(trim($agent)),
        'lead'    => null,
        'csrf_token' => csrf_token()
      ];

      if(isset($_GET['tk']) && !empty(trim($_GET['tk']))){
        $token = preg_replace('/[^a-zA-Z0-9_\-]/', '', trim($_GET['tk']));

        if(!empty($token)){
          $curl = curl_init();
          curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://check.galaxydistribution.com/api/lead/' . $token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
          ]);

          $response = curl_exec($curl);
          curl_close($curl);

          if($response){
            $leadData = json_decode($response, true);
            // Response structure: { "success": true, "data": { "email", "city", "state", "zipcode" } }
            if(!empty($leadData['success']) && isset($leadData['data']) && is_array($leadData['data'])){
              $d = $leadData['data'];
              $data['lead'] = [
                'email'   => isset($d['email'])   ? htmlspecialchars($d['email'],   ENT_QUOTES, 'UTF-8') : '',
                'zipcode' => isset($d['zipcode']) ? htmlspecialchars($d['zipcode'], ENT_QUOTES, 'UTF-8') : '',
                'city'    => isset($d['city'])    ? htmlspecialchars($d['city'],    ENT_QUOTES, 'UTF-8') : '',
                'state'   => isset($d['state'])   ? htmlspecialchars($d['state'],   ENT_QUOTES, 'UTF-8') : '',
              ];
            }
          }
        }
      }

      $this->view('pages/index', $data);
    }

    public function indexcheck(){
      
          $this->view('pages/indexcheck');
    }

    public function about(){
      $data = [
        'title' => 'About Us',
        'description' => 'App to share posts with other users'
      ];

      $this->view('pages/about', $data);
    }
    
  public function privacy()
    {
        $data = ['title' => 'Privacy Policy'];
        $this->view('pages/privacy', $data);
    }

    public function contact(){
      $data = [
          'title' => 'Contact Us',
          'description' => 'You can contact us through this medium',
          'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
          'name' => 'Omonzebaguan Emmanuel',
          'location' => 'Nigeria, Edo State',
          'contact' => '+2348147534847',
          'mail' => 'emmizy2015@gmail.com'
      ];

      $this->view('pages/contact', $data);
    }
  }