<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Historico_model extends CI_Model
{

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

      public function muestra_meses_venta()
      {
        $this->db->select('*');
        $this->db->from('venta_mes vm');
        $this->db->where('vm.estado', 1);
        $this->db->order_by('vm.id_mes', 'asc');
        $query = $this->db->get();

        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function muestra_anos_venta()
      {
        $this->db->select('*');
        $this->db->from('venta_ano va');
        $this->db->where('va.estado', 1);
        $this->db->order_by('va.id_ano', 'asc');
        $query = $this->db->get();

        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_venta($data)
      {
        $this->db->select_sum('v.monto_quincena');  
        $this->db->select('v.id_venta,v.id_mes,v.id_ano,v.lunes_quincena,v.estado');
        $this->db->from('venta v');
        $this->db->where('v.lunes_quincena >=', $data['fi']);
        $this->db->where('v.lunes_quincena <=', $data['ft']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->where('v.id_quincena', 2);
        //$this->db->where('v.estado', 1);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_venta_resumen($data)
      {
          
        $this->db->select('v.id_venta,v.monto_quincena,v.id_empresa_guarda,v.id_mes,v.id_ano,v.lunes_quincena');
        $this->db->from('venta v');
        $this->db->where('v.lunes_quincena >=', $data['lunes_quincena']);
        $this->db->where('v.lunes_quincena <=', $data['ft']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        $this->db->where('v.estado', 1);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }
      public function trae_euincena($data)
      {
        $this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano,v.lunes_quincena');
        $this->db->from('venta v');
        $this->db->where('v.lunes_quincena >=', $data['fi']);
        $this->db->where('v.lunes_quincena <=', $data['ft']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        $this->db->where('v.estado', 1);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function sum_trae_euincena($data)
      {
          
        //$this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano,v.lunes_quincena');
        $this->db->select_sum('v.monto_quincena', 'monto_total_quincena');
        $this->db->from('venta v');
        $this->db->where('v.lunes_quincena >=', '2015-01-01');
        $this->db->where('v.lunes_quincena <', $data['lunes_quincena']);
        //$this->db->where('v.lunes_quincena', $data['lunes_quincena']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        $this->db->where('v.estado', 1);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }
      
     /* public function sum_trae_iba($data)
      {
          
        //$this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano,v.lunes_quincena,v.monto_iva,v.lunes_iva');
        $this->db->select_sum('v.monto_iva', 'monto_total_iva');
        $this->db->from('venta v');
        $this->db->where('v.lunes_iva >=', '2015-01-01');
        $this->db->where('v.lunes_iva <', $data['lunes_iva']);
        //$this->db->where('v.lunes_iva', $data['lunes_iva']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }
      
      public function trae_iba($data)
      {
          
        $this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano,v.lunes_quincena');
        $this->db->from('venta v');
        $this->db->where('v.lunes_iva', $data['lunes_iva']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }*/

      public function devuelve_venta_grilla_consolidada($data)
      {
        $this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano,v.lunes_quincena,id_empresa_guarda');
        $this->db->from('venta v');
        $this->db->where('v.id_ano', $data['id_año']);
        //$this->db->where('v.id_mes', $data['id_mes']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_tributo_grilla_consolidada($data)
      {
        $this->db->select('t.id_tributario,t.monto_tributario,t.id_mes,t.id_ano,id_empresa_guarda');
        $this->db->from('tributario t');
        $this->db->where('t.id_ano', $data['id_año']);
        //$this->db->where('v.id_mes', $data['id_mes']);
        $this->db->where('t.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_venta_grilla($data)
      {
        $this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano,v.lunes_quincena');
        $this->db->from('venta v');
        $this->db->where('v.id_ano', $data['id_año']);
        $this->db->where('v.id_mes', $data['id_mes']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_tribut_grilla($data)
      {
        $this->db->select('t.monto_tributario,t.id_mes,t.id_ano,t.id_empresa_guarda');
        $this->db->from('tributario t');
        $this->db->where('t.id_ano =', $data['id_año']);
        $this->db->where('t.id_mes =', $data['id_mes']);
        $this->db->where('t.id_empresa_guarda',$data['id_empresa_guarda']);
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_venta_año($data)
      {
          
        $this->db->select_sum('v.monto_quincena', 'total_año');
        $this->db->from('venta v');
        $this->db->where('v.id_ano', $data['id_ano']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_tributario_año($data)
      {
          
        $this->db->select_sum('t.monto_tributario', 'total_tributario_año');
        $this->db->from('tributario t');
        $this->db->where('t.id_ano', $data['id_ano']);
        $this->db->where('t.id_empresa_guarda',$data['id_empresa_guarda']);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_consolidado_ano($data)
      {
          
        $this->db->select_sum('v.monto_quincena', 'total_año', 'id_empresa_guarda');
        $this->db->from('venta v');
        $this->db->join('empresa e', 'e.id_empresa = v.id_empresa_guarda');
        $names = $data['id_empresa_guarda'];
        $this->db->where_in('v.id_empresa_guarda', $names);
        $this->db->where('v.id_ano', $data['id_ano']);
        //$this->db->where('e.id_holding', 1);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_consolidado_tribut($data)
      {
          
        $this->db->select_sum('v.monto_tributario', 'total_año', 'id_empresa_guarda');
        $this->db->from('tributario v');
        $this->db->join('empresa e', 'e.id_empresa = v.id_empresa_guarda');
        $names = $data['id_empresa_guarda'];
        $this->db->where_in('v.id_empresa_guarda', $names);
        $this->db->where('v.id_ano', $data['id_ano']);
        //$this->db->where('e.id_holding', 1);
        //$this->db->group_by('1');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_venta_editar($data)
      {
        $this->db->select('v.id_venta,v.monto_quincena,v.lunes_quincena,v.monto_iva,v.lunes_iva,v.id_mes,v.id_ano');
        $this->db->from('venta v');
        $this->db->where('v.id_ano =', $data['id_ano']);
        $this->db->where('v.id_mes =', $data['id_mes']);
        //$this->db->where('v.id_quincena', $data['id_quincena']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_tributario_editar($data)
      {
        $this->db->select('t.monto_tributario,t.id_mes,t.id_ano,t.id_empresa_guarda');
        $this->db->from('tributario t');
        $this->db->where('t.id_ano =', $data['id_ano_trib']);
        $this->db->where('t.id_mes =', $data['id_mes_trib']);
        $this->db->where('t.id_empresa_guarda',$data['id_empresa_guarda']);
        
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      public function devuelve_var($data)
      {
        $this->db->select_sum('v.id_ano', 'anos');
        $this->db->select('v.id_venta,v.monto_quincena,v.id_mes,v.id_ano');
        $this->db->from('venta v');
        $anos = array($data['id_ano'],$data['id_ano_ant']);
        $this->db->where_in('v.id_ano', $anos);
        $this->db->where('v.id_mes', $data['id_mes']);
        $this->db->where('v.id_empresa_guarda',$data['id_empresa_guarda']);
        $this->db->group_by('id_venta');
        $query = $this->db->get();
        if($query->num_rows() >  0){
            return $query->result();
        }else{
            return false;
        }
      }

      function guarda_venta($data){

        $this->db->trans_start();
        
        $this->db->delete('venta', 
            array('id_ano' => $data['id_ano'],'id_mes' => $data['id_mes'],'id_empresa_guarda' => $data['id_empresa_guarda'])
        );

        $uin=1;
        for($q=0;$q<2;$q++){
            $this->db->insert(
              'venta',
              array(
                'id_quincena'=>$uin,  
                'id_ano'=>$data['id_ano'],
                'id_mes'=>$data['id_mes'],
                'monto_quincena'=>$data['monto_quincena'][$q],
                'lunes_quincena'=>$data['lunes_quincena'][$q],
                //'monto_iva'=>$data['monto_iva'],
                //'lunes_iva'=>$data['lunes_iva'],                
                'id_empresa_guarda'=>$data['id_empresa_guarda'],
                'usuario_guarda'=>$data['usuario_guarda'],
                'fecha_guarda'=>$data['fecha_guarda'],
                'estado'=>$data['estado']

              )
            );
            $uin++;
        }
                  
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    
    }


    function guarda_tributario($data){

      $this->db->trans_start();
      
      $this->db->delete('tributario', 
          array('id_ano' => $data['id_ano_trib'],'id_mes' => $data['id_mes_trib'],'id_empresa_guarda' => $data['id_empresa_guarda'])
      );

     /* $uin=1;
      for($q=0;$q<2;$q++){*/
          $this->db->insert(
            'tributario',
            array(
              'id_ano'=>$data['id_ano_trib'],
              'id_mes'=>$data['id_mes_trib'],
              'monto_tributario'=>$data['monto_tributario'],            
              'id_empresa_guarda'=>$data['id_empresa_guarda'],
              'usuario_guarda'=>$data['usuario_guarda'],
              'fecha_guarda'=>$data['fecha_guarda'],
              'estado'=>$data['estado']

            )
          );
          /*$uin++;
      }*/
                
      $insert_id = $this->db->insert_id();

      $this->db->trans_complete();

      return $insert_id;
  
  }
}
