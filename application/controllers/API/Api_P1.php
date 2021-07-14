<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
require(APPPATH.'libraries/REST_Controller.php');

class Api_P1 extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_P1');
            
        }

        public function P1_ApproveAndConnectLine_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_P1->P1_ApproveAndConnectLine($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        }


        public function P1_CheckUserConnected_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_P1->P1_CheckUserConnected($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        public function GetAllP1Connect_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_P1->GetAllP1Connect($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
   

        public function GetSubShopWithP1Id_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_P1->GetSubShopWithP1Id($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
   

    


             

       

}