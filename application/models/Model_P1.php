<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_P1 extends CI_Model{    

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


    public function P1_ApproveAndConnectLine($data){

        $ls_shop_p1_code = $data['ls_shop_p1_code'];
        $result_ls_shop_p1_connect = $this->db->query("SELECT COUNT(ls_shop_p1_code) FROM ls_shop_p1_connect WHERE ls_shop_p1_code = '$ls_shop_p1_code'")->result_array();

        $count = $result_ls_shop_p1_connect[0]["COUNT(ls_shop_p1_code)"];


        if($count == "0"){

            $data_insert = array(
                'ls_shop_p1_connect_id'             =>  NULL,
                'ls_shop_p1_code '                  =>  $data['ls_shop_p1_code'], 
                'ls_shop_p1_line_uid'               =>  $data['ls_shop_p1_line_uid'], 
                'ls_shop_p1_id_node'                =>  $data['ls_shop_p1_id_node'], 
                'ls_shop_p1_line_detail'            =>  json_encode($data['ls_line_data']),
                'ls_shop_p1_connect_line_status'    =>  $data['ls_shop_p1_connect_line_status'], 
                'ls_shop_p1_note'                   =>  $data['ls_shop_p1_note'], 
            );
    
    
            $this->db->insert('ls_shop_p1_connect', $data_insert);
            if(($this->db->affected_rows() != 1) ? false : true){
    
                return  array(  'status' => "true" , 'result' => "Insert_shop_p1_connect true" );
    
            }else{
    
                return  array(  'status' => "false" , 'result' => "Insert_shop_p1_connect false" );
    
            }
    
        }else if($count == "1"){

            $data_insert = array(
                'ls_shop_p1_connect_id'             =>  NULL,
                'ls_shop_p1_code '                  =>  $data['ls_shop_p1_code'], 
                'ls_shop_p1_line_uid'               =>  $data['ls_shop_p1_line_uid'], 
                'ls_shop_p1_id_node'                =>  $data['ls_shop_p1_id_node'], 
                'ls_shop_p1_line_detail'            =>  json_encode($data['ls_line_data']),
                'ls_shop_p1_connect_line_status'    =>  $data['ls_shop_p1_connect_line_status'], 
                'ls_shop_p1_note'                   =>  $data['ls_shop_p1_note'], 
            );


            $this->db->trans_begin();
            $this->db->where('ls_shop_p1_code', $ls_shop_p1_code)->set($data_insert)->update('ls_shop_p1_connect');
                   
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();

                return  array(  'status' => "false" , 'result' => "Update_shop_p1_connect false" );
    
            } else {
                $this->db->trans_commit();

                return  array(  'status' => "true" , 'result' => "Update_shop_p1_connect true" );
            }


        }

    }

    public function P1_CheckUserConnected($data){

        $ls_shop_p1_code = $data['ls_shop_p1_code'];
        $result_ls_shop_p1_connect = $this->db->query("SELECT * FROM `ls_shop_p1_connect` WHERE ls_shop_p1_code = $ls_shop_p1_code")->result_array();
     

        // print_r($result_ls_shop_p1_connect);
        
        // echo sizeof($result_ls_shop_p1_connect);

        if(sizeof($result_ls_shop_p1_connect) != 0){
            
            if($result_ls_shop_p1_connect[0]['ls_shop_p1_line_uid'] == ""){

                return  array(  'status' => "true" , 'result' => "ls_shop_p1_code not connect" );
                
            }else{

                return  array(  'status' => "false" , 'result' => $result_ls_shop_p1_connect[0] );
            }
            
        }else{
            return  array(  'status' => "true" , 'result' => "ls_shop_p1_code not connect" );
        }

    }

    public function P1_GetUserAll($data){
        $result = $this->db->query("SELECT * FROM `ls_shop_p1_connect`  WHERE `ls_shop_p1_connect_line_status` = 1 ")->result_array();
        return $result;
    }

    public function GetAllP1Connect($data){
        
        $result = $this->db->query("SELECT * FROM `ls_shop_p1_connect`")->result_array();
      
        for($index =0; $index  < sizeof($result); $index ++){

            $reault_p1_detail = $this->GetDetailP1WithID(array("p1_shop_code" => $result[$index]['ls_shop_p1_code']));
            $result[$index]['ls_shop_p1_detail'] = $reault_p1_detail;
            $result[$index]['ls_shop_p1_line_detail'] = json_decode($result[$index]['ls_shop_p1_line_detail'], true);
        }
       
       
        return $result;

    }

    public function GetDetailP1WithID($data){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://change.toat.co.th/regis/index.php/API/API_P1/GetDetailP1WithID');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $data ));
      
        $result = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($result, true);
        return $res;
    }
    
    public function GetSubShopWithP1Id($data){

        if($data['p1_shop_code']  != ""){

            $ls_shop_sale_id = $data['p1_shop_code'];
            $result_shop = $this->db->query("SELECT * FROM `ls_shop` WHERE ls_shop_sale_id = '$ls_shop_sale_id' ORDER BY `ls_shop`.`ls_shop_id` DESC")->result_array();

            return  array(  'status' => "false" , 'result' => $this->ConvertJson_DATASTUDIO($result_shop) );

        }else{

            return  array(  'status' => "false" , 'result' => "request p1_shop_code" );

        }
      
    }



    

}