<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ingreso_model extends CI_Model
{
  var $table = 'movimiento';
  var $column = array('id_movimiento', 'nombre_cuenta', 'nombre_subcuenta', 'movimiento.fecha_registro', 'movimiento.estado');
  var $order = array('id_movimiento' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
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

  public function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('movimiento.id_movimiento, nombre_cuenta, movimiento.id_subcuenta, nombre_subcuenta, movimiento.fecha_registro, movimiento.estado');
    $this->db->join('cuenta c', 'c.id_cuenta = movimiento.id_cuenta');
    $this->db->join('subcuenta sc', 'sc.id_subcuenta = movimiento.id_subcuenta');
    $this->db->where('movimiento.id_empresa_guarda', $id_empresa);
    $this->db->where('movimiento.id_tipo_movimiento', 1);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_detalle_ingreso($id_movimiento)
  {
    $this->db->select('m.id_movimiento, nombre_cuenta, m.id_subcuenta, nombre_subcuenta, md.monto, md.monto_cuenta_banco, DATE_FORMAT(md.fecha_ingreso, "%d-%m-%Y") as fecha_ingreso, m.estado, nombre_tipo_estado_movimiento');
    $this->db->from('movimiento m');
    $this->db->join('movimiento_detalle md', 'm.id_movimiento = md.id_movimiento');
    $this->db->join('cuenta c', 'c.id_cuenta = m.id_cuenta');
    $this->db->join('subcuenta sc', 'sc.id_subcuenta = m.id_subcuenta');
    $this->db->join('tipo_estado_movimiento tem', 'tem.id_tipo_estado_movimiento = md.id_tipo_estado_movimiento');
    $this->db->where('m.id_movimiento', $id_movimiento);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('movimiento.id_movimiento, nombre_cuenta, movimiento.id_subcuenta, nombre_subcuenta, movimiento.fecha_registro, movimiento.estado');
    $this->db->join('cuenta c', 'c.id_cuenta = movimiento.id_cuenta');
    $this->db->join('subcuenta sc', 'sc.id_subcuenta = movimiento.id_subcuenta');
    $this->db->where('movimiento.id_empresa_guarda', $id_empresa);
    $this->db->where('movimiento.id_tipo_movimiento', 1);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('movimiento.id_movimiento, nombre_cuenta, movimiento.id_subcuenta, nombre_subcuenta, movimiento.fecha_registro, movimiento.estado');
    $this->db->join('cuenta c', 'c.id_cuenta = movimiento.id_cuenta');
    $this->db->join('subcuenta sc', 'sc.id_subcuenta = movimiento.id_subcuenta');
    $this->db->where('movimiento.id_empresa_guarda', $id_empresa);
    $this->db->where('movimiento.id_tipo_movimiento', 1);
    return $this->db->count_all_results();
  }

      public function devuelve_ultimo_id_ingreso()
      {
      $this->db->select_max('id_movimiento');
        	$Q = $this->db->get('movimiento');
        	$row = $Q->row_array();
        	return $row['id_movimiento'] + 1;

      }

      public function trae_ingresos($id_empresa)
      {
        $this->db->select('m.id_movimiento,m.id_tipo_movimiento');
        $this->db->from('movimiento m');
        $this->db->where('m.id_tipo_movimiento', 1);
        $this->db->where('m.id_empresa_guarda',$id_empresa);
        $query = $this->db->get();

        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function data_movimiento($id_movimiento)
      {
        $this->db->select('m.id_movimiento,md.id_movimiento_detalle,
        m.fecha_registro,m.id_tipo_movimiento,m.id_empresa_guarda,m.id_cuenta,nombre_cuenta,cuenta_banco,monto_cuenta_banco,
        m.id_subcuenta,nombre_subcuenta,md.id_tipo_documento,nombre_tipo_documento,con_iva,es_nota_credito,es_obligatorio,md.numero_tipo_documento,
        md.monto,md.monto_nota_credito,md.fecha_ingreso,md.fecha_pago,md.mes_iva,md.año_iva,md.id_tipo_estado_movimiento,
        nombre_tipo_estado_movimiento,md.id_banco,nombre_banco,md.id_condicion_pago,nombre_condicion_pago,
        md.numero_voucher,md.observaciones');
        $this->db->from('movimiento m');
        $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
        $this->db->join('cuenta c', 'c.id_cuenta = m.id_cuenta');
        $this->db->join('subcuenta sc', 'sc.id_subcuenta = m.id_subcuenta');
        $this->db->join('tipo_documento tp', 'tp.id_tipo_documento = md.id_tipo_documento','left');
        $this->db->join('banco b', 'b.id_banco = md.id_banco','left');
        $this->db->join('condicion_pago cp', 'cp.id_condicion_pago = md.id_condicion_pago','left');
        $this->db->join('tipo_estado_movimiento tem', 'tem.id_tipo_estado_movimiento = md.id_tipo_estado_movimiento');

        /*$this->db->group_start();
          $this->db->group_start();
          $this->db->where('md.fecha_ingreso >=', $fi);
          $this->db->where('md.fecha_ingreso <=', $ft);
          $this->db->group_end();
          $this->db->or_group_start();
          $this->db->where('md.fecha_pago >=', $fi);
          $this->db->where('md.fecha_pago <=', $ft);
          $this->db->group_end();
        $this->db->group_end();*/

        /*
        $this->db->group_start();
        $this->db->where('md.fecha_ingreso >=', $fi);
        $this->db->where('md.fecha_ingreso <=', $ft);
        $this->db->group_end();
        $this->db->or_group_start();
        $this->db->where('md.fecha_pago >=', $fi);
        $this->db->where('md.fecha_pago <=', $ft);
        $this->db->group_end();
        */

        /*
        $this->db->where('md.fecha_ingreso >=', $fi);
        $this->db->where('md.fecha_ingreso <=', $ft); 
        */       
        $this->db->where('m.id_movimiento',$id_movimiento);


        $this->db->order_by('md.id_movimiento_detalle ', 'ASC');

        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function data_movimiento_sinrango($id_movimiento,$fi,$ft)
      {
        $this->db->select('m.id_movimiento,md.id_movimiento_detalle,
        m.fecha_registro,m.id_tipo_movimiento,m.id_empresa_guarda,m.id_cuenta,nombre_cuenta,cuenta_banco,monto_cuenta_banco,
        m.id_subcuenta,nombre_subcuenta,md.id_tipo_documento,nombre_tipo_documento,con_iva,es_nota_credito,es_obligatorio,md.numero_tipo_documento,
        md.monto,md.monto_nota_credito,md.fecha_ingreso,md.fecha_pago,md.mes_iva,md.año_iva,md.id_tipo_estado_movimiento,
        nombre_tipo_estado_movimiento,md.id_banco,nombre_banco,md.id_condicion_pago,nombre_condicion_pago,
        md.numero_voucher,md.observaciones');
        $this->db->from('movimiento m');
        $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
        $this->db->join('cuenta c', 'c.id_cuenta = m.id_cuenta');
        $this->db->join('subcuenta sc', 'sc.id_subcuenta = m.id_subcuenta');
        $this->db->join('tipo_documento tp', 'tp.id_tipo_documento = md.id_tipo_documento','left');
        $this->db->join('banco b', 'b.id_banco = md.id_banco','left');
        $this->db->join('condicion_pago cp', 'cp.id_condicion_pago = md.id_condicion_pago','left');
        $this->db->join('tipo_estado_movimiento tem', 'tem.id_tipo_estado_movimiento = md.id_tipo_estado_movimiento');
        $this->db->where('m.id_movimiento',$id_movimiento);
        $this->db->order_by('md.id_movimiento_detalle ', 'ASC');

        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function trae_subcuentas($id_cuenta)
      {
        $this->db->where('id_cuenta',$id_cuenta);
        $subcuentas = $this->db->get('subcuenta');
        if($subcuentas->num_rows()>0)
        {
        return $subcuentas->result();
        }
      }

      public function trae_estado_movimiento()
      {
        $this->db->select('tem.id_tipo_estado_movimiento, tem.nombre_tipo_estado_movimiento, tem.estado');
        $this->db->from('tipo_estado_movimiento tem');
        $this->db->where('tem.estado', 1);
        $query = $this->db->get();

        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }


      function mostrar_condicion_pago($id_empresa){
          $this->db->select('cp.id_condicion_pago, cp.nombre_condicion_pago, cp.estado');
          $this->db->from('condicion_pago cp');
          $this->db->where('cp.estado', 1);
          $this->db->where('cp.id_empresa_guarda',$id_empresa);
          $query = $this->db->get();
          if($query->num_rows() >  0){
              return $query->result();
          }else{
              return false;
          }
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

      function muestra_tipo_documento($id_empresa)
      {
        $this->db->select('td.id_tipo_documento,td.nombre_tipo_documento,td.con_iva,td.estado');
        $this->db->from('tipo_documento td');
        $this->db->where('td.estado', 1);
        $this->db->where('td.id_empresa_guarda',$id_empresa);
        $query = $this->db->get();
        return $query->result();
      }

      function muestra_cuenta($id_empresa)
      {
        $this->db->select('c.id_cuenta,c.nombre_cuenta,c.estado');
        $this->db->from('cuenta c');

        //HAmestica: Ordenar cuentas segun table cuenta_orden
        $this->db->join('cuenta_orden co','c.id_cuenta=co.id_cuenta','left');

        $this->db->where('c.estado', 1);
        $this->db->where('c.mostrar_calendario', 1);
        $this->db->where('c.tipo_movimiento', 1);
        $this->db->where('c.id_empresa_guarda',$id_empresa);
        
        //HAmestica: Ordenar cuentas segun table cuenta_orden
        //$this->db->order_by('c.cuenta_banco','asc');
        //$this->db->order_by('c.id_cuenta','asc');
        $this->db->order_by('co.orden','asc');

        $query = $this->db->get();
        return $query->result();
      }

      //HAmestica: ordenar sub cuentas según lo seleccionado en la view
      //function muestra_subcuenta($id_empresa)
      function muestra_subcuenta($id_empresa,$orden,$direccion,$fecha_ini,$fecha_fin)
      {
        // $this->db->select('s.id_cuenta,s.id_subcuenta,s.nombre_subcuenta,s.estado');
        // $this->db->from('subcuenta s');
        // $this->db->where('s.estado', 1);
        // $this->db->where('s.tipo_movimiento', 1);
        // $this->db->where('s.id_empresa_guarda',$id_empresa);
        // $this->db->order_by('s.id_cuenta','asc');
        // $query = $this->db->get();
        // return $query->result();

        if($orden=='subcuenta'){
          $this->db->select('s.id_cuenta,s.id_subcuenta,s.nombre_subcuenta,s.estado');
          $this->db->from('subcuenta s');
          $this->db->where('s.estado', 1);
          $this->db->where('s.tipo_movimiento', 1);
          $this->db->where('s.id_empresa_guarda',$id_empresa);
          $this->db->order_by('s.nombre_subcuenta',$direccion);
          $query = $this->db->get();
          return $query->result();
        }

        if($orden=='semana'){
          $query=$this->db->query("select
                                      subcue.id_cuenta,subcue.id_subcuenta,
                                      subcue.nombre_subcuenta,
                                      subcue.monto_gas_proy,subcue.estado,
                                      SUM(ifnull(mov_det.Monto,0)) AS Monto,
                                      cueord.Orden AS cuenta_orden
                                    FROM subcuenta subcue
                                      LEFT OUTER JOIN movimiento mov
                                      ON(mov.id_subcuenta=subcue.id_subcuenta)
                                      LEFT OUTER JOIN movimiento_detalle mov_det
                                      ON(mov_det.id_movimiento = mov.id_movimiento)
                                      INNER JOIN cuenta_orden cueord
                                      ON(subcue.id_cuenta=cueord.id_cuenta)
                                    WHERE subcue.estado=1
                                      AND subcue.tipo_movimiento=1
                                      AND subcue.id_empresa_guarda='".$id_empresa."'
                                      AND (mov_det.fecha_ingreso >= '".$fecha_ini."' and mov_det.fecha_ingreso <= '".$fecha_fin."')
                                    GROUP BY subcue.nombre_subcuenta,subcue.monto_gas_proy,subcue.estado,
                                      mov.id_cuenta,mov.id_subcuenta
                                    UNION
                                    SELECT
                                      s.id_cuenta,s.id_subcuenta,
                                      s.nombre_subcuenta,
                                      s.monto_gas_proy,s.estado,
                                      0 as Monto,
                                      cueord.Orden AS cuenta_orden
                                    FROM subcuenta s
                                      INNER JOIN cuenta_orden cueord
                                      ON(s.id_cuenta=cueord.id_cuenta)
                                    WHERE s.estado=1
                                      AND s.tipo_movimiento=1
                                      AND s.id_empresa_guarda='".$id_empresa."'
                                      AND s.id_subcuenta NOT IN(
                                        SELECT
                                          subcue.id_subcuenta
                                        FROM subcuenta subcue
                                          LEFT OUTER JOIN movimiento mov
                                          ON(mov.id_subcuenta=subcue.id_subcuenta)
                                          LEFT OUTER JOIN movimiento_detalle mov_det
                                          ON(mov_det.id_movimiento = mov.id_movimiento)
                                        WHERE subcue.estado=1
                                          AND subcue.tipo_movimiento=1
                                          AND subcue.id_empresa_guarda='".$id_empresa."'
                                          AND (mov_det.fecha_ingreso >= '".$fecha_ini."' and mov_det.fecha_ingreso <= '".$fecha_fin."')
                                        GROUP BY subcue.nombre_subcuenta,subcue.monto_gas_proy,subcue.estado,
                                          mov.id_cuenta,mov.id_subcuenta
                                      )
                                    ORDER BY cuenta_orden ASC,Monto ".$direccion.",nombre_subcuenta ASC
            ");
          
          // $SP_subcuenta_orden_movimientos_semana="CALL SP_subcuenta_orden_movimientos_semana(?,?,?,?)";
          // $query=$this->db->query($SP_subcuenta_orden_movimientos_semana,array('v_id_empresa_guarda'=>$id_empresa,'v_fec_ini'=>$fecha_ini,'v_fec_fin'=>$fecha_fin,'v_orden'=>$direccion));
          $res=$query->result();
    
          // $query->next_result();
          // $query->free_result();
          
          return $res;
        }
      }

      function muestra_cuenta_ingreso($id_empresa)
      {
        $this->db->select('c.id_cuenta,c.nombre_cuenta,c.estado');
        $this->db->from('cuenta c');
        $this->db->where('c.estado', 1);
        $this->db->where('c.id_empresa_guarda',$id_empresa);
        $this->db->order_by('c.cuenta_banco','asc');
        $query = $this->db->get();
        return $query->result();
      }

      function guarda($data){

        $this->db->insert('movimiento', array('id_tipo_movimiento'=>$data['id_tipo_movimiento'],
        'id_empresa_guarda'=>$data['id_empresa_guarda'],
        'id_cuenta'=>$data['id_cuenta'],
        'id_subcuenta'=>$data['id_subcuenta'],
        'fecha_registro'=>$data['fecha_registro'],
        'usuario_guarda'=>$data['usuario_guarda'],
        'fecha_guarda'=>$data['fecha_guarda'],
        'estado'=>$data['estado']));

        $id_movimiento = $this->db->insert_id();

        $cant_mov = '';
        $cuenta_banco = $data['cuenta_banco'];
        

        if($cuenta_banco == 1){
          $cant_mov= 1;
        }else {
          $cant_mov=count($data['id_tipo_documento']);
        }
        //echo $cant_mov;

        for($m=0;$m<$cant_mov;$m++){

          $this->db->insert(
            'movimiento_detalle',
            array(
              'id_movimiento'=>$id_movimiento,
              'id_tipo_documento'=>$data['id_tipo_documento'][$m],
              'numero_tipo_documento'=>$data['numero_tipo_documento'][$m],
              'monto'=>$data['monto'][$m],
              'monto_nota_credito'=>$data['monto_nota_credito'][$m],
              'monto_cuenta_banco'=>$data['monto_cuenta_banco'],
              'fecha_ingreso'=>fecha_ingles($data['fecha_ingreso'][$m]),
              'fecha_pago'=>fecha_ingles($data['fecha_pago'][$m]),
              'mes_iva'=>$data['mes_iva'][$m],
              'año_iva'=>$data['año_iva'][$m],
              'id_tipo_estado_movimiento'=>$data['id_tipo_estado_movimiento'][$m],
              'id_banco'=>$data['id_banco'][$m],
              'id_condicion_pago'=>$data['id_condicion_pago'][$m],
              'numero_voucher'=>$data['numero_voucher'][$m],
              'observaciones'=>$data['observaciones'][$m],
              'usuario_guarda'=>$data['usuario_guarda'],
              'fecha_guarda'=>$data['fecha_guarda']
              )
            );

        }
   
    }

    public function consulta_movimiento($data)
    {
      $this->db->select('m.id_movimiento,md.id_movimiento_detalle,md.id_tipo_estado_movimiento,md.monto,md.fecha_ingreso,md.fecha_pago,color_tipo_documento,es_prioritario,monto_cuenta_banco,monto_nota_credito,nombre_tipo_documento, md.numero_tipo_documento,nombre_tipo_estado_movimiento');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento', 'left');
      $this->db->join('tipo_estado_movimiento tem', 'tem.id_tipo_estado_movimiento  = md.id_tipo_estado_movimiento', 'left');
      $this->db->join('tipo_documento td', 'td.id_tipo_documento  = md.id_tipo_documento', 'left');

      /*
      $this->db->group_start();
      $this->db->where('md.fecha_ingreso >=', $data['fi']);
      $this->db->where('md.fecha_ingreso <=', $data['ft']);
      $this->db->group_end();
      $this->db->or_group_start();
      $this->db->where('md.fecha_pago >=', $data['fi']);
      $this->db->where('md.fecha_pago <=', $data['ft']);
      $this->db->group_end();
      */

      $this->db->group_start();
        $this->db->group_start();
        $this->db->where('md.fecha_ingreso >=', $data['fi']);
        $this->db->where('md.fecha_ingreso <=', $data['ft']);
        $this->db->group_end();
        $this->db->or_group_start();
        $this->db->where('md.fecha_pago >=', $data['fi']);
        $this->db->where('md.fecha_pago <=', $data['ft']);
        $this->db->group_end();
      $this->db->group_end();
      


      
      $this->db->where('m.id_cuenta',$data['idc']);
      $this->db->where('m.id_subcuenta',$data['ids']);
      $this->db->where('m.id_tipo_movimiento',$data['id_tipo_movimiento']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      $this->db->where('m.estado',1);
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }
    }

    public function consulta_res_ing($data)
    {
      $this->db->select_sum('md.monto', 'monto_resumen_ingreso');
      $this->db->select_sum('md.monto_cuenta_banco', 'monto_cuenta_banco');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
      $this->db->where('md.fecha_ingreso >=', $data['fi']);
      $this->db->where('md.fecha_ingreso <=', $data['ft']);
      $this->db->where('m.id_tipo_movimiento',$data['id_tipo_movimiento']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      $this->db->where('md.id_tipo_estado_movimiento', 2);
      $this->db->where('m.estado',1);
      $query = $this->db->get();
      if($query->num_rows() >  0){
        return $query->result();
      }else{
          return false;
      }
    }

    function guarda_servicio_quincena($data){


      $this->db->trans_start();
      
      

      $cantidad_servicios=$data['cantidad_servicios1'];

      for($q=0;$q<$cantidad_servicios;$q++){

          $this->db->delete('venta', 
              array('id_servicio' => $data['id_servicio'][$q],'id_ano' => $data['ano'], 'id_mes' => $data['mes'],'id_empresa_guarda' => $data['id_empresa_guarda'])
          );

          $this->db->insert(
            'venta',
            array(
              'lunes_quincena'=>fecha_ingles($data['fecha_quincena1']),
              'id_ano'=>$data['ano'],
              'id_mes'=>$data['mes'],
              'monto_quincena'=>$data['monto_servicio'][$q],            
              'id_servicio'=>$data['id_servicio'][$q],            
              'id_quincena'=>$data['id_quiencena'],            
              'id_empresa_guarda'=>$data['id_empresa_guarda'],
              'usuario_guarda'=>$data['usuario_guarda'],
              'fecha_guarda'=>$data['fecha_guarda'],
              'estado'=>$data['estado']

            )
          );

      }
                
      $insert_id = $this->db->insert_id();

      $this->db->trans_complete();

      return $insert_id;
  
  }

  function guarda_servicio_quincena2($data){


    $this->db->trans_start();

    $cantidad_servicios=$data['cantidad_servicios2'];

    for($q=0;$q<$cantidad_servicios;$q++){

        $this->db->delete('venta', 
            array('id_servicio' => $data['id_servicio'][$q],'id_ano' => $data['ano'], 'id_mes' => $data['mes'],'id_empresa_guarda' => $data['id_empresa_guarda'])
        );

        $this->db->insert(
          'venta',
          array(
            'lunes_quincena'=>fecha_ingles($data['fecha_quincena2']),
            'id_ano'=>$data['ano'],
            'id_mes'=>$data['mes'],
            'monto_quincena'=>$data['monto_servicio'][$q],            
            'id_servicio'=>$data['id_servicio'][$q],            
            'id_quincena'=>$data['id_quiencena'],            
            'id_empresa_guarda'=>$data['id_empresa_guarda'],
            'usuario_guarda'=>$data['usuario_guarda'],
            'fecha_guarda'=>$data['fecha_guarda'],
            'estado'=>$data['estado']

          )
        );

    }
              
    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;

}
  public function devuelve_servicio_mostrar($data)
  {
    $this->db->select('t.monto_quincena,t.id_mes,t.id_ano,t.id_servicio,t.id_empresa_guarda,t.id_quincena,t.usuario_guarda,t.fecha_guarda');
    $this->db->from('venta t');
    $this->db->where('t.id_empresa_guarda', $data['id_empresa_guarda']);
    $this->db->where('t.id_mes', $data['mes']);
    $this->db->where('t.id_ano', $data['ano']);
    //$this->db->where('t.id_quiencena', $data['id_quincena']);
    $this->db->where('t.id_servicio', $data['id_servicio']);
    $this->db->where('t.estado', 1);

    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
  }

    public function devuelve_servicio_editar($data)
    {
      $this->db->select('t.monto_quincena,t.id_mes,t.id_ano,t.id_servicio,t.id_empresa_guarda,t.lunes_quincena');
      $this->db->from('venta t');
      $this->db->where('t.id_empresa_guarda', $data['id_empresa_guarda']);
      $this->db->where('t.id_mes', $data['mes']);
      $this->db->where('t.id_ano', $data['ano']);
      $this->db->where('t.id_quincena', $data['id_quincena']);
      //$this->db->where('t.id_servicio', $data['id_servicio']);
      $this->db->where('t.estado', 1);

      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }
    }

    public function consulta_res_egr($data)
    {
      $this->db->select_sum('md.monto', 'monto_resumen_egreso');
      $this->db->select_sum('md.monto_cuenta_banco', 'monto_cuenta_banco');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
      $this->db->where('md.fecha_ingreso >=', $data['fi']);
      $this->db->where('md.fecha_ingreso <=', $data['ft']);
      $this->db->where('m.id_tipo_movimiento',$data['id_tipo_movimiento']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      $this->db->where('md.id_tipo_estado_movimiento', 2);
      $this->db->where('m.estado',1);
      $query = $this->db->get();
      if($query->num_rows() >  0){
        return $query->result();
      }else{
          return false;
      }
    }

    public function sum_consulta_ingreso_total($data)
    {
      
      /*$this->db->select_sum('md.monto', 'monto_total_sem');
      $this->db->select_sum('md.monto_cuenta_banco', 'monto_banco_total_sem');
      $this->db->select_sum('md.monto_nota_credito', 'monto_nota_credito_total_sem');*/
      $this->db->select('md.monto,md.monto_cuenta_banco,md.monto_nota_credito,md.id_tipo_estado_movimiento');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
      $this->db->join('subcuenta s', 's.id_subcuenta = m.id_subcuenta');
      $this->db->join('cuenta c', 'c.id_cuenta = m.id_cuenta');
      $this->db->where('s.estado',1);
      $this->db->where('c.estado',1);
      $this->db->where('md.fecha_ingreso >=', '2015-01-01');
      $this->db->where('md.fecha_ingreso <', $data['ft']);
      $this->db->where('m.id_tipo_movimiento',$data['id_tipo_movimiento']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      $this->db->where('md.id_tipo_estado_movimiento', 2);
      //var_dump($this->db);
      $this->db->where('m.estado',1);
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }
    }
    
    public function consulta_ingreso_total($data)
    {
      
      /*$this->db->select_sum('md.monto', 'monto_total_sem');
      $this->db->select_sum('md.monto_cuenta_banco', 'monto_banco_total_sem');
      $this->db->select_sum('md.monto_nota_credito', 'monto_nota_credito_total_sem');*/
      $this->db->select('md.monto,md.monto_cuenta_banco,md.monto_nota_credito,md.id_tipo_estado_movimiento');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
      $this->db->join('subcuenta s', 's.id_subcuenta = m.id_subcuenta');
      $this->db->join('cuenta c', 'c.id_cuenta = m.id_cuenta');
      $this->db->where('s.estado',1);
      $this->db->where('c.estado',1);
      $this->db->where('md.fecha_ingreso >=', $data['fi']);
      $this->db->where('md.fecha_ingreso <=', $data['ft']);
      $this->db->where('m.id_tipo_movimiento',$data['id_tipo_movimiento']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      //$this->db->where('md.id_tipo_estado_movimiento', 2);
      //echo '<pre>';
      //var_dump($this->db);
      $this->db->where('m.estado',1);
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }
    }

    public function consulta_ingreso_acum($data)
    {
      $this->db->select_sum('md.monto', 'monto_total_sem');
      $this->db->select_sum('md.monto_cuenta_banco', 'monto_banco_total_sem');
      $this->db->select_sum('md.monto_nota_credito', 'monto_nota_credito_total_sem');
      //$this->db->select('md.monto,md.monto_cuenta_banco,md.monto_nota_credito,md.id_tipo_estado_movimiento');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
      $this->db->join('subcuenta s', 's.id_subcuenta = m.id_subcuenta');
      $this->db->join('cuenta c', 'c.id_cuenta = m.id_cuenta');
      $this->db->where('s.estado',1);
      $this->db->where('c.estado',1);
      $this->db->where('md.fecha_ingreso >=', '2015-01-01');
      $this->db->where('md.fecha_ingreso <=', $data['ft']);
      $this->db->where('m.id_tipo_movimiento',$data['id_tipo_movimiento']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      $this->db->where('m.estado',1);
      //var_dump($this->db);      exit();
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->row();
      }else{
          return false;
      } 
    }

    public function consulta_res_acum($data)
    {
      $this->db->select_sum('md.monto', 'monto_acum');
      $this->db->from('movimiento m');
      $this->db->join('movimiento_detalle md', 'md.id_movimiento = m.id_movimiento');
      $this->db->where('md.fecha_ingreso >=', '2018-01-01');
      $this->db->where('md.fecha_ingreso <=', $data['ft']);
      $this->db->where('m.id_empresa_guarda',$data['id_empresa_guarda']);
      //$this->db->where('md.id_tipo_estado_movimiento',2);
      $this->db->where('m.estado',1);
      $query = $this->db->get();
      return $query->row();
    }

    public function eliminar_documento($id){
      $this->db->delete('movimiento_detalle', array('id_movimiento_detalle' => $id));
    }
    
    public function update($data)
    {

    $cant_mov = $data['cant_mov_det2'];
    /*echo ">".$cant_mov;
    exit();*/

    $this->db->delete('movimiento_detalle', array('id_movimiento' => $data['id_movimiento']));

    $id_movimiento = $data['id_movimiento'];
    $id_movimiento_detalle = $data['id_movimiento_detalle'];

    /*$cant_mov = '';
    $cuenta_banco = $data['cuenta_banco'];*/


    /*if($cuenta_banco == 1){
      $cant_mov= 1;
    }else {
      $cant_mov=count($data['id_tipo_documento']);
    }*/

    for($m=0;$m<$cant_mov;$m++){

      $this->db->insert(
        'movimiento_detalle',
        array(
          'id_movimiento'=>$id_movimiento,
          'id_tipo_documento'=>$data['id_tipo_documento'][$m],
          'numero_tipo_documento'=>$data['numero_tipo_documento'][$m],
          'monto'=>$data['monto'][$m],
          'monto_nota_credito'=>$data['monto_nota_credito'][$m],
          'monto_cuenta_banco'=>$data['monto_cuenta_banco'],
          'fecha_ingreso'=>fecha_ingles($data['fecha_ingreso'][$m]),
          'fecha_pago'=>fecha_ingles($data['fecha_pago'][$m]),
          'mes_iva'=>$data['mes_iva'][$m],
          'año_iva'=>$data['año_iva'][$m],
          'id_tipo_estado_movimiento'=>$data['id_tipo_estado_movimiento'][$m],
          'id_banco'=>$data['id_banco'][$m],
          'id_condicion_pago'=>$data['id_condicion_pago'][$m],
          'numero_voucher'=>$data['numero_voucher'][$m],
          'observaciones'=>$data['observaciones'][$m],
          'usuario_modifica' => $this->input->post('usuario_guarda'),
          'fecha_modifica' => date("Y-m-d H:i:s")
          )
        );

      //return $this->db->affected_rows();

    }








    /*
    este codigop comentado solo servia para editar n tipos de documentos, no sirve para actualizar un tipo de documento que se afgrego a un movimiento que ya existe, 
    este codigo me costo pillaro, favor sebastian nop borrarlo :(
    for($u=0;$u<$cant_mov;$u++){

      foreach($data as $valor => $cat){

        $array = array(
           'monto_cuenta_banco' => $data['monto_cuenta_banco'],
           'id_tipo_documento' => $data['id_tipo_documento'][$u],
           'numero_tipo_documento' => $data['numero_tipo_documento'][$u],
           'monto' => $data['monto'][$u],
           'fecha_ingreso' => $data['fecha_ingreso'][$u],
           'fecha_pago' => $data['fecha_pago'][$u],
           'mes_iva' => $data['mes_iva'][$u],
           'año_iva' => $data['año_iva'][$u],
           'id_tipo_estado_movimiento' => $data['id_tipo_estado_movimiento'][$u],
           'id_banco' => $data['id_banco'][$u],
           'id_condicion_pago' => $data['id_condicion_pago'][$u],
           'numero_voucher' => $data['numero_voucher'][$u],
           'observaciones' => $data['observaciones'][$u],
           'usuario_modifica' => $this->input->post('usuario_guarda'),
           'fecha_modifica' => date("Y-m-d H:i:s")
         );
      }

      /*$this->db->where('id_movimiento_detalle', $data['id_movimiento_detalle'][$u]);
      $this->db->update(
        'movimiento_detalle',$array
        );
    }*/

    }

    public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_movimiento',$id);
		$query = $this->db->get();

		return $query->row();
    }
    
    public function devuelveNombreCuenta($id){
        $this->db->from('cuenta c');
        $this->db->where('c.id_cuenta', $id);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function devuelveCuentaBanco($id){
        $this->db->from('cuenta c');
        $this->db->where('c.id_cuenta', $id);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function devuelveNombreSubcuenta($id){
        $this->db->from('subcuenta s');
        $this->db->where('s.id_subcuenta', $id);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function devuelveParametroCalendario($id){
        $this->db->from('empresa_parametro ep');
        $this->db->join('parametro p', 'p.id_parametro = ep.id_parametro');
        $this->db->join('parametro_detalle pd', 'pd.id_parametro = p.id_parametro');
        $this->db->where('ep.id_empresa', $id);
        $this->db->where('p.grupo_parametro', 1);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function actualiza_quincena($where, $data)
    {
      $this->db->update('venta', $data, $where);
      return $this->db->affected_rows();
    }

    public function anula($where, $data)
    {
      $this->db->update('movimiento', $data, $where);
      return $this->db->affected_rows();
    }

    public function activa($where, $data)
    {
      $this->db->update('movimiento', $data, $where);
      return $this->db->affected_rows();
    }

    public function trae_con_iva($id_tipo_documento)
    {
        $this->db->from('tipo_documento');
        $this->db->where('id_tipo_documento',$id_tipo_documento);
        //$this->db->where('con_iva', 1);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->row();
        }else{
            return false;
        }
    
      }
}
