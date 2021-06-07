<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Api_Shop extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_Shop');
            
        }

  

        public function GetProvince_post(){

            $data = json_decode(file_get_contents('php://input'), true);    

            if(isset($data['province'])){
                $result = $this->Model_Shop->GetAllProvince($data['province']); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }

        }


        public function GetAmphoeWithProvince_post(){

            $data = json_decode(file_get_contents('php://input'), true);    

            if(isset($data['province'])){
                if(isset($data['amphoe'])){
                    $result = $this->Model_Shop->GetAllAmphoeWithProvince($data); 
                    echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
    
            }
            
        }


        
        public function GetTambonWithAmphoe_post(){

            $data = json_decode(file_get_contents('php://input'), true);    

            if(isset($data['province'])){
                if(isset($data['amphoe'])){
                    if(isset($data['tambon'])){

                        $result = $this->Model_Shop->GetAllTambonWithAmphoe($data); 
                        echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    }
                    
                }
    
            }
            
        }


        public function GetZipCodeWithTambon_post(){

            $data = json_decode(file_get_contents('php://input'), true);    

            if(isset($data['tambon'])){

                $result = $this->Model_Shop->GetZipCodeWithTambon($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
                    
            

        }


        public function GetDetailWithZipCode_post(){
            

            $data = json_decode(file_get_contents('php://input'), true);    

            if(isset($data['zipcode'])){

                $result = $this->Model_Shop->GetDetailWithZipcode($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }


       

}