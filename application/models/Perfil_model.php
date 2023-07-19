<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Perfil_model extends CI_Model
{

  var $table = 'usuario';

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->search = '';

  }

 
  public function update_con($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }


}
