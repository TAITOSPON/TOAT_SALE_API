<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Shop extends CI_Model{    



    public function GetAllProvince($Province){

        $data = $this->db
        ->query("SELECT DISTINCT `ls_tambons`.province  FROM `ls_tambons` WHERE province LIKE '$Province%' ")
        ->result_array();

        return $data;
    }

    public function GetAllAmphoeWithProvince($result){
       
        $province = $result['province'];
        $amphoe = $result['amphoe'];

        $data = $this->db
        ->query("SELECT DISTINCT `ls_tambons`.amphoe  FROM `ls_tambons` WHERE province = '$province' AND amphoe LIKE '$amphoe%' ")
        ->result_array();

        return $data;
    }

    
    public function GetAllTambonWithAmphoe($result){
       
        $province = $result['province'];
        $amphoe = $result['amphoe'];
        $tambon = $result['tambon'];

        $data = $this->db
        ->query("SELECT DISTINCT `ls_tambons`.tambon  FROM `ls_tambons` WHERE province = '$province' AND amphoe = '$amphoe' AND tambon LIKE '$tambon%' ")
        ->result_array();

        return $data;
    }


    
    public function GetZipCodeWithTambon($result){

        $province = $result['province'];
        $amphoe = $result['amphoe'];
        $tambon = $result['tambon'];

        $data = $this->db
        ->query("SELECT * FROM `ls_tambons` WHERE province = '$province' AND  amphoe = '$amphoe' AND tambon = '$tambon'  ")
        ->result_array();

        return $data;
    }


    public function GetDetailWithZipcode($result){

        $zipcode = $result['zipcode'];

        // $data = $this->db
        // ->query("SELECT 
        // `ls_tambons`.`tambon_code`,
        // `ls_tambons`.`tambon`,
        // `ls_tambons`.`amphoe`,
        // `ls_tambons`.`province`,
        // `ls_tambons`.`zipcode`,
        // `subdistricts`.`latitude`,
        // `subdistricts`.`longitude` 
        
        // FROM `ls_tambons` 
        // INNER JOIN `subdistricts`  
        // ON `ls_tambons`.`tambon_code` = `subdistricts`.`code` 
        // WHERE  `ls_tambons`.`zipcode` LIKE '$zipcode%'")
        // ->result_array();


        $data = $this->db
        ->query(" SELECT * FROM `ls_tambons` where zipcode like '$zipcode%'")->result_array();

        return $data;
    }


}