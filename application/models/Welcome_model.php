<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        $this->search = '';

  }

  function muestra_submodulo()
      {
        $this->db->select('s.id_modulo,s.id_submodulo,s.nombre_submodulo,s.estado,s.titulo_submodulo,s.icon');
        $this->db->from('submodulo s');
        $this->db->where('s.estado', 1);
        $query = $this->db->get();
        return $query->result();
      }



}
