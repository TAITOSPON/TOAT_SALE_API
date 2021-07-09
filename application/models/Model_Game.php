<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Game extends CI_Model{    

    function __construct(){
          parent::__construct();
        //   $this->default = $this->load->database('default', TRUE);
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






}