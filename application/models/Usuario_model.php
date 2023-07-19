<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuario_model extends CI_Model
{

  var $table = 'usuario';
  var $column = array('usuario.id_usuario','usuario.id_tipo_perfil','fullname','username','usuario.estado');
  var $order = array('id_usuario' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        $this->search = '';

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

  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id_usuario',$id);
    $query = $this->db->get();

    return $query->row();
  }

  public function get_user_exists($name)
  {
    $this->db->from($this->table);
    $this->db->where('username',$name);
    $query = $this->db->get();

    if($query->num_rows() >  0){
        return true;
    }else{
        return false;
    }
  }

  public function get_by_permi($ide,$idu)
	{
		$this->db->from('usuario_permiso');
		$this->db->where('id_usuario',$idu);
    $this->db->where('id_empresa',$ide);
		$query = $this->db->get();
		return $query->result();
	}

  public function reset_pass($where, $data)
  {
    $this->db->update('usuario', $data, $where);
    return $this->db->affected_rows();
  }

  function get_datatables($id_empresa)
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $this->db->select('usuario.id_usuario,p.nombre_tipo_perfil,usuario.fullname,usuario.username,usuario.estado');
    $this->db->join('perfil p', 'p.id_tipo_perfil = usuario.id_tipo_perfil');
    $this->db->join('usuario_empresa up', 'up.id_usuario = usuario.id_usuario');
    $this->db->where('mostrar_empresa_madre',1);
    $this->db->where('up.id_empresa',$id_empresa);

    $query = $this->db->get();

    return $query->result();

  }

  function count_filtered($id_empresa)
  {
    $this->_get_datatables_query();
    $this->db->select('usuario.id_usuario,p.nombre_tipo_perfil,usuario.fullname,usuario.username,usuario.estado');
    $this->db->join('perfil p', 'p.id_tipo_perfil = usuario.id_tipo_perfil');
    $this->db->join('usuario_empresa up', 'up.id_usuario = usuario.id_usuario');
    $this->db->where('up.id_empresa',$id_empresa);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all($id_empresa)
  {
    $this->db->from($this->table);
    $this->db->select('usuario.id_usuario,p.nombre_tipo_perfil,usuario.fullname,usuario.username,usuario.estado');
    $this->db->join('perfil p', 'p.id_tipo_perfil = usuario.id_tipo_perfil');
    $this->db->join('usuario_empresa up', 'up.id_usuario = usuario.id_usuario');
    $this->db->where('up.id_empresa',$id_empresa);
    return $this->db->count_all_results();
  }

  function guarda_usuario($data){


    $this->db->insert($this->table, array('id_tipo_perfil'=>$data['id_tipo_perfil'],
    'fullname'=>$data['fullname'],
    'username'=>$data['username'],
    'usuario_guarda'=>$data['usuario_guarda'],
    'password'=>$data['password'],
    'fecha_guarda'=>$data['fecha_guarda'],
    'estado'=>$data['estado']));

    $id_usuario = $this->db->insert_id();

    //ADMINISTRADOR
    if($data['id_tipo_perfil'] == 1){

      foreach($data['id_empresa'] as $valor => $cat)
        $this->db->insert(
          'usuario_empresa',
          array(
            'id_usuario'=>$id_usuario,
            'id_empresa'=>$cat,
            'usuario_guarda'=>$data['usuario_guarda'],
            'fecha_guarda'=>$data['fecha_guarda'],
            'estado'=>$data['estado'])
        );
        

      foreach($data['id_empresa'] as $valor1 => $cat1)
        foreach($data['permisos_administrador'] as $valor=>$cat)
          $this->db->insert(
            'usuario_permiso',
            array(
              'id_usuario'=>$id_usuario,
              'codigo_permiso'=>$cat,
              'id_empresa'=>$cat1,
              'usuario_guarda'=>$data['usuario_guarda'],
              'fecha_guarda'=>$data['fecha_guarda']
              )
            );

      }
  
    //DIGITADOR
    if($data['id_tipo_perfil'] == 3){
          
      foreach($data['id_empresa'] as $valor => $cat)
      $this->db->insert(
        'usuario_empresa',
        array(
          'id_usuario'=>$id_usuario,
          'id_empresa'=>$cat,
          'usuario_guarda'=>$data['usuario_guarda'],
          'fecha_guarda'=>$data['fecha_guarda'],
          'estado'=>$data['estado'])
      );

        foreach($data['id_empresa'] as $valor1 => $cat1)
          foreach($data['permisos_digitador'] as $valor=>$cat)
            $this->db->insert(
              'usuario_permiso',
              array(
                'id_usuario'=>$id_usuario,
                'codigo_permiso'=>$cat,
                'id_empresa'=>$cat1,
                'usuario_guarda'=>$data['usuario_guarda'],
                'fecha_guarda'=>$data['fecha_guarda']
                )
              );

    }  

    //INVITADO
    if($data['id_tipo_perfil'] == 4){
          
      foreach($data['id_empresa'] as $valor => $cat)
      $this->db->insert(
        'usuario_empresa',
        array(
          'id_usuario'=>$id_usuario,
          'id_empresa'=>$cat,
          'usuario_guarda'=>$data['usuario_guarda'],
          'fecha_guarda'=>$data['fecha_guarda'],
          'estado'=>$data['estado'])
      );
      

    foreach($data['id_empresa'] as $valor1 => $cat1)
      foreach($data['permisos_invitado'] as $valor=>$cat)
        $this->db->insert(
          'usuario_permiso',
          array(
            'id_usuario'=>$id_usuario,
            'codigo_permiso'=>$cat,
            'id_empresa'=>$cat1,
            'usuario_guarda'=>$data['usuario_guarda'],
            'fecha_guarda'=>$data['fecha_guarda']
            )
          );

    }  

}
public function update($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  function guarda_usuario_empresa($data)
  {
    foreach($data['id_empresa'] as $valor => $cat)
      $this->db->insert(
        'usuario_empresa',
        array(
          'id_usuario'=>$data['id_usuario'],
          'id_empresa'=>$cat,
          'usuario_guarda'=>$data['usuario_guarda'],
          'fecha_guarda'=>$data['fecha_guarda']
          )
        );

  }

  function mostrar_modulos(){
    $this->db->select('m.id_modulo, m.nombre_modulo, m.estado, m.titulo_modulo, m.icono, m.id_ambiente');
    $this->db->from('modulo m');
    $this->db->where('m.estado', 1);
    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
}

  function mostrar_permisos(){
      $this->db->select('p.id_permiso, p.codigo_permiso, p.nombre_permiso, p.estado, p.descripcion_permiso, p.titulo_permiso, p.id_modulo, p.id_tipo_permiso');
      $this->db->from('permiso p');
      $this->db->join('modulo m', 'm.id_modulo = p.id_modulo');
      $this->db->where('p.estado', 1);
      $query = $this->db->get();
      if($query->num_rows() >  0){
          return $query->result();
      }else{
          return false;
      }
  }

  function mostrar_permisos_por_perfil($id_perfil){
    $this->db->select('p.id_canasta_permiso, p.codigo_permiso');
    $this->db->from('canasta_permiso p');
    //$this->db->join('modulo m', 'm.id_modulo = p.id_modulo');
    $this->db->where('p.estado', 1);
    //1: Admin, 3: Digitador y 4: Invitado
    $this->db->where('p.id_tipo_perfil', $id_perfil);
    $query = $this->db->get();
    if($query->num_rows() >  0){
        return $query->result();
    }else{
        return false;
    }
}



  function get_permisos_usuario($ide,$idu){
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

  function get_nuevos_permisos_usuario($ide,$idu){
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

  function guarda_permiso($data,$status){

    if($status == 1){

      $this->db->delete('usuario_permiso', array('id_usuario' => $data['id_usuario'],'id_empresa' => $data['id_empresa_guarda_perm']));

      foreach($data['codigo_permiso'] as $valor => $cat)
        $this->db->insert(
          'usuario_permiso',
          array(
            'id_usuario'=>$data['id_usuario'],
            'id_empresa'=>$data['id_empresa_guarda_perm'],
            'codigo_permiso'=>$cat,
            'usuario_guarda'=>$data['usuario_guarda'],
            'fecha_guarda'=>$data['fecha_guarda']
            )
          );

    }else{

      $this->db->delete('usuario_permiso', array('id_usuario' => $data['id_usuario'],'id_empresa' => $data['id_empresa_guarda_perm']));
    }
  }

  function guarda_empresa($data,$status){

    if($status == 0){
      
        $this->db->delete('usuario_empresa', array('id_usuario' => $data['id_usuario']));

        
        $this->db->insert(
        'usuario_empresa',
        array(
          'id_usuario'=>$data['id_usuario'],
          'id_empresa'=>$data['id_empresa_madre'],
          'usuario_guarda'=>$data['usuario_guarda'],
          'fecha_guarda'=>$data['fecha_guarda'])
        );

    
    }else{

      $this->db->delete('usuario_empresa', array('id_usuario' => $data['id_usuario']));

      foreach($data['id_empresa'] as $valor => $emp)
        
        //foreach($data['id_sucursal'] as $valor => $suc)

        $this->db->insert(
          'usuario_empresa',
          array(
            'id_usuario'=>$data['id_usuario'],
            'id_empresa'=>$emp,
            //'id_sucursal'=>$suc,
            'usuario_guarda'=>$data['usuario_guarda'],
            'fecha_guarda'=>$data['fecha_guarda']
            )
          );

    }

    

  }

    public function update_con($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }


}
