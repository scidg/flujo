<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Servicio_otro_model extends CI_Model
{

  var $table = 'servicio_otro';
  var $column = array('rut_servicio_otro','nombre_servicio_otro','servicio_otro.id_condicion_pago','servicio_otro.id_plazo_pago','estado');
  var $order = array('id_servicio_otro' => 'desc');

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

  function mostrar_condicion_pago(){

      $this->db->select('cp.id_condicion_pago, cp.nombre_condicion_pago, cp.estado');
      $this->db->from('condicion_pago cp');
      $this->db->where('cp.estado', 1);

      $query = $this->db->get();

      if($query->num_rows() >  0){

          return $query->result();

      }else{

          return false;
      }

  }

  function mostrar_plazo_pago(){

      $this->db->select('pp.id_plazo_pago, pp.nombre_plazo_pago, pp.estado');
      $this->db->from('plazo_pago pp');
      $this->db->where('pp.estado', 1);

      $query = $this->db->get();

      if($query->num_rows() >  0){

          return $query->result();

      }else{

          return false;
      }

  }

  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id_servicio_otro',$id);
    $query = $this->db->get();

    return $query->row();
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_servicio_otro,rut_servicio_otro,nombre_servicio_otro,cp.nombre_condicion_pago,pp.nombre_plazo_pago,servicio_otro.estado');
    $this->db->join('condicion_pago cp', 'cp.id_condicion_pago = servicio_otro.id_condicion_pago');
    $this->db->join('plazo_pago pp', 'pp.id_plazo_pago = servicio_otro.id_plazo_pago');

    $query = $this->db->get();

    return $query->result();

  }

  function muestra_servicio_otro()
  {
    $this->db->select('s.id_servicio_otro,s.rut_servicio_otro,s.nombre_servicio_otro,s.estado');
    $this->db->from('servicio_otro s');
    $this->db->where('s.estado', 1);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  function guarda_servicio_otro($data){

    $this->db->trans_start();
    $this->db->insert('servicio_otro', $data);

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
