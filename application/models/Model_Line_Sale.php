<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Line_Sale extends CI_Model{    


    public function InsertShop($data_){
      
        $data_insert = array(
            'ls_shop_id'                => NULL,
            'ls_shop_sale_id'           => $data_['ls_shop_sale_id'],
            "ls_shop_sale_type"         => $data_['ls_shop_sale_type'],
            'ls_shop_name'              => $data_['ls_shop_name'],
            'ls_shop_name_owner'        => $data_['ls_shop_name_owner'],
            'ls_shop_people_id_owner'   => $data_['ls_shop_people_id_owner'],
            'ls_shop_datebrith'         => $data_['ls_shop_datebrith'],
            'ls_shop_lat_lon'           => json_encode($data_['ls_shop_lat_lon']),
            'ls_shop_address'           => json_encode($data_['ls_shop_address']),
            'ls_shop_tel'               => $data_['ls_shop_tel'],
            'ls_shop_tel_mobile'        => $data_['ls_shop_tel_mobile'],
            'ls_shop_vol_cig'           => $data_['ls_shop_vol_cig'],
            'ls_shop_other_cig'         => $data_['ls_shop_other_cig'],
            'ls_shop_file'              => json_encode($data_['ls_shop_file']),
            'ls_shop_line_regis'        => json_encode($data_['ls_line_data']),
            'ls_shop_datetime_create'   => date("Y-m-d H:i:s"),
            'ls_shop_create_by_type'    => $data_['ls_shop_create_by_type'],
            'ls_approve_id'             => NULL,

            
        );


        $this->db->insert('ls_shop', $data_insert);
        if(($this->db->affected_rows() != 1) ? false : true){

            $ls_shop_name = $data_['ls_shop_name'];
            $ls_shop_name_owner = $data_['ls_shop_name_owner'];

            $data = $this->db->query(" SELECT * FROM `ls_shop` WHERE `ls_shop_name` = '$ls_shop_name'
                                        AND  `ls_shop_name_owner` = '$ls_shop_name_owner' 
                                        ORDER BY `ls_shop_id`  DESC LIMIT 1 ")->result_array();

            return  array(  'status' => "true" , 'result' => "InsertShop true" , 'data' => $this->ConvertJson_DATASTUDIO($data));

        }else{

            return  array(  'status' => "false" , 'result' => "InsertShop false" );

        }

    }
    
    public function UpdateShop($data_){

        $this->db->trans_begin();
        $this->db->where('ls_shop_id', $data_['ls_shop_id'])
        ->set(
            array( 
                "ls_shop_sale_id"           => $data_['ls_shop_sale_id'],
                "ls_shop_sale_type"         => $data_['ls_shop_sale_type'],
                'ls_shop_name'              => $data_['ls_shop_name'],
                'ls_shop_name_owner'        => $data_['ls_shop_name_owner'],
                'ls_shop_people_id_owner'   => $data_['ls_shop_people_id_owner'],
                'ls_shop_datebrith'         => $data_['ls_shop_datebrith'],
                'ls_shop_lat_lon'           => json_encode($data_['ls_shop_lat_lon']),
                'ls_shop_address'           => json_encode($data_['ls_shop_address']),
                'ls_shop_tel'               => $data_['ls_shop_tel'],
                'ls_shop_tel_mobile'        => $data_['ls_shop_tel_mobile'],
                'ls_shop_vol_cig'           => $data_['ls_shop_vol_cig'],
                'ls_shop_other_cig'         => $data_['ls_shop_other_cig'],
                'ls_shop_file'              => json_encode($data_['ls_shop_file']),
                'ls_shop_line_regis'        => json_encode($data_['ls_line_data']),

                )) ->update('ls_shop');


        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return  array(  'status' => "false" , 'result' => "update ls_shop false" );
        } else {
            $this->db->trans_commit();
            $data_['action'] = "UpdateShop";
            $this->InsertShopLog($data_);

            return  array(  'status' => "true" , 'result' => "update ls_shop true" );
        }
    
    }

    public function DeleteShop($data_){

        $this->db->trans_begin();
        $this->db->where('ls_shop_id', $data_['ls_shop_id'])
        ->set( array( 'ls_shop_status'  => "0") ) ->update('ls_shop');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return  array(  'status' => "false" , 'result' => "delete ls_shop false" );
        } else {
            $this->db->trans_commit();
            $data_['action'] = "DeleteShop";
            $this->InsertShopLog($data_);

            return  array(  'status' => "true" , 'result' => "delete ls_shop true" );

        }
    }

    public function InsertDetailShop($data_){

        if($data_['ls_shop_id']  != ""){
            
            $this->db->trans_begin();
            $this->db->where('ls_shop_id', $data_['ls_shop_id'])
            ->set(
                array( 
               
                    'ls_shop_datebrith'         => $data_['ls_shop_datebrith'],
                    'ls_shop_sale_gender'       => $data_['ls_shop_sale_gender'],
                    'ls_shop_email'             => $data_['ls_shop_email'],
                    'ls_shop_lat_lon'           => json_encode($data_['ls_shop_lat_lon']),
                    'ls_shop_file'              => json_encode($data_['ls_shop_file']),
        
                    )) ->update('ls_shop');
    
    
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return  array(  'status' => "false" , 'result' => "update ls_shop false" );
            } else {
                $this->db->trans_commit();
                $data_['action'] = "UpdateShopDetail";
                $data_['ls_shop_sale_id'] =  $data_['ls_shop_id'];
    
                $this->InsertShopLog($data_);
    
                return  array(  'status' => "true" , 'result' => "UpdateShopDetail ls_shop true" );
            }
        }else{
            return  array(  'status' => "false" , 'result' => "update ls_shop false" );
        }

     

    }

    public function GetAllShopRegister($data){
        $result = $this->db->query(" SELECT * FROM `ls_shop` WHERE `ls_shop_status` = 1 ")->result_array();
        return $result;
    }


    public function GetDetailShopById($data){

        if(isset($data['ls_shop_id'])){
            $ls_shop_id = $data['ls_shop_id'];
            $result = $this->db->query(" SELECT * FROM `ls_shop` WHERE ls_shop_id = '$ls_shop_id' ")->result_array();
            return $result;
        }else{
            return null;
        }
     
    }


    public function ConvertJson($result){

            if($result!=null){
                    for($index =0; $index  < sizeof($result); $index ++){


                            if($result[$index]['ls_shop_lat_lon'] == "null"){

                                $array_latlon = json_encode( array("lat" => "null" , "lon"=>"null") ); 
                                $array_latlon = json_decode($array_latlon,true);
                                
                            }else{
                                $array_latlon           = json_decode($result[$index]['ls_shop_lat_lon'],true);
                            }
                         


                            $array_address          = json_decode($result[$index]['ls_shop_address'],true);
                            $array_file             = json_decode($result[$index]['ls_shop_file'],true);
                            $array_line_regis       = json_decode($result[$index]['ls_shop_line_regis'],true);
    
                            $result[$index]['ls_shop_lat_lon']      =  $array_latlon;
                            $result[$index]['ls_shop_address']      =  $array_address;
                            $result[$index]['ls_shop_file']         =  $array_file;
                            $result[$index]['ls_shop_line_regis']   =  $array_line_regis;

                            if($result[$index]['ls_shop_sale_gender'] == null){
                                $result[$index]['ls_shop_sale_status_detail']   = "false";
                            }else{
                                $result[$index]['ls_shop_sale_status_detail']   = "true";
                                
                                // if($result[$index]['ls_shop_sale_gender'] == '1'){
                                //     $result[$index]['ls_shop_sale_gender'] = "ชาย";
                                // }else if($result[$index]['ls_shop_sale_gender'] == '2'){
                                //     $result[$index]['ls_shop_sale_gender'] = "หญิง";
                                // }else  if($result[$index]['ls_shop_sale_gender'] == '3'){
                                //     $result[$index]['ls_shop_sale_gender'] = "ไม่ระบุ";
                                // }
                               
                            }
                           
                        
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

                    if(isset($array_tambol['address_number'])){
                        if(isset($array_tambol['address_group_number'])){

                            $result[$index]['ls_shop_address_number']               =  $array_tambol['address_number'];
                            $result[$index]['ls_shop_address_group_number']         =  $array_tambol['address_group_number'];

                        }
                    }else{
                        $result[$index]['ls_shop_address_number']               =  NULL;
                        $result[$index]['ls_shop_address_group_number']         =  NULL;
                    }




                    $result[$index]['ls_shop_file_ls_shop_file_01']         =  $array_file['ls_shop_file_01'];

                    $result[$index]['ls_shop_line_regis_user_line_uid']             =  $array_line_regis['user_line_uid'];
                    $result[$index]['ls_shop_line_regis_user_line_name']            =  $array_line_regis['user_line_name'];
                    $result[$index]['ls_shop_line_regis_user_line_pic_url']         =  $array_line_regis['user_line_pic_url'];

                    if(isset($array_line_regis['user_os'])){
                            $result[$index]['ls_shop_line_regis_user_line_os']              =  $array_line_regis['user_os'];
                    }else{
                            $result[$index]['ls_shop_line_regis_user_line_os']   = NULL;
                    }

                    if($result[$index]['ls_shop_sale_gender'] == null){
                        $result[$index]['ls_shop_sale_status_detail']   = "false";
                    }else{
                        $result[$index]['ls_shop_sale_status_detail']   = "true";
                        
                        // if($result[$index]['ls_shop_sale_gender'] == '1'){
                        //     $result[$index]['ls_shop_sale_gender'] = "ชาย";
                        // }else if($result[$index]['ls_shop_sale_gender'] == '2'){
                        //     $result[$index]['ls_shop_sale_gender'] = "หญิง";
                        // }else  if($result[$index]['ls_shop_sale_gender'] == '3'){
                        //     $result[$index]['ls_shop_sale_gender'] = "ไม่ระบุ";
                        // }
                       
                    }
                    
        
                    unset($result[$index]['ls_shop_address']    );
                    unset($result[$index]['ls_shop_file']       );
                    unset($result[$index]['ls_shop_line_regis'] );
                    
                
            }
            
            return $result;


    }


    public function InsertShopLog($data_){


        $data_insert = array(
            'ls_shop_log_id '               => NULL,
            'ls_shop_log_datetime'          => date("Y-m-d H:i:s"),
            'ls_shop_log_action'            => $data_['action'],
            'ls_shop_log_shop_id'           => $data_['ls_shop_id'],
            'ls_shop_log_user_id'           => $data_['ls_shop_sale_id'],
        );


        $this->db->insert('ls_shop_log', $data_insert);
        if(($this->db->affected_rows() != 1) ? false : true){

            return  array(  'status' => "true" , 'result' => "InsertShopLog true" );

        }else{

            return  array(  'status' => "false" , 'result' => "InsertShopLog false" );

        }
    }

 

}