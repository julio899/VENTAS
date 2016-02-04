<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Librosventas extends CI_Controller {
		public function index()
	{
		$this->tipo_ventas_libros();
		$this->load->view('html/head2');
		$this->load->view('contenido/libros_seleccion');
		$this->load->view('html/footer2');
	}

	public function tipo_ventas_libros(){
			$dataUser=$this->session->userdata('datos_usuario');
			if($dataUser['tipo']!='L'){
				redirect('identificacion/redireccion');
			}	
	}

 //imprimir/imp_fac_ventas/008/01/16
}