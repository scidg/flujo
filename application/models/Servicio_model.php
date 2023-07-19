<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Servicio_model extends CI_Model
{

  var $table = 'servicio';
  var $column = array('id_servicio','nombre_servicio','estado');
  var $order = array('id_servicio' => 'desc');

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
    $this->db->from($this->table);
    $this->db->where('id_servicio',$id);
    $query = $this->db->get();

    return $query->row();
  }
  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_servicio,nombre_servicio,id_quincena,estado');
    $this->db->where('id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('id_servicio,nombre_servicio,id_quincena,estado');
    $this->db->where('id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('id_servicio,nombre_servicio,id_quincena,estado');
    $this->db->where('id_empresa_guarda',$id_empresa);
    return $this->db->count_all_results();
  }

  public function get_servicios($id,$q){
    $this->db->from($this->table);
    $this->db->select('id_servicio,nombre_servicio,id_quincena,estado');
    $this->db->where('id_empresa_guarda',$id);
    $this->db->where('id_quincena',$q);
    $this->db->where('estado', 1);
    $this->db->order_by('id_servicio', 'ASC');


    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
  }

    function guarda_servicio($data){

        $this->db->trans_start();
        $this->db->insert('servicio', $data);
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
