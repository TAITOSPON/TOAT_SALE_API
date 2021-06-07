<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
require(APPPATH.'libraries/REST_Controller.php');

class Api_line_sale extends REST_Controller{

        public function __construct(){

                parent::__construct();
                $this->load->model('Model_Line_Sale');
            
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
                                $result = json_encode( $this->ConvertJson_DATASTUDIO($result) ,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                                echo  $result ; 
                        }

                }else{
                        $data = json_decode(file_get_contents('php://input'), true);  
                        $result = $this->Model_Line_Sale->GetAllShopRegister($data); 
                        $result = json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                        // $result = json_encode( $this->ConvertJson($result) ,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                        echo  $result ;

                }
          
             
        }



        public function GetShopById_post(){
                $data = json_decode(file_get_contents('php://input'), true);  
                $result = $this->Model_Line_Sale->GetDetailShopById($data); 
                // $result = json_encode($result,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                $result = json_encode( $this->ConvertJson($result) ,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
                $result = json_encode( $this->Model_Line_Sale->DeleteShop($data)  ,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo  $result ;
        } 


        public function ConvertJson($result){
                if($result!=null){
                        for($index =0; $index  < sizeof($result); $index ++){

                                $array_latlon           = json_decode($result[$index]['ls_shop_lat_lon'],true);
                                $array_address          = json_decode($result[$index]['ls_shop_address'],true);
                                $array_file             = json_decode($result[$index]['ls_shop_file'],true);
                                $array_line_regis       = json_decode($result[$index]['ls_shop_line_regis'],true);
        
                                $result[$index]['ls_shop_lat_lon']      =  $array_latlon;
                                $result[$index]['ls_shop_address']      =  $array_address;
                                $result[$index]['ls_shop_file']         =  $array_file;
                                $result[$index]['ls_shop_line_regis']   =  $array_line_regis;
                           
                        }
                        
                        return $result;
        
                }
                
                

        }



        public function ConvertJson_DATASTUDIO($result){
        
                
                for($index =0; $index  < sizeof($result); $index ++){

                        $array_latlon           = json_decode($result[$index]['ls_shop_lat_lon'],true);
                        $array_tambol           = json_decode($result[$index]['ls_shop_address'],true);
                        $array_file             = json_decode($result[$index]['ls_shop_file'],true);
                        $array_line_regis       = json_decode($result[$index]['ls_shop_line_regis'],true);


                        $result[$index]['ls_shop_lat_lon']      =  $array_latlon['lat'] .",".$array_latlon['lon'];
                        // $result[$index]['ls_shop_lat_lon']      =  $array_latlon['lon'];


                        $result[$index]['ls_shop_address_address']              =  $array_tambol['address'];
                        $result[$index]['ls_shop_address_tambon']               =  $array_tambol['tambon'];
                        $result[$index]['ls_shop_address_amphoe']               =  $array_tambol['amphoe'];
                        $result[$index]['ls_shop_address_province']             =  $array_tambol['province'];
                        $result[$index]['ls_shop_address_zipcode']              =  $array_tambol['zipcode'];
                        $result[$index]['ls_shop_address_tambon_code']          =  $array_tambol['tambon_code'];
                        $result[$index]['ls_shop_address_amphoe_code']          =  $array_tambol['amphoe_code'];
                        $result[$index]['ls_shop_address_province_code']        =  $array_tambol['province_code'];
                        $result[$index]['ls_shop_address_id']                   =  $array_tambol['id'];


                        $result[$index]['ls_shop_file_ls_shop_file_01']         =  $array_file['ls_shop_file_01'];

                        $result[$index]['ls_shop_line_regis_user_line_uid']             =  $array_line_regis['user_line_uid'];
                        $result[$index]['ls_shop_line_regis_user_line_name']            =  $array_line_regis['user_line_name'];
                        $result[$index]['ls_shop_line_regis_user_line_pic_url']         =  $array_line_regis['user_line_pic_url'];

                        if(isset($array_line_regis['user_os'])){
                                $result[$index]['ls_shop_line_regis_user_line_os']              =  $array_line_regis['user_os'];
                        }else{
                                $result[$index]['ls_shop_line_regis_user_line_os']   = NULL;
                        }
                       
           
                        unset($result[$index]['ls_shop_address']    );
                        unset($result[$index]['ls_shop_file']       );
                        unset($result[$index]['ls_shop_line_regis'] );
                     
                   
                }
                
                return $result;


        }



        public function GetWithJson_post(){
              
                // SELECT * FROM `ls_shop` WHERE ls_shop_address like '%"province_code":"10"%' 
                // SELECT * FROM `ls_shop` WHERE ls_shop_address like '%"amphoe_code":"1039"%'
                // SELECT * FROM `ls_shop` WHERE ls_shop_address like '%"tambon_code":"103306"%'

        }
    

      

       

}