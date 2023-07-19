<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banco_model extends CI_Model
{

  var $table = 'banco';
  var $column = array('id_banco','rut_banco','nombre_banco','banco.id_moneda','banco.linea_sobregiro','nombre_linea_credito','banco.estado');
  var $order = array('id_banco' => 'desc');

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

       foreach ($this->column as $item) // loop column
       {
           if($_POST['search']['value']) // if datatable send POST for search
           {

               if($i===0) // first loop
               {
                   $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                   $this->db->like($item, $_POST['search']['value']);
               }
               else
               {
                   $this->db->or_like($item, $_POST['search']['value']);
               }

               if(count($this->column) - 1 == $i) //last loop
                   $this->db->group_end(); //close bracket
           }
           $i++;
       }

       if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }
  }

  function mostrar_moneda($id_empresa){

      $this->db->select('m.id_moneda, m.nombre_moneda, m.simbolo_moneda, m.estado');
      $this->db->from('moneda m');
      $this->db->where('m.estado', 1);
      $this->db->where('m.id_empresa_guarda',$id_empresa);

      $query = $this->db->get();

      if($query->num_rows() >  0){

          return $query->result();

      }else{

          return false;
      }

  }

  function mostrar_linea_credito($id_empresa){

      $this->db->select('lc.id_linea_credito, lc.nombre_linea_credito, lc.estado');
      $this->db->from('linea_credito lc');
      $this->db->where('lc.estado', 1);
      $this->db->where('lc.id_empresa_guarda',$id_empresa);
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
    $this->db->where('id_banco',$id);
    $query = $this->db->get();

    return $query->row();
  }
  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_banco,rut_banco,nombre_banco,m.nombre_moneda,linea_sobregiro,nombre_linea_credito,banco.estado');
    $this->db->join('moneda m', 'm.id_moneda = banco.id_moneda');
    $this->db->join('linea_credito lc', 'lc.id_linea_credito = banco.id_linea_credito');
    $this->db->where('banco.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->result();

  }

  function muestra_banco($id_empresa)
  {
    $this->db->select('b.id_banco,b.rut_banco,b.nombre_banco,b.estado');
    $this->db->from('banco b');
    $this->db->where('b.estado', 1);
    $this->db->where('b.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('id_banco,rut_banco,nombre_banco,m.nombre_moneda,linea_sobregiro,nombre_linea_credito,banco.estado');
    $this->db->join('moneda m', 'm.id_moneda = banco.id_moneda');
    $this->db->join('linea_credito lc', 'lc.id_linea_credito = banco.id_linea_credito');
    $this->db->where('banco.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('id_banco,rut_banco,nombre_banco,m.nombre_moneda,linea_sobregiro,nombre_linea_credito,banco.estado');
    $this->db->join('moneda m', 'm.id_moneda = banco.id_moneda');
    $this->db->join('linea_credito lc', 'lc.id_linea_credito = banco.id_linea_credito');
    $this->db->where('banco.id_empresa_guarda',$id_empresa);
    return $this->db->count_all_results();
  }

  function guarda_banco($data){

    $this->db->trans_start();
    $this->db->insert('banco', $data);

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
