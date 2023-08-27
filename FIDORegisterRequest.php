<?php

require '/xampp/htdocs/SendChallenge.php';

class Version {
    public $major = 1;
    public $minor = 1;
}

abstract class Operation {
    const Reg = 1;
    const Auth = 2;
    const Dereg = 3;
}

class OperationHeader {
    public $upv;
    public $op;
    public $appID;
    public $serverdata;
    // extension은 비움    
    
    public function __construct() {
        $this->upv = new Version();
        $this->op = Operation::Reg; // Set default value to Reg
        $this->appID = "duduhgee";
        $this->serverdata = "1440";  //session expire time
    }
}

class MatchCriteria{
    public $userVerification = "1023";
}


function only_alpha_number(String $content){
  return preg_replace('/[^a-zA-Z0-9가-힣]/u', '', $content);
}

class RegisterRequest{
    public $header;
    public $challenge;
    public $username;
    public $policy;
    
    public function __construct() {
        $this->header = new OperationHeader();
        $this->challenge =  createChallenge();// Set default value to Reg
        $this->username = isset($_POST["userID"]) ? only_alpha_number($_POST["userID"]) : "";
        $this->policy = new MatchCriteria();
    }
}

$regi = new RegisterRequest();

$response = array();

$response = array(
    'Header' => $regi->header,
    'Username' => $regi->username,
    'Challenge' => $regi->challenge,
    'Policy' => $regi->policy
);


echo json_encode($response);

?>

