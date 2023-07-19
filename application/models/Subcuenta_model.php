<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subcuenta_model extends CI_Model
{

  var $table = 'subcuenta';
  var $column = array('id_subcuenta','nombre_cuenta','rut_subcuenta','nombre_subcuenta','subcuenta.tipo_movimiento','subcuenta.estado');
  var $order = array('id_subcuenta' => 'desc');

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
  public function get_by_id($id)
  {
    /*
    $this->db->from($this->table);
    $this->db->where('id_subcuenta',$id);
    $query = $this->db->get();
    return $query->row();
    */

    
    $this->db->select('s.id_subcuenta,s.id_cuenta,nombre_cuenta,s.rut_subcuenta,s.nombre_subcuenta,nombre_tipo_movimiento,s.tipo_movimiento,s.estado,s.usuario_guarda,s.fecha_guarda,s.usuario_modifica,s.fecha_modifica');
    $this->db->from('subcuenta s');
    $this->db->join('cuenta c', 'c.id_cuenta = s.id_cuenta');
    $this->db->join('tipo_movimiento tm', 'tm.id_tipo_movimiento = s.tipo_movimiento');
    $this->db->where('id_subcuenta',$id);
    $query = $this->db->get();
    return $query->row();
    

  }

  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_subcuenta,nombre_cuenta,rut_subcuenta,nombre_subcuenta,subcuenta.tipo_movimiento,subcuenta.estado');
    $this->db->join('cuenta c', 'c.id_cuenta = subcuenta.id_cuenta');
    $this->db->where('subcuenta.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->result();
  }

  function mostrar_subcuentas($id_empresa)
  {
    $this->db->select('id_cuenta,id_subcuenta,nombre_subcuenta,estado');
    $this->db->from($this->table);
    $this->db->where('subcuenta.id_empresa_guarda',$id_empresa);
    $this->db->order_by('id_cuenta', 'asc');
    $query = $this->db->get();
    return $query->result();
  }

  public function trae_cuentas($tm,$ie)
  {
    $this->db->where('tipo_movimiento',$tm);
    $this->db->where('id_empresa_guarda',$ie);
    $subcuentas = $this->db->get('cuenta');
    if($subcuentas->num_rows()>0)
    {
    return $subcuentas->result();
    }
  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('id_subcuenta,nombre_cuenta,rut_subcuenta,nombre_subcuenta,subcuenta.tipo_movimiento,subcuenta.estado');
    $this->db->join('cuenta c', 'c.id_cuenta = subcuenta.id_cuenta');
    $this->db->where('subcuenta.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('id_subcuenta,nombre_cuenta,rut_subcuenta,nombre_subcuenta,subcuenta.tipo_movimiento,subcuenta.estado');
    $this->db->join('cuenta c', 'c.id_cuenta = subcuenta.id_cuenta');
    $this->db->where('subcuenta.id_empresa_guarda',$id_empresa);
    return $this->db->count_all_results();
  }

  function guarda_subcuenta($data){

    $this->db->trans_start();
    $this->db->insert($this->table, $data);

    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;

}

public function mostrar_en_calendario($where, $data)
{
  $this->db->update('cuenta', $data, $where);
  return $this->db->affected_rows();
}

public function update($where, $data)
{
  $this->db->update($this->table, $data, $where);
  
  //HAmestica: actualizacion id_cuenta a los movimientos asociados a id_subcuenta
  $this->db->update('movimiento',array('id_cuenta' => $data['id_cuenta']), $where);

  return $this->db->affected_rows();
}

}
