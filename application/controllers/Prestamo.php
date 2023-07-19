<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Prestamo extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cuenta_model','cuenta');
        $this->load->model('Subcuenta_model','subcuenta');
        $this->load->model('Empresa_model','empresa');
        $this->load->model('Sucursal_model','sucursal');
        $this->load->model('Proveedor_model','proveedor');
        $this->load->model('Cliente_model','cliente');
        $this->load->model('Banco_model','banco');
        $this->load->model('Servicio_otro_model','servicio_otro');
        $this->load->model('Malla_societaria_model','malla_societaria');
        $this->load->model('Iva_model','iva');
        $this->load->model('Servicio_model','servicio');
        $this->load->model('Linea_model','linea');
        $this->load->model('Moneda_model','moneda');
        $this->load->model('Tipo_documento_model','tipo');
        $this->load->model('Plazo_pago_model','plazo');
        $this->load->model('Condicion_pago_model','condicion');
        $this->load->model('Parametro_model','parametro');
        $this->load->model('Usuario_model','usuario');
        $this->load->model('Perfil_model','perfil');        
        $this->load->model('Prestamo_model','prestamo');        
        $this->load->model('Ingreso_model','ingreso');        

        $this->isLoggedIn();
    }


    public function prestamo($i)
    {
         
         $this->global['pageTitle'] = 'Préstamos - Flujo de Caja';
         $this->global['id_empresa'] = $i;
         $this->global['mostrar_moneda'] = $this->banco->mostrar_moneda($i);
         $iu = $this->session->userdata('id_usuario');
         $this->global['mostrar_cuenta'] = $this->prestamo->muestra_cuenta_prestamo($i);
         $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i, $iu);
         $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
         $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
         //echo 'ya';
         //exit();
         $this->loadViews("view_prestamo", $this->global, NULL, NULL);
         //}
    }

    public function lista_prestamo($i)
        {
          //echo "hola";
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          $uf = devuelve_uf(date('Y-m-d'));
          $list = $this->prestamo->get_datatables($i);
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $prestamo) {
              $no++;
              $row = array();
              //$row[] = $prestamo->id_prestamo;
              $row[] = $prestamo->nombre_prestamo;
              $row[] = fecha_espanol2($prestamo->fecha_colocacion);
              $row[] = $prestamo->tasa;
              $row[] = formato_precio(devuelve_simbolo_moneda($prestamo->id_moneda), $prestamo->monto_solicitado, devuelve_posicion_moneda($prestamo->id_moneda));
              $row[] = formato_precio("$ ", $prestamo->pie, 'first');
              
              if(devuelve_simbolo_moneda($prestamo->id_moneda)=='UF'){
                $row[] = formato_precio("$ ", (($prestamo->monto_solicitado * $uf) - $prestamo->pie), 'first');
              }else{
                $row[] = formato_precio("$ ", ($prestamo->monto_solicitado - $prestamo->pie), 'first');
              }
              $row[] = formato_precio("$ ", $prestamo->valor_cuota, 'first');
              $row[] = $prestamo->cuotas;
              $row[] = devuelve_cuotas_canceladas($prestamo->id_cuenta, $prestamo->id_subcuenta);
              $row[] = devuelve_cuotas_pendientes($prestamo->id_cuenta, $prestamo->id_subcuenta);

              //SALDO
              $row[] = formato_precio("$ ",devuelve_cuotas_pendientes($prestamo->id_cuenta, $prestamo->id_subcuenta) * $prestamo->valor_cuota, 'first');

              //$row[] = $prestamo->cuotas_canceladas;
      

              $row[] = ($prestamo->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
              '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

              $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_prestamo('."'".$prestamo->id_prestamo."'".')"><i class="glyphicon glyphicon-pencil"></i></a>

              <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_prestamo('."'".$prestamo->id_prestamo."'".')"><i class="glyphicon glyphicon-road"></i></a>';

              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->prestamo->count_all($i),
                          "recordsFiltered" => $this->prestamo->count_filtered($i),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
       // }
        }


        function save_prestamo(){

            /*$this->_validate_prestamo();*/

            //TABLA SUBCUENTA
            $data_subcuenta = array(

                'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                'id_cuenta' => $this->input->post('id_cuenta_p'),
                'rut_subcuenta' => '',
                'nombre_subcuenta' => $this->input->post('nombre_prestamo'),
                'tipo_movimiento' => 2,//$this->input->post('tipo_movimiento_a'),
                'usuario_guarda' => $this->input->post('usuario_guarda'),
                'fecha_guarda' => date("Y-m-d H:i:s"),
                'estado' => $this->input->post('estado')
        );

            $data_update = array(
                
                'mostrar_calendario' => 1
        );

        $ultimo_insert_subcuenta = $this->prestamo->guarda_prestamo_subcuenta($data_subcuenta);
        $this->prestamo->mostrar_en_calendario(array('id_cuenta' => $this->input->post('id_cuenta_p')), $data_update);

           //TABLA PRESTAMO
           $data = array(
                   'id_cuenta' => $this->input->post('id_cuenta_p'),
                   'id_subcuenta' => $ultimo_insert_subcuenta, //movimiento
                   'id_empresa' => $this->input->post('id_empresa_guarda'),
                   'nombre_prestamo' => $this->input->post('nombre_prestamo'),
                   'fecha_colocacion' => $this->input->post('fecha_colocacion'),
                   'tasa' => $this->input->post('tasa'),
                   'monto_solicitado' => $this->input->post('monto_solicitado'),
                   'id_moneda' => $this->input->post('id_moneda'),
                   'pie' => $this->input->post('pie'),
                   'valor_cuota' => $this->input->post('valor_cuota'),
                   'cuotas' => $this->input->post('cuotas'),
                   //'dia_vencimiento' => $this->input->post('dia_vencimiento'),
                   'observacion' => $this->input->post('observacion'),
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );

           $insert = $this->prestamo->guarda_prestamo($data);



            //TABLA MOVIMIENTO
            $monto_solicitado = $this->input->post('monto_solicitado');
            $valor_cuota = $this->input->post('valor_cuota');
            $cuotas = $this->input->post('cuotas');
      
            $data_mov = array(
                    'fecha_registro' => $this->input->post('fecha_colocacion'), //movimiento                 
                    'id_tipo_movimiento' => 2, //movimiento_detalle
                    'id_empresa_guarda' => $this->input->post('id_empresa_guarda'), //movimiento
                    'id_cuenta' => $this->input->post('id_cuenta_p'), //movimiento
                    'id_subcuenta' => $ultimo_insert_subcuenta, //movimiento
                    'id_tipo_documento' => 60, //movimiento_detalle
                    'numero_tipo_documento' => '', //movimiento_detalle
                    'monto' => $valor_cuota, //movimiento_detalle
                    'monto_cuenta_banco' => 0, //movimiento_detalle
                    'monto_cuenta_prestamo' => $valor_cuota, //movimiento_detalle
                    'valor_cuota' => $valor_cuota, //movimiento_detalle
                    'cuotas' => $cuotas, //movimiento_detalle
                    'monto_nota_credito' => 0, //movimiento_detalle
                    'fecha_ingreso' => $this->input->post('fecha_colocacion'), //movimiento_detalle
                    'fecha_pago' => '0000-00-00', //movimiento_detalle
                    'mes_iva' => date('m'), //movimiento_detalle
                    'año_iva' => date('Y'), //movimiento_detalle
                    'id_tipo_estado_movimiento' => 2, //movimiento_detalle
                    'id_banco' => 0, //movimiento_detalle
                    'id_condicion_pago' => '', //movimiento_detalle
                    'numero_voucher' => '', //movimiento_detalle
                    'observaciones' => '',  //movimiento_detalle
                    'usuario_guarda' => $this->input->post('usuario_guarda'), //movimiento_detalle
                    'fecha_guarda' => date("Y-m-d H:i:s"), //movimiento_detalle
                    'estado' => 1 //movimiento_detalle

                );

             $insert = $this->prestamo->guarda_prestamo_mov($data_mov);
             echo json_encode(array("status" => TRUE));

       }


        public function ajax_edit_prestamo($id)
        {
           $data = $this->prestamo->get_by_id($id);
           echo json_encode($data);
        }

       public function ajax_consulta_empresa_madre($hold)
       {  
           $hold = 1;
           $data = $this->empresa->get_empresa_madre_exists($hold);
           echo json_encode($data);
       }

        public function ajax_param_empresa($id)
        {
           $data = $this->empresa->get_by_param($id);
           echo json_encode($data);
        }


        public function ajax_servi_empresa($id)
        {
           $data = $this->empresa->get_by_serv($id);
           echo json_encode($data);
        }

        function update_prestamo(){

        $this->_validate_prestamo();

        $data = array(
            
            'id_cuenta' => $this->input->post('id_cuenta_p'),
            'nombre_prestamo' => $this->input->post('nombre_prestamo'),
            'fecha_colocacion' => $this->input->post('fecha_colocacion'),
            'tasa' => $this->input->post('tasa'),
            'monto_solicitado' => $this->input->post('monto_solicitado'),
            'id_moneda' => $this->input->post('id_moneda'),
            'pie' => $this->input->post('pie'),
            'valor_cuota' => $this->input->post('valor_cuota'),
            'cuotas' => $this->input->post('cuotas'),
            //'dia_vencimiento' => $this->input->post('dia_vencimiento'),
            'observacion' => $this->input->post('observacion'),
            'usuario_modifica' => $this->input->post('usuario_guarda'),
            'fecha_modifica' => date("Y-m-d H:i:s"),
            'estado' => $this->input->post('estado')
            );

           $this->prestamo->update(array('id_prestamo' => $this->input->post('id_prestamo')), $data);
           echo json_encode(array("status" => TRUE));


         //}

        }


        private function _validate_prestamo()
        {
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;
            
            //NOMBRE PRESTAMO
            if(empty($this->input->post('id_cuenta_p')))
            {
                $data['inputerror'][] = 'id_cuenta_p';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            //NOMBRE PRESTAMO
            if(empty($this->input->post('nombre_prestamo')))
            {
                $data['inputerror'][] = 'nombre_prestamo';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            //FECHA COLOCACION
            if(empty($this->input->post('fecha_colocacion')))
            {
                $data['inputerror'][] = 'fecha_colocacion';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            //TASA
            /*if(empty($this->input->post('tasa')))
            {
                $data['inputerror'][] = 'tasa';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if(!empty($this->input->post('tasa')))
            {
                if(!is_numeric($this->input->post('tasa')))
                {
                    $data['inputerror'][] = 'tasa';
                    $data['error_string'][] = '* Sólo números';
                    $data['status'] = FALSE;
                }
            }*/

            //MONTO SOLICITADO
            if(empty($this->input->post('monto_solicitado')))
            {
                $data['inputerror'][] = 'monto_solicitado';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if(!empty($this->input->post('monto_solicitado')))
            {
                if(!is_numeric($this->input->post('monto_solicitado')))
                {
                    $data['inputerror'][] = 'monto_solicitado';
                    $data['error_string'][] = '* Sólo números';
                    $data['status'] = FALSE;
                }
            }

            //MONEDA
            if(empty($this->input->post('id_moneda')))
            {
                $data['inputerror'][] = 'id_moneda';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            //PIE
            /*if(empty($this->input->post('pie')))
            {
                $data['inputerror'][] = 'pie';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if(!empty($this->input->post('pie')))
            {
                if(!is_numeric($this->input->post('pie')))
                {
                    $data['inputerror'][] = 'pie';
                    $data['error_string'][] = '* Sólo números';
                    $data['status'] = FALSE;
                }
            }*/

            //CUOTAS
            if(empty($this->input->post('cuotas')))
            {
                $data['inputerror'][] = 'cuotas';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if(!empty($this->input->post('cuotas')))
            {
                if(!is_numeric($this->input->post('cuotas')))
                {
                    $data['inputerror'][] = 'cuotas';
                    $data['error_string'][] = '* Sólo números';
                    $data['status'] = FALSE;
                }
            }

            //VALOR CUOTAS
            if(empty($this->input->post('valor_cuota')))
            {
                $data['inputerror'][] = 'valor_cuota';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if(!empty($this->input->post('valor_cuota')))
            {
                if(!is_numeric($this->input->post('valor_cuota')))
                {
                    $data['inputerror'][] = 'valor_cuota';
                    $data['error_string'][] = '* Sólo números';
                    $data['status'] = FALSE;
                }
            }

            //DIA VENCIMIENTO
            /*if(empty($this->input->post('dia_vencimiento')))
            {
                $data['inputerror'][] = 'dia_vencimiento';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }*/
        

            if($data['status'] === FALSE)
            {
                echo json_encode($data);
                exit();
            }
        }
    
}

?>
