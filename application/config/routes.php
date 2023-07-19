<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

/*********** POR DEFECTO *******************/
//principal
$route['default_controller'] = 'login';
$route['404_override'] = '';

/*********** LOGIN *******************/
//login
$route['inside'] = 'login/inside';
$route['main'] = 'user/index';
$route['logout'] = 'user/logout';

/*********** REGISTER *******************/
//register
$route['register'] = 'login/register';

/*********** SELECCION EMPRESA *******************/
//home empresa
$route['dashboard/(:any)/(:any)/(:any)'] = 'user/dashboard/$1/$2/$3';
$route['home_empresa/(:any)/(:any)/(:any)'] = 'user/home_empresa/$1/$2/$3';


/*********** RESUMEN *******************/
$route['return_all_increase'] = 'ingreso/return_all_increase';
$route['devuelve_resumen_ingreso'] = 'ingreso/devuelve_resumen_ingreso';
$route['return_all_egress'] = 'ingreso/return_all_egress';
$route['devuelve_resumen_egreso'] = 'ingreso/devuelve_resumen_egreso';
$route['return_accumulated'] = 'ingreso/return_accumulated';
$route['devuelve_resumen_acumulado'] = 'ingreso/devuelve_resumen_acumulado';

/*********** INGRESO *******************/
//ingreso
$route['ingreso/(:any)/(:any)'] = 'ingreso/ingreso/$1/$2';

