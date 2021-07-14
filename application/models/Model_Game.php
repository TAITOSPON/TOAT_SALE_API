<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Game extends CI_Model{    

    function __construct(){
          parent::__construct();
          $this->default = $this->load->database('default', TRUE);
          $this->ls_game = $this->load->database('ls_game', TRUE);
          
    }

    public function InsertGameRegisCount($data){

        if(isset($data['ls_shop_id'])){
            if(isset($data['user_line_uid'])){

                $result_count = $this->ls_game->query("SELECT count(*) FROM `ls_game_regis_order`")->result_array();
       
                $data_insert = array(
                    'ls_shop_geme_regis_id'         => NULL,
                    'ls_shop_id'                    => $data['ls_shop_id'],
                    "user_line_uid"                 => $data['user_line_uid'],
                    'ls_shop_geme_regis_datetime'   => date("Y-m-d H:i:s"),
                    'ls_shop_geme_regis_count'      => $this->SetNumberCountThreeDigit((intval($result_count[0]['count(*)'])+1)),
                    'ls_shop_geme_regis_status'     => "true",
                   
                );
        
        
                $this->ls_game->insert('ls_game_regis_order', $data_insert);
                if(($this->ls_game->affected_rows() != 1) ? false : true){
        
                    $ls_shop_id = $data['ls_shop_id'];
                    $user_line_uid = $data['user_line_uid'];
        
                    $result_retrun = $this->ls_game->query(" SELECT * FROM `ls_game_regis_order` WHERE `ls_shop_id` = '$ls_shop_id'
                                                AND  `user_line_uid` = '$user_line_uid' 
                                                ORDER BY `ls_shop_geme_regis_id`  DESC LIMIT 1 ")->result_array();
        
                    return  array(  'status' => "true" , 'result' => "InsertGameRegisCount true" , 'data' => $result_retrun);
        
                }else{
        
                    return  array(  'status' => "false" , 'result' => "InsertGameRegisCount false" );
        
                }
        

            }else{
                return  array(  'status' => "false" , 'result' => "request user_line_uid" );
            }
        }else{
            return  array(  'status' => "false" , 'result' => "request ls_shop_id" );
        }
    
    }

    public function SetNumberCountThreeDigit($number){
   
        if($number < 100){

            if($number < 10){

                return "00".strval($number);
    
            }else{
                return "0".strval($number);
            }

        }else{

            return strval($number);

        }
       

    }
 


    public function CheckStatusPlayGameRegisCount($data){

        if(isset($data['ls_shop_id'])){
            if(isset($data['user_line_uid'])){

                $ls_shop_id = $data['ls_shop_id'];
                $user_line_uid = $data['user_line_uid'];
    
                $result_count_play = $this->ls_game->query(" SELECT count(*) FROM `ls_game_regis_order` WHERE `ls_shop_id` = '$ls_shop_id'
                                AND  `user_line_uid` = '$user_line_uid' 
                                ORDER BY `ls_shop_geme_regis_id`  DESC LIMIT 1 ")->result_array();

                $result_play = $this->ls_game->query(" SELECT * FROM `ls_game_regis_order` WHERE `ls_shop_id` = '$ls_shop_id'
                                AND  `user_line_uid` = '$user_line_uid' 
                                ORDER BY `ls_shop_geme_regis_id`  DESC LIMIT 1 ")->result_array();

                if($result_count_play[0]['count(*)'] != "0"){

                    return  array(  'status' => "true" , 'result' => "YES PlayGameRegisCounted" , "data" => $result_play );

                }else{

                    return  array(  'status' => "true" , 'result' => "NOT PlayGameRegisCount" , "data" => $result_play  );
                }

            
                

            }else{
                return  array(  'status' => "false" , 'result' => "request user_line_uid" );
            }
        }else{
            return  array(  'status' => "false" , 'result' => "request ls_shop_id" );
        }
    }


    public function GetAllShopAward($data){
        
        $result_all_award = $this->ls_game->query("SELECT * FROM `ls_game_regis_order`  ORDER BY `ls_game_regis_order`.`ls_shop_geme_regis_id`  ASC")->result_array();
     

        for($index =0; $index  < sizeof($result_all_award); $index ++){
           
           
            $ls_shop_id = $result_all_award[$index]['ls_shop_id'];
            
            $result = $this->db->query(" SELECT * FROM `ls_shop` WHERE ls_shop_id = '$ls_shop_id' ")->result_array();
            $result_all_award[$index]["ls_shop_detail"] = $result;
    
        }
        return $result_all_award;
    }


    public function GetAllShopAwardGroup($data){
        
        $result_all_award = $this->ls_game->query("SELECT * FROM `ls_game_regis_order`  ORDER BY `ls_game_regis_order`.`ls_shop_geme_regis_id`  ASC")->result_array();
     
        $Award_frist = array('001','010','020','030','070','110','150','190','230','280','330','380','430','480','530','580','630','680','730','780');
        $Award_Second = array('006','018','027','036','043','049','055','061','068','079','085','091','097','103','115','121','127','133','139','145','157','163','169','175',
                                '181','187','199','205','211','217','223','235','241','247','253','259','265','271','277','289','295','301','307','313','319','325','337','343',
                                '349','355','361','367','373','385','391','397','403','409','415','421','427','439','445','451','457','487','493','499','505','511','517','523',
                                '535','541','547','553','559','565','571','577','583','589','595','601','607','613','619','625','637','643','649','655','661','667','673','685',
                                '691','697','703','709','715','721','727','733','739','745','751','757','763','769','775','787','793','799','805','811','817');
      
        $shop_first_award = array();         
        $shop_second_award = array();      
        $shop_other_award = array();                       

        for($index =0; $index  < sizeof($result_all_award); $index ++){
           
           
            $ls_shop_id = $result_all_award[$index]['ls_shop_id'];
            

            $result = $this->db->query(" SELECT * FROM `ls_shop` WHERE ls_shop_id = '$ls_shop_id' ")->result_array();
            $result_all_award[$index]["ls_shop_detail"] = $this->ConvertJson_DATASTUDIO($result);

            $ls_shop_geme_regis_count = $result_all_award[$index]['ls_shop_geme_regis_count'];

            $status = "false";

            for($index_first = 0; $index_first  < sizeof($Award_frist); $index_first ++){
                if($ls_shop_geme_regis_count == $Award_frist[$index_first ]){

                    array_push($shop_first_award, $result_all_award[$index]);
                    $status = "true";
                }
            }

            for($index_second = 0; $index_second  < sizeof($Award_Second); $index_second ++){
                if($ls_shop_geme_regis_count == $Award_Second[$index_second ]){

                    array_push($shop_second_award, $result_all_award[$index]);
                    $status = "true";
                }
            }

            if( $status == "false"){
                array_push($shop_other_award, $result_all_award[$index]);
            }
      
             
                
    
        }
        $result = array(
            "shop_first_award" => $shop_first_award,
            "shop_second_award" => $shop_second_award , 
            "shop_other_award" => $shop_other_award,
        );
        return $result;
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



}