<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_P1 extends CI_Model{    


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

    

}