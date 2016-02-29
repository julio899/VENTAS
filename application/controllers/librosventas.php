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
	public function generar_libro(){
		if($this->input->post('mes') && $this->input->post('year') && $this->input->post('compa')){
			//var_dump($this->input->post('compa') );
			$mes="";
			if($this->input->post('mes')<10 ){
				$mes='0'.$this->input->post('mes');
			}else{
				$mes=$this->input->post('mes');
			}
				redirect('imprimir/imp_fac_ventas/'.$this->input->post('compa').'/'.$mes.'/'.substr($this->input->post('year'), -2,2) );
			
			
		}else{
			echo "Falto la recibir algun dato porfavor verifique.";
		}
	}

 //imprimir/imp_fac_ventas/008/01/16
}