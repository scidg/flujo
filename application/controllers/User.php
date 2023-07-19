<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
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
        $this->load->model('Manual_model','manual');        
        $this->load->model('Welcome_model','welcome');        
              

        $this->isLoggedIn();
    }


    public function index()
    {
        $usuario_id = $this->session->userdata('id_usuario');
        $empresa_usuario_id = $this->session->userdata('id_empresa_user');
        //$this->global['empresa_usuario_id'] = $empresa_usuario_id;
        //$this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($empresa_usuario_id);
        $this->global['pageTitle'] = 'FLUJO DE CAJA ';
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($usuario_id);
       // $this->global['sucursales_empresa'] = $this->empresa->sucursales_empresa($usuario_id,$empresa_usuario_id);
        $this->loadViews("view_main", $this->global, NULL , NULL);
    }

    
    public function dashboard($ies,$ius,$fechaactual)
    {   
        $fechaactual = strtr($fechaactual, array('.' => '+', '-' => '=', '~' => '/'));
        $fechaactual = $this->encryption->decrypt($fechaactual);
        $this->global['fecha_actual'] = $fechaactual;
        $empresa_usuario_id = $this->session->userdata('id_empresa_user');
        $this->global['pageTitle'] = 'Dashboard - Flujo de Caja';
        $this->global['muestra_submodulo'] = $this->welcome->muestra_submodulo();
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($ius);
        $this->global['sucursales_empresa'] = $this->empresa->sucursales_empresa($ius,4);
        //$this->global['mostrar_empresas_usuario_sin_em'] = $this->empresa->mostrar_empresas_usuario_sin_em($ius);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($ies);
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($ies,$ius);
        $this->global['id_empresa'] = $ies;
        $this->global['id_usuario'] = $ius;

        $_SESSION['ids_cuenta_mostrar']='';

        $this->loadViews("view_dashboard", $this->global, NULL , NULL);
    }


    public function home_empresa($ies,$ius,$fechaactual)
    {   
        $fechaactual = strtr($fechaactual, array('.' => '+', '-' => '=', '~' => '/'));
        $fechaactual = $this->encryption->decrypt($fechaactual);
        $this->global['fecha_actual'] = $fechaactual;
        if(es_casa_central($ies)){
            $txt_informe = "Consolidado";
        }else{
            $txt_informe = "Resumen";
        }
        $this->global['pageTitle'] = $txt_informe.' - Flujo de Caja';
        $this->global['muestra_submodulo'] = $this->welcome->muestra_submodulo();
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($ius);
        $this->global['mostrar_empresas_usuario_sin_em'] = $this->empresa->mostrar_empresas_usuario_sin_em($ius);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($ies);
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($ies,$ius);
        $this->global['id_empresa'] = $ies;
        $this->global['id_usuario'] = $ius;

        $this->loadViews("view_main", $this->global, NULL , NULL);
    }


    //INICIO SUBCUENTA

    function subcuenta($i){

      /*if($this->isAdmin() == TRUE)
      {
          $this->loadThis();
      }
      else
      {*/
        $this->global['pageTitle'] = 'Subcuenta - Flujo de Caja';
        $this->global['mostrar_cuentas'] = $this->cuenta->mostrar_cuentas($i);
        $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
        $this->global['id_empresa'] = $i;
        $iu = $this->session->userdata('id_usuario');
        $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
        $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
        $this->loadViews("view_subcuenta", $this->global, NULL , NULL);

      //}
    }

    public function llena_cuentas($tm,$ie)
    {

      $options = "";
        if($tm)
        {
          $cuentas = $this->subcuenta->trae_cuentas($tm,$ie);
          echo '<option value="">Seleccione</option>';
          foreach($cuentas as $fila)
            {
            ?>

            <option value="<?=$fila -> id_cuenta ?>"><?=$fila -> nombre_cuenta ?></option>
            <?php
            }
      }
    }

    public function lista_subcuenta($i)
    {
      /*if($this->isAdmin() == TRUE)
      {
          $this->loadThis();
      }
      else
      {*/

        $list = $this->subcuenta->get_datatables($i);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $subcuenta) {
            $no++;
            $row = array();
            $row[] = $subcuenta->id_subcuenta;
            $row[] = $subcuenta->nombre_cuenta;
            $row[] = formato_rut($subcuenta->rut_subcuenta);
            $row[] = $subcuenta->nombre_subcuenta;
            $row[] = ($subcuenta->tipo_movimiento)== 1 ?'<span>INGRESO</span>':'<span>EGRESO</span>';
            
            /*$icono_eliminar = eliminar_subcuenta($subcuenta->id_subcuenta);

            if($icono_eliminar){

            }*/

            $row[] = ($subcuenta->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
            '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_subcuenta('."'".$subcuenta->id_subcuenta."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_subcuenta('."'".$subcuenta->id_subcuenta."'".')"><i class="glyphicon glyphicon-road"></i></a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Traza" onclick="traza_subcuenta('."'".$subcuenta->id_subcuenta."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->subcuenta->count_all($i),
                        "recordsFiltered" => $this->subcuenta->count_filtered($i),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    //}
    }


     function save_subcuenta(){

       $this->_validate_subcuenta();

       /*if($this->isAdmin() == TRUE)
       {
           $this->loadThis();
       }
       else
       {*/
         $data = array(
                 'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                 'id_cuenta' => $this->input->post('id_cuenta_a'),
                 'rut_subcuenta' => $this->input->post('rut_subcuenta'),
                 'nombre_subcuenta' => $this->input->post('nombre_subcuenta'),
                 'tipo_movimiento' => $this->input->post('tipo_movimiento_a'),
                 'usuario_guarda' => $this->input->post('usuario_guarda'),
                 'fecha_guarda' => date("Y-m-d H:i:s"),
                 'estado' => $this->input->post('estado')
             );
        
         $data_update = array(
            'mostrar_calendario' => 1
        );

         $insert = $this->subcuenta->guarda_subcuenta($data);
         $this->subcuenta->mostrar_en_calendario(array('id_cuenta' => $this->input->post('id_cuenta_a')), $data_update);
         echo json_encode(array("status" => TRUE));

        // }

       }

     function update_subcuenta(){

       $this->_validate_subcuenta();

       /*if($this->isAdmin() == TRUE)
       {
           $this->loadThis();
       }
       else
       {*/
          $data = array(
                 //'id_cuenta' => $this->input->post('id_cuenta_'),
                 'rut_subcuenta' => $this->input->post('rut_subcuenta'),
                 //HAmestica: update id_cuenta
                 'id_cuenta' => $this->input->post('id_cuenta_m'),
                 'nombre_subcuenta' => $this->input->post('nombre_subcuenta'),
                 'usuario_modifica' => $this->input->post('usuario_guarda'),
                 'fecha_modifica' => date("Y-m-d H:i:s"),
                 'estado' => $this->input->post('estado')
             );

         $this->subcuenta->update(array('id_subcuenta' => $this->input->post('id_subcuenta')), $data);

         echo json_encode(array("status" => TRUE));


       //}

     }

     public function ajax_edit_subcuenta($id)
     {
        $data = $this->subcuenta->get_by_id($id);
        echo json_encode($data);
     }

     private function _validate_subcuenta()
     {
         $data = array();
         $data['error_string'] = array();
         $data['inputerror'] = array();
         $data['status'] = TRUE;
         
         $nuevoo = $this->input->post('nuevo');
         $editar = $this->input->post('editar');

         if($nuevoo == 1){
            if($this->input->post('tipo_movimiento_a') == '')
            {
                $data['inputerror'][] = 'tipo_movimiento_a';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if($this->input->post('id_cuenta_a') == '')
            {
                $data['inputerror'][] = 'id_cuenta_a';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
         }
        }

        if($editar == 1){
         if($this->input->post('tipo_movimiento_m') == '')
         {
             $data['inputerror'][] = 'tipo_movimiento_m';
             $data['error_string'][] = '* Requerido';
             $data['status'] = FALSE;
         }

         if($this->input->post('id_cuenta_m') == '')
         {
             $data['inputerror'][] = 'id_cuenta_m';
             $data['error_string'][] = '* Requerido';
             $data['status'] = FALSE;
         }
        }


         if($this->input->post('rut_subcuenta') != '')
         {
            if(!check_rut($this->input->post('rut_subcuenta')))
            {
                $data['inputerror'][] = 'rut_subcuenta';
                $data['error_string'][] = '* RUT inválido';
                $data['status'] = FALSE;
            }
         }

         if($this->input->post('nombre_subcuenta') == '')
         {
             $data['inputerror'][] = 'nombre_subcuenta';
             $data['error_string'][] = '* Requerido';
             $data['status'] = FALSE;
         }

         if($this->input->post('estado') == '')
         {
             $data['inputerror'][] = 'estado';
             $data['error_string'][] = '* Requerido';
             $data['status'] = FALSE;
         }

         if($data['status'] === FALSE)
         {
             echo json_encode($data);
             exit();
         }
     }





        //BLANK
        function blank($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['pageTitle'] = 'Blank - Flujo de Caja';
            $this->global['id_empresa'] = $i;
            $this->global['parametrosDefault'] = $this->empresa->devuelveParametrosDefault();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $this->global['mostrar_parametros'] = $this->empresa->mostrar_parametros($i);
            $this->global['mostrar_parametros_dealle'] = $this->empresa->mostrar_parametros_dealle($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['es_casa_central'] = es_casa_central($i);
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_blank", $this->global, NULL , NULL);
        // }

        }

        //SOPORTE
        function soporte($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['pageTitle'] = 'Soporte';
            $this->global['id_empresa'] = $i;
            $this->global['parametrosDefault'] = $this->empresa->devuelveParametrosDefault();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $this->global['mostrar_parametros'] = $this->empresa->mostrar_parametros($i);
            $this->global['mostrar_parametros_dealle'] = $this->empresa->mostrar_parametros_dealle($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['es_casa_central'] = es_casa_central($i);
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_soporte", $this->global, NULL , NULL);
        // }

        }        

                //SOPORTE
        function control($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['pageTitle'] = 'Control de Versiones';
            $this->global['id_empresa'] = $i;
            $this->global['parametrosDefault'] = $this->empresa->devuelveParametrosDefault();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $this->global['mostrar_parametros'] = $this->empresa->mostrar_parametros($i);
            $this->global['mostrar_parametros_dealle'] = $this->empresa->mostrar_parametros_dealle($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['es_casa_central'] = es_casa_central($i);
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_control", $this->global, NULL , NULL);
        // }

        }  
        
        //SOPORTE
        function manual($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['pageTitle'] = 'Manual - Flujo de Caja';
            $this->global['id_empresa'] = $i;
            $this->global['parametrosDefault'] = $this->empresa->devuelveParametrosDefault();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            //$this->global['mostrar_manuales'] = $this->manual->devuelveManual();
            $this->global['mostrar_parametros'] = $this->empresa->mostrar_parametros($i);
            $this->global['mostrar_parametros_dealle'] = $this->empresa->mostrar_parametros_dealle($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['es_casa_central'] = es_casa_central($i);
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_manual", $this->global, NULL , NULL);
        // }

        }  

        public function lista_manual($i)
        {
          /*if($this->isAdmin() == TRUE)
          {
              $this->loadThis();
          }
          else
          {*/
 
            $list = $this->manual->get_datatables($i);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $manual) {
                $no++;
                $row = array();
                $row[] = $manual->id_manual;
                $row[] = devuelve_titulo_modulo($manual->id_modulo);
                $row[] = devuelve_titulo_submodulo($manual->id_submodulo);
                $row[] = $manual->nombre_manual;
                $nombre_manual = $manual->nombre_manual.".pdf";
                $row[] = '<a class="btn btn-sm btn-primary" target="_blank" href="'.base_url()."../manual/".$nombre_manual.'" title="Descargar">
                <i class="glyphicon glyphicon-download-alt"></i>
                </a>';

                $data[] = $row;
            }
 
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->manual->count_all($i),
                            "recordsFiltered" => $this->manual->count_filtered($i),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
         // }
        }

    //////////MANTENEDORES

        //EMPRESA
        function empresa($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['pageTitle'] = 'Empresa - Flujo de Caja';
            $this->global['id_empresa'] = $i;
            $this->global['id_holding_user'] = $this->session->userdata('id_holding_user');
            $this->global['parametrosDefault'] = $this->empresa->devuelveParametrosDefault();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $this->global['mostrar_parametros'] = $this->empresa->mostrar_parametros($i);
            $ihu = $this->session->userdata('id_holding_user');
            $this->global['mostrar_empresas'] = $this->empresa->mostrar_empresas($ihu);
            $this->global['mostrar_parametros_dealle'] = $this->empresa->mostrar_parametros_dealle($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['es_casa_central'] = es_casa_central($i);
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);            
            $this->loadViews("view_empresa", $this->global, NULL , NULL);
            

            
       // }

        }


        public function lista_empresa($i)
        {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          $ih = $this->session->userdata('id_holding_user');
          $list = $this->empresa->get_datatables($ih);
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $empresa) {
              $no++;
              $row = array();
              $row[] = $empresa->id_empresa;
              $row[] = formato_rut($empresa->rut_empresa);
              $row[] = ($empresa->casa_central) == 1 ? '<span><i class="icon icon-star"></i></span>':'<span><i class=""></i></span>';
              $row[] = $empresa->nombre_empresa;
              if($empresa->logo_empresa)
                $row[] = '<img id="logo-empresa" src="'.base_url('upload/'.$empresa->logo_empresa).'"/>';
            else
                $row[] = '(Sin foto)';

                //$empresa->orden = $empresa->orden + 1;
              //$row[] = '<span class="label label-xlg label-default">'.$empresa->orden.'</span>';

              $row[] = $empresa->telefono_empresa;
              $row[] = $empresa->direccion_empresa;
              //$row[] = $empresa->cant_suc;
              //$row[] = $empresa->estado;

              $row[] = ($empresa->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
              '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

              $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_empresa('."'".$empresa->id_empresa."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
              <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Parámetros" onclick="parametro_empresa('."'".$empresa->id_empresa."'".')"><i class="glyphicon glyphicon-cog"></i></a>
              <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_empresa('."'".$empresa->id_empresa."'".')"><i class="glyphicon glyphicon-road"></i></a>';

              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->empresa->count_all($ih),
                          "recordsFiltered" => $this->empresa->count_filtered($ih),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
       // }
        }


        function save_empresa(){

         $this->_validate_empresa();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
          $checked_casa_central = $this->input->post('casa_central');
          (isset($checked_casa_central) == 1)?$checked_casa_central=1:$checked_casa_central=0;

           $data = array(
                   'id_holding' => $this->input->post('id_holding'),
                   'casa_central' => $checked_casa_central,
                   'rut_empresa' => $this->input->post('rut_empresa'),
                   'nombre_empresa' => $this->input->post('nombre_empresa'),
                   'telefono_empresa' => $this->input->post('telefono_empresa'),
                   'direccion_empresa' => $this->input->post('direccion_empresa'),
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );

                    if(!empty($_FILES['logo_empresa']['name']))
                    {
                        $upload = $this->_do_upload();
                        $data['logo_empresa'] = $upload;
                    }else{
                        $data['logo_empresa'] = '';
                    }

           $insert = $this->empresa->guarda_empresa($data);
           echo json_encode(array("status" => TRUE));

          // }

       }

       function save_empresa_orden(){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $id_empresa = $this->input->post('id_empresa');
            $orden = $this->input->post('orden');
            //print_r($id_empresa);
            $data = array(
                //'id_usuario' => $this->input->post('id_usuario_empr'),
                'id_empresa' => $id_empresa,
                'usuario_guarda' => $this->input->post('usuario_guarda'),
                'fecha_guarda' => date("Y-m-d H:i:s")
              );
        
        $insert = $this->empresa->save_orden($data);
        echo json_encode(array("status" => TRUE)); 
         

          //}

      }

       function save_empresa_param(){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          $ip = $this->input->post('id_parametro_detalle_save');

          $data = array(
                  'id_empresa_guarda' => $this->input->post('id_empresa_guarda_param'),
                  'id_empresa' => $this->input->post('id_empresa'),
                  'id_parametro_detalle' => $ip,
                  'usuario_guarda' => $this->input->post('usuario_guarda'),
                  'fecha_guarda' => date("Y-m-d H:i:s"),
                  'estado' => 1
              );

          $insert_param = $this->empresa->save_param($data);
          echo json_encode(array("status" => TRUE));

          //}

      }

        public function ajax_edit_empresa($id)
        {
           $data = $this->empresa->get_by_id($id);
           echo json_encode($data);
        }

       public function ajax_consulta_casa_central($hold)
       {  
           $hold = 1;
           $data = $this->empresa->get_casa_central_exists($hold);
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

        function update_empresa(){

        $this->_validate_empresa();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           //$checked_casa_central = $this->input->post('casa_central');
           /*echo $checked_casa_central;
           exit;
           //(isset($checked_casa_central) == 'on')?$checked_casa_central=1:$checked_casa_central=0;
            /*if($checked_casa_central == 'on'){
                $checked_casa_central=1;
            else{
                $checked_casa_central=0;
            }*/

           $data = array(
                   'rut_empresa' => $this->input->post('rut_empresa'),
                   'casa_central' => $this->input->post('es_casa_central'),
                   'nombre_empresa' => $this->input->post('nombre_empresa'),
                   'telefono_empresa' => $this->input->post('telefono_empresa'),
                   'direccion_empresa' => $this->input->post('direccion_empresa'),
                   'usuario_modifica' => $this->input->post('usuario_guarda'),
                   'fecha_modifica' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );

            if($this->input->post('remove_photo')) // if remove photo checked
            {
                if(file_exists('upload/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                    unlink('upload/'.$this->input->post('remove_photo'));
                $data['logo_empresa'] = '';
            }

            if(!empty($_FILES['logo_empresa']['name']))
            {
                $upload = $this->_do_upload();

                //delete file
                $empresa2 = $this->empresa->get_by_id($this->input->post('id_empresa'));
                if(file_exists('upload/'.$empresa2->logo_empresa) && $empresa2->logo_empresa)
                    unlink('upload/'.$empresa2->logo_empresa);

                $data['logo_empresa'] = $upload;
            }

           $this->empresa->update(array('id_empresa' => $this->input->post('id_empresa')), $data);
           echo json_encode(array("status" => TRUE));


         //}

        }

        private function _do_upload()
        {
            $config['upload_path']          = 'upload/';
            $config['allowed_types']        = '*';
            $config['max_size']             = 1024; //set max size allowed in Kilobyte
            $config['max_width']            = 2000; // set max width image allowed
            $config['max_height']           = 1000; // set max height allowed
            $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
            $config["remove_spaces"]        = TRUE;

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('logo_empresa')) //upload and validate
            {
                $data['inputerror'][] = 'logo_empresa';
                $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }
            return $this->upload->data('file_name');
        }


        private function _validate_empresa()
        {
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if(!check_rut($this->input->post('rut_empresa')))
            {
                $data['inputerror'][] = 'rut_empresa';
                $data['error_string'][] = '* RUT inválido';
                $data['status'] = FALSE;
            }
/*
            if(devuelve_rut_existente($this->input->post('rut_empresa')) == 1)
            {
                $data['inputerror'][] = 'rut_empresa';
                $data['error_string'][] = '* RUT existe, ingrese otro';
                $data['status'] = FALSE;
            }*/

            if($this->input->post('nombre_empresa') == '')
            {
                $data['inputerror'][] = 'nombre_empresa';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if($this->input->post('telefono_empresa') == '')
            {
                $data['inputerror'][] = 'telefono_empresa';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if($this->input->post('direccion_empresa') == '')
            {
                $data['inputerror'][] = 'direccion_empresa';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if($this->input->post('estado') == '')
            {
                $data['inputerror'][] = 'estado';
                $data['error_string'][] = '* Requerido';
                $data['status'] = FALSE;
            }

            if($data['status'] === FALSE)
            {
                echo json_encode($data);
                exit();
            }
        }



        //FIN EMPRESA

        //INICIO SUCURSAL
        function sucursal($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['id_empresa'] = $i;
            $ihu = $this->session->userdata('id_holding_user');
            $this->global['mostrar_empresas'] = $this->empresa->mostrar_empresas($ihu);
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->global['pageTitle'] = 'Sucursal - Flujo de Caja';

            $this->loadViews("view_sucursal", $this->global, NULL , NULL);
        //}

        }

        public function lista_sucursal($i)
        {
          /*if($this->isAdmin() == TRUE)
          {
              $this->loadThis();
          }
          else
          {*/

            $list = $this->sucursal->get_datatables($i);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $sucursal) {
                $no++;
                $row = array();
                $row[] = $sucursal->id_sucursal;
                $row[] = $sucursal->nombre_empresa;
                $row[] = $sucursal->nombre_sucursal;
                $row[] = $sucursal->direccion_sucursal;
                //$row[] = $person->estado;

                $row[] = ($sucursal->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
                '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_sucursal('."'".$sucursal->id_sucursal."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_sucursal('."'".$sucursal->id_sucursal."'".')"><i class="glyphicon glyphicon-road"></i></a>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->sucursal->count_all($i),
                            "recordsFiltered" => $this->sucursal->count_filtered($i),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
        //}
        }


         function save_sucursal(){

           $this->_validate_sucursal();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
                     'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                     'id_empresa' => $this->input->post('id_empresa'),
                     'nombre_sucursal' => $this->input->post('nombre_sucursal'),
                     'direccion_sucursal' => $this->input->post('direccion_sucursal'),
                     'usuario_guarda' => $this->input->post('usuario_guarda'),
                     'fecha_guarda' => date("Y-m-d H:i:s"),
                     'estado' => $this->input->post('estado')
                 );
             $insert = $this->sucursal->guarda_sucursal($data);
             echo json_encode(array("status" => TRUE));

          //   }

           }

         function update_sucursal(){

           $this->_validate_sucursal();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
                     'id_empresa' => $this->input->post('id_empresa'),
                     'nombre_sucursal' => $this->input->post('nombre_sucursal'),
                     'direccion_sucursal' => $this->input->post('direccion_sucursal'),
                     'usuario_modifica' => $this->input->post('usuario_guarda'),
                     'fecha_modifica' => date("Y-m-d H:i:s"),
                     'estado' => $this->input->post('estado')
                 );

             $this->sucursal->update(array('id_sucursal' => $this->input->post('id_sucursal')), $data);
             echo json_encode(array("status" => TRUE));


         //  }

         }

         public function ajax_edit_sucursal($id)
         {
            $data = $this->sucursal->get_by_id($id);
            echo json_encode($data);
         }

         private function _validate_sucursal()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('id_empresa') == '')
             {
                 $data['inputerror'][] = 'id_empresa';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('nombre_sucursal') == '')
             {
                 $data['inputerror'][] = 'nombre_sucursal';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('direccion_sucursal') == '')
             {
                 $data['inputerror'][] = 'direccion_sucursal';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }


        //FIN SUCURSAL



        //INICIO PROVEEDOR
        function proveedor($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['id_empresa'] = $i;
            $this->global['mostrar_condicion_pago'] = $this->proveedor->mostrar_condicion_pago();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $this->global['mostrar_plazo_pago'] = $this->proveedor->mostrar_plazo_pago();
            $this->global['pageTitle'] = 'Proveedor - Flujo de Caja';
            $iu = $this->session->userdata('id_usuario');
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_proveedor", $this->global, NULL , NULL);
        //}

        }

        public function lista_proveedor($i)
        {
          /*if($this->isAdmin() == TRUE)
          {
              $this->loadThis();
          }
          else
          {*/

            $list = $this->proveedor->get_datatables($i);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $proveedor) {
                $no++;
                $row = array();
                $row[] = $proveedor->id_proveedor;
                $row[] = $proveedor->rut_proveedor;
                $row[] = $proveedor->nombre_proveedor;
                $row[] = $proveedor->nombre_condicion_pago;
                $row[] = $proveedor->nombre_plazo_pago;
                //$row[] = $person->estado;

                $row[] = ($proveedor->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
                '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_proveedor('."'".$proveedor->id_proveedor."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_proveedor('."'".$proveedor->id_proveedor."'".')"><i class="glyphicon glyphicon-road"></i></a>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->proveedor->count_all($i),
                            "recordsFiltered" => $this->proveedor->count_filtered($i),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
        //}
        }


         function save_proveedor(){

           $this->_validate_proveedor();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
                     'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                     'rut_proveedor' => $this->input->post('rut_proveedor'),
                     'nombre_proveedor' => $this->input->post('nombre_proveedor'),
                     'id_condicion_pago' => $this->input->post('id_condicion_pago'),
                     'id_plazo_pago' => $this->input->post('id_plazo_pago'),
                     'usuario_guarda' => $this->input->post('usuario_guarda'),
                     'fecha_guarda' => date("Y-m-d H:i:s"),
                     'estado' => $this->input->post('estado')
                 );
             $insert = $this->proveedor->guarda_proveedor($data);
             echo json_encode(array("status" => TRUE));

             //}

           }

         function update_proveedor(){

           $this->_validate_proveedor();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
               'rut_proveedor' => $this->input->post('rut_proveedor'),
               'nombre_proveedor' => $this->input->post('nombre_proveedor'),
               'id_condicion_pago' => $this->input->post('id_condicion_pago'),
               'id_plazo_pago' => $this->input->post('id_plazo_pago'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
                 );

             $this->proveedor->update(array('id_proveedor' => $this->input->post('id_proveedor')), $data);
             echo json_encode(array("status" => TRUE));
          // }

         }

         public function ajax_edit_proveedor($id)
         {
            $data = $this->proveedor->get_by_id($id);
            echo json_encode($data);
         }

         private function _validate_proveedor()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if(!check_rut($this->input->post('rut_proveedor')))
             {
                 $data['inputerror'][] = 'rut_proveedor';
                 $data['error_string'][] = '* RUT inválido';
                 $data['status'] = FALSE;
             }


             if($this->input->post('nombre_proveedor') == '')
             {
                 $data['inputerror'][] = 'nombre_proveedor';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('id_condicion_pago') == '')
             {
                 $data['inputerror'][] = 'id_condicion_pago';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('id_plazo_pago') == '')
             {
                 $data['inputerror'][] = 'id_plazo_pago';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }

        //FIN PROVEEDOR

        //INICIO CLIENTE
        function cliente($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['id_empresa'] = $i;
            $this->global['mostrar_condicion_pago'] = $this->cliente->mostrar_condicion_pago();
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $this->global['mostrar_plazo_pago'] = $this->cliente->mostrar_plazo_pago();
            $iu = $this->session->userdata('id_usuario');
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->global['pageTitle'] = 'Cliente - Flujo de Caja';

            $this->loadViews("view_cliente", $this->global, NULL , NULL);
        //}

        }

        public function lista_cliente($i)
        {
          /*if($this->isAdmin() == TRUE)
          {
              $this->loadThis();
          }
          else
          {*/

            $list = $this->cliente->get_datatables($i);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $cliente) {
                $no++;
                $row = array();
                $row[] = $cliente->id_cliente;
                $row[] = $cliente->rut_cliente;
                $row[] = $cliente->nombre_cliente;
                $row[] = $cliente->nombre_condicion_pago;
                $row[] = $cliente->nombre_plazo_pago;
                //$row[] = $person->estado;

                $row[] = ($cliente->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
                '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_cliente('."'".$cliente->id_cliente."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_cliente('."'".$cliente->id_cliente."'".')"><i class="glyphicon glyphicon-road"></i></a>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->cliente->count_all($i),
                            "recordsFiltered" => $this->cliente->count_filtered($i),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
        //}
        }


         function save_cliente(){

           $this->_validate_cliente();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
                     'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                     'rut_cliente' => $this->input->post('rut_cliente'),
                     'nombre_cliente' => $this->input->post('nombre_cliente'),
                     'id_condicion_pago' => $this->input->post('id_condicion_pago'),
                     'id_plazo_pago' => $this->input->post('id_plazo_pago'),
                     'usuario_guarda' => $this->input->post('usuario_guarda'),
                     'fecha_guarda' => date("Y-m-d H:i:s"),
                     'estado' => $this->input->post('estado')
                 );
             $insert = $this->cliente->guarda_cliente($data);
             echo json_encode(array("status" => TRUE));

             //}

           }

         function update_cliente(){

           $this->_validate_cliente();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
               'rut_cliente' => $this->input->post('rut_cliente'),
               'nombre_cliente' => $this->input->post('nombre_cliente'),
               'id_condicion_pago' => $this->input->post('id_condicion_pago'),
               'id_plazo_pago' => $this->input->post('id_plazo_pago'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
                 );

             $this->cliente->update(array('id_cliente' => $this->input->post('id_cliente')), $data);
             echo json_encode(array("status" => TRUE));
           //}

         }

         public function ajax_edit_cliente($id)
         {
            $data = $this->cliente->get_by_id($id);
            echo json_encode($data);
         }

         private function _validate_cliente()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if(!check_rut($this->input->post('rut_cliente')))
             {
                 $data['inputerror'][] = 'rut_cliente';
                 $data['error_string'][] = '* RUT inválido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('nombre_cliente') == '')
             {
                 $data['inputerror'][] = 'nombre_cliente';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('id_condicion_pago') == '')
             {
                 $data['inputerror'][] = 'id_condicion_pago';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('id_plazo_pago') == '')
             {
                 $data['inputerror'][] = 'id_plazo_pago';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }
        //FIN CLIENTE


        //INICIO BANCO
        function banco($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['id_empresa'] = $i;
            $this->global['mostrar_moneda'] = $this->banco->mostrar_moneda($i);
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->global['mostrar_linea_credito'] = $this->banco->mostrar_linea_credito($i);
            
            $this->global['pageTitle'] = 'Banco - Flujo de Caja';

            $this->loadViews("view_banco", $this->global, NULL , NULL);
       // }

        }

        public function lista_banco($i)
        {
          /*if($this->isAdmin() == TRUE)
          {
              $this->loadThis();
          }
          else
          {*/

            $list = $this->banco->get_datatables($i);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $banco) {
                $no++;
                $row = array();
                $row[] = $banco->id_banco;
                $row[] = formato_rut($banco->rut_banco);
                $row[] = $banco->nombre_banco;
                $row[] = $banco->nombre_moneda;
                $row[] = $banco->linea_sobregiro;
                $row[] = $banco->nombre_linea_credito;
                //$row[] = $person->estado;

                $row[] = ($banco->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
                '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_banco('."'".$banco->id_banco."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_banco('."'".$banco->id_banco."'".')"><i class="glyphicon glyphicon-road"></i></a>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->banco->count_all($i),
                            "recordsFiltered" => $this->banco->count_filtered($i),
                            "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
        //}
        }


         function save_banco(){

           $this->_validate_banco();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
                     'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                     'rut_banco' => $this->input->post('rut_banco'),
                     'nombre_banco' => $this->input->post('nombre_banco'),
                     'id_moneda' => $this->input->post('id_moneda'),
                     'linea_sobregiro' => $this->input->post('linea_sobregiro'),
                     'id_linea_credito' => $this->input->post('id_linea_credito'),
                     'usuario_guarda' => $this->input->post('usuario_guarda'),
                     'fecha_guarda' => date("Y-m-d H:i:s"),
                     'estado' => $this->input->post('estado')
                 );
             $insert = $this->banco->guarda_banco($data);
             echo json_encode(array("status" => TRUE));

             //}

           }

         function update_banco(){

           $this->_validate_banco();

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
             $data = array(
               'rut_banco' => $this->input->post('rut_banco'),
               'nombre_banco' => $this->input->post('nombre_banco'),
               'id_moneda' => $this->input->post('id_moneda'),
               'linea_sobregiro' => $this->input->post('linea_sobregiro'),
               'id_linea_credito' => $this->input->post('id_linea_credito'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
                 );

             $this->banco->update(array('id_banco' => $this->input->post('id_banco')), $data);
             echo json_encode(array("status" => TRUE));
           //}

         }

         public function ajax_edit_banco($id)
         {
            $data = $this->banco->get_by_id($id);
            echo json_encode($data);
         }

         private function _validate_banco()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if(!check_rut($this->input->post('rut_banco')))
             {
                 $data['inputerror'][] = 'rut_banco';
                 $data['error_string'][] = '* RUT inválido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('nombre_banco') == '')
             {
                 $data['inputerror'][] = 'nombre_banco';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('id_moneda') == '')
             {
                 $data['inputerror'][] = 'id_moneda';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('linea_sobregiro') == '')
             {
                 $data['inputerror'][] = 'linea_sobregiro';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('id_linea_credito') == '')
             {
                 $data['inputerror'][] = 'id_linea_credito';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }

        //FIN BANCO



       //INICIO MALLA SOCIETARIA
         function malla_societaria($i){

           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/
               $this->global['id_empresa'] = $i;
               $ihu = $this->session->userdata('id_holding_user');
               $this->global['mostrar_empresas'] = $this->empresa->mostrar_empresas($ihu);
               $this->global['pageTitle'] = 'Malla Societaria - Flujo de Caja';
               $iu = $this->session->userdata('id_usuario');
               $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
               $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
               $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
               $this->loadViews("view_malla_societaria", $this->global, NULL , NULL);
          // }

       }


         public function lista_malla_societaria($i)
         {
           /*if($this->isAdmin() == TRUE)
           {
               $this->loadThis();
           }
           else
           {*/

             $list = $this->malla_societaria->get_datatables($i);
             $data = array();
             $no = $_POST['start'];
             foreach ($list as $malla) {
                 $no++;
                 $row = array();
                 $row[] = $malla->id_socio;
                 $row[] = formato_rut($malla->rut_socio);
                 $row[] = $malla->nombre_socio;
                 $row[] = $malla->nombre_empresa;
                 $row[] = $malla->porcentaje_socio;
                 //$row[] = $person->estado;

                 $row[] = ($malla->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
                 '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

                 $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_malla_societaria('."'".$malla->id_socio."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                 <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_malla_societaria('."'".$malla->id_socio."'".')"><i class="glyphicon glyphicon-road"></i></a>';

                 $data[] = $row;
             }

             $output = array(
                             "draw" => $_POST['draw'],
                             "recordsTotal" => $this->malla_societaria->count_all($i),
                             "recordsFiltered" => $this->malla_societaria->count_filtered($i),
                             "data" => $data,
                     );
             //output to json format
             echo json_encode($output);
        // }
         }


          function save_malla_societaria(){

            $this->_validate_socio();

            /*if($this->isAdmin() == TRUE)
            {
                $this->loadThis();
            }
            else
            {*/
              $data = array(
                      'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                      'rut_socio' => $this->input->post('rut_socio'),
                      'nombre_socio' => $this->input->post('nombre_socio'),
                      'id_empresa' => $this->input->post('id_empresa'),
                      'porcentaje_socio' => $this->input->post('porcentaje_socio'),
                      'usuario_guarda' => $this->input->post('usuario_guarda'),
                      'fecha_guarda' => date("Y-m-d H:i:s"),
                      'estado' => $this->input->post('estado')
                  );
              $insert = $this->malla_societaria->guarda_socio($data);
              echo json_encode(array("status" => TRUE));

             // }

            }

          function update_malla_societaria(){

            $this->_validate_socio();

            /*if($this->isAdmin() == TRUE)
            {
                $this->loadThis();
            }
            else
            {*/
              $data = array(
                      'rut_socio' => $this->input->post('rut_socio'),
                      'nombre_socio' => $this->input->post('nombre_socio'),
                      'id_empresa' => $this->input->post('id_empresa'),
                      'porcentaje_socio' => $this->input->post('porcentaje_socio'),
                      'usuario_modifica' => $this->input->post('usuario_guarda'),
                      'fecha_modifica' => date("Y-m-d H:i:s"),
                      'estado' => $this->input->post('estado')
                  );

              $this->malla_societaria->update(array('id_socio' => $this->input->post('id_socio')), $data);
              echo json_encode(array("status" => TRUE));


            //}

          }

          public function ajax_edit_malla_societaria($id)
          {
             $data = $this->malla_societaria->get_by_id($id);
             echo json_encode($data);
          }

          private function _validate_socio()
          {
              $data = array();
              $data['error_string'] = array();
              $data['inputerror'] = array();
              $data['status'] = TRUE;

              if(!check_rut($this->input->post('rut_socio')))
              {
                  $data['inputerror'][] = 'rut_socio';
                  $data['error_string'][] = '* RUT inválido';
                  $data['status'] = FALSE;
              }

              if($this->input->post('nombre_socio') == '')
              {
                  $data['inputerror'][] = 'nombre_socio';
                  $data['error_string'][] = '* Requerido';
                  $data['status'] = FALSE;
              }

              if($this->input->post('id_empresa') == '')
              {
                  $data['inputerror'][] = 'id_empresa';
                  $data['error_string'][] = '* Requerido';
                  $data['status'] = FALSE;
              }

              if($this->input->post('porcentaje_socio') == '')
              {
                  $data['inputerror'][] = 'porcentaje_socio';
                  $data['error_string'][] = '* Requerido';
                  $data['status'] = FALSE;
              }

              if($this->input->post('estado') == '')
              {
                  $data['inputerror'][] = 'estado';
                  $data['error_string'][] = '* Requerido';
                  $data['status'] = FALSE;
              }

              if($data['status'] === FALSE)
              {
                  echo json_encode($data);
                  exit();
              }

          }

          //FIN MALLA SOCIETARIA

       //INICIO CUENTA

      function cuenta($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
        
            $this->global['pageTitle'] = 'Cuenta - Flujo de Caja';
            $this->global['id_empresa'] = $i;
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['texto_breadcum'] = ' Mantenedor de Cuenta';
            $this->global['texto_breadcum_detalle'] = ' crea y edita cuentas';
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_cuenta", $this->global, NULL , NULL);
        //}

      }

      function save_cuenta(){

        $this->_validate_cuenta();

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
        
          /*$checked_bco = $this->input->post('cuenta_banco');
          (isset($checked_bco) == 1)?$cuenta_banco=1:$cuenta_banco=0;*/

          $id_tipo_cuenta = $this->input->post('id_tipo_cuenta');
          ($id_tipo_cuenta[0]) == 'banco'?$banco=1:$banco=0;
          ($id_tipo_cuenta[0]) == 'prestamo'?$prestamo=1:$prestamo=0;

          $data = array(
                  'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                  'nombre_cuenta' => $this->input->post('nombre_cuenta'),
                  'cuenta_banco' => $banco,
                  'cuenta_prestamo' => $prestamo,
                  'tipo_movimiento' => $this->input->post('tipo_movimiento'),
                  'usuario_guarda' => $this->input->post('usuario_guarda'),
                  'fecha_guarda' => date("Y-m-d H:i:s"),
                  'estado' => $this->input->post('estado')
              );
          $insert = $this->cuenta->guarda_cuenta($data);

          //HAmestica: Registrar orden cuenta
          $this->cuenta->cuenta_orden_registrar($insert,$this->input->post('orden_cuenta'));

          echo json_encode(array("status" => TRUE));

        //}

      }

      public function ajax_edit_cuenta($id)
      {
          $data = $this->cuenta->get_by_id($id);
          echo json_encode($data);
      }

      //HAmestica: funcion que devuelve options con nombre y orden de las cuentas
      public function ajax_get_orden_cuenta($id_empresa_guarda,$id_cuenta)
      {
        $cuentas = $this->cuenta->get_orden_cuenta_by_id($id_empresa_guarda);
        foreach($cuentas as $fila){
            if($fila->id_cuenta==$id_cuenta){
                ?>
                    <option value="<?=$fila -> orden ?>" selected="selected"><?=$fila -> nombre_cuenta ?></option>
                <?php
            }else{
                ?>
                    <option value="<?=$fila -> orden ?>"><?=$fila -> nombre_cuenta ?></option>
                <?php
            }
        }

        ?>
            <option value="<?=(end($cuentas) -> orden)+1 ?>">[ÚLTIMO]</option>
        <?php
      }

      public function lista_cuenta($i)
      {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/

          $list = $this->cuenta->get_datatables($i);
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $cuenta) {
              $no++;
              $row = array();
              $row[] = $cuenta->id_cuenta;
              $row[] = $cuenta->nombre_cuenta;
              $row[] = ($cuenta->cuenta_banco)== 1 ?'<span><i class="icon icon-ok"></i></span>':'<span><i class=""></i></span>';
              $row[] = ($cuenta->cuenta_prestamo)== 1 ?'<span><i class="icon icon-ok"></i></span>':'<span><i class=""></i></span>';

              $row[] = ($cuenta->tipo_movimiento)== 1 ?'<span>INGRESO</span>':'<span>EGRESO</span>';
              $row[] = ($cuenta->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
              '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

              $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="" onclick="edit_cuenta('."'".$cuenta->id_cuenta."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
              <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_cuenta('."'".$cuenta->id_cuenta."'".')"><i class="glyphicon glyphicon-road"></i></a>';

              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->cuenta->count_all($i),
                          "recordsFiltered" => $this->cuenta->count_filtered($i),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
        //}

      }

      function update_cuenta(){

        $this->_validate_cuenta();

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          /*$checked_bco = $this->input->post('cuenta_banco');
          (isset($checked_bco) == 1)?$cuenta_banco=1:$cuenta_banco=0;*/

          $id_tipo_cuenta = $this->input->post('id_tipo_cuenta');
          ($id_tipo_cuenta[0]) == 'banco'?$banco=1:$banco=0;
          ($id_tipo_cuenta[0]) == 'prestamo'?$prestamo=1:$prestamo=0;

          $data = array(
              'nombre_cuenta' => $this->input->post('nombre_cuenta'),
              'cuenta_banco' => $banco,
              'cuenta_prestamo' => $prestamo,
              'tipo_movimiento' => $this->input->post('tipo_movimiento'),
              'usuario_modifica' => $this->input->post('usuario_guarda'),
              'fecha_modifica' => date("Y-m-d H:i:s"),
              'estado' => $this->input->post('estado')
              );

          $this->cuenta->update(array('id_cuenta' => $this->input->post('id_cuenta')), $data);

          //HAmestica: Registrar orden cuenta
          $this->cuenta->cuenta_orden_registrar($this->input->post('id_cuenta'),$this->input->post('orden_cuenta'));

          echo json_encode(array("status" => TRUE));


       // }

      }

      private function _validate_cuenta()
      {
          $data = array();
          $data['error_string'] = array();
          $data['inputerror'] = array();
          $data['status'] = TRUE;

          if($this->input->post('tipo_movimiento') == '')
          {
              $data['inputerror'][] = 'tipo_movimiento';
              $data['error_string'][] = '* Requerido';
              $data['status'] = FALSE;
          }

          if($this->input->post('nombre_cuenta') == '')
          {
              $data['inputerror'][] = 'nombre_cuenta';
              $data['error_string'][] = '* Requerido';
              $data['status'] = FALSE;
          }

          if($this->input->post('estado') == '')
          {
              $data['inputerror'][] = 'estado';
              $data['error_string'][] = '* Requerido';
              $data['status'] = FALSE;
          }

          if($data['status'] === FALSE)
          {
              echo json_encode($data);
              exit();
          }

      }

      //FIN CUENTA


      //INICIO CONDICION DE PAGO

       function condicion_pago($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['pageTitle'] = 'Condición de Pago  - Flujo de Caja';
             $this->global['id_empresa'] = $i;
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $this->loadViews("view_condicion_pago", $this->global, NULL , NULL);
        // }

       }

       function save_condicion_pago(){

         $this->_validate_condicion_pago();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
                   'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                   'nombre_condicion_pago' => $this->input->post('nombre_condicion_pago'),
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );
           $insert = $this->condicion->guarda_condicion_pago($data);
           echo json_encode(array("status" => TRUE));

         //}

       }

       public function ajax_edit_condicion_pago($id)
       {
           $data = $this->condicion->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_condicion_pago($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->condicion->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $condicion) {
               $no++;
               $row = array();
               $row[] = $condicion->id_condicion_pago;
               $row[] = $condicion->nombre_condicion_pago;
               //$row[] = $condicion->estado;

               $row[] = ($condicion->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

               //add html for action
               $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_condicion_pago('."'".$condicion->id_condicion_pago."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
               <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_condicion_pago('."'".$condicion->id_condicion_pago."'".')"><i class="glyphicon glyphicon-road"></i></a>';

               $data[] = $row;
           }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->condicion->count_all($i),
                           "recordsFiltered" => $this->condicion->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
         //}

       }

       function update_condicion_pago(){

         $this->_validate_condicion_pago();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
               'nombre_condicion_pago' => $this->input->post('nombre_condicion_pago'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->condicion->update(array('id_condicion_pago' => $this->input->post('id_condicion_pago')), $data);
           echo json_encode(array("status" => TRUE));


         //}

         }

         private function _validate_condicion_pago()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('nombre_condicion_pago') == '')
             {
                 $data['inputerror'][] = 'nombre_condicion_pago';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }

         }

       // FIN CONDICION DE PAGO

       // INICIO PLAZO DE PAGO

       function plazo_pago($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

             $this->global['pageTitle'] = 'Plazo de pago  - Flujo de Caja';
             $this->global['id_empresa'] = $i;
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->loadViews("view_plazo_pago", $this->global, NULL , NULL);
         //}


       }

       function save_plazo_pago(){

         $this->_validate_plazo_pago();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
                   'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                   'nombre_plazo_pago' => $this->input->post('nombre_plazo_pago'),
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );
           $insert = $this->plazo->guarda_plazo_pago($data);
           echo json_encode(array("status" => TRUE));

        // }

       }

       public function ajax_edit_plazo_pago($id)
       {
           $data = $this->plazo->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_plazo_pago($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->plazo->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $plazo) {
               $no++;
               $row = array();
               $row[] = $plazo->id_plazo_pago;
               $row[] = $plazo->nombre_plazo_pago;
               //$row[] = $plazo->estado;

               $row[] = ($plazo->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

               $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_plazo_pago('."'".$plazo->id_plazo_pago."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
               <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_plazo_pago('."'".$plazo->id_plazo_pago."'".')"><i class="glyphicon glyphicon-road"></i></a>';

               $data[] = $row;
           }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->plazo->count_all($i),
                           "recordsFiltered" => $this->plazo->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
        // }

       }

       function update_plazo_pago(){

         $this->_validate_plazo_pago();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
               'nombre_plazo_pago' => $this->input->post('nombre_plazo_pago'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->plazo->update(array('id_plazo_pago' => $this->input->post('id_plazo_pago')), $data);
           echo json_encode(array("status" => TRUE));


       //  }

         }

         private function _validate_plazo_pago()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('nombre_plazo_pago') == '')
             {
                 $data['inputerror'][] = 'nombre_plazo_pago';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }

         }

       // FIN PLAZO DE PAGO


       //INICIO TIPO DOCUMENTO

       function tipo_documento($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['pageTitle'] = 'Tipo de Documento  - Flujo de Caja';
             $this->global['id_empresa'] = $i;
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->loadViews("view_tipo_documento", $this->global, NULL , NULL);
        // }

       }

       function save_tipo_documento(){

         $this->_validate_tipo_documento();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

          $checked_iva = $this->input->post('con_iva');
          (isset($checked_iva) == 1)?$checked_iva=1:$checked_iva=0;

          $checked_priori = $this->input->post('es_prioritario');
          (isset($checked_priori) == 1)?$checked_priori=1:$checked_priori=0;

          $checked_nc = $this->input->post('es_nota_credito');
          (isset($checked_nc) == 1)?$checked_nc=1:$checked_nc=0;

          $checked_o = $this->input->post('es_obligatorio');
          (isset($checked_o) == 1)?$checked_o=1:$checked_o=0;          
          
           $data = array(
                   'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                   'nombre_tipo_documento' => $this->input->post('nombre_tipo_documento'),
                   'es_prioritario' => $checked_priori,
                   'color_tipo_documento' => $this->input->post('color_tipo_documento'),
                   'con_iva' => $checked_iva,
                   'es_nota_credito' => $checked_nc,
                   'es_obligatorio' => $checked_o,
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );

               $insert = $this->tipo->guarda_tipo_documento($data);
               echo json_encode(array("status" => TRUE));


         //}

       }

       public function ajax_edit_tipo_documento($id)
       {
           $data = $this->tipo->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_tipo_documento($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->tipo->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $tipo) {
               $no++;
               $row = array();
               $row[] = $tipo->id_tipo_documento;
               $row[] = $tipo->nombre_tipo_documento;
               $row[] = ($tipo->es_prioritario)== 1 ?'<span><i class="icon icon-ok"></i></span>':'<span><i class=""></i></span>';

               $row[] = ($tipo->con_iva)== 1 ?'<span><i class="icon icon-ok"></i></span>':'<span><i class=""></i></span>';
               $row[] = ($tipo->es_nota_credito)== 1 ?'<span><i class="icon icon-ok"></i></span>':'<span><i class=""></i></span>';
                $row[] = ($tipo->es_obligatorio)== 1 ?'<span><i class="icon icon-ok"></i></span>':'<span><i class=""></i></span>';
               $row[] = '<div style="width:150px;background-color:'.$tipo->color_tipo_documento.'">&nbsp;</div>';
               $row[] = ($tipo->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

               $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_tipo_documento('."'".$tipo->id_tipo_documento."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
               <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_tipo_documento('."'".$tipo->id_tipo_documento."'".')"><i class="glyphicon glyphicon-road"></i></a>';

               $data[] = $row;
           }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->tipo->count_all($i),
                           "recordsFiltered" => $this->tipo->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
        // }

       }

       function update_tipo_documento(){

         $this->_validate_tipo_documento();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $checked_iva = $this->input->post('con_iva');
           (isset($checked_iva) == 1)?$checked_iva=1:$checked_iva=0;

           $checked_priori = $this->input->post('es_prioritario');
           (isset($checked_priori) == 1)?$checked_priori=1:$checked_priori=0;

           $checked_nc = $this->input->post('es_nota_credito');
           (isset($checked_nc) == 1)?$checked_nc=1:$checked_nc=0;

          $checked_o = $this->input->post('es_obligatorio');
          (isset($checked_o) == 1)?$checked_o=1:$checked_o=0; 

           $data = array(
               'nombre_tipo_documento' => $this->input->post('nombre_tipo_documento'),
               'es_prioritario' => $checked_priori,
               'color_tipo_documento' => $this->input->post('color_tipo_documento'),
               'con_iva' => $checked_iva,
               'es_nota_credito' => $checked_nc,
               'es_obligatorio' => $checked_o,
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->tipo->update(array('id_tipo_documento' => $this->input->post('id_tipo_documento')), $data);
           echo json_encode(array("status" => TRUE));


         //}

         }

         private function _validate_tipo_documento()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('nombre_tipo_documento') == '')
             {
                 $data['inputerror'][] = 'nombre_tipo_documento';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('color_tipo_documento') == '')
             {
                 $data['inputerror'][] = 'color_tipo_documento';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }

         }


       //FIN TIPO DOCUMENTO

       //INICIO MONEDA

       function moneda($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['id_empresa'] = $i;
             $this->global['pageTitle'] = 'Moneda  - Flujo de Caja';
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->loadViews("view_moneda", $this->global, NULL , NULL);
         //}


       }

       function save_moneda(){

         $this->_validate_moneda();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $id_posicion_moneda = $this->input->post('id_posicion_moneda')[0];
            
           $data = array(
                   'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                   'nombre_moneda' => $this->input->post('nombre_moneda'),
                   'simbolo_moneda' => $this->input->post('simbolo_moneda'),
                   'id_posicion_moneda' => $id_posicion_moneda,
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );
           $insert = $this->moneda->guarda_moneda($data);
           echo json_encode(array("status" => TRUE));

        // }

       }

       public function ajax_edit_moneda($id)
       {
           $data = $this->moneda->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_moneda($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->moneda->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $moneda) {
               $no++;
               $row = array();
               $row[] = $moneda->id_moneda;
               $row[] = $moneda->nombre_moneda;
               $row[] = $moneda->simbolo_moneda;
               $row[] = ($moneda->id_posicion_moneda==1)?' IZQUIERDA':'DERECHA';

               $row[] = ($moneda->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

               $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_moneda('."'".$moneda->id_moneda."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
               <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_moneda('."'".$moneda->id_moneda."'".')"><i class="glyphicon glyphicon-road"></i></a>';

               $data[] = $row;
           }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->moneda->count_all($i),
                           "recordsFiltered" => $this->moneda->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
        // }
       }

       function update_moneda(){

         $this->_validate_moneda();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
            $id_posicion_moneda = $this->input->post('id_posicion_moneda')[0];

           $data = array(
               'nombre_moneda' => $this->input->post('nombre_moneda'),
               'simbolo_moneda' => $this->input->post('simbolo_moneda'),
               'id_posicion_moneda' => $id_posicion_moneda,               
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->moneda->update(array('id_moneda' => $this->input->post('id_moneda')), $data);
           echo json_encode(array("status" => TRUE));


        //  }

         }

      private function _validate_moneda()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('nombre_moneda') == '')
             {
                 $data['inputerror'][] = 'nombre_moneda';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('simbolo_moneda') == '')
             {
                 $data['inputerror'][] = 'simbolo_moneda';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }

         }

       //FIN MONEDA

       //INICIO LINEA DE CREDITO

       function linea_credito($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['id_empresa'] = $i;
             $this->global['pageTitle'] = 'Línea de Crédito - Flujo de Caja';
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->loadViews("view_linea_credito", $this->global, NULL , NULL);
        // }


       }

       function save_linea_credito(){

         $this->_validate_linea_credito();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
                   'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                   'nombre_linea_credito' => $this->input->post('nombre_linea_credito'),
                   'monto_linea_credito' => $this->input->post('monto_linea_credito'),
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );
           $insert = $this->linea->guarda_linea_credito($data);
           echo json_encode(array("status" => TRUE));
         //}

       }

       public function ajax_edit_linea_credito($id)
       {
           $data = $this->linea->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_linea_credito($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->linea->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $linea) {
               $no++;
               $row = array();
               $row[] = $linea->id_linea_credito;
               $row[] = $linea->nombre_linea_credito;
               $row[] = $linea->monto_linea_credito;

               $row[] = ($linea->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

               $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_linea_credito('."'".$linea->id_linea_credito."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
               <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_linea_credito('."'".$linea->id_linea_credito."'".')"><i class="glyphicon glyphicon-road"></i></a>';

               $data[] = $row;
           }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->linea->count_all($i),
                           "recordsFiltered" => $this->linea->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
        // }
       }

       function update_linea_credito(){

         $this->_validate_linea_credito();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
               'nombre_linea_credito' => $this->input->post('nombre_linea_credito'),
               'monto_linea_credito' => $this->input->post('monto_linea_credito'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->linea->update(array('id_linea_credito' => $this->input->post('id_linea_credito')), $data);
           echo json_encode(array("status" => TRUE));


          //}

         }

         private function _validate_linea_credito()
            {
                $data = array();
                $data['error_string'] = array();
                $data['inputerror'] = array();
                $data['status'] = TRUE;

                if($this->input->post('nombre_linea_credito') == '')
                {
                    $data['inputerror'][] = 'nombre_linea_credito';
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if($this->input->post('monto_linea_credito') == '' || $this->input->post('monto_linea_credito') <= 0 )
                {
                    $data['inputerror'][] = 'monto_linea_credito';
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if($this->input->post('estado') == '')
                {
                    $data['inputerror'][] = 'estado';
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if($data['status'] === FALSE)
                {
                    echo json_encode($data);
                    exit();
                }

            }

       //FIN LINEA DE CREDITO

       //INICIO IVA

       function iva($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['id_empresa'] = $i;
             $this->global['pageTitle'] = 'IVA - Flujo de Caja';
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->loadViews("view_iva", $this->global, NULL , NULL);
        // }


       }

       function save_iva(){

         $this->_validate_iva();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
                   'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                   'nombre_iva' => $this->input->post('nombre_iva'),
                   'usuario_guarda' => $this->input->post('usuario_guarda'),
                   'fecha_guarda' => date("Y-m-d H:i:s"),
                   'estado' => $this->input->post('estado')
               );
           $insert = $this->iva->guarda_iva($data);
           echo json_encode(array("status" => TRUE));
        // }

       }

       public function ajax_edit_iva($id)
       {
           $data = $this->iva->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_iva($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->iva->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $iva) {
               $no++;
               $row = array();
               $row[] = $iva->id_iva;
               $row[] = $iva->nombre_iva;
               //$row[] = $iva->estado;

               $row[] = ($iva->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

           $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_iva('."'".$iva->id_iva."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
           <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_iva('."'".$iva->id_iva."'".')"><i class="glyphicon glyphicon-road"></i></a>';

               $data[] = $row;
           }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->iva->count_all($i),
                           "recordsFiltered" => $this->iva->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
        // }
       }

       function update_iva(){

         $this->_validate_iva();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
               'nombre_iva' => $this->input->post('nombre_iva'),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->iva->update(array('id_iva' => $this->input->post('id_iva')), $data);
           echo json_encode(array("status" => TRUE));


        //  }

         }

         private function _validate_iva()
            {
                $data = array();
                $data['error_string'] = array();
                $data['inputerror'] = array();
                $data['status'] = TRUE;

                if($this->input->post('nombre_iva') == '')
                {
                    $data['inputerror'][] = 'nombre_iva';
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if($this->input->post('estado') == '')
                {
                    $data['inputerror'][] = 'estado';
                    $data['error_string'][] = '* Requerido';
                    $data['status'] = FALSE;
                }

                if($data['status'] === FALSE)
                {
                    echo json_encode($data);
                    exit();
                }

            }


       //FIN IVA





       //INICIO SERVICIO

       function servicio($i){

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->global['id_empresa'] = $i;
            $this->global['pageTitle'] = 'Servicio - Flujo de Caja';
            $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
            $iu = $this->session->userdata('id_usuario');
            $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
            $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
            $this->loadViews("view_servicio", $this->global, NULL , NULL);
       // }


      }

      function save_servicio(){

        $this->_validate_servicio();

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          $data = array(
                  'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                  'id_quincena' => $this->input->post('quincena_servicio'),
                  'nombre_servicio' => $this->input->post('nombre_servicio'),
                  'usuario_guarda' => $this->input->post('usuario_guarda'),
                  'fecha_guarda' => date("Y-m-d H:i:s"),
                  'estado' => $this->input->post('estado')
              );
          $insert = $this->servicio->guarda_servicio($data);
          echo json_encode(array("status" => TRUE));
       // }

      }

      public function ajax_edit_servicio($id)
      {
          $data = $this->servicio->get_by_id($id);
          echo json_encode($data);
      }

      public function lista_servicio($i)
      {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/

          $list = $this->servicio->get_datatables($i);
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $servicio) {
              $no++;
              $row = array();
              $row[] = $servicio->id_servicio;
              $row[] = $servicio->nombre_servicio;
              $row[] = ($servicio->id_quincena==1) ? 'PRIMERA QUINCENA' :' SEGUNDA QUIENCENA';

              $row[] = ($servicio->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
              '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

          $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_servicio('."'".$servicio->id_servicio."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
          <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_servicio('."'".$servicio->id_servicio."'".')"><i class="glyphicon glyphicon-road"></i></a>';

              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->iva->count_all($i),
                          "recordsFiltered" => $this->iva->count_filtered($i),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
       // }
      }

      function update_servicio(){

        $this->_validate_servicio();

        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
          $data = array(
              'nombre_servicio' => $this->input->post('nombre_servicio'),
              'id_quincena' => $this->input->post('quincena_servicio'),
              'usuario_modifica' => $this->input->post('usuario_guarda'),
              'fecha_modifica' => date("Y-m-d H:i:s"),
              'estado' => $this->input->post('estado')
              );

          $this->servicio->update(array('id_servicio' => $this->input->post('id_servicio')), $data);
          echo json_encode(array("status" => TRUE));


       //  }

        }

        private function _validate_servicio()
           {
               $data = array();
               $data['error_string'] = array();
               $data['inputerror'] = array();
               $data['status'] = TRUE;

               if($this->input->post('quincena_servicio') == '')
               {
                   $data['inputerror'][] = 'quincena_servicio';
                   $data['error_string'][] = '* Requerido';
                   $data['status'] = FALSE;
               }

               if($this->input->post('nombre_servicio') == '')
               {
                   $data['inputerror'][] = 'nombre_servicio';
                   $data['error_string'][] = '* Requerido';
                   $data['status'] = FALSE;
               }

               if($this->input->post('estado') == '')
               {
                   $data['inputerror'][] = 'estado';
                   $data['error_string'][] = '* Requerido';
                   $data['status'] = FALSE;
               }

               if($data['status'] === FALSE)
               {
                   echo json_encode($data);
                   exit();
               }

           }


      //FIN IVA

       //INICIO PARAMETRO

       function parametro($i){

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['pageTitle'] = 'Parametro - Flujo de Caja';
             $this->global['id_empresa'] = $i;
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $iu = $this->session->userdata('id_usuario');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->loadViews("view_parametro", $this->global, NULL , NULL);
        // }

       }

       function save_parametro(){

         //$this->_validate_parametro();
         
         /*$valores = $this->input->post('opcion_parametro');
         $vals = $valores;*/

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
                    'nombre_parametro' => $this->input->post('nombre_parametro'),
                    'comentario_parametro' => $this->input->post('comentario_parametro'),
                    /*'opcion_parametro' => $vals,*/
                    'usuario_guarda' => $this->input->post('usuario_guarda'),
                    'fecha_guarda' => date("Y-m-d H:i:s"),
                    'estado' => $this->input->post('estado')
               );
           $insert = $this->parametro->guarda_parametro($data);
           echo json_encode(array("status" => TRUE));
        // }

       }

       public function ajax_edit_parametro($id)
       {
           $data = $this->parametro->get_by_id($id);
           echo json_encode($data);
       }

       public function lista_parametro($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/

           $list = $this->parametro->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $parametro) {
               $no++;
               $row = array();
               $row[] = $parametro->id_parametro;
               $row[] = $parametro->nombre_parametro;
               $row[] = $parametro->grupo_parametro;
               $row[] = $parametro->cant_opc;
               $row[] = ($parametro->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

             $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_parametro('."'".$parametro->id_parametro."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
             <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Opciones" onclick="opcion_param('."'".$parametro->id_parametro."'".')"><i class="glyphicon glyphicon-cog"></i></a>
             <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_parametro('."'".$parametro->id_parametro."'".')"><i class="glyphicon glyphicon-road"></i></a>';

                 $data[] = $row;
             }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->parametro->count_all($i),
                           "recordsFiltered" => $this->parametro->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
         //}
       }

       function update_parametro(){

         $this->_validate_parametro();

         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $data = array(
               'id_tipo_perfil' => $this->input->post('id_tipo_perfil'),
               'fullname' => $this->input->post('fullname'),
               'username' => $this->input->post('username'),
               'password' => $this->input->post('password'),
               'parametro_modifica' => $this->input->post('parametro_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );

           $this->parametro->update(array('id_parametro' => $this->input->post('id_parametro')), $data);
           echo json_encode(array("status" => TRUE));


          //}

         }

         private function _validate_parametro()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('id_tipo_perfil') == '')
             {
                 $data['inputerror'][] = 'id_tipo_perfil';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('fullname') == '')
             {
                 $data['inputerror'][] = 'fullname';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('username') == '')
             {
                 $data['inputerror'][] = 'username';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('password') == '')
             {
                 $data['inputerror'][] = 'password';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '*empresa Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }
       // FIN USUARIO

       //INICIO USUARIO

       function usuario($i){
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
             $this->global['pageTitle'] = 'Usuario - Flujo de Caja';
             $ihu = $this->session->userdata('id_holding_user');
             $this->global['mostrar_empresas'] = $this->empresa->mostrar_empresas($ihu);
             $this->global['mostrar_sucursales'] = $this->empresa->mostrar_sucursales2($ihu);
             $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
             $this->global['mostrar_mod'] = $this->usuario->mostrar_modulos();
             $this->global['mostrar_per'] = $this->usuario->mostrar_permisos();
             $this->global['mostrar_per_admin'] = $this->usuario->mostrar_permisos_por_perfil(1);
             $this->global['mostrar_per_dig'] = $this->usuario->mostrar_permisos_por_perfil(3);
             $this->global['mostrar_per_guest'] = $this->usuario->mostrar_permisos_por_perfil(4);
             $iu = $this->session->userdata('id_usuario');
             $this->global['multiempresa'] = $this->session->userdata('multiempresa');
             $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
             $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
             $this->global['es_casa_central'] = es_casa_central($i);
             $this->global['casa_central_id'] = '';//get_id_casa_central($ihu);
             $this->global['id_empresa'] = $i;
             $this->loadViews("view_usuario", $this->global, NULL , NULL);
         //}

       }

       public function ajax_consulta_usuario($val)
       {
           $data = $this->usuario->get_user_exists($val);
           echo json_encode($data);
       }

       public function ajax_consulta_nombre()
       {   
            $val = $this->input->post('nom');
            $tabla = $this->input->post('tab');
            $campo = $this->input->post('cam');
            $ide = $this->input->post('emp');

           $data = $this->cuenta->get_name_exists($val,$tabla,$campo,$ide);
           echo json_encode($data);
       }

       public function ajax_consulta_rut()
       {   
            $val = $this->input->post('nom');
            $tabla = $this->input->post('tab');
            $campo = $this->input->post('cam');
            $ide = $this->input->post('emp');

           $data = $this->cuenta->get_rut_exists($val,$tabla,$campo,$ide);
           echo json_encode($data);
       }       

       public function ajax_edit_usuario($id)
       {
           $data = $this->usuario->get_by_id($id);
           echo json_encode($data);
       }

       public function reset_pass_usuario($id)
       {

        $data = array(

            'password' => password_hash('123', PASSWORD_BCRYPT)
        );

        $this->usuario->reset_pass(array('id_usuario' => $id), $data);
        echo json_encode(array("status" => TRUE));

       }

       public function ajax_permi_usuario($ide,$idu)
       {
          $data = $this->usuario->get_permisos_usuario($ide,$idu);
          echo json_encode($data);
       }

       public function ajax_empre_usuario($idu)
       {
          $data = $this->empresa->mostrar_empresas_usuario($idu);
          echo json_encode($data);
       }       


       public function lista_usuario($i)
       {
         /*if($this->isAdmin() == TRUE)
         {
             $this->loadThis();
         }
         else
         {*/
           $es_casa_central = es_casa_central($i);
           $list = $this->usuario->get_datatables($i);
           $data = array();
           $no = $_POST['start'];
           foreach ($list as $usuario) {
               $no++;
               $row = array();
               $row[] = $usuario->id_usuario;
               $row[] = $usuario->nombre_tipo_perfil;
               $row[] = $usuario->fullname;
               $row[] = $usuario->username;
               //$row[] = $usuario->estado;

               $row[] = ($usuario->estado)?'<span class="btn btn-sm btn-success"><i class="icon icon-ok"></i> ACTIVO</span>':
               '<span class="btn btn-sm btn-danger"><i class="icon icon-remove"></i> INACTIVO</span>';

//if($es_casa_central == 1){
             
             $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_usuario('."'".$usuario->id_usuario."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
            
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Asignar permisos" onclick="permiso_usuario('."'".$i."'".','."'".$usuario->id_usuario."'".')"><i class="icon icon-lock"></i></a>
            
            <a class="btn btn-sm btn-default" href="javascript:void(0)" title="Asignar empresas" onclick="empresa_usuario('."'".$usuario->id_usuario."'".')"><i class="glyphicon glyphicon-tag  "></i></a>

            <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Resetear clave" onclick="resetea_pass_usuario('."'".$usuario->id_usuario."'".')"><i class="icon icon-key"></i></a>

            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_usuario('."'".$usuario->id_usuario."'".')"><i class="glyphicon glyphicon-road"></i></a>';
/*}else{
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_usuario('."'".$usuario->id_usuario."'".')"><i class="glyphicon glyphicon-pencil"></i></a>

            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Permisos" onclick="permiso_usuario('."'".$i."'".','."'".$usuario->id_usuario."'".')"><i class="icon icon-lock"></i></a>

            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Traza" onclick="traza_usuario('."'".$usuario->id_usuario."'".')"><i class="glyphicon glyphicon-road"></i></a>';*/
//}
                 $data[] = $row;
                 
             }

           $output = array(
                           "draw" => $_POST['draw'],
                           "recordsTotal" => $this->usuario->count_all($i),
                           "recordsFiltered" => $this->usuario->count_filtered($i),
                           "data" => $data,
                   );
           //output to json format
           echo json_encode($output);
        // }
       }

        function save_usuario(){

           $this->_validate_usuario();

           $permisos_administrador = $this->input->post('permisos_administrador');
           $permisos_digitador = $this->input->post('permisos_digitador');
           $permisos_invitado = $this->input->post('permisos_invitado');

           $empresas = $this->input->post('empresa');

           $casa_central = $this->input->post('id_casa_central');
          
           //$username_clave = strtolower($this->input->post('username'));

           $username_clave = '123';           

           $password = strtolower($username_clave);

            if($this->input->post('id_tipo_perfil') == 1){         

                $data = array(

                        'id_tipo_perfil' => $this->input->post('id_tipo_perfil'),
                        'fullname' => $this->input->post('fullname'),
                        'username' => strtolower($this->input->post('username')),
                        'password' => password_hash($password, PASSWORD_BCRYPT),
                        'permisos_administrador' => $permisos_administrador,
                        'id_empresa' => $empresas,
                        'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                        'usuario_guarda' => $this->input->post('usuario_guarda'),
                        'fecha_guarda' => date("Y-m-d H:i:s"),
                        'estado' => $this->input->post('estado')
                        
                    );

                $insert_data = $this->usuario->guarda_usuario($data);
                echo json_encode(array("status" => TRUE));
            
            }
            
            //DIGITADOR
            if($this->input->post('id_tipo_perfil') == 3){   

                $data = array(

                    'id_tipo_perfil' => $this->input->post('id_tipo_perfil'),
                    'fullname' => $this->input->post('fullname'),
                    'username' => strtolower($this->input->post('username')),
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'permisos_digitador' => $permisos_digitador,
                    'id_empresa' => $empresas,
                    'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                    'usuario_guarda' => $this->input->post('usuario_guarda'),
                    'fecha_guarda' => date("Y-m-d H:i:s"),
                    'estado' => $this->input->post('estado')
                    
                );

                $insert_data = $this->usuario->guarda_usuario($data);
                echo json_encode(array("status" => TRUE));

            }
            
            if($this->input->post('id_tipo_perfil') == 4){

                $data = array(

                        'id_tipo_perfil' => $this->input->post('id_tipo_perfil'),
                        'fullname' => $this->input->post('fullname'),
                        'username' => strtolower($this->input->post('username')),
                        'password' => password_hash($password, PASSWORD_BCRYPT),
                        'permisos_invitado' => $permisos_invitado,
                        'id_empresa' => $empresas,
                        'id_empresa_guarda' => $this->input->post('id_empresa_guarda'),
                        'usuario_guarda' => $this->input->post('usuario_guarda'),
                        'fecha_guarda' => date("Y-m-d H:i:s"),
                        'estado' => $this->input->post('estado')
                        
                    );

                $insert_data = $this->usuario->guarda_usuario($data);
                echo json_encode(array("status" => TRUE));

          }
                   

       }


       function save_permi_usuario(){

        $codigos_permiso = $this->input->post('codigo_permiso');
        
        if(empty($codigos_permiso)){
          
          $data = array(
                  'id_usuario' => $this->input->post('id_usuario_perm'),
                  'id_empresa_guarda_perm' => $this->input->post('id_empresa_guarda_perm'),
                );
          
          $insert = $this->usuario->guarda_permiso($data,0);
          echo json_encode(array("status" => TRUE));
        
        }else{
        
          $data = array(
                  'id_usuario' => $this->input->post('id_usuario_perm'),
                  'id_empresa_guarda_perm' => $this->input->post('id_empresa_guarda_perm'),
                  'codigo_permiso' => $codigos_permiso,
                  'usuario_guarda' => $this->input->post('usuario_guarda'),
                  'fecha_guarda' => date("Y-m-d H:i:s"),

          );

          $insert = $this->usuario->guarda_permiso($data,1);
          echo json_encode(array("status" => TRUE));
          
          }
        
        }

       function save_empre_usuario(){

        $ids_empresas = $this->input->post('id_empresa');
        $ids_sucursales = $this->input->post('id_sucursal');
        $id_casa_central = $this->input->post('id_casa_central');

      
        if(empty($ids_empresas)){
          
          $data = array(
                  'id_usuario' => $this->input->post('id_usuario_empr'),
                  'id_casa_central' => $id_casa_central,
                  'id_empresa_guarda_empr' => $this->input->post('id_empresa_guarda_empr'),
                  'usuario_guarda' => $this->input->post('usuario_guarda'),
                  'fecha_guarda' => date("Y-m-d H:i:s"),
                );
          
          $insert = $this->usuario->guarda_empresa($data,0);
          echo json_encode(array("status" => TRUE));

        
        }else{

        $data = array(
                  'id_usuario' => $this->input->post('id_usuario_empr'),
                  'id_empresa_guarda_empr' => $this->input->post('id_empresa_guarda_empr'),
                  'id_empresa' => $ids_empresas,
                  'id_sucursal' => $ids_sucursales,
                  'usuario_guarda' => $this->input->post('usuario_guarda'),
                  'fecha_guarda' => date("Y-m-d H:i:s"),
              );

          $insert = $this->usuario->guarda_empresa($data,1);
          echo json_encode(array("status" => TRUE));

        }

      }


       function update_usuario(){

         $ids_empresas = $this->input->post('empresa');
         $vals = $ids_empresas;

         $this->_validate_usuario();

           $data = array(
               'id_tipo_perfil' => $this->input->post('id_tipo_perfil'),
               'fullname' => $this->input->post('fullname'),
               'username' => $this->input->post('username'),
               //'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s"),
               'estado' => $this->input->post('estado')
               );


            $this->usuario->update(array('id_usuario' => $this->input->post('id_usuario')), $data);
            echo json_encode(array("status" => TRUE));

         }

         private function _validate_usuario()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             if($this->input->post('id_tipo_perfil') == '')
             {
                 $data['inputerror'][] = 'id_tipo_perfil';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('fullname') == '')
             {
                 $data['inputerror'][] = 'fullname';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('username') == '')
             {
                 $data['inputerror'][] = 'username';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             /*if($this->input->post('password') == '')
             {
                 $data['inputerror'][] = 'password';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }*/

             if($this->input->post('estado') == '')
             {
                 $data['inputerror'][] = 'estado';
                 $data['error_string'][] = '* Requerido';
                 $data['status'] = FALSE;
             }

             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }
     // FIN USUARIO

       function perfil($i){
       /*if($this->isAdmin() == TRUE)
       {
           $this->loadThis();
       }
       else
       {*/
           $this->global['pageTitle'] = 'Mi Perfil - Flujo de Caja';
           $ihu = $this->session->userdata('id_holding_user');
           $this->global['mostrar_empresas'] = $this->empresa->mostrar_empresas($ihu);
           $this->global['nombreEmpresa'] = $this->empresa->devuelveNombreEmpresa($i);
           $this->global['mostrar_per'] = $this->usuario->mostrar_permisos();
           $iu = $this->session->userdata('id_usuario');
           $this->global['permisos_usuario'] = $this->usuario->get_permisos_usuario($i,$iu);
           $this->global['mostrar_empresas_usuario'] = $this->empresa->mostrar_empresas_usuario($iu);
           $this->global['es_casa_central'] = es_casa_central($i);
           $this->global['casa_central_id'] = get_id_casa_central(1);
           $this->global['id_empresa'] = $i;
           $this->loadViews("view_perfil", $this->global, NULL , NULL);
       //}

     }

      function update_contrasena(){

         $this->_validate_contrasena();

           $data = array(
               'password' => password_hash($this->input->post('contra_conf'), PASSWORD_BCRYPT),
               'usuario_modifica' => $this->input->post('usuario_guarda'),
               'fecha_modifica' => date("Y-m-d H:i:s")
               );

           $this->usuario->update_con(array('id_usuario' => $this->input->post('id_usuario')), $data);
           echo json_encode(array("status" => TRUE));
          }

         private function _validate_contrasena()
         {
             $data = array();
             $data['error_string'] = array();
             $data['inputerror'] = array();
             $data['status'] = TRUE;

             /*if($this->input->post('contra_actual') == '')
             {
                 $data['inputerror'][] = 'contra_actual';
                 $data['error_string'][] = 'Requerido';
                 $data['status'] = FALSE;
             }*/

             if($this->input->post('contra_nueva') == '')
             {
                 $data['inputerror'][] = 'contra_nueva';
                 $data['error_string'][] = 'Requerido';
                 $data['status'] = FALSE;
             }

             if($this->input->post('contra_conf') == '')
             {
                 $data['inputerror'][] = 'contra_conf';
                 $data['error_string'][] = 'Requerido';
                 $data['status'] = FALSE;
             }

             if( ($this->input->post('contra_nueva')) != ($this->input->post('contra_conf')) ) 
             {
                 $data['inputerror'][] = 'contra_conf';
                 $data['error_string'][] = 'Contraseñas deben coincidir!';
                 $data['status'] = FALSE;
             }

             /*if($this->input->post('contra_actual') != ''){
               
               if( ($this->input->post('contra_actual')) == ($this->input->post('contra_conf')) ) 
               {
                   $data['inputerror'][] = 'contra_conf';
                   $data['error_string'][] = 'ERROR: "Confirmación Contraseña" debe ser distinta a la "Contraseña Actual"';
                   $data['status'] = FALSE;
               }


               if( ($this->input->post('contra_actual')) == ($this->input->post('contra_nueva')) ) 
               {
                   $data['inputerror'][] = 'contra_nueva';
                   $data['error_string'][] = 'ERROR: "Contraseña Nueva" debe ser distinta a la "Contraseña Actual"';
                   $data['status'] = FALSE;
               }

            }*/
             
             if($data['status'] === FALSE)
             {
                 echo json_encode($data);
                 exit();
             }
         }

         function manual_usuario(){

            $this->global['pageTitle'] = 'Manual de Usuario';
            $this->loadViews("view_manual_usuario", $this->global, NULL , NULL);

         }

}

?>
