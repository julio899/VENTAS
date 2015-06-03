<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ventas extends CI_Controller {
var $session_page;
var $compa_select_txt;
var $zona_activa;
	public function index()
	{		/*Confirmamos que el usuario que se logueo  sea de tipo Vendedor*/
		$this->tipo_vendedor();
		//$this->load->view('vtn_vendedor');
		redirect('ventas/nuevo_pedido');
	}

	public function nuevo_pedido(){
		$this->tipo_vendedor();
		$this->session->set_userdata('page','nuevo_pedido');
		$this->load->view('html/head2');
		$this->load->view('contenido/nuevo_pedido_select');
		$this->load->view('html/footer2');

	}
	public function nuevo_pedido_cliente(){
		$this->tipo_vendedor();
			$this->session->set_userdata('page','nuevo_pedido_cliente');
			$this->session_page=$this->session->userdata('page');
			$this->load->model('data');
			$clientes=array('clientes'=>$this->data->get_clientes());
			//var_dump($clientes);
		$this->load->view('html/head2');
		$this->load->view('contenido/nuevo_pedido_cliente',$clientes);
		$this->load->view('html/footer2');

	}
	public function setCompa($codCompa=''){
		if ($codCompa=='001' || $codCompa=='002' || $codCompa=='005' ) {
			# cambiamos en la session el codigo de la compañia
			$this->session->set_userdata('compa_select',$codCompa);
			$this->session->set_userdata('compa_select_txt',$this->set_compa_select_txt($codCompa));
			$this->session->set_userdata('zona_activa',$this->set_zona_activa($codCompa));		
			$this->session_page=$this->session->userdata('page');

			
			switch ($this->session_page) {
						case 'nuevo_pedido':
							# si viene de la pagina nuevo_pedido ya selecciono la compañia y le decimos que seleccione el cliente
							//$this->nuevo_pedido_cliente();
							redirect('ventas/nuevo_pedido_cliente');
							break;
						
						default:
							redirect();
							break;
					}		
		

		}else{
			$error=array('error'=>'Codigo ['.$codCompa.'] de Compa&ntilde;ia es invalido, porfavor verifique');
					$this->tipo_vendedor();
					$this->load->view('html/head2');
					$this->load->view('contenido/nuevo_pedido_select',$error);
					$this->load->view('html/footer2');
			}
	}
	


	public function set_zona_activa($codCompa=''){
		$data=$this->session->userdata('datos_usuario');
		switch ($codCompa) {
			case '001':
				$this->zona_activa=$data['001'];
				$this->session->set_userdata('zona_a_comp',array('compa'=>'001','zona'=>$data['001']));
				break;
			case '002':
				$this->zona_activa=$data['002'];
				$this->session->set_userdata('zona_a_comp',array('compa'=>'002','zona'=>$data['002']));
				break;
			case '005':
				$this->zona_activa=$data['005'];
				$this->session->set_userdata('zona_a_comp',array('compa'=>'005','zona'=>$data['005']));
				break;
			default:
				$this->zona_activa='0';
				$this->session->set_userdata('zona_a_comp','0');
				break;
		}
		return $this->zona_activa;
		//echo $this->zona_activa;
	}

	public function set_compa_select_txt($codCompa=''){
		switch ($codCompa) {
			case '001':
				$this->compa_select_txt='dideco';
				break;
			case '002':
				$this->compa_select_txt='deimport';
				break;
			case '005':
				$this->compa_select_txt='compacto';
				break;
			
			default:
				$this->compa_select_txt='';
				break;
		}
		return $this->compa_select_txt;
	}

	public function tipo_vendedor(){
			$dataUser=$this->session->userdata('datos_usuario');
			if($dataUser['tipo']!='V'){
				redirect('identificacion/redireccion');
			}	
	}


public function genera_pedido(){
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('codcte', 'Codigo de Cliente', 'required');
		$this->form_validation->set_message('required', 'Dejo vacio el campo %s  que es obligatorio .');
			
			if ($this->form_validation->run() == FALSE)
		{

		}else{

				$this->verificaCodCliente($this->input->post('codcte'));
		}

}

public function genera_pedido_get($codcte='')
{
	$this->verificaCodCliente($codcte);
}

public function verificaCodCliente($codClient=''){
	$this->load->model('data');
	//
	if($this->data->get_cliente($codClient)!=-1){
					$this->session->set_userdata('codigo_cliente_seleccionado',$codClient);
					$this->load->view('html/head2');
					//var_dump($this->data->get_cliente($codClient));
					$datoscliente=array('cliente'=>$this->data->get_cliente($codClient),'proveedores'=>$this->data->get_proveedores());
					$this->load->view('contenido/nuevo_pedido',$datoscliente);
					$this->load->view('html/footer2');

	}else{
		$error=array('error'=>'Codigo de cliente ['.$codClient.'] es invalido, porfavor verifique');
					$this->load->view('html/head2');
					$this->load->view('contenido/nuevo_pedido_select',$error);
					$this->load->view('html/footer2');
	}
}

public function buscar_productos_por_proveedor($cod=''){
	$this->load->model('data');
	//var_dump($this->data->get_productos_proveedor($cod));
	header('Content-type: text/json');
	header('Content-type: application/json');
	echo json_encode($this->data->get_productos_proveedor($cod));
}

public function generar_pedido_confirmado(){
	//sleep(5);
	$this->load->model('data');
	$dataUser=$this->session->userdata('datos_usuario');
	$CompaZonaActiva=$this->session->userdata('zona_a_comp');
	$codigoCliente=$this->session->userdata('codigo_cliente_seleccionado');
	$nombreCompletoUsuario=$this->data->get_nombreCompletoUsuario($dataUser['idU']);
	$pedido=array('idU'=>$dataUser['idU'],'nombre_usuario_completo'=>$nombreCompletoUsuario['nombre'].' '.$nombreCompletoUsuario['apellido'],'compa'=>$CompaZonaActiva['compa'],'zona'=>$CompaZonaActiva['zona'],'codCliente'=>$codigoCliente,'productos'=>$_POST['productos'],'tipo'=>$_POST['tipo_venta'],'nota'=>$_POST['nota']);
	//var_dump($pedido);
	//var_dump($dataUser);
	//var_dump($pedido);


var_dump($this->data->procesar_pedido($pedido));
}

public function ultimo_pedido(){
	$datos_session=$this->session->userdata('datos_usuario');
	$this->load->model('data_complemento');
	echo json_encode($this->data_complemento->ultimo_pedido_usuario($datos_session['idU']));
}

public function pedidos_enviados(){
	$datos_session=$this->session->userdata('datos_usuario');
	$this->load->model('data_complemento');
	$pedidos=$this->data_complemento->todos_pedidos_usuario($datos_session['idU']);
		
		$this->load->view('html/head2');
		$tabla="<table class=\"hoverable\"><tr><th class=\"ocultar-en-movil\">Nro. Pedido</th><th>COMPA&Ntilde;IA</th><th class=\"ocultar-en-movil\">ZONA</th><th class=\"ocultar-en-movil\">COD. CLIENTE</th><th>Raz&oacute;n Social</th><th class=\"ocultar-en-movil\">FECHA</th><th>TIPO</th><th>Detalle</th></tr>";
		for ($i=0; $i < count($pedidos); $i++) { 
			$cliente=$this->data_complemento->get_cliente($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
			$tipo="";
			if($pedidos[$i]['tipo']==1){$tipo='<span class="btn-floating btn-large waves-effect waves-light green">C.O.D</span>';}
			if($pedidos[$i]['tipo']==2){$tipo='<span class="btn-floating btn-large waves-effect waves-light red">CR-10</span>';}
			$tabla.="<tr><td class=\"ocultar-en-movil\">".$pedidos[$i]['id']."</td><td>".strtoupper($this->get_compaTXT($pedidos[$i]['compa']))."</td><td class=\"ocultar-en-movil\">".$pedidos[$i]['zona']."</td><td class=\"ocultar-en-movil\">".$pedidos[$i]['codcte']."</td><td>".$cliente['razsoc']."</td><td class=\"ocultar-en-movil\" >".date_format(date_create($pedidos[$i]['fecha']),"d-m-Y g:i A")."</td><td>".$tipo."</td><td><a class=\"btn btn-info\" href=\"".base_url().index_page()."/ventas/detallar_pedido/".$pedidos[$i]['id']."\"><i class=\"icon-search\" title=\"Mostrar Detalles\"></i> Ver</a></td></tr>";
		}
		//var_dump($pedidos);
		$tabla.="</table>";
		$this->load->view('contenido/tabla_pedidos_enviados',array('tabla'=>$tabla));
		$this->load->view('html/footer2');
					
}/*fin de la funcion pedidos_enviados*/

public function detallar_pedido($nro_ped=''){	
	$this->load->model('data_complemento');
	$pedido_detallado=$this->data_complemento->pedido_especifico($nro_ped);
	$this->load->view('html/head2');
	$clienteTXT=$this->load->data_complemento->get_cliente($pedido_detallado['cabecera']->codcte,$pedido_detallado['cabecera']->compa);
	
	$pedido_completo['cabecera']=array('id'=>$pedido_detallado['cabecera']->id,'nombre_vendedor'=>$pedido_detallado['cabecera']->nombre_completo,'fecha'=>$pedido_detallado['cabecera']->fecha,'compa'=>strtoupper($this->get_compaTXT($pedido_detallado['cabecera']->compa)),'zona'=>$pedido_detallado['cabecera']->zona,'codcte'=>$pedido_detallado['cabecera']->codcte,'tipo'=>$pedido_detallado['cabecera']->tipo,'nota'=>$pedido_detallado['cabecera']->nota,'clienteTXT'=>$clienteTXT);
			for ($i=0; $i < count($pedido_detallado['productos']); $i++) { 
				$pedido_completo['productos'][]=array('codpro' =>$pedido_detallado['productos'][$i]->cod_producto ,'descr'=>$this->data_complemento->get_descripcion_producto($pedido_detallado['productos'][$i]->cod_producto,$this->get_compaTXT($pedido_detallado['cabecera']->compa)),'cantidad'=>$pedido_detallado['productos'][$i]->cantidad);
	
			}
	
	$this->load->view('contenido/detalle_pedido',array('pedido_completo'=>$pedido_completo,'ultimo'=>$pedido_detallado['ultimo']));
	$this->load->view('html/footer2');
}/*fin de  la funcion detallar_pedido*/


public function get_compaTXT($codCompa){
$compaTXT='';
switch ($codCompa) {
			case '001':
				$compaTXT='dideco';
				break;
			case '002':
				$compaTXT='deimport';
				break;
			case '005':
				$compaTXT='compacto';
				break;
			
			default:
				$compaTXT='default';
				break;
	}
	return $compaTXT;
}/*fin de funcion get_compaTXT*/

public function buscar_producto(){
	$this->load->view('html/head2');
	$this->load->view('contenido/buscar_producto');
	$this->load->view('html/footer2');
}
public function getProductosCompa(){
	$descripcion=$_POST['palabra'];
	$codCompa=$_POST['compa'];
	$this->load->model('data_inventario');
	echo json_encode($this->data_inventario->get_20productos_compa($codCompa,$descripcion));
}

public function productos_existencia($compa=""){
	
}//fin de productos_existencia


}//fin de la clase