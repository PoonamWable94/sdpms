<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class My_company_model extends CI_Model
{
    
    public function get_company()
    {
        $this->db->from("tg_company");
        $query = $this->db->get();
        return $query->result();
    }

    public function save_data($company_data)
    {
        $this->db->update('tg_company',$company_data,'id=1');
    }

}

  