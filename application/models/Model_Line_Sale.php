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

            return  array(  'status' => "true" , 'result' => "InsertShop true" );

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