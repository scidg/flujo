<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BaseController extends CI_Controller {
	protected $id_tipo_perfil = '';
	protected $id_usuario = '';
	protected $username = '';
	protected $fullname = '';
	protected $nombre_tipo_perfil = '';
	protected $estado = '';
	protected $id_permiso = '';
	protected $id_permiso_detalle = '';
	protected $acceso = '';
	protected $id_empresa_user = '';

	protected $global = array ();

	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}

	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );

		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			$this->id_tipo_perfil = $this->session->userdata ( 'id_tipo_perfil' );
			$this->id_usuario = $this->session->userdata ( 'id_usuario' );
			$this->fullname = $this->session->userdata ( 'fullname' );
			$this->username = $this->session->userdata ( 'username' );
			$this->nombre_tipo_perfil = $this->session->userdata ( 'nombre_tipo_perfil' );
			$this->id_cliente = $this->session->userdata ( 'id_cliente' );
			$this->estado = $this->session->userdata ( 'estado' );
			$this->id_permiso = $this->session->userdata ( 'id_permiso' );
			$this->id_permiso_detalle = $this->session->userdata ( 'id_permiso_detalle' );
			$this->acceso = $this->session->userdata ( 'acceso' );
			$this->id_empresa_user = $this->session->userdata ( 'id_empresa_user' );

			$this->global ['fullname'] = $this->fullname;
			$this->global ['username'] = $this->username;
			$this->global ['id_usuario'] = $this->id_usuario;
			$this->global ['id_tipo_perfil'] = $this->id_tipo_perfil;
			$this->global ['nombre_tipo_perfil'] = $this->nombre_tipo_perfil;
			$this->global ['id_cliente'] = $this->id_cliente;
			$this->global ['estado'] = $this->estado;
			$this->global ['id_permiso'] = $this->id_permiso;
			$this->global ['id_permiso_detalle'] = $this->id_permiso_detalle;
			$this->global ['acceso'] = $this->acceso;
			$this->global ['id_empresa_user'] = $this->id_empresa_user;


		}
	}

	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->id_tipo_perfil != ROLE_ADMIN) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isTicketter() {
		if ($this->id_tipo_perfil != ROLE_ADMIN || $this->id_tipo_perfil != ROLE_CUSTOMER) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$this->global ['pageTitle'] = 'OV : Acceso Denegado';

		$this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
	}

	/**
	 * This function is used to logged out user from system
	 */
	function logout() {
		$this->session->sess_destroy ();
		redirect ( 'login' );
	}

	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
    }

	/**
	 * This function used provide the pagination resources
	 * @param {string} $link : This is page link
	 * @param {number} $count : This is page count
	 * @param {number} $perPage : This is records per page limit
	 * @return {mixed} $result : This is array of records and pagination data
	 */
	function paginationCompress($link, $count, $perPage = 10) {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = SEGMENT;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';

		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( SEGMENT );

		return array (
				"page" => $page,
				"segment" => $segment
		);
	}
}
