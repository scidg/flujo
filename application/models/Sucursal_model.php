<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sucursal_model extends CI_Model
{

  var $table = 'sucursal';
  var $column = array('id_sucursal','sucursal.id_empresa','nombre_sucursal','direccion_sucursal','sucursal.estado');
  var $order = array('id_sucursal' => 'desc');

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
    $this->db->where('id_sucursal',$id);
    $query = $this->db->get();

    return $query->row();
  }
  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_sucursal,e.nombre_empresa,nombre_sucursal,direccion_sucursal,sucursal.estado');
    $this->db->join('empresa e', 'e.id_empresa = sucursal.id_empresa');
    $this->db->where('sucursal.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();

    return $query->result();

  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('id_sucursal,e.nombre_empresa,nombre_sucursal,direccion_sucursal,sucursal.estado');
    $this->db->join('empresa e', 'e.id_empresa = sucursal.id_empresa');
    $this->db->where('sucursal.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('id_sucursal,e.nombre_empresa,nombre_sucursal,direccion_sucursal,sucursal.estado');
    $this->db->join('empresa e', 'e.id_empresa = sucursal.id_empresa');
    $this->db->where('sucursal.id_empresa_guarda',$id_empresa);
    return $this->db->count_all_results();
  }

  function guarda_sucursal($data){

    $this->db->trans_start();
    $this->db->insert('sucursal', $data);

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
