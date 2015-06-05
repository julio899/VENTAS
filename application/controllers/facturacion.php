<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturacion extends CI_Controller{
	
	public function index(){
		$this->load->model('data_complemento');
		$this->tipo_facturador();
		$this->load->view("html/head2");
		$pedidos=$this->data_complemento->todos_pedidos();
		$cant_pedidos_nuevos=$this->data_complemento->cantidad_pedidos_nuevos();

					$tabla="<table class=\"table table-hover table-condensed tbl-ped-env\"><tr><th>Nro.</th><th>COMPA&Ntilde;IA</th><th class=\"ocultar-en-movil600\">ZONA</th><th>COD. CLIENTE</th><th>Raz&oacute;n Social</th><th class=\"ocultar-en-movil600\">FECHA</th><th>TIPO</th><th>Detalle</th></tr>";
				for ($i=0; $i < count($pedidos); $i++) { 
					$cliente=$this->data_complemento->get_cliente($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
					$tipo="";
					if($pedidos[$i]['tipo']==1){$tipo='<span class="label label-success">C.O.D</span>';}
					if($pedidos[$i]['tipo']==2){$tipo='<span class="label label-warning">CR-10</span>';}
					if($pedidos[$i]['status']=="I"){
						$tabla.= "<tr style=\"background-color:#CEECF5\"><td>".$pedidos[$i]['id']."</td><td>".strtoupper($this->data_complemento->get_compaTXT($pedidos[$i]['compa']))."</td><td class=\"ocultar-en-movil600\" >".$pedidos[$i]['zona']."</td><td>".$pedidos[$i]['codcte']."</td><td>".$cliente['razsoc']."</td><td class=\"ocultar-en-movil600\" >".date_format(date_create($pedidos[$i]['fecha']),"d-m-Y g:i A")."</td><td>".$tipo."</td><td><a class=\"btn btn-info\" href=\"".base_url().index_page()."/ventas/detallar_pedido/".$pedidos[$i]['id']."\"><i class=\"icon-search\" title=\"Mostrar Detalles\"></i> Ver</a></td></tr>";
			
					}else{
						$tabla.= "<tr><td>".$pedidos[$i]['id']."</td><td>".strtoupper($this->data_complemento->get_compaTXT($pedidos[$i]['compa']))."</td><td class=\"ocultar-en-movil600\" >".$pedidos[$i]['zona']."</td><td>".$pedidos[$i]['codcte']."</td><td>".$cliente['razsoc']."</td><td class=\"ocultar-en-movil600\" >".date_format(date_create($pedidos[$i]['fecha']),"d-m-Y g:i A")."</td><td>".$tipo."</td><td><a class=\"btn btn-info\" href=\"".base_url().index_page()."/ventas/detallar_pedido/".$pedidos[$i]['id']."\"><i class=\"icon-search\" title=\"Mostrar Detalles\"></i> Ver</a></td></tr>";
					}
					
				}
				//var_dump($pedidos);
				$tabla.="</table>";



		$this->load->view("contenido/fac_index",array('tabla' =>$tabla,'cant_ped_new'=>$cant_pedidos_nuevos));
		$this->load->view('html/footer2');
	}//fin de la funcion Index

	public function generados(){
		$this->tipo_facturador();
		$this->load->model('data_complemento');
		$cant_pedidos_nuevos=$this->data_complemento->cantidad_pedidos_nuevos();
		$archivos_generados=$this->data_complemento->get_archivos_generados();
		$this->load->view("html/head2");
		$this->load->view("contenido/archivos_generados",array('cant_ped_new'=>$cant_pedidos_nuevos,'archivos_generados'=>$archivos_generados));
		$this->load->view("html/footer2");
	}

	public function pedidos_vendedor($id=""){
		$this->load->model('data_complemento');
		$this->load->view('html/head2');

		$pedidos_vendedor=$this->data_complemento->todos_pedidos_usuario($id);
		//var_dump($pedidos_vendedor);

		$this->load->view('contenido/select_pedido_vendedor',array("pedidos_vendedor"=>$pedidos_vendedor));

		$this->load->view('html/footer2');


	}//fin de pedidos  del Vendedor

	public function consultarVendedor(){
		$this->load->model('data_complemento');
		$this->load->view("html/head2");
		$vendedores=$this->data_complemento->get_vendedores();
		//var_dump($vendedores);

		$this->load->view("contenido/select_vendedor",array('vendedores'=>$vendedores));
		$this->load->view("html/footer2");
	}
	public function cant(){
		$this->load->model('data_complemento');

		echo $this->data_complemento->cantidad_pedidos_nuevos();

	}
	public function tipo_facturador(){
			$dataUser=$this->session->userdata('datos_usuario');
			if($dataUser['tipo']!='F'){
				redirect('identificacion/redireccion');
			}	
	}

	public function select_compa($action=""){
		
		$this->session->set_userdata('action',$action);
		
		$this->load->view('html/head2');
		$this->load->view('contenido/select_compa');
		$this->load->view('html/footer2');
	}//fin de la funcion select_compa

	public function inventario_existencia($compa=""){
		$this->session->set_userdata('compa_select',$compa);
		$this->load->model("data_inventario");
		$datos=array('inventario'=>$this->data_inventario->get_productos_act_existencia($compa));
		
		//cargo las Viastas
		$this->load->view('html/head2');
		$this->load->view('contenido/tabla_inventario_existencia',$datos);
		$this->load->view('html/footer2');	
		
	}//fin de la funcion inventario_existencia

	public function inventario_existencia_nom($compa=""){
		$this->session->set_userdata('compa_select',$compa);
		$this->load->model("data_inventario");
		$datos=array('inventario'=>$this->data_inventario->get_productos_act_nombre($compa));
		
		//cargo las Viastas
		$this->load->view('html/head2');
		$this->load->view('contenido/tabla_inventario_existencia',$datos);
		$this->load->view('html/footer2');	
		
	}//fin de la funcion inventario_existencia
}
?>