<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Identificacion extends CI_Controller {
	var $data;
	public function index()
	{
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('usu', 'Usuario', 'required');
		$this->form_validation->set_rules('pass', 'Clave', 'required');

		$this->form_validation->set_message('required', 'Dejo vacio el campo %s  que es obligatorio .');
			//var_dump($this->input->post('usu'));

		if ($this->form_validation->run() == FALSE)
		{

			//var_dump(validation_errors());
			if(validation_errors()==""){
					$error = array('error' => 'Su sesi&oacute;n ha expirado debe autenticarse.'); 
			}else{
					$error = array('error' => validation_errors()); 
			}

			$this->load->view('head');	
			$this->load->view('form_login',$error);	
			$this->load->view('footer');

		}else{
				$this->validar($this->input->post('usu'),$this->input->post('pass'));
				/*$this->load->view('head');
				$this->load->view('footer');*/
		}
	}

	private function validar($u='',$p=''){
	$this->load->database();
	$query = $this->db->query("SELECT * FROM  `usuariosventas` WHERE  `USUARIO` LIKE  '".$this->db->escape_str($u)."' AND  `CLAVE` LIKE  '".$this->db->escape_str($p)."' LIMIT 1");
	if ($query->num_rows() > 0) {
		foreach ($query->result() as $columna) {

			$datosUser=array("idU"=>$columna->idU,"usuario"=>$columna->USUARIO,"001"=>$columna->ZONA001,"002"=>$columna->ZONA002,"005"=>$columna->ZONA005,"tipo"=>$columna->tipo);
			$data = array('datos_usuario' => $datosUser);
			$this->session->set_userdata($data);
			//var_dump($datosUser);
			//print_r($this->session->userdata('datos_usuario'));
			
			$this->redireccion();
		}
	}else{			
			$error = array('error' => 'Usuario o Clave INVALIDOS'); 	
				$this->load->view('head');	
				$this->load->view('form_login',$error);	
				$this->load->view('footer');
	}

	}//fin de la funcion de validar

	public function cerrarSesion(){
		$this->session->unset_userdata('datos_usuario');
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function redireccion(){
		$this->data=$this->session->userdata('datos_usuario');
		switch ($this->data['tipo']) {
			case 'V':
				# En Caso de Ser Vendedor
				redirect('ventas');
				break;
			case 'F':
				# En Caso de Ser Facturador
				redirect('facturacion');
				break;
			case 'E':
				# En Caso de Ser SUPERVISION
				redirect('editor');
				break;
			case 'C':
				# En Caso de Ser Consultor
				break;
			
			default:
				# si no se definio su tipo
			$error = array('error' => 'No se le ha asignado un tipo a Este Usuario (TIPO DE USUARIO NO DEFINIDO)'); 	
				$this->load->view('head');	
				$this->load->view('form_login',$error);	
				$this->load->view('footer');

				break;
		}
	}

}