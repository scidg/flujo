<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Parametro_model extends CI_Model
{

  var $table = 'parametro';
  var $column = array('grupo_parametro','grupo_parametro','estado');
  var $order = array('id_parametro' => 'desc');

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


  function devuelveNombreEmpresa($id){

      $this->db->select('e.id_empresa, e.nombre_empresa,e.logo_empresa, e.estado');
      $this->db->from('empresa e');
      $this->db->where('e.id_empresa', $id);
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }
  }

  function get_datatables($id_empresa)
  {

    //$this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('p.id_parametro,p.nombre_parametro, p.grupo_parametro,
    (SELECT COUNT(id_parametro) FROM parametro_detalle pd WHERE pd.id_parametro = p.id_parametro) AS cant_opc, p.estado');
    $this->db->from('parametro p');
    //$this->db->join('parametro_detalle pd','pd.grupo = p.id_parametro_grupo1');
    $query = $this->db->get();

    return $query->result();


  }

  public function get_by_id($id)
	{   
        $this->db->select('p.id_parametro,p.nombre_parametro,p.comentario_parametro,p.estado');
        $this->db->from('parametro p');
        //$this->db->join('parametro_detalle pd', 'pd.id_parametro = p.id_parametro');
		$this->db->where('p.id_parametro',$id);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->row();
        }else{
            return false;
        }
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

  public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

  function guarda_parametro($data)
	{
    $this->db->insert($this->table, array('nombre_parametro'=>$data['nombre_parametro'],
    'comentario_parametro'=>$data['comentario_parametro'],
    'usuario_guarda'=>$data['usuario_guarda'],
    'fecha_guarda'=>$data['fecha_guarda'],
    'estado'=>$data['estado']));

    //$id_parametro=$this->db->insert_id();

    /*foreach($data['opcion_parametro'] as $valor=>$cat)
      $this->db->insert(
        'parametro_detalle',
        array(
          'id_parametro'=>$id_parametro,
          'opcion_parametro'=>$cat,
          'usuario_guarda'=>$data['usuario_guarda'],
          'fecha_guarda'=>$data['fecha_guarda'],
          'estado'=>1
          )
      );*/

	}


}
