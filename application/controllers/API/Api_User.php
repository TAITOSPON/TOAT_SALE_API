<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Api_User extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_P1');
                $this->load->model('Model_Line_Sale');
                
        }

  

        public function CheckUserType_post(){


            $data = json_decode(file_get_contents('php://input'), true);  
         
            $result_p1 = $this->P1_CheckUser($data);
        
            if($result_p1['status'] == "true"){

                $result = $result_p1;
     
            }else{

                $result_shop = $this->Shop_CheckUser($data);
                if($result_shop['status'] == "true"){
              
                    $result = $result_shop;

                }else{
                    $result = array("status" => "false" , "result" => array("type" => "None" ));
                }
               
            }

      
            echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


            
        }

        public function Shop_CheckUser($data){


            $user_line_uid = $data['user_line_uid'];
            $result = $this->Model_Line_Sale->GetAllShopRegister($data);
            $result_shop = $this->Model_Line_Sale->ConvertJson_DATASTUDIO($result);
            
            $status_check = "false";
            $result_check = array();

            for($index =0; $index  < sizeof($result_shop); $index ++){
                
                if($user_line_uid == $result_shop[$index]['ls_shop_line_regis_user_line_uid']){

                    array_push($result_check,$result_shop[$index]);
                    $status_check = "true";

                }

            }
            return array("status" => $status_check , "result" => array("type" => "Shop" , "result" => $result_check));


        }

        public function P1_CheckUser($data){

            $user_line_uid = $data['user_line_uid']; 
           

            $result_p1 = $this->Model_P1->P1_GetUserAll($data);
            
            $status_check = "false";
            $result_check = array();

            for($index =0; $index  < sizeof($result_p1); $index ++){
                
                if($user_line_uid == $result_p1[$index]['ls_shop_p1_line_uid']){

                    array_push($result_check,$result_p1[$index]);
                    $status_check = "true";

                }

            }
            return array("status" => $status_check , "result" => array("type" => "P1" , "result" => $result_check));


        }


       

}