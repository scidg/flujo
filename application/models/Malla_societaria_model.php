<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Malla_societaria_model extends CI_Model
{

  var $table = 'malla_societaria';
  var $column = array('id_socio','rut_socio','nombre_socio','nombre_empresa','porcentaje_socio','estado');
  var $order = array('id_socio' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        $this->search = '';

  }

  private function _get_datatables_query()
  {

    $this->db->from($this->table);

    $i = 0;

    foreach ($this->column as $item)
    {
      if($_POST['search']['value'])
        ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
      $column[$i] = $item;
      $i++;
    }

    if(isset($_POST['order']))
    {
      $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order))
    {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id_socio',$id);
    $query = $this->db->get();

    return $query->row();
  }
  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_socio,e.nombre_empresa,rut_socio,nombre_socio,porcentaje_socio,malla_societaria.estado');
    //$this->db->from('malla_societaria ms');
    $this->db->join('empresa e', 'malla_societaria.id_empresa = e.id_empresa');
    $this->db->where('malla_societaria.id_empresa_guarda',$id_empresa);

    $query = $this->db->get();

    return $query->result();

  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('ms.id_socio,e.nombre_empresa,ms.rut_socio,ms.nombre_socio,ms.porcentaje_socio,ms.estado');
    $this->db->from('malla_societaria ms');
    $this->db->join('empresa e', 'ms.id_empresa = e.id_empresa');
    $this->db->where('malla_societaria.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('ms.id_socio,e.nombre_empresa,ms.rut_socio,ms.nombre_socio,ms.porcentaje_socio,ms.estado');
    $this->db->from('malla_societaria ms');
    $this->db->join('empresa e', 'ms.id_empresa = e.id_empresa');
    $this->db->where('malla_societaria.id_empresa_guarda',$id_empresa);
    return $this->db->count_all_results();
  }

  function guarda_socio($data){

    $this->db->trans_start();
    $this->db->insert('malla_societaria', $data);

    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;

}
public function update($where, $data)
{
  $this->db->update($this->table, $data, $where);
  return $this->db->affected_rows();
}

}
