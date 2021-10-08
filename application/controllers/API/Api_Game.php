<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
require(APPPATH.'libraries/REST_Controller.php');

class Api_Game extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_Game');
                $this->load->model('Model_Line_Sale');
            
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

        public function GetAllShopAward_post(){
                
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->GetAllShopAward($data); 

                for($index =0; $index  < sizeof($result); $index ++){
                        $result[$index]['ls_shop_detail'] = $this->Model_Line_Sale->ConvertJson_DATASTUDIO($result[$index]['ls_shop_detail']);
                }

                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        public function GetAllShopAwardGroup_post(){
                
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->GetAllShopAwardGroup($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }




        // GameChoice
        public function InsertStartGameChoice_post(){
     
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->InsertStartGameChoice($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        public function UpdatePointGameChoice_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->UpdatePointGameChoice($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);    
        }
   
        public function CheckStatusPlayGameChoice_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->CheckStatusPlayGameChoice($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);    
        }

        public function GetAllShopPlayGameChoice_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->GetAllShopPlayGameChoice($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }



        // Shop Q 27-30 /09/2021
        public function GetDateQueue_post(){
           
                $result = $this->Model_Game->GetDateQueue(); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }
        public function GetTimeQueue_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->GetTimeQueue($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }

        public function InsertShopQueue_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->InsertShopQueue($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }

        public function ShopQueueCheck_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->ShopQueueCheck($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }

        public function GetAllShopQueue_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->GetAllShopQueue($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }
        public function GetAllShopQueueEasy_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Game->GetAllShopQueueEasy($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);  
        }

  
}
