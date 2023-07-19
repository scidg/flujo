<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Historico extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cuenta_model', 'cuenta');
        $this->load->model('Subcuenta_model', 'subcuenta');
        $this->load->model('Empresa_model', 'empresa');
        $this->load->model('Sucursal_model', 'sucursal');
        $this->load->model('Proveedor_model', 'proveedor');
        $this->load->model('Cliente_model', 'cliente');
        $this->load->model('Banco_model', 'banco');
        $this->load->model('Servicio_otro_model', 'servicio_otro');
        $this->load->model('Malla_societaria_model', 'malla_societaria');
        $this->load->model('Iva_model', 'iva');
        $this->load->model('Linea_model', 'linea');
        $this->load->model('Moneda_model', 'moneda');
        $this->load->model('Tipo_documento_model', 'tipo');
        $this->load->model('Plazo_pago_model', 'plazo');
        $this->load->model('Condicion_pago_model', 'condicion');
        $this->load->model('Parametro_model', 'parametro');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->model('Historico_model', 'historico');

        $this->isLoggedIn();
    }

    public function index($i) {
        $id_user = $this->session->userdata('id_usuario');
        //$id_empresa_user = $this->session->userdata('id_empresa_user');
        //$this->global['id_empresa_user'] = $id_empresa_user;
        //$this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($id_empresa_user);
        $this->global['pageTitle'] = 'Flujo de Caja';

        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($id_user);
        $this->loadViews("view_main", $this->global, NULL, NULL);
    }

    public function historico($i) {
        $this->global['pageTitle'] = 'Histórico - Flujo de Caja';
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
        $this->global['nombre_empresa'] = devuelve_nombre_empresa($i);
        $this->global['es_casa_central'] = es_casa_central($i);
        $this->global['id_empresa'] = $i;
        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i, $iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        $this->global['mostrar_empresas_usuario_sin_em'] = $this->empresa->mostrar_empresas_usuario_sin_em($iu);
        $this->global['muestra_meses_venta'] = $this->historico->muestra_meses_venta();
        $this->global['muestra_anos_venta'] = $this->historico->muestra_anos_venta();
        $this->loadViews("view_historico", $this->global, NULL, NULL);
    }

    public function return_sale() {
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('l'))) as $data) {
            //$rs = $this->historico->devuelve_venta(array('lunes_quincena' => $data, 'id_empresa_guarda' => $this->input->post('e')));
            $rs = $this->historico->devuelve_venta(array_merge((array) $data, array('id_empresa_guarda' => $this->input->post('e'))));
            $arr = (array) $data;

            
            if ($rs) {
                /* $json = array();
                  foreach ($rs as $key => $val) {
                  $json[$key] = array_merge((array) $data, (array) $val);
                  } */
                $arg[] = $rs;
            }
        }

        echo json_encode($arg);
    }

    public function return_sale_resumen() {
        $arg = [];
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arr = array_merge((array) $data);
            $monto_quincena = 0;
            $lunes_quincena = '';
            $id_empresa_guarda = '';

            $rs = $this->historico->devuelve_venta_resumen($arr);

            if(is_array($rs)){
                foreach ($rs as $val) {
                    $monto_quincena += intval($val->monto_quincena);
                    $lunes_quincena .= $val->lunes_quincena;
                    $id_empresa_guarda .= $val->id_empresa_guarda;

                }
            }
            $arg[] = array_merge(
                array('monto_quincena'=>$monto_quincena,'lunes_quincena'=>$lunes_quincena,'id_empresa_guarda'=>$id_empresa_guarda),
                (array) $data
            );
        }
        echo json_encode($arg);
    }

    public function devuelve_venta() {
        $data = array(
            'lunes_quincena' => $this->input->post('l'),
            'id_empresa_guarda' => $this->input->post('e')
        );
        $consulta = $this->historico->devuelve_venta($data);
        echo json_encode($consulta);
    }

    public function trae_euincena() {
        $data = array(
            'fi' => $this->input->post('fi'),
            'ft' => $this->input->post('ft'),
            'id_empresa_guarda' => $this->input->post('ide')
        );
        $consulta = $this->historico->trae_euincena($data);
        echo json_encode($consulta);
    }

    public function trae_iba() {
        $data = array(
            'lunes_iva' => $this->input->post('fi'),
            'id_empresa_guarda' => $this->input->post('ide')
        );
        $consulta = $this->historico->trae_iba($data);
        echo json_encode($consulta);
    }

    
    public function return_sales_grid() {
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res' => $this->historico->devuelve_venta_grilla(array(
                    'id_año' =>$data->year,
                    'id_mes' => $data->month,
                    'id_empresa_guarda' => $this->input->post('e')
                )),
                'a'=>$data->year,
                'm'=>$data->month
            );
        }

        echo json_encode($arg);
    }

    public function return_tributario_grid() {
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res' => $this->historico->devuelve_tribut_grilla(array(
                    'id_año' =>$data->year,
                    'id_mes' => $data->month,
                    'id_empresa_guarda' => $this->input->post('e')
                )),
                'a'=>$data->year,
                'm'=>$data->month
            );
        }

        echo json_encode($arg);
    }

    public function return_sales_grid_consolidated() {
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res' => $this->historico->devuelve_venta_grilla_consolidada(array(
                    'id_año' =>$data->year,
                    'id_empresa_guarda' => $data->comp,
                )),
                'a'=>$data->year,
                'e'=>$data->comp
            );
        }

        echo json_encode($arg);
    }

    public function return_tribut_grid_consolidated() {
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res' => $this->historico->devuelve_tributo_grilla_consolidada(array(
                    'id_año' =>$data->year,
                    'id_empresa_guarda' => $data->comp,
                )),
                'a'=>$data->year,
                'e'=>$data->comp
            );
        }

        echo json_encode($arg);
    }

    public function devuelve_venta_grilla() {
        $data = array(
            'id_año' => $this->input->post('a'),
            'id_mes' => $this->input->post('m'),
            'id_empresa_guarda' => $this->input->post('e')
        );
        $consulta = $this->historico->devuelve_venta_grilla($data);
        echo json_encode($consulta);
    }

    public function return_total_year(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res'=>$this->historico->devuelve_venta_año(array(
                    'id_ano' =>$data->year,
                    'id_empresa_guarda' => $this->input->post('e')
                )),
                'a'=>$data->year
            );
        }

        echo json_encode($arg);
    }

    public function return_total_year_tribut(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res'=>$this->historico->devuelve_tributario_año(array(
                    'id_ano' =>$data->year,
                    'id_empresa_guarda' => $this->input->post('e')
                )),
                'a'=>$data->year
            );
        }

        echo json_encode($arg);
    }

    public function devuelve_total_ano() {
        $data = array(
            'id_ano' => $this->input->post('a'),
            'id_empresa_guarda' => $this->input->post('e')
        );
        $consulta = $this->historico->devuelve_venta_año($data);
        echo json_encode($consulta);
    }

    public function return_consolidated_year(){
        $arg = array();
        
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res'=> $this->historico->devuelve_consolidado_ano(array(
                    'id_ano' =>$data->year,'id_empresa_guarda' =>$data->comp
                )),
                'a'=>$data->year
            );
        }

        echo json_encode($arg);
    }

    public function return_consolidated_year_tribute(){
        $arg = array();
        foreach (json_decode(stripslashes($this->input->post('arg'))) as $data) {
            $arg[] = array(
                'res'=> $this->historico->devuelve_consolidado_tribut(array(
                    'id_ano' =>$data->year,'id_empresa_guarda' =>$data->comp
                )),
                'a'=>$data->year
            );
        }

        echo json_encode($arg);
    }

    public function devuelve_consolidado_ano() {
        $data = array(
            'id_ano' => $this->input->post('a'),
        );
        $consulta = $this->historico->devuelve_consolidado_ano($data);
        echo json_encode($consulta);
    }

    public function devuelve_venta_editar() {
        $data = array(
            'id_ano' => $this->input->post('a'),
            'id_mes' => $this->input->post('m'),
            //'id_quincena' => $this->input->post('idq'),
            'id_empresa_guarda' => $this->input->post('e')
        );
        $consulta = $this->historico->devuelve_venta_editar($data);
        echo json_encode($consulta);
    }

    public function devuelve_tributario_editar() {
        $data = array(
            'id_ano_trib' => $this->input->post('a'),
            'id_mes_trib' => $this->input->post('m'),
            'id_empresa_guarda' => $this->input->post('e')
        );
        $consulta = $this->historico->devuelve_tributario_editar($data);
        echo json_encode($consulta);
    }


    public function devuelve_var() {
        $data = array(
            'id_ano' => $this->input->post('a'),
            'id_ano_ant' => $this->input->post('aa'),
            'id_mes' => $this->input->post('m'),
            'id_empresa_guarda' => $this->input->post('e')
        );
        $consulta = $this->historico->devuelve_var($data);
        echo json_encode($consulta);
    }

    function save_venta() {

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $data = array(
            'cantidad_lunes' => $this->input->post('cant_lun'),
            'id_ano' => $this->input->post('id_ano'),
            'id_mes' => $this->input->post('id_mes'),
            'monto_quincena' => $this->input->post('monto_quincena'),
            'lunes_quincena' => $this->input->post('lunes_quincena'),
            //'monto_iva' => $this->input->post('monto_iva'),
            //'lunes_iva' => $this->input->post('lunes_iva'),
            'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
            'usuario_guarda' => $this->input->post('usuario_guarda'),
            'fecha_guarda' => date("Y-m-d H:i:s"),
            'estado' => 1
        );

        $insert = $this->historico->guarda_venta($data);
        echo json_encode(array("status" => TRUE));

        //}
    }

        function save_tributario() {

        /* if($this->isAdmin() == TRUE)
          {
          $this->loadThis();
          }
          else
          { */
        $data = array(
            'id_ano_trib' => $this->input->post('id_ano_trib'),
            'id_mes_trib' => $this->input->post('id_mes_trib'),
            'monto_tributario' => $this->input->post('monto_tributario'),
            'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
            'usuario_guarda' => $this->input->post('usuario_guarda'),
            'fecha_guarda' => date("Y-m-d H:i:s"),
            'estado' => 1
        );

        $insert = $this->historico->guarda_tributario($data);
        echo json_encode(array("status" => TRUE));

        //}
    }
}

?>
