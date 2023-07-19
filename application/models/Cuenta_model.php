<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cuenta_model extends CI_Model
{

  var $table = 'cuenta';
  var $column = array('id_cuenta','nombre_cuenta','cuenta_banco','tipo_movimiento','estado');
  var $order = array('id_cuenta' => 'desc');

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

  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_cuenta,nombre_cuenta,cuenta_banco,cuenta_prestamo,tipo_movimiento,estado');
    $this->db->where('id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->result();
  }
  function mostrar_cuentas($id_empresa)
  {
    $this->db->select('id_cuenta,nombre_cuenta,estado');
    $this->db->from($this->table);
    $this->db->where('cuenta.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->result();
  }
  public function get_by_id($id)
	{
    //HAmestica: select cuenta con campo orden de la tabla cuenta_orden
    // $this->db->from($this->table);
    // $this->db->where('id_cuenta',$id);
    $this->db->select('a.*,ifnull(b.orden,999) as orden');
    $this->db->from('cuenta a');
    $this->db->join('cuenta_orden b','a.id_cuenta=b.id_cuenta','left');
    $this->db->where('a.id_cuenta',$id);

		$query = $this->db->get();

		return $query->row();
  }
  
  //HAmestica: funcion que devuelve id, nombre y orden de las cuentas
  public function get_orden_cuenta_by_id($id_empresa_guarda)
	{
    $this->db->select('a.id_cuenta,a.nombre_cuenta,ifnull(b.orden,999) as orden');
    $this->db->from('cuenta a');
    $this->db->join('cuenta_orden b','a.id_cuenta=b.id_cuenta','left');
    $this->db->where('a.id_empresa_guarda',$id_empresa_guarda);
    $this->db->order_by('3 asc');

		$query = $this->db->get();

		return $query->result();
  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('id_cuenta,nombre_cuenta,cuenta_banco,tipo_movimiento,estado');
    $this->db->where('id_empresa_guarda',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('id_cuenta,nombre_cuenta,cuenta_banco,tipo_movimiento,estado');
    $this->db->where('id_empresa_guarda',$id_empresa);
    return $this->db->count_all_results();
  }

  public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

  function guarda_cuenta($data){

    $this->db->trans_start();
    $this->db->insert($this->table, $data);

    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;

}

//HAmestica: funcion que llama al procedimiento de que registra y ordena la tabla cuenta_orden
public function cuenta_orden_registrar($id_cuenta,$orden){
  $SP_cuenta_orden_Registrar="CALL SP_cuenta_orden_Registrar(?,?)";
  $this->db->query($SP_cuenta_orden_Registrar,array('v_id_cuenta'=>$id_cuenta,'v_orden'=>$orden));
}

public function get_name_exists($val,$tabla,$campo,$ide)
  {
    $this->db->from($tabla);
    $this->db->where($campo,$val);
    $this->db->where('id_empresa_guarda',$ide);
    $query = $this->db->get();

    if($query->num_rows() >  0){
        return true;
    }else{
        return false;
    }
  }

  public function get_rut_exists($val,$tabla,$campo,$ide)
  {
    $this->db->from($tabla);
    $this->db->where($campo,$val);
    $this->db->where('id_empresa_guarda',$ide);
    $query = $this->db->get();

    if($query->num_rows() >  0){
        return true;
    }else{
        return false;
    }
  }  
}
