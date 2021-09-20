<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
require(APPPATH.'libraries/REST_Controller.php');

class Api_line_sale extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_Line_Sale');
                $this->load->model('Model_Game');
        }

        public function InsertShop_post(){
               
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->InsertShop($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
        }


        public function GetAllShop_post(){
              
                $data = json_decode(file_get_contents('php://input'), true);
                if(isset($data['data_type'])){

                        if($data['data_type'] == "data_studio"){

                                $data = json_decode(file_get_contents('php://input'), true);  
                                $result = $this->Model_Line_Sale->GetAllShopRegister($data); 
                                $result = $this->Model_Line_Sale->ConvertJson_DATASTUDIO($result); 
                                $result = $this->CheckStatusShopPlayGameCount($result,"DATASTUDIO");
                                echo json_encode( $result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ; 
                        }

                }else{
                        $data = json_decode(file_get_contents('php://input'), true);  
                        $result = $this->Model_Line_Sale->GetAllShopRegister($data); 
                        $result = $this->CheckStatusShopPlayGameCount($result,"");
                        echo json_encode( $result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

                }
          
             
        }

        
        public function CheckStatusShopPlayGameCount($result,$type){
                if($type == "DATASTUDIO"){

                        for($index =0; $index  < sizeof($result); $index ++){

                                $result_status = $this->Model_Game->CheckStatusPlayGameRegisCount(
                                       
                                        array(
                                                "ls_shop_id" => $result[$index]['ls_shop_id'],
                                                "user_line_uid" => $result[$index]['ls_shop_line_regis_user_line_uid'],
        
                                        )
                                );
        
                                $result[$index]["ls_shop_sale_status_play_game_count_regis"] = $result_status;
                        }
        
                    
                }else{
                        for($index =0; $index  < sizeof($result); $index ++){

                                $result_convert = $this->Model_Line_Sale->ConvertJson_DATASTUDIO(array($result[$index])); 
        
                          
                                $result_status = $this->Model_Game->CheckStatusPlayGameRegisCount(
                                       
                                        array(
                                                "ls_shop_id" => $result[$index]['ls_shop_id'],
                                                "user_line_uid" => $result_convert[0]['ls_shop_line_regis_user_line_uid'],
        
                                        )
                                );
        
                                $result[$index]["ls_shop_sale_status_play_game_count_regis"] = $result_status;
                        }
                        
                }

                return $result;

        }



        public function GetShopById_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->GetDetailShopById($data); 
                // $result = json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                $result = json_encode( $this->Model_Line_Sale->ConvertJson($result) ,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo  $result ;

        }


        
        public function UpdateShopDataById_post(){

                // $data = json_encode('{    
                //         "ls_shop_id" :"53",
                //         "ls_shop_sale_id": "003599",
                //         "ls_shop_sale_type": "ป.3",
                //         "ls_shop_name": "ชื่อร้านค้า",
                //         "ls_shop_name_owner": "ชื่อเจ้าของร้าน",
                //         "ls_shop_datebrith": "25\/01\/2540",
                //         "ls_shop_people_id_owner": "",
                //         "ls_shop_lat_lon": {
                //                 "lat": "13.7363456",
                //                 "lon": "100.5584384"
                //         },
                //         "ls_shop_tel": "",
                //         "ls_shop_tel_mobile": "0852246875",
                //         "ls_shop_vol_cig": "120",
                //         "ls_shop_other_cig": " 12321123",
                //         "ls_shop_create_by_type": "by_sale",
                //         "ls_shop_address": {
                //                 "id": "",
                //                 "tambon": "",
                //                 "amphoe": "",
                //                 "province": "",
                //                 "zipcode": "",
                //                 "tambon_code": "",
                //                 "amphoe_code": "",
                //                 "province_code": "",
                //                 "address": "60"
                //         },
                //         "ls_line_data": {
                //                 "user_line_uid":"Uc771d175895a00dd636c0087a8b6afd1",
                //                 "user_line_name":"Supol",
                //                 "user_line_pic_url":"https:\/\/profile.line-scdn.net\/0m0e6e2e4a7251354009baeea6d164111a0503f9c8a659",
                //                 "user_line_os":"ios"
                //         },

                //         "ls_shop_file": {
                //                 "ls_shop_file_01": "dfgdfg"
                //         },
                //         "ls_shop_status": "1"
                // }');


                // $result = $this->Model_Line_Sale->UpdateShop($data); 
                // echo  $result ;


                $data = json_decode(file_get_contents('php://input'), true);  
                $result = json_encode( $this->Model_Line_Sale->UpdateShop($data)  ,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo  $result ;
        } 


        public function DeleteShopDataById_post(){

                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->DeleteShop($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } 


        public function InsertDetailShop_post(){
               
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->InsertDetailShop($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        public function GetWithJson_post(){
              
                // SELECT * FROM `ls_shop` WHERE ls_shop_address like '%"province_code":"10"%' 
                // SELECT * FROM `ls_shop` WHERE ls_shop_address like '%"amphoe_code":"1039"%'
                // SELECT * FROM `ls_shop` WHERE ls_shop_address like '%"tambon_code":"103306"%'

        }
    

        public function GetShopHaveLineRegis_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->GetShopHaveLineRegis($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        }
        
        public function EditShopByShopSalf_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->EditShopByShopSalf($data); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        public function GetShopOnlyBase1_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->GetShopOnlyBase1($data); 
                $result = $this->Model_Line_Sale->ConvertJson_DATASTUDIO($result); 
                echo json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
     
        
 
       

}