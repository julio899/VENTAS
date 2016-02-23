<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends CI_Controller{

	public function __construct() {        
	    parent::__construct();
	    $this->verifica_editor();
	}// fin de __construct

    # funcion encargada de verificar si es un tipo de usuario EDITOR para usar las funciones de esta clase
    public function verifica_editor(){
    			if(!isset($this->session->userdata['datos_usuario']))
			{
					echo "ha expirado el tiempo de sesión ó cerrado la sesión...<br>";
					echo "<a href=\"".base_url()."\">Click Aqui para regresar</a>";
			}else{

				if($this->session->userdata['datos_usuario']['tipo']!='E')
				{
					echo "<pre>Necesita acceder con una cuenta de tipo EDITOR para poder acceder a este modulo.</pre>";
					echo "<a href=\"".base_url()."\">Click Aqui para regresar</a>";
					exit();
				}
			}
    }// FIN DE verifica_editor

	
	public function index()
{
	$this->load->view('html/head2');
			$this->load->model('data_complemento');
			$pedidos=$this->data_complemento->pedidos_por_procesar();
			$cant_pedidos_nuevos=$this->data_complemento->cantidad_pedidos_nuevos();

					$tabla="<table class=\"hoverable\"><tr><th>Nro.</th><th>COMPA&Ntilde;IA</th><th class=\"ocultar-en-movil600\">ZONA</th><th>COD. CLIENTE</th><th>Raz&oacute;n Social</th><th class=\"ocultar-en-movil600\">FECHA</th><th>TIPO</th><th>Detalle</th></tr>";
				for ($i=0; $i < count($pedidos); $i++) { 
					$cliente=$this->data_complemento->get_cliente($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
					$tipo="";
					if($pedidos[$i]['tipo']==1){$tipo='<span class="label label-success">C.O.D</span>';}
					if($pedidos[$i]['tipo']==2){$tipo='<span class="label label-warning">CR-10</span>';}
					if($pedidos[$i]['status']=="I"){
						$tabla.= "<tr style=\"background-color:#CEECF5\"><td>".$pedidos[$i]['id']."</td><td>".strtoupper($this->data_complemento->get_compaTXT($pedidos[$i]['compa']))."</td><td class=\"ocultar-en-movil600\" >".$pedidos[$i]['zona']."</td><td>".$pedidos[$i]['codcte']."</td><td>".$cliente['razsoc']."</td><td class=\"ocultar-en-movil600\" >".date_format(date_create($pedidos[$i]['fecha']),"d-m-Y g:i A")."</td><td>".$tipo."</td><td><a class=\"btn btn-info\" href=\"".base_url().index_page()."/ventas/detallar_pedido/".$pedidos[$i]['id']."\"><i class=\"icon-search\" title=\"Mostrar Detalles\"></i> Ver</a></td></tr>";
			
					}else{
						$tabla.= "<tr><td>".$pedidos[$i]['id']."</td><td>".strtoupper($this->data_complemento->get_compaTXT($pedidos[$i]['compa']))."</td><td class=\"ocultar-en-movil600\" >".$pedidos[$i]['zona']."</td><td>".$pedidos[$i]['codcte']."</td><td>".$cliente['razsoc']."</td><td class=\"ocultar-en-movil600\" >".date_format(date_create($pedidos[$i]['fecha']),"d-m-Y g:i A")."</td><td>".$tipo."</td><td><a class=\"btn btn-info\" href=\"".base_url().index_page()."/ventas/detallar_pedido/".$pedidos[$i]['id']."\"><i class=\"icon-search\" title=\"Mostrar Detalles\"></i> REVISAR</a></td></tr>";
					}
					
				}
				//var_dump($pedidos);
				$tabla.="</table>";



		$this->load->view("contenido/edicion_index",array('tabla' =>$tabla,'cant_ped_new'=>$cant_pedidos_nuevos));
	$this->load->view('html/footer2');
}//fin de funcion index();

}// Fin de clase Editor