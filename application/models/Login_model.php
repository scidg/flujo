<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function login_user($username)
  	{

      {
          $this->db->select('tp.nombre_tipo_perfil,ul.id_tipo_perfil,ul.id_usuario, ul.fullname, ul.username, ul.estado');
          $this->db->from('usuario as ul');
          $this->db->join('perfil as tp','tp.id_tipo_perfil = ul.id_tipo_perfil');
          $this->db->where('ul.username', $username);
          $query = $this->db->get();
          return $query->result();

          /*$query = $this->db->get();

          if($query->num_rows() >  0){
              return $query->result();
          }else{
              return false;
          }*/

      }

  	}

    public function login_user_hash($username,$password)
    {

      {
          $this->db->select('tp.nombre_tipo_perfil,ul.id_usuario,ul.id_tipo_perfil,ul.username,ul.password,
          ul.fullname,ue.id_empresa,ul.estado');
          $this->db->from('usuario as ul');
          $this->db->join('perfil as tp','tp.id_tipo_perfil = ul.id_tipo_perfil');
          $this->db->join('usuario_empresa as ue','ue.id_usuario = ul.id_usuario');
          $this->db->where('ul.username', $username);
          $this->db->order_by('ue.id_empresa', 'asc');
          
          $query = $this->db->get();
          
          if($query->num_rows() >  0){
              
              $row = $query->row_array();

              $pass_hash = $row['password'];

              if (password_verify($password, $pass_hash)) {
                  
                return $query->result();
              
              }

          }else{

              return $query->result();
          }

      }

    }

public function login_user_activo($username,$password)
    {

      {
          $this->db->select('tp.nombre_tipo_perfil, ul.id_usuario, ul.id_tipo_perfil, ul.username, ul.password, 
          ul.fullname, ue.id_empresa, e.casa_central, ul.estado, e.id_holding, tre.tipo_registro_id');
          $this->db->from('usuario as ul');
          $this->db->join('perfil as tp','tp.id_tipo_perfil = ul.id_tipo_perfil');
          $this->db->join('usuario_empresa as ue','ue.id_usuario = ul.id_usuario');
          $this->db->join('empresa as e','e.id_empresa = ue.id_empresa');
          $this->db->join('tipo_registro_empresa as tre', 'tre.id_empresa = e.id_empresa');
          //$this->db->where('e.casa_central', 1);
          $this->db->where('ul.estado', 1);
          $this->db->where('ul.username', $username);
          $this->db->order_by('e.casa_central', 'DESC');
          
          $query = $this->db->get();
          
          if($query->num_rows() >  0){
              
              $row = $query->row_array();

              $pass_hash = $row['password'];

              if (password_verify($password, $pass_hash)) {
                  
                return $query->result();
              
              }

          }else{

              return $query->result();
          }

      }

    }    

    public function get_permisos_usuario($ide,$idu){
      $this->db->select('up.codigo_permiso');
      $this->db->from('usuario_permiso up');
      $this->db->where('up.id_empresa',$ide);
      $this->db->where('up.id_usuario',$idu);

      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }

    }

    function guarda_acceso($data){
        $this->db->insert('acceso',$data);
    }

    function crea_registro($data_u, $data_e, $tipo_c){
        
        if($tipo_c == 'on'){
            $permisos = array(100,101,102,200,201,300,301,302,303,304,305,306,307,308,309,310,311,400,401,402,403,404,405,406,407,408,409,410,500,600,601,602,603,604,605,606,607,608,609,610,611,612,613,700);
            $casa_central = 1;
            $multicuenta = 1;

        }else{
            //No guarda permiso 603, creacion de empresas
            $permisos = array(100,101,102,200,201,300,301,302,303,304,305,306,307,308,309,310,311,400,401,402,403,404,405,406,407,408,409,410,500,600,601,602,604,605,606,607,608,609,610,611,612,613,700);
            $casa_central = 0;
            $multicuenta = 0;
        }

        $this->db->insert('usuario', $data_u);
        $usuario_id = $this->db->insert_id();

        $this->db->select_max('id_holding');
        $Q = $this->db->get('empresa');
        $row = $Q->row_array();
        $id_holding = $row['id_holding'] + 1;
        
        $data_e['id_holding'] = $id_holding;
        $data_e['casa_central'] = $casa_central;

        $this->db->insert('empresa', $data_e);
        $empresa_id = $this->db->insert_id();

        $data_usuario_empresa = array(
            'id_usuario' => $usuario_id,
            'id_empresa' => $empresa_id,
            'usuario_guarda'=> 'registro_web',
            'fecha_guarda'=>date("Y-m-d H:i:s")
        );
        $this->db->insert('usuario_empresa', $data_usuario_empresa);

        foreach($permisos as $permiso_id){

            $this->db->insert(
                'usuario_permiso',
                array(
                  'id_usuario' => $usuario_id,
                  'id_empresa' => $empresa_id,
                  'codigo_permiso' => $permiso_id,                  
                  'usuario_guarda '=> 'registro_web',
                  'fecha_guarda' => date("Y-m-d H:i:s")
                  )
                );
        }

        $data_empresa_orden = array(
            'id_holding' => $id_holding,
            'id_empresa' => $empresa_id,
            'orden' => 0,
            'mostrar' => 1,
            'usuario_guarda'=> 'registro_web',
            'fecha_guarda'=>date("Y-m-d H:i:s")
        );

        $this->db->insert('empresa_orden', $data_empresa_orden);

        $data_registro_empresa = array(
            'id_empresa' => $empresa_id,
            'tipo_registro_id' => $multicuenta,
            'usuario_guarda'=> 'registro_web',
            'fecha_guarda'=>date("Y-m-d H:i:s")
        );

        $this->db->insert('tipo_registro_empresa', $data_registro_empresa);

        $parametros = array(1, 24);

        foreach($parametros as $parametro){

            $this->db->insert(
                'empresa_parametro',
                array(
                    'id_empresa' => $empresa_id,
                    'id_parametro_detalle' => $parametro,
                    'usuario_guarda'=> 'registro_web',
                    'fecha_guarda'=>date("Y-m-d H:i:s")
                )
                );        
        }
    }

   
}

/* End of file modelog.php */
/* Location: ./application/models/modelog.php */
