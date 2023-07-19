<?php

class BaseModel extends CI_Model {

    protected $error;
    protected $inTrans = false;
    protected $numRows = 0;
    protected $userID = "";
    protected $periodo_actual;

    protected $lastErrorMsg = "";
    protected $lastErrorCode = 0;
    protected $hasLastError = false;
    
    public function __construct() {
        parent::__construct();

        // if (!defined('_POSTGRESQL')) {
        //     define("_POSTGRESQL", true);
        // }
        
        $this->load->database();
        $this->load->library('session');

        $this->db->simple_query("SET SQL_SAFE_UPDATES=0");
        $this->db->simple_query('SET NAMES \'utf8\'');
        if (isset($_SESSION["usuarioID"])) {
            $this->userID = $_SESSION["usuarioID"];
        }

        $this->getPeriodoActual();
    }

    public function Begin() {
        $this->db->trans_begin();
        $this->inTrans = true;
        log_message('debug', 'Begin');
    }

    public function Commit() {
        if ($this->inTrans) {
            $this->db->trans_commit();
            log_message('debug', 'Commit');
        }
        $this->inTrans = false;
    }

    public function Rollback() {
        if ($this->inTrans) {
            $this->db->trans_rollback();
            log_message('debug', 'Rollback');
        }
        $this->inTrans = false;
    }

    public function Query($stmtQuery) {
        $stmtQuery = str_replace("\r", " ", str_replace("\n", " ", $stmtQuery));
        log_message('debug', $stmtQuery);
        $query = $this->db->query($stmtQuery);
        $this->numRows = $query->num_rows();
        $this->error = $this->db->error();
        $this->session->set_userdata($this->error);
        return $query;
    }
    
    public function FirstRow($stmtQuery) {
        $stmtQuery = str_replace("\r", " ", str_replace("\n", " ", $stmtQuery));
        log_message('debug', $stmtQuery);
        $query = $this->db->query($stmtQuery);
        $this->numRows = $query->num_rows();
        $this->error = $this->db->error();
        $this->session->set_userdata($this->error);
        // if ($query->num_rows() > 0) {
        return $query->first_row();
        // }
        // return null;
    }

    public function NonQuery($stmtSQL) {
        $stmtSQL = str_replace("\r", " ", str_replace("\n", " ", $stmtSQL));
        log_message('debug', $stmtSQL);
        $ok = $this->db->simple_query($stmtSQL);
        // SELECT ROW_COUNT();
        $this->numRows = $this->db->affected_rows();
        $this->error = $this->db->error();
        $this->session->set_userdata($this->error);
        if ($this->HasError()) {
            if ($this->inTrans)
                $this->Rollback();
            return false;
        } else {
            return true;
        }
    }


    public function escape($value) {
        return $this->db->escape(str_replace("'", "", $value));
    }

}

?>