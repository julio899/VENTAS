<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {
	public function index(){

                                               header('Content-type: application/json');
		//header('Content-Type: application/json; charset=utf-8', true,200);
		$datos=array(array('Controlador'=>'Json','Version'=>0.1),'App_data','2013');
		echo json_encode($datos);
	}
	
	public function validacion($u="",$p=""){
	$this->load->database();
	$query = $this->db->query("SELECT * FROM  `usuariosventas` WHERE  `USUARIO` LIKE  '".$this->db->escape_str($u)."' AND  `CLAVE` LIKE  '".$this->db->escape_str($p)."' LIMIT 1");
	
       header('Content-type: application/json');
	if ($query->num_rows() > 0) {
		echo json_encode( array('respuesta'=>true) );
	}else{
		
		echo json_encode( array('respuesta'=>false) );
	}
	
	}//fin de la funcion validacion
	
	public function dideco(){
		$this->load->model('data_inventario');
		header('Content-type: application/json');
		echo json_encode($this->data_inventario->get_productos_proveedor('001','027'));

	}
	public function deimport(){
		$this->load->model('data_inventario');
		header('Content-type: application/json');
		echo json_encode($this->data_inventario->get_productos_proveedor('002','007'));

	}
	public function compacto(){
		$this->load->model('data_inventario');
		header('Content-type: application/json');
		echo json_encode($this->data_inventario->get_productos_proveedor('005','552'));

	}

}