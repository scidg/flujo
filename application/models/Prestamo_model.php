<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prestamo_model extends CI_Model
{

  var $table = 'prestamo';
  var $column = array('id_prestamo','nombre_prestamo','fecha_colocacion','tasa','monto_solicitado','cuotas','estado');
  var $order = array('id_prestamo' => 'asc');

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
    $this->db->select('id_prestamo,nombre_prestamo,DATE_FORMAT(fecha_colocacion, "%d-%m-%Y") as fecha_colocacion,tasa,monto_solicitado,cuotas,pie,valor_cuota,id_moneda,estado,id_cuenta,id_subcuenta');
    $this->db->where('id_empresa',$id_empresa);
    $this->db->order_by('id_prestamo', 'asc');
    $query = $this->db->get();  

    return $query->result();
   
  }

  public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_prestamo',$id);
		$query = $this->db->get();

		return $query->row();
	}

  public function get_by_param($id){

    $this->db->select('*');
    //$this->db->from('parametro p');
    $this->db->from('parametro_detalle pd');
    //$this->db->join('parametro_detalle pd', 'pd.id_parametro = p.id_parametro');
    $this->db->join('empresa_parametro ep','ep.id_parametro_detalle = pd.id_parametro_detalle');
    $this->db->where('ep.id_empresa',$id);
    $this->db->where('pd.estado', 1);

    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
  }
  
  function muestra_cuenta_prestamo($id_empresa)
  {
    $this->db->select('c.id_cuenta,c.nombre_cuenta,c.estado');
    $this->db->from('cuenta c');
    $this->db->where('c.estado', 1);
    //$this->db->where('c.mostrar_calendario', 1);
    $this->db->where('c.tipo_movimiento', 2);
    $this->db->where('c.cuenta_prestamo', 1);
    $this->db->where('c.id_empresa_guarda',$id_empresa);
    $this->db->order_by('c.cuenta_prestamo','asc');
    $this->db->order_by('c.id_cuenta','asc');
    $query = $this->db->get();
    return $query->result();
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

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('id_prestamo, nombre_prestamo,fecha_colocacion,tasa,monto_solicitado,estado');
    $this->db->where('id_empresa',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('id_prestamo, nombre_prestamo,fecha_colocacion,tasa,monto_solicitado,cuotas,estado');
    $this->db->where('id_empresa',$id_empresa);
    return $this->db->count_all_results();
  }

  public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

  function guarda_prestamo($data)
	{
    $this->db->insert($this->table, 
    array('id_cuenta'=>$data['id_cuenta'],
    'id_subcuenta'=>$data['id_subcuenta'],
    'id_empresa'=>$data['id_empresa'],
    'nombre_prestamo'=>$data['nombre_prestamo'],
    'fecha_colocacion'=>$data['fecha_colocacion'],
    'tasa'=>$data['tasa'],
    'monto_solicitado'=>$data['monto_solicitado'],
    'id_moneda'=>$data['id_moneda'],
    'pie'=>$data['pie'],
    'valor_cuota'=>$data['valor_cuota'],
    'cuotas'=>$data['cuotas'],
    //'dia_vencimiento'=>$data['dia_vencimiento'],
    'observacion'=>$data['observacion'],
    'usuario_guarda'=>$data['usuario_guarda'],
    'fecha_guarda'=>$data['fecha_guarda'],
    'estado'=>$data['estado']
    
    ));

	}

  public function mostrar_en_calendario($where, $data)
{
  $this->db->update('cuenta', $data, $where);
  return $this->db->affected_rows();
}

  function guarda_prestamo_subcuenta($data){

    $this->db->trans_start();
    $this->db->insert('subcuenta', $data);

    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;

}

  function guarda_prestamo_mov($data){
    
    $cuotas = $data['cuotas'];

    for($m=0;$m<$cuotas;$m++){
        
        $fecha_ingreso = $data['fecha_ingreso'];
        $fecha_ingreso_save = date("Y-m-d", strtotime($fecha_ingreso . "+ ".$m." month"));

        $this->db->insert('movimiento', array(
        'id_tipo_movimiento'=>$data['id_tipo_movimiento'],
        'id_empresa_guarda'=>$data['id_empresa_guarda'],
        'id_cuenta'=>$data['id_cuenta'],
        'id_subcuenta'=>$data['id_subcuenta'],
        'fecha_registro'=>$data['fecha_registro'],
        'usuario_guarda'=>$data['usuario_guarda'],
        'fecha_guarda'=>$data['fecha_guarda'],
        'estado'=>$data['estado']));  
        
        $id_movimiento = $this->db->insert_id();
        
          $this->db->insert(
            'movimiento_detalle',
            array(
              'id_movimiento'=>$id_movimiento,
              'id_tipo_documento'=>$data['id_tipo_documento'],
              'numero_tipo_documento'=>$data['numero_tipo_documento'],
              'monto'=>$data['valor_cuota'],
              'monto_nota_credito'=>$data['monto_nota_credito'],
              'monto_cuenta_banco'=>$data['monto_cuenta_banco'],
              'monto_cuenta_prestamo'=>0,//$data['valor_cuota'],
              'fecha_ingreso'=>$fecha_ingreso_save,
              'fecha_pago'=>$data['fecha_pago'],
              'mes_iva'=>$data['mes_iva'],
              'año_iva'=>$data['año_iva'],
              'id_tipo_estado_movimiento'=>$data['id_tipo_estado_movimiento'],
              'id_banco'=>$data['id_banco'],
              'id_condicion_pago'=>$data['id_condicion_pago'],
              'numero_voucher'=>$data['numero_voucher'],
              'observaciones'=>$data['observaciones'],
              'usuario_guarda'=>$data['usuario_guarda'],
              'fecha_guarda'=>$data['fecha_guarda']
              )
            );
          }
   
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

  public function get_empresa_madre_exists($hold)
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
