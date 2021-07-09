<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
require(APPPATH.'libraries/REST_Controller.php');

class Api_Game extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_Game');
            
        }

        public function InsertGameRegisCount_post(){
               
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->InsertGameRegisCount($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
        }

        public function CheckStatusPlayGameRegisCount_post(){

                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->CheckStatusPlayGameRegisCount($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                
        }

        public function treetest_get(){
      
                $result = $this->Model_Game->tree(); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                
        }
   

}