<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Product_model extends CI_Model{
     
    function get_category(){
        $query = $this->db->get('xin_companies');
        return $query;  
    }
 
    function get_sub_category($category_id){
        $query = $this->db->get_where('xin_office_location', array('company_id' => $category_id));
        return $query;
    }
     
}