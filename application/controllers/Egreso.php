<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Egreso extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Egreso_model','egreso');
        $this->load->model('Empresa_model','empresa');
        $this->load->model('Subcuenta_model','subcuenta');
        $this->load->model('Usuario_model','usuario');
        $this->isLoggedIn();
    }


    public function index()
    {

      $this->global['pageTitle'] = 'Egresos - Flujo de Caja';
      $this->loadViews("view_egreso", $this->global, NULL , NULL);
    }

    
    // public function egreso($i,$fechaactual)/*i = id empresa*/
    //HAmestica: IDs cuentas a desplegar ahora por variable session
    //public function egreso($i,$fechaactual,$ids_cuenta_mostrar='')/*i = id empresa*/
    //HAmestica: Variables para ordenar subcuentas
    public function egreso($i,$fechaactual,$ids_cuenta_mostrar='',$orden='subcuenta',$direccion='asc',$fecha_ini='',$fecha_fin='')/*i = id empresa*/
    {
      $fechaactual = strtr($fechaactual,array('.' => '+', '-' => '=', '~' => '/'));
      $fechaactual = $this->encryption->decrypt($fechaactual);

      /*if($this->isAdmin() == TRUE)
      {
          $this->loadThis();
      }
      else
      {*/
        $this->global['pageTitle'] = 'Egresos Movimientos - Flujo de Caja';
        $this->global['id_empresa'] = $i;
        $this->global['fecha_actual'] = $fechaactual;
        $this->global['mostrar_cuenta_egreso'] = $this->egreso->muestra_cuenta($i);

        //HAmestica: Envio de variable para mostrar detalles subcuenta
        // $this->global['ids_cuenta_mostrar'] = $ids_cuenta_mostrar;
        if($ids_cuenta_mostrar=='-'){
          $ids_cuenta_mostrar='';
        }
        
        if(!isset($_SESSION['orden_subcuenta'])){
          //HAmestica: Variables para ordenar subcuentas
          $_SESSION['orden_subcuenta'] = $orden;
          $_SESSION['orden_subcuenta_direccion'] = $direccion;
          $_SESSION['orden_subcuenta_fecini'] = $fecha_ini;
          $_SESSION['orden_subcuenta_fecfin'] = $fecha_fin;
        }
        
        if($ids_cuenta_mostrar!="0"){
          $_SESSION['ids_cuenta_mostrar']=$ids_cuenta_mostrar;

          //HAmestica: Variables para ordenar subcuentas
          $_SESSION['orden_subcuenta'] = $orden;
          $_SESSION['orden_subcuenta_direccion'] = $direccion;
          $_SESSION['orden_subcuenta_fecini'] = $fecha_ini;
          $_SESSION['orden_subcuenta_fecfin'] = $fecha_fin;
        }
        
        //HAmestica: Llamada a funcion actualizada con variables para ordenar subcuentas
        // $this->global['mostrar_subcuenta_egreso'] = $this->egreso->muestra_subcuenta($i);
        $this->global['mostrar_subcuenta_egreso'] = $this->egreso->muestra_subcuenta($i,$_SESSION['orden_subcuenta'],$_SESSION['orden_subcuenta_direccion'],$_SESSION['orden_subcuenta_fecini'],$_SESSION['orden_subcuenta_fecfin']);

        $iu = $this->session->userdata('id_usuario');

        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        $this->global['trae_egresos'] = $this->egreso->trae_egresos($i);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);

        $this->loadViews("egreso/view_excel_egreso", $this->global, NULL , NULL);
      //}
    }

    public function egreso_muestra_periodo_iva($id_tipo_documento)
    {
          $data = $this->egreso->trae_con_iva($id_tipo_documento);
          echo json_encode($data);
    }

    function update_egreso(){

       $this->_validate_egreso();

       $cuenta_banco = $this->input->post('cuenta_banco');
       $monto_cuenta_banco = $this->input->post('monto_cuenta_banco');
       $iva_disabled_upd = $this->input->post('iva_disabled');
       $param_fecha_inicio = $this->input->post('param_fecha_inicio');
       $es_nota_credito_upd = $this->input->post('es_nota_credito');
       $mes_iva_upd = $this->input->post('mes_iva');
       $año_iva_upd = $this->input->post('año_iva');
       $monto_upd = $this->input->post('monto');

       for($j=0;$j<count($iva_disabled_upd);$j++){

          if (!$mes_iva_upd[$j]) {
            $mes_iva_upd[$j]='0';
          }
          if (!$año_iva_upd[$j]) {
            $año_iva_upd[$j]='0';
          }

        }

        for($k=0;$k<count($es_nota_credito_upd);$k++){

          if($es_nota_credito_upd[$k] == 0){
            if(isset($monto_upd[$k])){
              $monto_upd_ar[$k]=$monto_upd[$k];
              $monto_nota_credito_upd_ar[$k]=0;
            }
          }else{
            if(isset($monto_upd[$k])){
              $monto_nota_credito_upd_ar[$k] = $monto_upd[$k];
              $monto_upd_ar[$k]=0;
            }
          }

        }

       $id_movimiento_detalle_upd = $this->input->post('id_movimiento_detalle');
        if(isset($id_movimiento_detalle_upd)){
          $id_movimiento_detalle_upd=$id_movimiento_detalle_upd;

        }else {
          $id_movimiento_detalle_upd='0';
        }
        $id_movimiento_upd = $this->input->post('id_movimiento');
        if(isset($id_movimiento_upd)){
          $id_movimiento_upd=$id_movimiento_upd;

        }else {
          $id_movimiento_upd='0';
        }
        if(isset($monto_cuenta_banco)){
          $monto_cuenta_banco=$monto_cuenta_banco;
          $monto_upd_ar='0';
          $monto_nota_credito_upd_ar='0';
        }else {
          $monto_cuenta_banco='0';
        }
       $id_tipo_documento_upd = $this->input->post('id_tipo_documento');
        if(isset($id_tipo_documento_upd)){
          $id_tipo_documento_upd=$id_tipo_documento_upd;

        }else {
          $id_tipo_documento_upd='0';
        }
       $numero_tipo_documento_upd = $this->input->post('numero_tipo_documento');
        if(isset($numero_tipo_documento_upd)){
          $numero_tipo_documento_upd=$numero_tipo_documento_upd;

        }else {
          $numero_tipo_documento_upd='0';
        }


       $fecha_ingreso_upd = $this->input->post('fecha_ingreso');
       $fecha_ingreso_2_upd = $this->input->post('fecha_ingreso_2');

       if($param_fecha_inicio == 1){
        $fecha_ingreso_upd=$fecha_ingreso_2_upd;
       }else{
        $fecha_ingreso_upd=$fecha_ingreso_upd;
       }

       $fecha_pago_upd = $this->input->post('fecha_pago');
        if(isset($fecha_pago_upd)){
          $fecha_pago_upd=$fecha_pago_upd;

        }else {
          $fecha_pago_upd='0';
        }

       $id_tipo_estado_movimiento_upd = $this->input->post('id_tipo_estado_movimiento');
        if(isset($id_tipo_estado_movimiento_upd)){
          $id_tipo_estado_movimiento_upd=$id_tipo_estado_movimiento_upd;

        }else {
          $id_tipo_estado_movimiento_upd='2';
        }
       $id_banco_upd = $this->input->post('id_banco');
        if(isset($id_banco_upd)){
          $id_banco_upd=$id_banco_upd;

        }else {
          $id_banco_upd='0';
        }
       $id_condicion_pago_upd = $this->input->post('id_condicion_pago');
        if(isset($id_condicion_pago_upd)){
          $id_condicion_pago_upd=$id_condicion_pago_upd;

        }else {
          $id_condicion_pago_upd='0';
        }
       $numero_voucher_upd = $this->input->post('numero_voucher');
        if(isset($numero_voucher_upd)){
          $numero_voucher_upd=$numero_voucher_upd;

        }else {
          $numero_voucher_upd='0';
        }
       $observaciones_upd = $this->input->post('observaciones');
        if(isset($observaciones_upd)){
          $observaciones_upd=$observaciones_upd;

        }else {
          $observaciones_upd='0';
        }
       $estado_upd = 1;

      /* $id_movimiento_detalle_upd = $this->input->post('id_movimiento_detalle');
       $id_tipo_documento_upd = $this->input->post('id_tipo_documento');
       $numero_tipo_documento_upd = $this->input->post('numero_tipo_documento');
       $monto_upd = $this->input->post('monto');
       $fecha_ingreso_upd = $this->input->post('fecha_ingreso');
       $fecha_pago_upd = $this->input->post('fecha_pago');
       $mes_iva_upd = $this->input->post('mes_iva');
       $año_iva_upd = $this->input->post('año_iva');
       $id_tipo_estado_movimiento_upd = $this->input->post('id_tipo_estado_movimiento');
       $id_banco_upd = $this->input->post('id_banco');
       $id_condicion_pago_upd = $this->input->post('id_condicion_pago');
       $numero_voucher_upd = $this->input->post('numero_voucher');
       $observaciones_upd = $this->input->post('observaciones');
       $estado_upd = 1;*/

     /*if($this->isAdmin() == TRUE)
     {
         $this->loadThis();
     }
     else
     {*/
       $data = array(
         'cant_mov_det' => $this->input->post('cant_mov_det'),
         'cuenta_banco' => $cuenta_banco,
         'monto_cuenta_banco' => $monto_cuenta_banco,
         'id_movimiento' => $id_movimiento_upd,
         'id_movimiento_detalle' => $id_movimiento_detalle_upd,
         'id_tipo_documento' => $id_tipo_documento_upd,
         'numero_tipo_documento' => $numero_tipo_documento_upd,
         'monto' => $monto_upd_ar,
         'monto_nota_credito' => $monto_nota_credito_upd_ar,
         'fecha_ingreso' => $fecha_ingreso_upd,
         'fecha_pago' => $fecha_pago_upd,
         'mes_iva' => $mes_iva_upd,
         'año_iva' => $año_iva_upd,
         'id_tipo_estado_movimiento' => $id_tipo_estado_movimiento_upd,
         'id_banco' => $id_banco_upd,
         'id_condicion_pago' => $id_condicion_pago_upd,
         'numero_voucher' => $numero_voucher_upd,
         'observaciones' => $observaciones_upd,
         'usuario_modifica' => $this->input->post('usuario_guarda'),
         'fecha_modifica' => date("Y-m-d H:i:s")
           );

       $this->egreso->update($data);
       echo json_encode(array("status" => TRUE));
     //}

   }//fin update_egreso

   
   //HAmestica: Funcion que busca los movimientos resumidos por cuenta/semana
   public function consulta_totales_movimiento_cuenta_semana_json(){
      $arg = array();

      foreach (json_decode(stripslashes($this->input->post('args'))) as $data) {
        $rs = $this->egreso->consulta_movimientos_cuenta_semana(array_merge((array) $data, array('id_empresa_guarda' => $this->input->post('ide'), 'id_tipo_movimiento' => $this->input->post('idtm'))));
        
        if ($rs) {
          $json = array();
          
          foreach ($rs as $key => $val) {
            $json[$key] = array_merge((array) $data, (array) $val);
          }
          
          $arg[] = $json;
        }
      }
      
      echo json_encode($arg);
    }

    public function consulta_detalle_movimiento_json(){
    
      $data = array(
        'id_movi' => $this->input->post('id_movi')
       );
       $consulta = $this->egreso->get_data_mov_det($data);
       echo json_encode($consulta);


      }
      
   public function consulta_movimiento_json(){
    $arg = array();
    foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
        $rs = $this->egreso->consulta_movimiento(array_merge((array) $data, array('ie' => $this->input->post('ide'))));
        if ($rs) {
            $json = array();
            foreach ($rs as $key => $val) {
                $json[$key] = array_merge((array) $data, (array) $val);
            }
            $arg[] = $json;
        }
    }
    echo json_encode($arg);
    }
    
    /*
      INGRESOS
      public function query_amount() {
      $arg = array();
      foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
          $rs = $this->ingreso->consulta_movimiento(array_merge((array) $data, array('id_empresa_guarda' => $this->input->post('ide'), 'id_tipo_movimiento' => $this->input->post('idtm'))));
          if ($rs) {
              $json = array();
              foreach ($rs as $key => $val) {
                  $json[$key] = array_merge((array) $data, (array) $val);
              }
              $arg[] = $json;
          }
      }

      echo json_encode($arg);
  }*/


    public function consulta_total_pagados_pendiente_json(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = (array) $data;
            $arg[] = array('data'=>$arr,'request'=>$this->egreso->consulta_saldo_pendiente(array_merge($arr, array('id_empresa_guarda' => $this->input->post('ide'),'id_tipo_movimiento' => $this->input->post('idtm')))));
        }
        echo json_encode($arg);
    }
    
    public function consulta_egreso_acum_json(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = (array) $data;
            $arg[] = array('data'=>$arr,'request'=>$this->egreso->consulta_egreso_acum(array_merge($arr, array('id_empresa_guarda' => $this->input->post('ide'),'id_tipo_movimiento' => $this->input->post('idtm')))));
        }
        echo json_encode($arg);
    }

    
   public function consulta_movimiento(){
      $data = array(
      'idc' => $this->input->post('idc'),
      'ids' => $this->input->post('ids'),
      'fi' => $this->input->post('fi'),
      'ft' => $this->input->post('ft'),
      'id_empresa_guarda' => $this->input->post('ide'),
      'id_tipo_movimiento' => $this->input->post('idtm')
     );
     $consulta = $this->egreso->consulta_movimiento($data);
     echo json_encode($consulta);
    }


   private function _validate_egreso()
   {
       $data = array();
       $data['error_string'] = array();
       $data['inputerror'] = array();
       $data['status'] = TRUE;

       $id_tipo_documento_val = $this->input->post('id_tipo_documento');
       $numero_tipo_documento_val = $this->input->post('numero_tipo_documento');
       $monto_val = $this->input->post('monto');
       $es_obligatorio_val = $this->input->post('es_obligatorio');
       $param_fecha_inicio_val = $this->input->post('param_fecha_inicio');
       $fecha_ingreso_val = $this->input->post('fecha_ingreso');
       $fecha_ingreso_2_val = $this->input->post('fecha_ingreso_2');
       $fecha_pago_val = $this->input->post('fecha_pago');
       $mes_iva_val = $this->input->post('mes_iva');
       $año_iva_val = $this->input->post('año_iva');
       $id_tipo_estado_movimiento_val = $this->input->post('id_tipo_estado_movimiento');
       $id_banco_val = $this->input->post('id_banco');
       $id_condicion_pago_val = $this->input->post('id_condicion_pago');
       $numero_voucher_val = $this->input->post('numero_voucher');
       $observaciones_val = $this->input->post('observaciones');
       $estado_val = 1;

       $cant_mov = count($id_tipo_documento_val);


       for($m=0;$m<$cant_mov;$m++){
         //echo ">".$numero_tipo_documento_val[$m];
          if($id_tipo_documento_val[$m] == '')
           {
               $data['inputerror'][] = 'id_tipo_documento_'.$m;
               $data['error_string'][] = '* Requerido';
               $data['status'] = FALSE;
           }

            if($es_obligatorio_val[$m] == 1) {
                
                if (empty($numero_tipo_documento_val[$m])) {

                $data['inputerror'][] = 'numero_tipo_documento_' . $m;
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;

                }
            }

           /*if(empty($numero_tipo_documento_val[$m]))
           {
               $data['inputerror'][] = 'numero_tipo_documento_'.$m;
               $data['error_string'][] = '* Requerido';
               $data['status'] = FALSE;
           
           }else{
            
            if(!is_numeric($numero_tipo_documento_val[$m]))
 
            {
                $data['inputerror'][] = 'numero_tipo_documento_'.$m;
                $data['error_string'][] = '* Sólo dígitos';
                $data['status'] = FALSE;
            }

           }*/

           if(empty($monto_val[$m]))
           {
               $data['inputerror'][] = 'monto_'.$m;
               $data['error_string'][] = '* Requerido';
               $data['status'] = FALSE;
           
           }else{
            
            if(!is_numeric($monto_val[$m]))
 
            {
                $data['inputerror'][] = 'monto_'.$m;
                $data['error_string'][] = '* Sólo dígitos';
                $data['status'] = FALSE;
            }

           }

           /*if($mes_iva_val[$m] == '')
           {
               $data['inputerror'][] = 'mes_iva_'.$m;
               $data['error_string'][] = 'Requerido';
               $data['status'] = FALSE;
           }

           if($año_iva_val[$m] == '')
           {
               $data['inputerror'][] = 'año_iva_'.$m;
               $data['error_string'][] = 'Requerido';
               $data['status'] = FALSE;
           }*/

           if($id_tipo_estado_movimiento_val[$m] == '')
           {
               $data['inputerror'][] = 'id_tipo_estado_movimiento_'.$m;
               $data['error_string'][] = '* Requerido';
               $data['status'] = FALSE;
           }

           if (!empty($fecha_pago_val[$m]) && $id_tipo_estado_movimiento_val[$m] == 2) {

            $data['inputerror'][] = 'id_tipo_estado_movimiento_' . $m;
            $data['error_string'][] = '* Debe cambiar Estado a "PAGADO".';
            $data['status'] = FALSE;
        }

           if($id_tipo_estado_movimiento_val[$m] == 1)
           {
             if($id_banco_val[$m] == '')
             {
                 $data['inputerror'][] = 'id_banco_'.$m;
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($id_condicion_pago_val[$m] == '')
             {
                 $data['inputerror'][] = 'id_condicion_pago_'.$m;
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($numero_voucher_val[$m] != '')
             {
               if(!is_numeric($numero_voucher_val[$m]))
  
               {
                   $data['inputerror'][] = 'numero_voucher_'.$m;
                   $data['error_string'][] = '* Sólo dígitos';
                   $data['status'] = FALSE;
               }
             }

             if($fecha_pago_val[$m] == '')
             {
                 $data['inputerror'][] = 'fecha_pago_'.$m;
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             
             } /*else if(strtotime($fecha_pago_val[$m]) < strtotime($fecha_ingreso_val[$m])){
               
                 $data['inputerror'][] = 'fecha_pago_'.$m;
                 $data['error_string'][] = '* F. Pago debe ser mayor a F. Ingreso';
                 $data['status'] = FALSE;
             }*/

             if($param_fecha_inicio_val==0){

              if($fecha_pago_val[$m] == '')
              {
                  $data['inputerror'][] = 'fecha_pago_'.$m;
                  $data['error_string'][] = '* Requerido';
                  $data['status'] = FALSE;
              
              } /*else if(strtotime($fecha_pago_val[$m]) < strtotime($fecha_ingreso_val[$m])){
                
                 $data['inputerror'][] = 'fecha_pago_'.$m;
                  $data['error_string'][] = '* F. Pago debe ser mayor a F. Ingreso';
                  $data['status'] = FALSE;
              }*/
             
             }else{
 
               if($fecha_pago_val[$m] == '')
              {
                  $data['inputerror'][] = 'fecha_pago_'.$m;
                  $data['error_string'][] = '* Requerido';
                  $data['status'] = FALSE;
              
              } /*else if(strtotime($fecha_pago_val[$m]) < strtotime($fecha_ingreso_2_val[$m])){
                
                 $data['inputerror'][] = 'fecha_pago_'.$m;
                  $data['error_string'][] = '* F. Pago debe ser mayor a F. Ingreso';
                  $data['status'] = FALSE;
              }*/
             }


           }


       }

       if($data['status'] === FALSE)
       {
           echo json_encode($data);
           exit();
       }


   }//fin validate egreso

    function activar_egreso(){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          $data = array(
              'estado' => 1
              );
  
          $this->egreso->activa(array('id_movimiento' => $this->input->post('id_movimiento')), $data);
          echo json_encode(array("status" => TRUE));
  
         //}
  
        }

    public function listado($i){
      
      /*if($this->isAdmin() == TRUE)
      {
          $this->loadThis();
      }
      else
      {*/
        $this->global['pageTitle'] = 'Egresos Listado - Flujo de Caja';
        $this->global['id_empresa'] = $i;
        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        $this->global['trae_egresos'] = $this->egreso->trae_egresos($i);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);

        $this->loadViews("view_listado_egreso", $this->global, NULL , NULL);
      //*}

    }

    public function lista_egreso($i)
    {
     /* if($this->isAdmin() == TRUE)
      {
          $this->loadThis();
      }
      else
      {*/

        $list = $this->egreso->get_datatables($i);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $egreso) {
            $no++;
            $row = array();
            $row[] = $egreso->id_movimiento;
            $row[] = $egreso->nombre_cuenta;
            $row[] = $egreso->nombre_subcuenta;
            $row[] = fecha_espanol($egreso->fecha_registro);
            /*$row[] = formato_precio($egreso->monto_total);
            $row[] = formato_precio($egreso->monto_cuenta_banco);
            $row[] = $egreso->cant_doc;*/

            //$row[] = $egreso->estado;
            if($_SESSION['egr_lis_act']==1){
              $onclick='onclick="activar(' . "'" . $egreso->id_movimiento . "'" . ')"';
            }else{
                $onclick='';
            }
 
              $row[] = ($egreso->estado)?'<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Activado"><i class="con icon-ok"></i>ACTIVO</a>':'<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Anulado" '.$onclick.')"><i class="con icon-remove"></i>ANULADO</a>';

            $row[] = '
            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Detalle movimiento" onclick="detalle_egreso(' . "'" . $egreso->id_movimiento . "'" . ')"><i class="glyphicon glyphicon-search"></i></a>';

              $row[] = '
               <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_egreso('."'".$egreso->id_movimiento."'".')"><i class="glyphicon glyphicon-road"></i></a>';

            
            

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->egreso->count_all($i),
                        "recordsFiltered" => $this->egreso->count_filtered($i),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
     // }
    }

    public function ajax_data_egreso($id)
    {
        $data = $this->egreso->get_by_id($id);
        echo json_encode($data);
    }

    public function get_detalle_egreso($id) {
        $data = $this->egreso->get_detalle_egreso($id);
        echo json_encode($data);
    }

    public function get_up_detalle_egreso($id) {
      $data = $this->egreso->get_up_detalle_egreso($id);
      echo json_encode($data);
  }


    function anular_egreso(){

     /* if($this->isAdmin() == TRUE)
      {
          $this->loadThis();
      }
      else
      {*/
        $data = array(
            'estado' => 0
            );

        $this->egreso->anula(array('id_movimiento' => $this->input->post('id_movimiento')), $data);
        echo json_encode(array("status" => TRUE));

       //}

      }

    public function movimiento($idem,$idmov)//idem id empresa , idmov es id movimiento
    {
        //echo $idem."----------------".$idmov;
        list($id_mo1, $id_res_encript) = explode("@", $idmov);
        //echo $id_mo1."-".$id_res_encript."<br>";

        $id_res_encript = strtr($id_res_encript, array('.' => '+', '-' => '=', '~' => '/'));
        $id_res_desencript = $this->encryption->decrypt($id_res_encript);
        //echo $id_res_encript."<br>";

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */

        $this->global['pageTitle'] = 'Egresos';
        $this->global['id_empresa'] = $idem;
        $this->global['id_movimiento'] = $id_mo1;

        if($id_mo1 == 0){ //nueva
            $id_m = 0;
            list($id_c,$id_s,$fi,$ft) = explode("n", $id_res_desencript);
            $this->global['id_m'] = $id_m;
            $this->global['id_c'] = $id_c;
            $this->global['id_s'] = $id_s;
            $this->global['fi'] = $fi;
            $this->global['ft'] = $ft;
            $this->global['data_movimiento_detalle'] = '';
            $this->global['cuenta_banco'] = $this->egreso-> devuelveCuentaBanco($id_c);
            $this->global['nombre_cuenta'] = $this->egreso-> devuelveNombreCuenta($id_c);
            $this->global['nombre_subcuenta'] = $this->egreso-> devuelveNombreSubcuenta($id_s);
            $this->global['pageTitle'] = 'Creación Egreso  - Flujo de Caja';

          } else {//editar
            list($fis,$fts) = explode("n", $id_res_desencript);
            $id_m = $id_mo1;
            $this->global['idmov'] = $idmov;
            $this->global['id_m'] = $id_m;
            $this->global['id_me'] = $id_res_desencript;
            $this->global['id_c'] = '';
            $this->global['id_s'] = '';
            $this->global['fi'] = $fis;
            $this->global['ft'] = $fts;
            $this->global['data_movimiento_detalle'] = $this->egreso->data_movimiento($id_m);
            $this->global['data_movimiento_sinrango'] = $this->egreso->data_movimiento_sinrango($id_m, $fis, $fts);  
            $this->global['pageTitle'] = 'Edición Egreso  - Flujo de Caja';          

          }

        $this->global['mostrar_cuenta'] = $this->egreso->muestra_cuenta($idem);
        $this->global['mostrar_subcuenta'] = $this->subcuenta->mostrar_subcuentas($idem);
        $this->global['mostrar_tipo_documento'] = $this->egreso->muestra_tipo_documento($idem);
        $this->global['mostrar_condicion_pago'] = $this->egreso->mostrar_condicion_pago($idem);
        $this->global['mostrar_estado_movimiento'] = $this->egreso->trae_estado_movimiento();
        $this->global['mostrar_banco'] = $this->egreso->muestra_banco($idem);
        $this->global['devuelve_ultimo_id_ingreso'] = $this->egreso->devuelve_ultimo_id_ingreso();


        $this->global['trae_ingresos'] = $this->egreso->trae_egresos($idem);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($idem);
        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($idem,$iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        
        $this->loadViews("egreso/view_egreso_header", $this->global, NULL , NULL);
     // }
    }

    public function consulta_egreso_total_json(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = (array) $data;
            $arg[] = array('data'=>$arr,'request'=>$this->egreso->consulta_egreso_total(array_merge($arr, array('id_empresa_guarda' => $this->input->post('ide'),'id_tipo_movimiento' => $this->input->post('idtm')))));
        }
        echo json_encode($arg);
    }
    public function consulta_total_pagados_json(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = (array) $data;
            $arg[] = array('data'=>$arr,'request'=>$this->egreso->consulta_egreso_total_pagado(array_merge($arr, array('id_empresa_guarda' => $this->input->post('ide'),'id_tipo_movimiento' => $this->input->post('idtm')))));
        }
        echo json_encode($arg);
    }
    
    public function consulta_egreso_total(){
      $data = array(
      'fi' => $this->input->post('fi'),
      'ft' => $this->input->post('ft'),
      'id_empresa_guarda' => $this->input->post('ide'),
      'id_tipo_movimiento' => $this->input->post('idtm')
     );
     $consulta = $this->egreso->consulta_egreso_total($data);
     echo json_encode($consulta);
    }

    
    public function consulta_egreso_simplifycate_json(){
      $arg = array();
      foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
        $arr = (array) $data;
        $sql = array_merge($arr, array('id_empresa_guarda' => $this->input->post('ide'),'id_tipo_movimiento' => $this->input->post('idtm')));
        $arg[] = array(
          'data'=>$arr,
          'request' => array(
            'total_pagados' => $this->egreso->consulta_egreso_total_pagado($sql),
            'egreso_total' => $this->egreso->consulta_egreso_total($sql),
            'movimiento' => $this->egreso->consulta_movimiento($sql),
            'total_pagados_pendientes' => $this->egreso->consulta_saldo_pendiente($sql),
            'total_egreso_acumulado' => $this->egreso->consulta_egreso_acum($sql)
          )
        );
      }
      echo json_encode($arg);
    }
    
    public function consulta_total_pagados(){
      $data = array(
      'fi' => $this->input->post('fi'),
      'ft' => $this->input->post('ft'),
      'id_empresa_guarda' => $this->input->post('ide'),
      'id_tipo_movimiento' => $this->input->post('idtm')
     );
     $consulta = $this->egreso->consulta_egreso_total_pagado($data);
     echo json_encode($consulta);
    }

    public function consulta_total_pagados_pendiente(){
      $data = array(
      'fi' => $this->input->post('fi'),
      'ft' => $this->input->post('ft'),
      'id_empresa_guarda' => $this->input->post('ide'),
      'id_tipo_movimiento' => $this->input->post('idtm')
     );
     $consulta = $this->egreso->consulta_saldo_pendiente($data);
     echo json_encode($consulta);
    }

    public function consulta_egreso_acum(){
      $data = array(
      'fi' => $this->input->post('fi'),
      'ft' => $this->input->post('ft'),
      'id_empresa_guarda' => $this->input->post('ide'),
      'id_tipo_movimiento' => $this->input->post('idtm')
     );
     $consulta = $this->egreso->consulta_egreso_acum($data);
     echo json_encode($consulta);
    }


    function save_egreso(){

      $this->_validate_egreso();

     $cuenta_banco = $this->input->post('cuenta_banco');
     $monto_cuenta_banco = $this->input->post('monto_cuenta_banco');
     $iva_disabled = $this->input->post('iva_disabled');
     $es_nota_credito = $this->input->post('es_nota_credito');
     $mes_iva_save = $this->input->post('mes_iva');
     $año_iva_save = $this->input->post('año_iva');
     $monto_save = $this->input->post('monto');

      for($i=0;$i<count($iva_disabled);$i++){

        if (!$mes_iva_save[$i]) {
          $mes_iva_save[$i]='0';
        }
        if (!$año_iva_save[$i]) {
          $año_iva_save[$i]='0';
        }

      }


      for($j=0;$j<count($es_nota_credito);$j++){

        if($es_nota_credito[$j] == 0){
          if(isset($monto_save[$j])){
            $monto[$j]=$monto_save[$j];
            $monto_nota_credito[$j]=0;
          }
        }else{
          if(isset($monto_save[$j])){
            $monto_nota_credito[$j] = $monto_save[$j];
            $monto[$j]=0;
          }
        }

      }



      if(isset($monto_cuenta_banco)){
        $monto_cuenta_banco=$monto_cuenta_banco;
        $monto='0';
        $monto_nota_credito='0';
      }else {
        $monto_cuenta_banco='0';
      }

     $id_tipo_documento_save = $this->input->post('id_tipo_documento');
      if(isset($id_tipo_documento_save)){
        $id_tipo_documento_save=$id_tipo_documento_save;

      }else {
        $id_tipo_documento_save='0';
      }
     $numero_tipo_documento_save = $this->input->post('numero_tipo_documento');
      if(isset($numero_tipo_documento_save)){
        $numero_tipo_documento_save=$numero_tipo_documento_save;

      }else {
        $numero_tipo_documento_save='0';
      }


     $fecha_ingreso_save = $this->input->post('fecha_ingreso');

      if(isset($fecha_ingreso_save)){
        $fecha_ingreso_save=$fecha_ingreso_save;
      }else {
        $fecha_ingreso_save='0';
      }

     $fecha_pago_save = $this->input->post('fecha_pago');
      if(isset($fecha_pago_save)){
        $fecha_pago_save=$fecha_pago_save;

      }else {
        $fecha_pago_save='0';
      }

     $id_tipo_estado_movimiento_save = $this->input->post('id_tipo_estado_movimiento');
      if(isset($id_tipo_estado_movimiento_save)){
        $id_tipo_estado_movimiento_save=$id_tipo_estado_movimiento_save;

      }else {
        $id_tipo_estado_movimiento_save='2';
      }
     $id_banco_save = $this->input->post('id_banco');
      if(isset($id_banco_save)){
        $id_banco_save=$id_banco_save;

      }else {
        $id_banco_save='0';
      }
     $id_condicion_pago_save = $this->input->post('id_condicion_pago');
      if(isset($id_condicion_pago_save)){
        $id_condicion_pago_save=$id_condicion_pago_save;

      }else {
        $id_condicion_pago_save='0';
      }
     $numero_voucher_save = $this->input->post('numero_voucher');
      if(isset($numero_voucher_save)){
        $numero_voucher_save=$numero_voucher_save;

      }else {
        $numero_voucher_save='0';
      }
     $observaciones_save = $this->input->post('observaciones');
      if(isset($observaciones_save)){
        $observaciones_save=$observaciones_save;

      }else {
        $observaciones_save='0';
      }
     $estado_save = 1;

     /*if($this->isAdmin() == TRUE)
     {
         $this->loadThis();
     }
     else
     {*/

       $data = array(
                'fecha_registro' => $this->input->post('fecha_registro'),
                'cuenta_banco' => $cuenta_banco,
                'monto_cuenta_banco' => $monto_cuenta_banco,
                'id_tipo_movimiento' => 2,
                'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                'id_cuenta' => $this->input->post('id_cuenta'),
                'id_subcuenta' => $this->input->post('id_subcuenta'),
                'id_tipo_documento' => $id_tipo_documento_save,
                'numero_tipo_documento' => $numero_tipo_documento_save,
                'monto' => $monto,
                'monto_nota_credito' => $monto_nota_credito,
                'fecha_ingreso' => $fecha_ingreso_save,
                'fecha_pago' => $fecha_pago_save,
                'mes_iva' => $mes_iva_save,
                'año_iva' => $año_iva_save,
                'id_tipo_estado_movimiento' => $id_tipo_estado_movimiento_save,
                'id_banco' => $id_banco_save,
                'id_condicion_pago' => $id_condicion_pago_save,
                'numero_voucher' => $numero_voucher_save,
                'observaciones' => $observaciones_save,
                'usuario_guarda' => $this->input->post('usuario_guarda'),
                'fecha_guarda' => date("Y-m-d H:i:s"),
                'estado' => $estado_save

           );
           //print_r($data);
       $insert = $this->egreso->guarda($data);
       echo json_encode(array("status" => TRUE));
     //  }
   }
   //fin save egreso

   public function devuelve_gas_proy_edit(){
    $data = array(
    'cuenta' => $this->input->post('c'),
    'subcuenta' => $this->input->post('s'),
    'id_empresa_guarda' => $this->input->post('e')
   );
   $consulta = $this->egreso->devuelve_gas_proy_edit($data);
   echo json_encode($consulta);
  }    

  function save_gas_proy(){

      $data = array(
        'monto_gas_proy'=> $this->input->post('monto_gas_proy'),     
        );

      $this->egreso->guarda_gas_proy(array('id_subcuenta' => $this->input->post('id_subcuenta')), $data);
      echo json_encode(array("status" => TRUE));

     }

     public function consulta_gasto_real(){
      $data = array(
      'idc' => $this->input->post('idc'),
      'ids' => $this->input->post('ids'),
      'id_empresa_guarda' => $this->input->post('ide'),
      'id_tipo_movimiento' => $this->input->post('idtm')
     );
     $consulta = $this->egreso->consulta_gasto_real($data);
     echo json_encode($consulta);
    }

    public function consulta_gasto_proy_json(){
      $arg = array();
      foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
        $arr = (array) $data;
        $arg[] = array('data'=>$arr,
          'request'=>$this->egreso->consulta_gasto_proy(array_merge(
            $arr, array(
              'id_empresa_guarda' => $this->input->post('ide'),
              'id_tipo_movimiento' => $this->input->post('idtm')
              )
            )
          )
        );
      }
      echo json_encode($arg);
    }

    public function consulta_gasto_real_json(){
      $arg = array();
      foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
        $arr = (array) $data;
        $arg[] = array('data'=>$arr,
          'request'=>$this->egreso->consulta_gasto_real(array_merge(
            $arr, array(
              'id_empresa_guarda' => $this->input->post('ide'),
              'id_tipo_movimiento' => $this->input->post('idtm')
              )
            )
          )
        );
      }
      echo json_encode($arg);
    }
}


?>
