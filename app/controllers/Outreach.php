<?php
  class Outreach extends Controller {
    public function __construct(){
     
    }

    public function index($facility = NULL){
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $currentUrl = $scheme . '://' . $host . $requestUri;

        $facilityValue = isset($facility) && !empty(trim($facility)) ? trim(rawurldecode($facility)) : null;

        $data = [
            'facility' => $facilityValue !== null ? htmlspecialchars($facilityValue, ENT_QUOTES, 'UTF-8') : null,
            'agent' => 'Outreach',
            'lead' => [
                'page_url_params' => $currentUrl
            ],
            'csrf_token' => csrf_token()
        ];

        // Load the outreach view
        $this->view('pages/index', $data);
    }
  }