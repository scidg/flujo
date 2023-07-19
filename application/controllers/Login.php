<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
      parent::__construct();
      $this->load->model('Login_model', 'login');
    }


  public function index()
  {
        $this->isLoggedIn();
  }

  function isLoggedIn()
  {
      $isLoggedIn = $this->session->userdata('isLoggedIn');

      $fecha_actual = date('Y-m-d');
      
      //$this->encryption->encrypt($to_encrypt)
      //$hoy_encrypt = $this->encrypt->encode($fecha_actual); encriptacion hasta php 7.1
      $hoy_encrypt = $this->encryption->encrypt($fecha_actual);
      $hoy = strtr($hoy_encrypt,array('+' => '.', '=' => '-', '/' => '~'));

      
      if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
      {
          $this->load->view('view_login');
      }
      else
      {
          redirect('/home_empresa/'.$this->session->userdata('id_empresa_user').'/'.$this->session->userdata('id_usuario').'/'.$hoy);

      }
  }

 

  public function register(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('fullname', 'Nombre', 'required|xss_clean|trim');

    $this->form_validation->set_message('required', '%s es obligatorio!');

    /*if($this->form_validation->run() == FALSE)
      {
          $this->index();
      }else{*/
          $rut_empresa = $this->input->post('rut_empresa');
          $nombre_empresa = $this->input->post('nombre_empresa');
          $fullname = $this->input->post('fullname');
          $username_register = $this->input->post('username_register');
          $password_register = $this->input->post('password_register');
          $password_register2 = $this->input->post('password_register2');
          $email = $this->input->post('email');
          $tipo_cuenta = $this->input->post('multiempresa');
          
          $data_usuario = array(
            'id_tipo_perfil' => 1,
            'fullname' => $fullname,
            'username' => $username_register,
            'password' => password_hash($password_register, PASSWORD_BCRYPT),
            'email' => $email,
            'usuario_guarda'=> 'registro_web',
            'fecha_guarda'=>date("Y-m-d H:i:s")
          );

          $data_empresa = array(
            'rut_empresa' => $rut_empresa,
            'nombre_empresa' => $nombre_empresa,
            'usuario_guarda'=> 'registro_web',
            'fecha_guarda'=>date("Y-m-d H:i:s")
          );
    
      $this->login->crea_registro($data_usuario, $data_empresa, $tipo_cuenta);
      redirect('/login');

      //}
  }



  public function inside()
  {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'Usuario', 'required|xss_clean|trim');
      $this->form_validation->set_rules('password', 'Clave', 'required|xss_clean|trim');

      $this->form_validation->set_message('required', '%s es obligatorio!');

      if($this->form_validation->run() == FALSE)
      {
          $this->index();
      }
      else
      {
          $username = $this->input->post('username');
          $password = $this->input->post('password');


          /*$data = array(
                  'username' => $username,
                  'password' => $password,
                  'fecha_ingreso'=>date("Y-m-d H:i:s")
              );
          
          $this->login->guarda_acceso($data);*/

          $result = $this->login->login_user($username);

          if(count($result) > 0)
          {

            $result2 = $this->login->login_user_hash($username, $password);

            if(count($result2) > 0)
            {

              //FOR ORIGINAL
              $result4 = $this->login->login_user_activo($username, $password);

              if(count($result4) > 0)
              {

              foreach ($result4 as $res)
              {
                  $sessionArray = array(
                                'nombre_tipo_perfil' => $res->nombre_tipo_perfil,
                                'id_usuario' => $res->id_usuario,
                                'id_tipo_perfil' => $res->id_tipo_perfil,
                                'username' => $res->username,
                                'fullname' => $res->fullname,
                                'estado' => $res->estado,
                                'id_empresa_user' => $res->id_empresa,
                                'id_holding_user' => $res->id_holding,
                                'multiempresa' => $res->tipo_registro_id,
                                'isLoggedIn' => TRUE
                                  );

                  $result3 = $this->login->get_permisos_usuario($res->id_empresa, $res->id_usuario);

                  $valores=array();

                  foreach ($result3 as $res3)
                    {
                      array_push($valores, $res3->codigo_permiso);
                    }

                    
                    //Determinamos los accesos del usuario
                    in_array(7,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
                    in_array(8,$valores)?$_SESSION['sucursal']=1:$_SESSION['sucursal']=0;
                    in_array(18,$valores)?$_SESSION['parametro']=1:$_SESSION['parametro']=0;
                    in_array(19,$valores)?$_SESSION['usuario']=1:$_SESSION['usuario']=0;

                  $this->session->set_userdata($sessionArray);
                  $fecha_actual = date('Y-m-d');
                  $hoy_encrypt = $this->encryption->encrypt($fecha_actual);
                  $hoy = strtr($hoy_encrypt,array('+' => '.', '=' => '-', '/' => '~'));

                  redirect('/dashboard/'.$res->id_empresa.'/'.$res->id_usuario.'/'.$hoy);
              }
              
              }else{

              $this->session->set_flashdata('error', 'Usuario bloqueado!');
              redirect('/login');


              }


            }else{

              $this->session->set_flashdata('error', 'Usuario o clave no coinciden!');
              redirect('/login');

            }

          }
          else
          {
              $this->session->set_flashdata('error', 'Usuario o clave no coinciden!');

              redirect('/login');
          }
      }
  }

}
/* End of file verifylogin.php */
/* Location: ./application/controllers/verifylogin.php */
