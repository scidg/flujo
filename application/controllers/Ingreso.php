<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Ingreso extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ingreso_model', 'ingreso');
        $this->load->model('Empresa_model', 'empresa');
        $this->load->model('Subcuenta_model', 'subcuenta');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->model('Historico_model', 'historico');
        $this->load->model('Servicio_model', 'servicio');

        $this->isLoggedIn();
    }

    public function llena_subcuentas($id_cuenta) {
        $options = "";
        if ($id_cuenta) {
            $subcuentas = $this->ingreso->trae_subcuentas($id_cuenta);
            echo '<option value="">--Seleccione--</option>';
            foreach ($subcuentas as $fila) {
                ?>

                <option value="<?= $fila->id_subcuenta ?>"><?= $fila->nombre_subcuenta ?></option>
                <?php
            }
        }
    }

    public function muestra_periodo_iva($id_tipo_documento) {
        $data = $this->ingreso->trae_con_iva($id_tipo_documento);
        echo json_encode($data);
    }

    //HAmestica: ordenar sub cuentas
    //public function ingreso($i, $fechaactual) {
    public function ingreso($i, $fechaactual,$orden='subcuenta',$direccion='asc',$fecha_ini='',$fecha_fin='') {

        //HAmestica: variables para ordenar sub cuentas
        $_SESSION['orden_subcuenta'] = $orden;
        $_SESSION['orden_subcuenta_direccion'] = $direccion;
        $_SESSION['orden_subcuenta_fecini'] = $fecha_ini;
        $_SESSION['orden_subcuenta_fecfin'] = $fecha_fin;
        
        //echo $fechaactual."<br>"; 
        $fechaactual = strtr($fechaactual, array('.' => '+', '-' => '=', '~' => '/'));
        $fechaactual = $this->encryption->decrypt($fechaactual);
        //echo $fechaactual;
        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $this->global['pageTitle'] = 'Ingresos Movimientos - Flujo de Caja';
        $this->global['id_empresa'] = $i;
        $this->global['fecha_actual'] = $fechaactual;
        $this->global['mostrar_cuenta'] = $this->ingreso->muestra_cuenta($i);
        
        //HAmestica: Mostrar sub cuentas ordenadas
        // $this->global['mostrar_subcuenta'] = $this->ingreso->muestra_subcuenta($i);
        $this->global['mostrar_subcuenta'] = $this->ingreso->muestra_subcuenta($i,$_SESSION['orden_subcuenta'],$_SESSION['orden_subcuenta_direccion'],$_SESSION['orden_subcuenta_fecini'],$_SESSION['orden_subcuenta_fecfin']);

        $this->global['mostrar_servicios_primera_quincena'] = $this->servicio->get_servicios($i,1);
        $this->global['mostrar_servicios_segunda_quincena'] = $this->servicio->get_servicios($i,2);

        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i, $iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        //$this->global['devuelveParametroCalendario'] = $this->ingreso->devuelveParametroCalendario($i);
        $this->global['trae_ingresos'] = $this->ingreso->trae_ingresos($i);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
        //echo 'ya';
        //exit();
        
        $this->loadViews("view_excel_ingreso", $this->global, NULL, NULL);
        //}
    }

    public function listado($i) {

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $this->global['pageTitle'] = 'Ingresos Listado - Flujo de Caja';
        $this->global['id_empresa'] = $i;
        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i, $iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        //$this->global['devuelveParametroCalendario'] = $this->ingreso->devuelveParametroCalendario($i);
        $this->global['trae_ingresos'] = $this->ingreso->trae_ingresos($i);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);

        $this->loadViews("view_listado_ingreso", $this->global, NULL, NULL);
        // }
    }

    public function lista_ingreso($i) {
        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */

        $list = $this->ingreso->get_datatables($i);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ingreso) {
            $no++;
            $row = array();
            $row[] = $ingreso->id_movimiento;
            $row[] = $ingreso->nombre_cuenta;
            $row[] = $ingreso->nombre_subcuenta;
            $row[] = fecha_espanol($ingreso->fecha_registro);
            /*$row[] = formato_precio($ingreso->monto_total);
            $row[] = formato_precio($ingreso->monto_cuenta_banco);
            $row[] = $ingreso->cant_doc;*/

            //$row[] = $ingreso->estado;
            if($_SESSION['ing_lis_act']==1){
                $onclick='onclick="activar(' . "'" . $ingreso->id_movimiento . "'" . ')"';
            }else{
                $onclick='';
            }

            $row[] = ($ingreso->estado) ? '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Activado"><i class="con icon-ok"></i>ACTIVO</a>' : '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Anulado" '.$onclick.'><i class="con icon-remove"></i>ANULADO</a>';

            $row[] = '
            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Detalle movimiento" onclick="detalle_ingreso(' . "'" . $ingreso->id_movimiento . "'" . ')"><i class="glyphicon glyphicon-search"></i></a>';

            $row[] = '
            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_ingreso(' . "'" . $ingreso->id_movimiento . "'" . ')"><i class="glyphicon glyphicon-road"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ingreso->count_all($i),
            "recordsFiltered" => $this->ingreso->count_filtered($i),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
        //}
    }

    public function ajax_data_ingreso($id) {
        $data = $this->ingreso->get_by_id($id);
        echo json_encode($data);
    }

    public function get_detalle_ingreso($id) {
        $data = $this->ingreso->get_detalle_ingreso($id);
        echo json_encode($data);
    }

    public function del_document($idmd) {
        $data = $this->ingreso->eliminar_documento($idmd);
        echo json_encode($data);
    }

    public function movimiento($idem, $idmov) {
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

        
        $this->global['id_empresa'] = $idem;
        $this->global['id_movimiento'] = $id_mo1;

        if ($id_mo1 == 0) { //nueva
            $id_m = 0;
            list($id_c, $id_s, $fi, $ft) = explode("n", $id_res_desencript);
            $this->global['id_m'] = $id_m;
            $this->global['id_c'] = $id_c;
            $this->global['id_s'] = $id_s;
            $this->global['fi'] = $fi;
            $this->global['ft'] = $ft;
            $this->global['data_movimiento_detalle'] = '';
            $this->global['cuenta_banco'] = $this->ingreso->devuelveCuentaBanco($id_c);
            $this->global['nombre_cuenta'] = $this->ingreso->devuelveNombreCuenta($id_c);
            $this->global['nombre_subcuenta'] = $this->ingreso->devuelveNombreSubcuenta($id_s);
            $this->global['pageTitle'] = 'Creación Ingreso  - Flujo de Caja';
        } else {//editar
            list($fis, $fts) = explode("n", $id_res_desencript);
            $id_m = $id_mo1;
            $this->global['idmov'] = $idmov;
            $this->global['id_m'] = $id_m;
            $this->global['id_me'] = $id_res_desencript;
            $this->global['id_c'] = '';
            $this->global['id_s'] = '';
            $this->global['fi'] = $fis;
            $this->global['ft'] = $fts;
            $this->global['data_movimiento_detalle'] = $this->ingreso->data_movimiento($id_m);
            $this->global['data_movimiento_sinrango'] = $this->ingreso->data_movimiento_sinrango($id_m, $fis, $fts);
            $this->global['pageTitle'] = 'Edición Ingreso  - Flujo de Caja';

        }

        $this->global['mostrar_cuenta'] = $this->ingreso->muestra_cuenta($idem);
        $this->global['mostrar_subcuenta'] = $this->subcuenta->mostrar_subcuentas($idem);
        $this->global['mostrar_tipo_documento'] = $this->ingreso->muestra_tipo_documento($idem);
        $this->global['mostrar_condicion_pago'] = $this->ingreso->mostrar_condicion_pago($idem);
        $this->global['mostrar_estado_movimiento'] = $this->ingreso->trae_estado_movimiento();
        $this->global['mostrar_banco'] = $this->ingreso->muestra_banco($idem);
        $this->global['devuelve_ultimo_id_ingreso'] = $this->ingreso->devuelve_ultimo_id_ingreso();



        $this->global['trae_ingresos'] = $this->ingreso->trae_ingresos($idem);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($idem);
        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($idem, $iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);

        $this->loadViews("view_ingreso_header", $this->global, NULL, NULL);
        //}
    }

    function anular_ingreso() {

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $data = array(
            'estado' => 0
        );

        $this->ingreso->anula(array('id_movimiento' => $this->input->post('id_movimiento')), $data);
        echo json_encode(array("status" => TRUE));

        // }
    }

    function activar_ingreso() {

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $data = array(
            'estado' => 1
        );

        $this->ingreso->activa(array('id_movimiento' => $this->input->post('id_movimiento')), $data);
        echo json_encode(array("status" => TRUE));

        // }
    }

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
    }

    public function devuelve_servicio_editar() {
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $rs = $this->ingreso->devuelve_servicio_mostrar(array_merge((array) $data, array('id_empresa_guarda' => $this->input->post('ide'))));
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
    
    public function devuelve_servicio_editar_popup() {


        $data = array(
            'id_empresa_guarda' => $this->input->post('e'),
            'mes' => $this->input->post('m'),
            'ano' => $this->input->post('a'),
            'id_quincena' => $this->input->post('s'),
            //'id_servicio' => $this->input->post('s')
        );
        $consulta = $this->ingreso->devuelve_servicio_editar($data);
        echo json_encode($consulta);
    }

    public function update_ingreso_total() {
        $data = array(
            'estado' => $this->input->post('estado')
        );
        $consulta = $this->ingreso->actualiza_quincena(array('lunes_quincena' => $this->input->post('lunes_quincena'),'id_empresa_guarda' => $this->input->post('id_empresa_guarda')), $data);
        echo json_encode($consulta);
    }

    public function returns_total_income() {
        
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {

            $rs = $this->ingreso->consulta_ingreso_total(array_merge((array) $data, array('id_empresa_guarda' => $this->input->post('ide'), 'id_tipo_movimiento' => $this->input->post('idtm'))));
            $arr = (array) $data;
            $montquintotal = 0;
            $fecha = explode('-', $arr['fi']);
            if (is_array($fecha)) {
                if (count($fecha) > 1) {
                    $fecha_2 = $fecha[0] . '-' . $fecha[1] . '-' . $fecha[2];
                    if ($arr['fi'] === $fecha_2) {
                        $ventars = $this->historico->trae_euincena(array(
                            'fi' => $arr['fi'],
                            'ft' => $arr['ft'],
                            'id_empresa_guarda' => $this->input->post('ide')
                        ));
                        if (is_array($ventars)) {

                            foreach ($ventars as $key => $rs_quin) {
                                $view = (array) $rs_quin;
                                $montquintotal = $montquintotal + intval($view['monto_quincena']);
                            }
                        }
                        /*if ($montquintotal <= 0) {
                            $ivars = $this->historico->trae_iba(array(
                                'lunes_iva' => $arr['fi'],
                                'id_empresa_guarda' => $this->input->post('ide')
                            ));

                            if (is_array($ivars)) {
                                foreach ($ivars as $key => $rs_iva) {
                                    $view = (array) $rs_iva;
                                    $montquintotal = intval($view['monto_iva']);
                                }
                            }
                        }*/
                    }
                }
            }
            if ($rs) {

                $json = array();
                foreach ($rs as $key => $val) { //$montquintotal
                    $json[$key] = array(
                        'data' => (array) $data,
                        'result' => $val,
                        'montquintotal' => $montquintotal
                    );
                }
                $arg[] = $json;
            } else {
                $arg[] = array(
                    'data' => (array) $data,
                    'result' => $rs,
                    'montquintotal' => $montquintotal
                );
            }
        }

        echo json_encode($arg);
    }

    public function returns_cumulative_increase() {
        $first = true;
        $OnlyOne = true;
        $lastamount = 0;
        $arg = array();
        $TotalProviders=0;
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = (array) $data;
            //echo $this->input->post('idtm') .'<br>'.$arr['ft'].'<br>';
            
            
            if ($OnlyOne) {
                /*$rs = $this->ingreso->sum_consulta_ingreso_total(
                    array_merge($arr, 
                    array('id_empresa_guarda' => $this->input->post('ide'),
                     'id_tipo_movimiento' => $this->input->post('idtm'))));*/
                $rs = $this->ingreso->sum_consulta_ingreso_total(
                    array_merge(array('ft'=>date ( 'Y-m-j', strtotime('-1 day',strtotime ($arr['fi'])))), 
                    array('id_empresa_guarda' => $this->input->post('ide'),
                     'id_tipo_movimiento' => $this->input->post('idtm'))));                     
                      
                $providers = $this->ingreso->consulta_ingreso_total(
                    array_merge(array(
                        'fi'=>'1900-01-01',
                        'ft'=>date ( 'Y-m-j', strtotime('-1 day',strtotime ($arr['fi'])))
                    ), 
                    array('id_empresa_guarda' => $this->input->post('ide'),
                     'id_tipo_movimiento' => $this->input->post('idtm'))));
                    if(is_array($providers)){
                        foreach ($providers as $provider) {
                            $TotalProviders+=floatval($provider->monto_cuenta_banco);
                        }
                    }
                if(is_array($rs)){
                    //echo '<pre>';
                    //var_dump($rs);
                    foreach($rs as $obj){
                        $amount = (array) $obj;
                        $lastamount +=intval($amount['monto']);
                        //agrego esta linea ya que no estaba llevando el monto cuenta banco al periodo siguiente
                        $lastamount +=intval($amount['monto_cuenta_banco']);
                    }
                }
                
                $last = $this->historico->sum_trae_euincena(array(
                    'lunes_quincena' => $arr['fi'],
                    'id_empresa_guarda' => $this->input->post('ide')
                )); 
                if (isset($last[0])) {
                    $lastamount += intval($last[0]->monto_total_quincena);
                }
                
                    //echo '<pre>';
                    //echo $arr['fi'];echo '<br>'.$this->input->post('ide').'<br//>';
                    //var_dump($lastiva);
                //if ($lastamount <= 0) {
                    
                    //if (isset($lastiva[0])) {
                        /*$lastiva = $this->historico->sum_trae_iba(array(
                            'lunes_iva' => $arr['fi'],
                            'id_empresa_guarda' => $this->input->post('ide')
                        ));
                        $lastamount += (intval($lastiva[0]->monto_total_iva)/2);*/
                    //}
                //}
                //var_dump($lastamount);//exit();
                $OnlyOne = false;
            }
            if ($first) {
                $rs = $this->ingreso->consulta_ingreso_acum(array_merge(array('fi' => $arr['fi_a'], 'ft' => $arr['ft']), array('id_empresa_guarda' => $this->input->post('ide'), 'id_tipo_movimiento' => $this->input->post('idtm'))));
                if (!is_null($rs->monto_total_sem)) {
                    $first = false;
                }
            } else {
                $rs = (object) array('monto_total_sem' => '0', 'monto_banco_total_sem' => '0', 'monto_nota_credito_total_sem' => '0');
            }
            $montquintotal = 0;
            $fecha = explode('-', $arr['fi']);
            if (is_array($fecha)) {
                if (count($fecha) > 1) {
                    $fecha_2 = $fecha[0] . '-' . $fecha[1] . '-' . $fecha[2];
                    if ($arr['fi'] === $fecha_2) {
                        $ventars = $this->historico->trae_euincena(array(
                            'fi' => $arr['fi'],
                            'ft' => $arr['ft'],
                            'id_empresa_guarda' => $this->input->post('ide')
                        ));
                        if (is_array($ventars)) {
                            foreach ($ventars as $key => $rs_quin) {
                                $view = (array) $rs_quin;
                                $montquintotal = intval($view['monto_quincena']);
                            }
                        }
                        /*if ($montquintotal <= 0) {
                            $ivars = $this->historico->trae_iba(array(
                                'lunes_iva' => $arr['fi'],
                                'id_empresa_guarda' => $this->input->post('ide')
                            ));

                            if (is_array($ivars)) {
                                foreach ($ivars as $key => $rs_iva) {
                                    $view = (array) $rs_iva;
                                    $montquintotal = intval($view['monto_iva']);
                                }
                            }
                        }*/
                    }
                }
            }
            /* if ($rs) {
              $json = array();
              foreach ($rs as $key => $val) { //$montquintotal
              $json[$key] = array(
              'data' => (array) $data,
              'result' => $val,
              'montquintotal' => $montquintotal
              );
              }
              $arg[] = $json;
              } else { */

            $arg[] = array(
                'data' => (array) $data,
                'provider'=>$TotalProviders,
                'result' => $rs,
                'montquintotal' => $montquintotal,
                'lastamount' => count($arg) === 0 ? $lastamount : 0
            );
            //}
        }
        echo json_encode($arg);
    }

    public function consulta_movimiento() {
        $data = array(
            'idc' => $this->input->post('idc'),
            'ids' => $this->input->post('ids'),
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide'),
            'id_tipo_movimiento' => $this->input->post('idtm')
        );
        $consulta = $this->ingreso->consulta_movimiento($data);
        echo json_encode($consulta);
    }

    public function return_all_increase() {
        $arg = [];
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = array_merge((array) $data,
                array(
                    'id_tipo_movimiento' => $this->input->post('idtm')
                )
            );
            $monto = 0;
            $rs = $this->ingreso->consulta_res_ing($arr);
            if(is_array($rs)){
                foreach ($rs as $val) {
                    $monto += intval($val->monto_resumen_ingreso);
                    $monto += intval($val->monto_cuenta_banco);
                }
            }
            $arg[] = array_merge(
                array('monto'=>$monto),
                (array) $data
            );
        }
        echo json_encode($arg);
    }

    public function return_all_egress() {
        $arg = [];
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = array_merge((array) $data,
                array(
                    'id_tipo_movimiento' => $this->input->post('idtm')
                )
            );
            $monto = 0;
            $rs = $this->ingreso->consulta_res_egr($arr);
            if(is_array($rs)){
                foreach ($rs as $val) {
                    $monto += intval($val->monto_resumen_egreso);
                    $monto += intval($val->monto_cuenta_banco);

                }
            }
            $arg[] = array_merge(
                array('monto'=>$monto),
                (array) $data
            );
        }
        echo json_encode($arg);
    }

    public function return_accumulated() {
        $arg = [];
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = array_merge((array) $data,
                array(
                    'id_tipo_movimiento' => $this->input->post('idtm')
                )
            );
            $ingreso = 0;
            $ingresos = $this->ingreso->consulta_res_ing(
                array(
                    'id_empresa_guarda'=>$arr['id_empresa_guarda'],
                    'id_tipo_movimiento' => 1,
                    'fi' => '1900-01-01',
                    'ft'=> date ('Y-m-d', strtotime('-1 day', strtotime($arr['fi'])))
                )
            );
            if(is_array($ingresos)){
                foreach ($ingresos as $val) {
                    $ingreso += intval($val->monto_resumen_ingreso);
                    $ingreso += intval($val->monto_cuenta_banco);
                }
            }
            if(is_object($ingresos)){
                $ingreso += intval($ingresos->monto_resumen_ingreso);
            }
            $egreso = 0;
            $egresos = $this->ingreso->consulta_res_egr(
                array(
                    'id_empresa_guarda'=>$arr['id_empresa_guarda'],
                    'id_tipo_movimiento' => 2,
                    'fi' => '1900-01-01',
                    'ft'=> date ('Y-m-d', strtotime('-1 day', strtotime($arr['fi'])))
                )
            );
            if(is_array($egresos)){
                foreach ($egresos as $val) {
                    $egreso += intval($val->monto_resumen_egreso);
                    $egreso += intval($val->monto_cuenta_banco);

                }
            }
            if(is_object($egresos)){
                $egreso += intval($egresos->monto_resumen_egreso);
            }
            $monto = 0;
            $rs = $this->ingreso->consulta_res_acum(array(
                'id_empresa_guarda'=>$arr['id_empresa_guarda'],
                'id_tipo_movimiento' => 2,
                'fi' => '1900-01-01',
                'ft'=> $arr['ft']
            ));
            if(is_array($rs)){
                foreach ($rs as $val) {
                    $monto += intval($val->monto_acum);
                }
            }
            if(is_object($rs)){
                $monto += intval($rs->monto_acum);
            }
            $monto =  $monto-($monto-($ingreso-$egreso));
            $data->fi = date('Y-m-d', strtotime('-7 day', strtotime($arr['fi'])));
            $data->ft = date('Y-m-d', strtotime('-1 day', strtotime($arr['fi'])));
            $arg[] = array_merge(
                array('ingreso'=>$ingreso),
                array('egreso'=>$egreso),
                array('monto'=>$monto),
                (array) $data
            );
        }
        echo json_encode($arg);
    }


    public function devuelve_resumen_ingreso() {
        $data = array(
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide'),
            'id_tipo_movimiento' => $this->input->post('idtm')
        );
        $consulta = $this->ingreso->consulta_res_ing($data);
        echo json_encode($consulta);
    }


    public function devuelve_resumen_egreso() {
        $data = array(
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide'),
            'id_tipo_movimiento' => $this->input->post('idtm')
        );
        $consulta = $this->ingreso->consulta_res_egr($data);
        echo json_encode($consulta);
    }

    public function consulta_ingreso_total() {
        $data = array(
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide'),
            'id_tipo_movimiento' => $this->input->post('idtm')
        );
        $consulta = $this->ingreso->consulta_ingreso_total($data);
        echo json_encode($consulta);
    }

    public function consulta_ingreso_acum() {
        $data = array(
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide'),
            'id_tipo_movimiento' => $this->input->post('idtm')
        );
        $consulta = $this->ingreso->consulta_ingreso_acum($data);
        echo json_encode($consulta);
    }

    public function devuelve_resumen_acumulado() {
        $data = array(
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide'),
            'id_tipo_movimiento' => $this->input->post('idtm')
        );
        $consulta = $this->ingreso->consulta_res_acum($data);
        echo json_encode($consulta);
    }

    function save_ingreso() {

        $this->_validate_ingreso();

        $cuenta_banco = $this->input->post('cuenta_banco');
        $monto_cuenta_banco = $this->input->post('monto_cuenta_banco');
        $iva_disabled = $this->input->post('iva_disabled');
        $es_nota_credito = $this->input->post('es_nota_credito');
        $mes_iva_save = $this->input->post('mes_iva');
        $año_iva_save = $this->input->post('año_iva');
        $monto_save = $this->input->post('monto');

        for ($i = 0; $i < count($iva_disabled); $i++) {

            if (!$mes_iva_save[$i]) {
                $mes_iva_save[$i] = '0';
            }
            if (!$año_iva_save[$i]) {
                $año_iva_save[$i] = '0';
            }
        }


        for ($j = 0; $j < count($es_nota_credito); $j++) {

            if ($es_nota_credito[$j] == 0) {
                if (isset($monto_save[$j])) {
                    $monto[$j] = $monto_save[$j];
                    $monto_nota_credito[$j] = 0;
                }
            } else {
                if (isset($monto_save[$j])) {
                    $monto_nota_credito[$j] = $monto_save[$j];
                    $monto[$j] = 0;
                }
            }
        }



        if (isset($monto_cuenta_banco)) {
            $monto_cuenta_banco = $monto_cuenta_banco;
            $monto = '0';
            $monto_nota_credito = '0';
        } else {
            $monto_cuenta_banco = '0';
        }

        $id_tipo_documento_save = $this->input->post('id_tipo_documento');
        if (isset($id_tipo_documento_save)) {
            $id_tipo_documento_save = $id_tipo_documento_save;
        } else {
            $id_tipo_documento_save = '0';
        }
        $numero_tipo_documento_save = $this->input->post('numero_tipo_documento');
        if (isset($numero_tipo_documento_save)) {
            $numero_tipo_documento_save = $numero_tipo_documento_save;
        } else {
            $numero_tipo_documento_save = '0';
        }


        $fecha_ingreso_save = $this->input->post('fecha_ingreso');

        if (isset($fecha_ingreso_save)) {
            $fecha_ingreso_save = $fecha_ingreso_save;
        } else {
            $fecha_ingreso_save = '0';
        }

        $fecha_pago_save = $this->input->post('fecha_pago');
        if (isset($fecha_pago_save)) {
            $fecha_pago_save = $fecha_pago_save;
        } else {
            $fecha_pago_save = '0';
        }

        $id_tipo_estado_movimiento_save = $this->input->post('id_tipo_estado_movimiento');
        if (isset($id_tipo_estado_movimiento_save)) {
            $id_tipo_estado_movimiento_save = $id_tipo_estado_movimiento_save;
        } else {
            $id_tipo_estado_movimiento_save = '2';
        }
        $id_banco_save = $this->input->post('id_banco');
        if (isset($id_banco_save)) {
            $id_banco_save = $id_banco_save;
        } else {
            $id_banco_save = '0';
        }
        $id_condicion_pago_save = $this->input->post('id_condicion_pago');
        if (isset($id_condicion_pago_save)) {
            $id_condicion_pago_save = $id_condicion_pago_save;
        } else {
            $id_condicion_pago_save = '0';
        }
        $numero_voucher_save = $this->input->post('numero_voucher');
        if (isset($numero_voucher_save)) {
            $numero_voucher_save = $numero_voucher_save;
        } else {
            $numero_voucher_save = '0';
        }
        $observaciones_save = $this->input->post('observaciones');
        if (isset($observaciones_save)) {
            $observaciones_save = $observaciones_save;
        } else {
            $observaciones_save = '0';
        }
        $estado_save = 1;

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */

        $data = array(
            'fecha_registro' => $this->input->post('fecha_registro'),
            'cuenta_banco' => $cuenta_banco,
            'monto_cuenta_banco' => $monto_cuenta_banco,
            'id_tipo_movimiento' => 1,
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
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/

        $insert = $this->ingreso->guarda($data);
        echo json_encode(array("status" => TRUE));
        // }
    }

    function save_servicio_quincena() {

        $this->_validate_servicio_quincena1();

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $cantidad_servicios1 = $this->input->post('cantidad_servicios1');
        $monto_servicio1 = $this->input->post('monto_servicio1');
        $id_servicio_q1 = $this->input->post('id_servicio_q1');

        for ($i = 0; $i < $cantidad_servicios1; $i++) {
            $monto_servicio_save[] = $monto_servicio1[$i];
        }

        for ($j = 0; $j < $cantidad_servicios1; $j++) {
            $id_servicio_q1_save[] = $id_servicio_q1[$j];
        }

        $data = array(
            'cantidad_servicios1' => $this->input->post('cantidad_servicios1'),
            'fecha_quincena1' => $this->input->post('fecha_quincena1'),
            'ano' => $this->input->post('ano_q1'),
            'mes' => $this->input->post('mes_q1'),
            'id_quiencena' => $this->input->post('id_quincena_q1'),
            'usuario_guarda' => $this->input->post('usuario_guarda'),
            'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
            'id_servicio' => $id_servicio_q1_save,
            'monto_servicio' => $monto_servicio_save,
            'fecha_guarda' => date("Y-m-d H:i:s"),
            'estado' => 1
        );
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        $insert = $this->ingreso->guarda_servicio_quincena($data);
        echo json_encode(array("status" => TRUE));

        //}
    }

    function save_servicio_quincena2() {

        $this->_validate_servicio_quincena2();

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $cantidad_servicios2 = $this->input->post('cantidad_servicios2');
        $monto_servicio2 = $this->input->post('monto_servicio2');
        $id_servicio_q2 = $this->input->post('id_servicio_q2');

        for ($i = 0; $i < $cantidad_servicios2; $i++) {
            $monto_servicio_save[] = $monto_servicio2[$i];
        }

        for ($j = 0; $j < $cantidad_servicios2; $j++) {
            $id_servicio_q1_save[] = $id_servicio_q2[$j];
        }

        $data = array(
            'cantidad_servicios2' => $this->input->post('cantidad_servicios2'),
            'fecha_quincena2' => $this->input->post('fecha_quincena2'),
            'ano' => $this->input->post('ano_q2'),
            'mes' => $this->input->post('mes_q2'),
            'id_quiencena' => $this->input->post('id_quincena_q2'),
            'usuario_guarda' => $this->input->post('usuario_guarda'),
            'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
            'id_servicio' => $id_servicio_q1_save,
            'monto_servicio' => $monto_servicio_save,
            'fecha_guarda' => date("Y-m-d H:i:s"),
            'estado' => 1
        );
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        $insert = $this->ingreso->guarda_servicio_quincena2($data);
        echo json_encode(array("status" => TRUE));

        //}
    }

    private function _validate_servicio_quincena1()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $cantidad_servicios1 = $this->input->post('cantidad_servicios1');
        $monto_servicio1 = $this->input->post('monto_servicio1');
        
       if(empty($this->input->post('fecha_quincena1')))
        {
            $data['inputerror'][] = 'fecha_quincena1';
            $data['error_string'][] = '* Requerido';
            $data['status'] = FALSE;
        }


        for ($i = 0; $i < $cantidad_servicios1; $i++) {
            //$monto_servicio_save[] = $monto_servicio1[$i];
            //echo $monto_servicio1[$i];
            if($monto_servicio1[$i] < 0){
                //echo "hola";
                $data['inputerror'][] = 'monto_servicio1'.$i;
                $data['error_string'][] = '* Requeridos';
                $data['status'] = FALSE;
            
            }/*else{*/

                if (!is_numeric($monto_servicio1[$i])) {

                    $data['inputerror'][] = 'monto_servicio1'.$i;
                    $data['error_string'][] = '* Solo digitos';
                    $data['status'] = FALSE;
                }
            //}
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }

    }

    private function _validate_servicio_quincena2()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $cantidad_servicios2 = $this->input->post('cantidad_servicios2');
        $monto_servicio2 = $this->input->post('monto_servicio2');
        
       if(empty($this->input->post('fecha_quincena2')))
        {
            $data['inputerror'][] = 'fecha_quincena2';
            $data['error_string'][] = '* Requerido';
            $data['status'] = FALSE;
        }


        for ($i = 0; $i < $cantidad_servicios2; $i++) {
            //$monto_servicio_save[] = $monto_servicio1[$i];
            //echo $monto_servicio1[$i];
            if ($monto_servicio2[$i] < 0){
                //echo "hola";
                $data['inputerror'][] = 'monto_servicio2'.$i;
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            
            }/*else{*/

                if (!is_numeric($monto_servicio2[$i])) {

                    $data['inputerror'][] = 'monto_servicio2'.$i;
                    $data['error_string'][] = '* Solo digitos';
                    $data['status'] = FALSE;
                }
            //}
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }

    }

    function update_ingreso() {

        $this->_validate_ingreso();

        $cuenta_banco = $this->input->post('cuenta_banco');
        $monto_cuenta_banco = $this->input->post('monto_cuenta_banco');
        $iva_disabled_upd = $this->input->post('iva_disabled');
        $param_fecha_inicio = $this->input->post('param_fecha_inicio');
        $es_nota_credito_upd = $this->input->post('es_nota_credito');
        $mes_iva_upd = $this->input->post('mes_iva');
        $año_iva_upd = $this->input->post('año_iva');
        $monto_upd = $this->input->post('monto');

        for ($j = 0; $j < count($iva_disabled_upd); $j++) {

            if (!$mes_iva_upd[$j]) {
                $mes_iva_upd[$j] = '0';
            }
            if (!$año_iva_upd[$j]) {
                $año_iva_upd[$j] = '0';
            }
        }

        for ($k = 0; $k < count($es_nota_credito_upd); $k++) {

            if ($es_nota_credito_upd[$k] == 0) {
                if (isset($monto_upd[$k])) {
                    $monto_upd_ar[$k] = $monto_upd[$k];
                    $monto_nota_credito_upd_ar[$k] = 0;
                }
            } else {
                if (isset($monto_upd[$k])) {
                    $monto_nota_credito_upd_ar[$k] = $monto_upd[$k];
                    $monto_upd_ar[$k] = 0;
                }
            }
        }

        $id_movimiento_detalle_upd = $this->input->post('id_movimiento_detalle');
        if (isset($id_movimiento_detalle_upd)) {
            $id_movimiento_detalle_upd = $id_movimiento_detalle_upd;
        } else {
            $id_movimiento_detalle_upd = '0';
        }
        $id_movimiento_upd = $this->input->post('id_movimiento');
        if (isset($id_movimiento_upd)) {
            $id_movimiento_upd = $id_movimiento_upd;
        } else {
            $id_movimiento_upd = '0';
        }
        if (isset($monto_cuenta_banco)) {
            $monto_cuenta_banco = $monto_cuenta_banco;
            $monto_upd_ar = '0';
            $monto_nota_credito_upd_ar = '0';
        } else {
            $monto_cuenta_banco = '0';
        }
        $id_tipo_documento_upd = $this->input->post('id_tipo_documento');
        if (isset($id_tipo_documento_upd)) {
            $id_tipo_documento_upd = $id_tipo_documento_upd;
        } else {
            $id_tipo_documento_upd = '0';
        }
        $numero_tipo_documento_upd = $this->input->post('numero_tipo_documento');
        if (isset($numero_tipo_documento_upd)) {
            $numero_tipo_documento_upd = $numero_tipo_documento_upd;
        } else {
            $numero_tipo_documento_upd = '0';
        }


        $fecha_ingreso_upd = $this->input->post('fecha_ingreso');
        $fecha_ingreso_2_upd = $this->input->post('fecha_ingreso_2');

        if ($param_fecha_inicio == 1) {
            $fecha_ingreso_upd = $fecha_ingreso_upd;
        } else {
            $fecha_ingreso_upd = $fecha_ingreso_upd;
        }

        $fecha_pago_upd = $this->input->post('fecha_pago');
        if (isset($fecha_pago_upd)) {
            $fecha_pago_upd = $fecha_pago_upd;
        } else {
            $fecha_pago_upd = '0';
        }

        $id_tipo_estado_movimiento_upd = $this->input->post('id_tipo_estado_movimiento');
        if (isset($id_tipo_estado_movimiento_upd)) {
            $id_tipo_estado_movimiento_upd = $id_tipo_estado_movimiento_upd;
        } else {
            $id_tipo_estado_movimiento_upd = '2';
        }
        $id_banco_upd = $this->input->post('id_banco');
        if (isset($id_banco_upd)) {
            $id_banco_upd = $id_banco_upd;
        } else {
            $id_banco_upd = '0';
        }
        $id_condicion_pago_upd = $this->input->post('id_condicion_pago');
        if (isset($id_condicion_pago_upd)) {
            $id_condicion_pago_upd = $id_condicion_pago_upd;
        } else {
            $id_condicion_pago_upd = '0';
        }
        $numero_voucher_upd = $this->input->post('numero_voucher');
        if (isset($numero_voucher_upd)) {
            $numero_voucher_upd = $numero_voucher_upd;
        } else {
            $numero_voucher_upd = '0';
        }
        $observaciones_upd = $this->input->post('observaciones');
        if (isset($observaciones_upd)) {
            $observaciones_upd = $observaciones_upd;
        } else {
            $observaciones_upd = '0';
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
          $estado_upd = 1; */

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $data = array(
            'cant_mov_det2' => $this->input->post('cant_mov_det2'),
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

        $this->ingreso->update($data);
        echo json_encode(array("status" => TRUE));
        //}
    }

    private function _validate_ingreso() {
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


        for ($m = 0; $m < $cant_mov; $m++) {
            //echo ">".$numero_tipo_documento_val[$m];
            if ($id_tipo_documento_val[$m] == '') {
                $data['inputerror'][] = 'id_tipo_documento_' . $m;
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

            /*if (empty($numero_tipo_documento_val[$m])) {
                $data['inputerror'][] = 'numero_tipo_documento_' . $m;
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            } else {

                if (!is_numeric($numero_tipo_documento_val[$m])) {
                    $data['inputerror'][] = 'numero_tipo_documento_' . $m;
                    $data['error_string'][] = '* Sólo dígitos';
                    $data['status'] = FALSE;
                }
            }*/

            if (empty($monto_val[$m])) {
                $data['inputerror'][] = 'monto_' . $m;
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            } else {

                if (!is_numeric($monto_val[$m])) {
                    $data['inputerror'][] = 'monto_' . $m;
                    $data['error_string'][] = '* Sólo dígitos';
                    $data['status'] = FALSE;
                }
            }

            /* if($mes_iva_val[$m] == '')
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
              } */

            if ($id_tipo_estado_movimiento_val[$m] == '') {
                $data['inputerror'][] = 'id_tipo_estado_movimiento_' . $m;
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if (!empty($fecha_pago_val[$m]) && $id_tipo_estado_movimiento_val[$m] == 2) {

                $data['inputerror'][] = 'id_tipo_estado_movimiento_' . $m;
                $data['error_string'][] = '* Debe cambiar Estado a "PAGADO".';
                $data['status'] = FALSE;
            }

            if ($id_tipo_estado_movimiento_val[$m] == 1) {

                if ($id_banco_val[$m] == '') {
                    $data['inputerror'][] = 'id_banco_' . $m;
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if ($id_condicion_pago_val[$m] == '') {
                    $data['inputerror'][] = 'id_condicion_pago_' . $m;
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if ($numero_voucher_val[$m] != '') {
                    if (!is_numeric($numero_voucher_val[$m])) {
                        $data['inputerror'][] = 'numero_voucher_' . $m;
                        $data['error_string'][] = '* Sólo dígitos';
                        $data['status'] = FALSE;
                    }
                }

                if ($fecha_pago_val[$m] == '') {
                    
                    $data['inputerror'][] = 'fecha_pago_' . $m;
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;

                } /*else if (strtotime($fecha_pago_val[$m]) < strtotime($fecha_ingreso_val[$m])) {

                    $data['inputerror'][] = 'fecha_pago_' . $m;
                    $data['error_string'][] = '* F. Pago debe ser mayor a F. Ingreso';
                    $data['status'] = FALSE;
                }*/

                if ($param_fecha_inicio_val == 0) {

                    if ($fecha_pago_val[$m] == '') {
                        $data['inputerror'][] = 'fecha_pago_' . $m;
                        $data['error_string'][] = '* Requerido';
                        $data['status'] = FALSE;
                    
                    } /*else if (strtotime($fecha_pago_val[$m]) < strtotime($fecha_ingreso_val[$m])) {

                        $data['inputerror'][] = 'fecha_pago_' . $m;
                        $data['error_string'][] = '* F. Pago debe ser mayor a F. Ingreso 1';
                        $data['status'] = FALSE;
                    }*/

                } else {

                    if ($fecha_pago_val[$m] == '') {
                        $data['inputerror'][] = 'fecha_pago_' . $m;
                        $data['error_string'][] = '* Requerido';
                        $data['status'] = FALSE;
                    } /*else if (strtotime($fecha_pago_val[$m]) < strtotime($fecha_ingreso_2_val[$m])) {

                        $data['inputerror'][] = 'fecha_pago_' . $m;
                        $data['error_string'][] = '* F. Pago debe ser mayor a F. Ingreso';
                        $data['status'] = FALSE;
                    }*/
                }
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}
?>
