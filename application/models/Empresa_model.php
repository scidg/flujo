<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresa_model extends CI_Model
{

  var $table = 'empresa';
  var $column = array('eo.orden','id_empresa','rut_empresa','casa_central','nombre_empresa','logo_empresa','telefono_empresa','direccion_empresa','estado');
  var $order = array('id_empresa' => 'asc');

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
  function mostrar_empresas($id_holding){

      $this->db->select('e.id_empresa,e.nombre_empresa,e.logo_empresa,eo.orden,eo.mostrar, e.estado');
      $this->db->from('empresa e');
      $this->db->join('empresa_orden eo', 'e.id_empresa = eo.id_empresa');
      $this->db->where('e.estado', 1);
      $this->db->where('e.id_holding', $id_holding);
      $this->db->order_by('eo.orden', 'asc');
            
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();

          return false;
      }
  }

  function mostrar_sucursales2($id_holding){

    $this->db->select('e.id_empresa,s.id_sucursal,s.nombre_sucursal,s.estado');
    $this->db->from('empresa e');
    $this->db->join('sucursal s', 's.id_empresa = e.id_empresa');
    $this->db->where('e.estado', 1);
    $this->db->where('e.id_holding', $id_holding);
    $this->db->order_by('s.id_sucursal', 'asc');
          
    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();

        return false;
    }
}

    function mostrar_empresas_usuario_sin_em($idu){

      $this->db->select('e.id_empresa,e.nombre_empresa,e.casa_central,e.estado');
      $this->db->from('empresa e');
      $this->db->join('usuario_empresa u', 'u.id_empresa = e.id_empresa');
      $this->db->join('empresa_orden eo', 'e.id_empresa = eo.id_empresa');
      $this->db->where('e.casa_central', 0);
      $this->db->where('u.estado', 1);
      $this->db->where('u.id_usuario', $idu);
      $this->db->order_by('eo.orden', 'asc');

      $query = $this->db->get();

      if($query->num_rows() >  0){
          return $query->result();

          return false;
      }
  }

  function mostrar_empresas_usuario($idu){

      $this->db->select('e.id_empresa,e.nombre_empresa,e.casa_central,e.estado');
      $this->db->from('empresa e');
      $this->db->join('usuario_empresa u', 'u.id_empresa = e.id_empresa');
      $this->db->join('empresa_orden eo', 'e.id_empresa = eo.id_empresa');
      $this->db->where('u.estado', 1);
      $this->db->where('u.id_usuario', $idu);
      $this->db->order_by('eo.orden', 'asc');

      $query = $this->db->get();

      if($query->num_rows() >  0){
          return $query->result();

        }else{
          return false;
      }
  }

  function sucursales_empresa($idu,$ide){

    $this->db->select('e.id_empresa,s.nombre_sucursal,e.estado');
    $this->db->from('empresa e');
    $this->db->join('usuario_empresa u', 'u.id_empresa = e.id_empresa');
    //$this->db->join('empresa_orden eo', 'e.id_empresa = eo.id_empresa');
    $this->db->join('sucursal s', 's.id_empresa = e.id_empresa');
    $this->db->where('u.estado', 1);
    $this->db->where('u.id_usuario', $idu);
    $this->db->where('e.id_empresa', $ide);
    $this->db->order_by('s.id_sucursal', 'asc');

    $query = $this->db->get();

    if($query->num_rows() >  0){
        return $query->result();

      }else{
        return false;
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

  /*function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('id_empresa, casa_central,rut_empresa,nombre_empresa,logo_empresa,telefono_empresa,direccion_empresa,
    (SELECT COUNT(id_empresa) FROM sucursal s WHERE s.id_empresa = empresa.id_empresa) AS cant_suc, estado');
    //$this->db->order_by('e.orden', 'asc');
    $this->db->where('empresa.id_empresa_guarda',$id_empresa);
    $query = $this->db->get();  

    return $query->result();
  }*/

  //ESTA ES LA MISMA DE ARRIBA, PERO SIN LA SUCURSAL
  function get_datatables($id_h)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('empresa.id_empresa, casa_central,rut_empresa,nombre_empresa,logo_empresa,eo.orden,eo.mostrar,telefono_empresa,direccion_empresa,empresa.estado');
    //$this->db->order_by('e.orden', 'asc');
    $this->db->join('empresa_orden eo', 'empresa.id_empresa = eo.id_empresa');
    //$this->db->where('empresa.id_empresa_guarda',$id_empresa);
    $this->db->where('empresa.id_holding', $id_h);
    $this->db->order_by('eo.orden', 'asc');
    $query = $this->db->get();  

    return $query->result();
   
  }

  function mostrar_parametros()
  {

      $this->db->select('p.id_parametro, p.nombre_parametro, p.comentario_parametro, p.grupo_parametro, p.estado');
      $this->db->from('parametro p');
      $this->db->where('p.estado', 1);

      $query = $this->db->get();

      if($query->num_rows() >  0){

          return $query->result();

      }else{

          return false;
      }

  }

  function mostrar_parametros_dealle(){

    $this->db->select('p.id_parametro, p.nombre_parametro,pd.id_parametro_detalle, p.grupo_parametro, pd.opcion_parametro, pd.condicion, p.estado');
    $this->db->from('parametro p');
    $this->db->join('parametro_detalle pd', 'pd.id_parametro = p.id_parametro');
    $this->db->where('pd.estado', 1);
    $this->db->order_by('pd.id_parametro_detalle', 'asc');
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
		$this->db->where('id_empresa',$id);
		$query = $this->db->get();

		return $query->row();
	}

  public function get_by_param($id){

    $this->db->select('*');
    //$this->db->from('parametro p');
    $this->db->from('parametro_detalle pd');
    //$this->db->join('parametro_detalle pd', 'pd.id_parametro = p.id_parametro');
    $this->db->join('empresa_parametro ep', 'ep.id_parametro_detalle = pd.id_parametro_detalle');
    $this->db->where('ep.id_empresa',$id);
    $this->db->where('pd.estado', 1);

    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
  }
  
  public function get_by_serv($id){
    $this->db->select('es.nombre_servicio, es.estado');
    $this->db->from($this->table);
    $this->db->join('empresa_servicio es', 'es.id_empresa = empresa.id_empresa');
    $this->db->where('empresa.id_empresa',$id);
    $this->db->where('empresa.estado', 1);

    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
	}

  function count_filtered($id_holding)
  {
    $this->_get_datatables_query();
    $this->db->select('empresa.id_empresa, casa_central,rut_empresa,nombre_empresa,logo_empresa,eo.orden,eo.mostrar,telefono_empresa,direccion_empresa,empresa.estado');
    //$this->db->order_by('e.orden', 'asc');
    $this->db->join('empresa_orden eo', 'empresa.id_empresa = eo.id_empresa');
    //$this->db->where('empresa.id_empresa_guarda',$id_empresa);
    $this->db->where('empresa.id_holding', $id_holding);
    $this->db->order_by('eo.orden', 'asc');
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_holding)
  {
    $this->db->from($this->table);
    $this->db->select('empresa.id_empresa, casa_central,rut_empresa,nombre_empresa,logo_empresa,eo.orden,eo.mostrar,telefono_empresa,direccion_empresa,empresa.estado');
    //$this->db->order_by('e.orden', 'asc');
    $this->db->join('empresa_orden eo', 'empresa.id_empresa = eo.id_empresa');
    //$this->db->where('empresa.id_empresa_guarda',$id_empresa);
    $this->db->where('empresa.id_holding', $id_holding);
    $this->db->order_by('eo.orden', 'asc');
    return $this->db->count_all_results();
  }

  public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

  function guarda_empresa($data)
	{
    $this->db->insert($this->table, array(
    'id_holding'=>$data['id_holding'],
    'rut_empresa'=>$data['rut_empresa'],
    'casa_central'=>$data['casa_central'],
    'nombre_empresa'=>$data['nombre_empresa'],
    'logo_empresa'=>$data['logo_empresa'],
    'telefono_empresa'=>$data['telefono_empresa'],
    'direccion_empresa'=>$data['direccion_empresa'],
    'usuario_guarda'=>$data['usuario_guarda'],
    'fecha_guarda'=>$data['fecha_guarda'],
    'estado'=>$data['estado']));

    $id_empresa_insert = $this->db->insert_id();

    $this->db->insert('empresa_orden', array(
    'id_holding'=>$data['id_holding'],
    'id_empresa'=>$id_empresa_insert,
    'orden'=>get_ultimo_eo_orden(),
    'mostrar'=>get_ultimo_eo_mostrar(),
    'usuario_guarda'=>$data['usuario_guarda'],
    'fecha_guarda'=>$data['fecha_guarda'],
    'estado'=>$data['estado']));
/*
    $permisos = array(100,101,102,200,201,300,301,302,303,304,305,306,307,308,309,310,311,400,401,402,403,404,405,406,407,408,409,410,500,600,601,602,604,605,606,607,608,609,610,611,612,613,700);
    
    foreach($permisos as $permiso){

      $this->db->insert(
          'usuario_permiso',
          array(
            'id_usuario' => $this->session->userdata('id_usuario'),
            'id_empresa' => $id_empresa_insert,
            'codigo_permiso' => $permiso,                  
            'usuario_guarda '=> $data['usuario_guarda'],
            'fecha_guarda' => date("Y-m-d H:i:s")
            )
          );
    }
*/
    $parametros = array(1, 24);

        foreach($parametros as $parametro){

            $this->db->insert(
                'empresa_parametro',
                array(
                    'id_empresa' => $id_empresa_insert,
                    'id_parametro_detalle' => $parametro,
                    'usuario_guarda'=> $data['usuario_guarda'],
                    'fecha_guarda'=>date("Y-m-d H:i:s")
                )
                );        
        }

        $data_registro_empresa = array(
          'id_empresa' => $id_empresa_insert,
          'tipo_registro_id' => 0,
          'usuario_guarda'=> $data['usuario_guarda'],
          'fecha_guarda'=>date("Y-m-d H:i:s")
      );

      $this->db->insert('tipo_registro_empresa', $data_registro_empresa);
	}

  function save_param($data){

    $this->db->delete('empresa_parametro', array('id_empresa' => $data['id_empresa']));

    foreach($data['id_parametro_detalle'] as $valor=>$cat)
      $this->db->insert(
        'empresa_parametro',
        array(
          'id_empresa_guarda'=>$data['id_empresa_guarda'],
          'id_empresa'=>$data['id_empresa'],
          'id_parametro_detalle'=>$cat,
          'usuario_guarda'=>$data['usuario_guarda'],
          'fecha_guarda'=>$data['fecha_guarda'],
          'estado'=>1
          )
        );
  }

  function save_orden($data){
    
    $this->db->delete('empresa_orden', array('estado' => 1));

    //$m=1;
    foreach($data['id_empresa'] as $valor => $cat){

      $this->db->insert('empresa_orden', array(
        'id_empresa' => $valor,
        'orden'=>$cat,
        'mostrar'=>$cat+1,
        'id_empresa_guarda'=>$data['id_empresa_guarda'],
        'usuario_guarda'=>$data['usuario_guarda'],
        'fecha_guarda'=>$data['fecha_guarda'],        
        'estado'=>1
      ));
    //$m++;
    }
  }

  function update_param($where, $data)
  {
    $this->db->update('empresa_parametro', $data, $where);
    return $this->db->affected_rows();
  }

  public function get_casa_central_exists($hold)
  {
//    $this->db->select('count(*)'); 
    $this->db->from($this->table);
    $this->db->where('id_holding', $hold);
    $this->db->where('casa_central',1);
    $query = $this->db->get();

    if($query->num_rows() >  0){
        return true;
    }else{
        return false;
    }
  }

  function devuelveParametrosDefault(){
    $this->db->select('id_parametro_detalle');
    $this->db->group_by('id_parametro_detalle');
    $Q = $this->db->get('parametro_detalle');
    if($Q->num_rows() >  0){
        return $Q->result();
    }else{
        return false;
    }

        /*
    $this->db->select('pd.id_parametro_detalle, pd.id_parametro, pd.valor_parametro, pd.estado');
    $this->db->from('parametro_detalle pd');
    $this->db->where('pd.estado', 1);
    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }*/
  }

}
