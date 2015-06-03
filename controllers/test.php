<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{		
	$this->load->model('data_complemento');
	//echo $this->data_complemento("201");
	echo "Test<br>";
	$id_vendedor=202;
	var_dump($this->data_complemento->get_email_vendedor($id_vendedor));
	echo "Ultimo pidido del [$id_vendedor] :".$this->data_complemento->ultimo_pedido_usuario($id_vendedor);
	echo "<br>";
	$dataUser=$this->session->userdata('datos_usuario');
	echo "<br>COD compa:".$this->session->userdata('compa_select');
	echo "<br>compa:".$this->session->userdata('compa_select_txt');
	echo "<br>Cod Cliente:".$this->session->userdata('codigo_cliente_seleccionado');
	echo "<br>";
	var_dump($dataUser);
	var_dump($this->session);
	}
}