//HAmestica: orden subcuentas pantalla ingreso
$route['ingreso/(:any)/(:any)/(:any)/(:any)'] = 'ingreso/ingreso/$1/$2/$3/$4';
$route['ingreso/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'ingreso/ingreso/$1/$2/$3/$4/$5/$6';

$route['save_ingreso'] = 'ingreso/save_ingreso';
$route['update_ingreso'] = 'ingreso/update_ingreso';
$route['anular_ingreso'] = 'ingreso/anular_ingreso';
$route['activar_ingreso'] = 'ingreso/activar_ingreso';
$route['llena_subcuentas/(:any)'] = 'ingreso/llena_subcuentas/$1';
$route['muestra_periodo_iva/(:any)'] = 'ingreso/muestra_periodo_iva/$1';


//movimientos de egreso
$route['movimiento_egreso/(:any)/(:any)'] = 'egreso/movimiento/$1/$2';
$route['consulta_egreso_simplifycate_json'] = 'egreso/consulta_egreso_simplifycate_json';
$route['consulta_movimiento_egreso_json'] = 'egreso/consulta_movimiento_json';
$route['consulta_detalle_movimiento'] = 'egreso/consulta_detalle_movimiento_json';

$route['consulta_totales_movimiento_cuenta_semana_json'] = 'egreso/consulta_totales_movimiento_cuenta_semana_json';

$route['consulta_egreso_total_json'] = 'egreso/consulta_egreso_total_json';
$route['consulta_egreso_acum_json'] = 'egreso/consulta_egreso_acum_json';
$route['consulta_total_pagados_pendiente_json'] = 'egreso/consulta_total_pagados_pendiente_json';
$route['consulta_total_pagados_json'] = 'egreso/consulta_total_pagados_json';
$route['consulta_movimiento_egreso'] = 'egreso/consulta_movimiento';
$route['consulta_egreso_total'] = 'egreso/consulta_egreso_total';
$route['consulta_egreso_acum'] = 'egreso/consulta_egreso_acum';
$route['consulta_total_pagados'] = 'egreso/consulta_total_pagados';
$route['consulta_total_pagados_pendiente'] = 'egreso/consulta_total_pagados_pendiente';


/************EGRESO********************/
$route['egreso/(:any)/(:any)'] = 'egreso/egreso/$1/$2';
//HAmestica: Agregar Variable de entrada para mostrar detalles id_cuenta
$route['egreso/(:any)/(:any)/(:any)'] = 'egreso/egreso/$1/$2/$3';
//HAmestica: Agregar Variables para ordenar subcuentas
$route['egreso/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'egreso/egreso/$1/$2/$3/$4/$5';
$route['egreso/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'egreso/egreso/$1/$2/$3/$4/$5/$6/$7';

$route['listado_egreso/(:num)'] = 'egreso/listado/$1';
$route['lista_egreso/(:num)'] = 'egreso/lista_egreso/$1';
$route['activar_egreso'] = 'egreso/activar_egreso';
$route['ajax_data_egreso/(:num)'] = 'egreso/ajax_data_egreso/$1';
$route['anular_egreso'] = 'egreso/anular_egreso';
$route['save_egreso'] = 'egreso/save_egreso';
$route['egreso_muestra_periodo_iva/(:any)'] = 'egreso/muestra_periodo_iva/$1';
$route['update_egreso'] = 'egreso/update_egreso';
$route['devuelve_gas_proy_edit'] = 'egreso/devuelve_gas_proy_edit';
$route['save_gas_proy'] = 'egreso/save_gas_proy';
$route['consulta_gasto_real'] = 'egreso/consulta_gasto_real';
$route['consulta_gasto_proy_json'] = 'egreso/consulta_gasto_proy_json';
$route['consulta_gasto_real_json'] = 'egreso/consulta_gasto_real_json';
$route['egreso_muestra_periodo_iva/(:any)'] = 'egreso/egreso_muestra_periodo_iva/$1';
$route['get_detalle_egreso/(:num)'] = 'egreso/get_detalle_egreso/$1';
$route['get_up_detalle_egreso/(:num)'] = 'egreso/get_up_detalle_egreso/$1';

//movimientos
$route['movimiento/(:any)/(:any)'] = 'ingreso/movimiento/$1/$2';
//AJAX RETURN AMOUNT BY JSON
$route['query_amount'] = 'ingreso/query_amount';
$route['consulta_movimiento'] = 'ingreso/consulta_movimiento';
$route['consulta_ingreso_total'] = 'ingreso/consulta_ingreso_total';
//AJAX RETURN TOTAL BY JSON
$route['returns_total_income'] = 'ingreso/returns_total_income';

//AJAX RETURN TOTAL BY JSON
$route['returns_cumulative_increase'] = 'ingreso/returns_cumulative_increase';
$route['update_ingreso_total'] = 'ingreso/update_ingreso_total';


$route['consulta_ingreso_acum'] = 'ingreso/consulta_ingreso_acum';
$route['listado/(:num)'] = 'ingreso/listado/$1';
$route['lista_ingreso/(:num)'] = 'ingreso/lista_ingreso/$1';
$route['ajax_data_ingreso/(:num)'] = 'ingreso/ajax_data_ingreso/$1';
$route['get_detalle_ingreso/(:num)'] = 'ingreso/get_detalle_ingreso/$1';
$route['del_document/(:num)'] = 'ingreso/del_document/$1';

/*********** HISTORICO *******************/
//venta
$route['historico/(:any)'] = 'historico/historico/$1';
//AJAX RETURN SALES BY JSON
$route['return_sale'] = 'historico/return_sale';
$route['return_sale_resumen'] = 'historico/return_sale_resumen';
$route['devuelve_venta'] = 'historico/devuelve_venta';
$route['devuelve_venta_editar'] = 'historico/devuelve_venta_editar';
$route['devuelve_tributario_editar'] = 'historico/devuelve_tributario_editar';

//SERVICIOS
$route['devuelve_servicio_editar'] = 'ingreso/devuelve_servicio_editar';
$route['devuelve_servicio_editar_popup'] = 'ingreso/devuelve_servicio_editar_popup';


//AJAX RETURN SALES GRID BY JSON
$route['return_sales_grid'] = 'historico/return_sales_grid';
$route['return_sales_grid_consolidated'] = 'historico/return_sales_grid_consolidated';
$route['return_tribut_grid_consolidated'] = 'historico/return_tribut_grid_consolidated';

$route['return_tributario_grid'] = 'historico/return_tributario_grid';
//AJAX RETURN CONSOLIDATED YEAR BY JSON
$route['return_consolidated_year'] = 'historico/return_consolidated_year';
$route['return_consolidated_year_tribute'] = 'historico/return_consolidated_year_tribute';


$route['devuelve_venta_grilla'] = 'historico/devuelve_venta_grilla';
$route['devuelve_consolidado_ano'] = 'historico/devuelve_consolidado_ano';
$route['trae_euincena'] = 'historico/trae_euincena';
$route['trae_iba'] = 'historico/trae_iba';
$route['devuelve_var'] = 'historico/devuelve_var';
//AJAX RETURN TOTAL YEAR BY JSON
$route['return_total_year'] = 'historico/return_total_year';
$route['return_total_year_tribut'] = 'historico/return_total_year_tribut';

$route['save_venta'] = 'historico/save_venta';
$route['save_tributario'] = 'historico/save_tributario';

/*********** PRESTAMOS *******************/
//prestamo      
$route['prestamo/(:num)'] = 'prestamo/prestamo/$1';
$route['lista_prestamo/(:any)'] = 'prestamo/lista_prestamo/$1';
$route['save_prestamo'] = 'prestamo/save_prestamo';
$route['update_prestamo'] = "prestamo/update_prestamo";
$route['ajax_edit_prestamo/(:any)'] = "prestamo/ajax_edit_prestamo/$1";

/*********** SOCIOS *******************/
//malla societaria      
$route['malla_societaria/(:num)'] = 'user/malla_societaria/$1';
$route['lista_malla_societaria/(:any)'] = 'user/lista_malla_societaria/$1';
$route['save_malla_societaria'] = 'user/save_malla_societaria';
$route['update_malla_societaria'] = "user/update_malla_societaria";
$route['ajax_edit_malla_societaria/(:any)'] = "user/ajax_edit_malla_societaria/$1";

/*********** MANTENEDORES *******************/

//global
$route['ajax_consulta_nombre'] = "user/ajax_consulta_nombre";
$route['ajax_consulta_rut'] = "user/ajax_consulta_rut";

//cuentas
$route['cuenta/(:num)'] = 'user/cuenta/$1';
$route['lista_cuenta/(:any)'] = 'user/lista_cuenta/$1';
$route['save_cuenta'] = 'user/save_cuenta';
$route['update_cuenta'] = "user/update_cuenta";
$route['ajax_edit_cuenta/(:any)'] = "user/ajax_edit_cuenta/$1";
//HAmestica: editar orden cuentas
$route['ajax_get_orden_cuenta/(:any)/(:any)'] = "user/ajax_get_orden_cuenta/$1/$2";

//subcuenta
$route['subcuenta/(:num)'] = 'user/subcuenta/$1';
$route['lista_subcuenta/(:any)'] = 'user/lista_subcuenta/$1';
$route['save_subcuenta'] = 'user/save_subcuenta';
$route['update_subcuenta'] = "user/update_subcuenta";
$route['ajax_edit_subcuenta/(:any)'] = "user/ajax_edit_subcuenta/$1";
$route['llena_cuentas/(:any)/(:any)'] = 'user/llena_cuentas/$1/$2';

//empresa
$route['empresa/(:num)'] = 'user/empresa/$1';
$route['lista_empresa/(:any)'] = 'user/lista_empresa/$1';
$route['save_empresa'] = 'user/save_empresa';
$route['update_empresa'] = "user/update_empresa";
$route['ajax_edit_empresa/(:any)'] = "user/ajax_edit_empresa/$1";
$route['ajax_param_empresa/(:any)'] = "user/ajax_param_empresa/$1";
$route['ajax_servi_empresa/(:any)'] = "user/ajax_servi_empresa/$1";
$route['save_empresa_param'] = "user/save_empresa_param";
$route['save_empresa_orden'] = "user/save_empresa_orden";
$route['ajax_consulta_casa_central/(:any)'] = "user/ajax_consulta_casa_central/$1";

//sucursal
$route['sucursal/(:num)'] = 'user/sucursal/$1';
$route['lista_sucursal/(:any)'] = 'user/lista_sucursal/$1';
$route['save_sucursal'] = 'user/save_sucursal';
$route['update_sucursal'] = "user/update_sucursal";
$route['ajax_edit_sucursal/(:any)'] = "user/ajax_edit_sucursal/$1";

//proveedor
$route['proveedor/(:num)'] = 'user/proveedor/$1';
$route['lista_proveedor/(:any)'] = 'user/lista_proveedor/$1';
$route['save_proveedor'] = 'user/save_proveedor';
$route['update_proveedor'] = "user/update_proveedor";
$route['ajax_edit_proveedor/(:any)'] = "user/ajax_edit_proveedor/$1";

//cliente
$route['cliente/(:num)'] = 'user/cliente/$1';
$route['lista_cliente/(:any)'] = 'user/lista_cliente/$1';
$route['save_cliente'] = 'user/save_cliente';
$route['update_cliente'] = "user/update_cliente";
$route['ajax_edit_cliente/(:any)'] = "user/ajax_edit_cliente/$1";

//banco
$route['banco/(:num)'] = 'user/banco/$1';
$route['lista_banco/(:any)'] = 'user/lista_banco/$1';
$route['save_banco'] = 'user/save_banco';
$route['update_banco'] = "user/update_banco";
$route['ajax_edit_banco/(:any)'] = "user/ajax_edit_banco/$1";

//condicion de pago
$route['condicion_pago/(:num)'] = 'user/condicion_pago/$1';
$route['lista_condicion_pago/(:any)'] = 'user/lista_condicion_pago/$1';
$route['save_condicion_pago'] = 'user/save_condicion_pago';
$route['update_condicion_pago'] = "user/update_condicion_pago";
$route['ajax_edit_condicion_pago/(:any)'] = "user/ajax_edit_condicion_pago/$1";

//condicion de pago
$route['plazo_pago/(:num)'] = 'user/plazo_pago/$1';
$route['lista_plazo_pago/(:any)'] = 'user/lista_plazo_pago/$1';
$route['save_plazo_pago'] = 'user/save_plazo_pago';
$route['update_plazo_pago'] = "user/update_plazo_pago";
$route['ajax_edit_plazo_pago/(:any)'] = "user/ajax_edit_plazo_pago/$1";

//tipo de documentos
$route['tipo_documento/(:num)'] = 'user/tipo_documento/$1';
$route['lista_tipo_documento/(:any)'] = 'user/lista_tipo_documento/$1';
$route['save_tipo_documento'] = 'user/save_tipo_documento';
$route['update_tipo_documento'] = "user/update_tipo_documento";
$route['ajax_edit_tipo_documento/(:any)'] = "user/ajax_edit_tipo_documento/$1";

//monedas
$route['moneda/(:num)'] = 'user/moneda/$1';
$route['lista_moneda/(:any)'] = 'user/lista_moneda/$1';
$route['save_moneda'] = 'user/save_moneda';
$route['update_moneda'] = "user/update_moneda";
$route['ajax_edit_moneda/(:any)'] = "user/ajax_edit_moneda/$1";

//linea de credito
$route['linea_credito/(:num)'] = 'user/linea_credito/$1';
$route['lista_linea_credito/(:any)'] = 'user/lista_linea_credito/$1';
$route['save_linea_credito'] = 'user/save_linea_credito';
$route['update_linea_credito'] = "user/update_linea_credito";
$route['ajax_edit_linea_credito/(:any)'] = "user/ajax_edit_linea_credito/$1";

//iva
$route['iva/(:num)'] = 'user/iva/$1';
$route['lista_iva/(:any)'] = 'user/lista_iva/$1';
$route['save_iva'] = 'user/save_iva';
$route['update_iva'] = "user/update_iva";
$route['ajax_edit_iva/(:any)'] = "user/ajax_edit_iva/$1";

//servicio
$route['servicio/(:num)'] = 'user/servicio/$1';
$route['lista_servicio/(:any)'] = 'user/lista_servicio/$1';
$route['save_servicio'] = 'user/save_servicio';
$route['save_servicio_quincena'] = 'ingreso/save_servicio_quincena';
$route['save_servicio_quincena2'] = 'ingreso/save_servicio_quincena2';

$route['update_servicio'] = "user/update_servicio";
$route['ajax_edit_servicio/(:any)'] = "user/ajax_edit_servicio/$1";

//parametro
$route['parametro/(:num)'] = 'user/parametro/$1';
$route['lista_parametro/(:any)'] = 'user/lista_parametro/$1';
$route['save_parametro'] = 'user/save_parametro';
$route['update_parametro'] = "user/update_parametro";
$route['ajax_edit_parametro/(:any)'] = "user/ajax_edit_parametro/$1";

//usuarios
$route['usuario/(:num)'] = 'user/usuario/$1';
$route['lista_usuario/(:num)'] = 'user/lista_usuario/$1';
$route['save_usuario'] = 'user/save_usuario';
$route['update_usuario'] = "user/update_usuario";
$route['permiso/(:num)'] = "user/permiso/$1";
$route['ajax_edit_usuario/(:num)'] = "user/ajax_edit_usuario/$1";
$route['reset_pass_usuario/(:num)'] = "user/reset_pass_usuario/$1";
$route['ajax_consulta_usuario/(:any)'] = "user/ajax_consulta_usuario/$1";
$route['ajax_permi_usuario/(:num)/(:num)'] = "user/ajax_permi_usuario/$1/$2";
$route['save_permi_usuario'] = "user/save_permi_usuario";
$route['ajax_empre_usuario/(:num)'] = "user/ajax_empre_usuario/$1";
$route['save_empre_usuario'] = "user/save_empre_usuario";

//perfil
$route['perfil/(:num)'] = 'user/perfil/$1';
$route['update_contrasena'] = "user/update_contrasena";

$route['blank/(:num)'] = 'user/blank/$1';
$route['soporte/(:num)'] = 'user/soporte/$1';
$route['manual/(:num)'] = 'user/manual/$1';
$route['lista_manual/(:any)'] = 'user/lista_manual/$1';


$route['control/(:num)'] = 'user/control/$1';

$route['manual_usuario'] = 'user/manual_usuario';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
