<?php

class My_Encript extends CI_Encrypt{

	public function sha512($cadena){

		return hash('sha512',$cadena);
	}
}