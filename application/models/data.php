<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Model {
var $codcompa;
var $txtcompa;
var $zona;
var $data_session;
var $temporal;
var $query;
var $dataCiuEst;
var $codciu;
var $codesta;
    function __construct()
    {
        parent::__construct();
        $this->data_session=$this->session->userdata('datos_usuario');
        $this->codcompa=$this->session->userdata('compa_select');
        switch ($this->session->userdata('compa_select')) {
        	case '001':
        		$this->txtcompa='dideco';
        		$this->zona=$this->data_session['001'];
        		$this->load->database($this->txtcompa);
        		$this->load->database($this->txtcompa, TRUE);
        		break;
        	case '002':
        		$this->txtcompa='deimport';
        		$this->zona=$this->data_session['002'];
        		$this->load->database($this->txtcompa, TRUE);
        		break;
        	case '005':
        		$this->txtcompa='compacto';
        		$this->zona=$this->data_session['005'];
        		$this->load->database($this->txtcompa, TRUE);
        		break;
        	
        	default:
        		# en caso que no lea ninguno de las anteriores
        		break;
        }
        //echo "cargo Modelo Data ".$this->codcompa."<br>";
        //var_dump($this->data_session);
        $this->get_clientes();
    }

    function get_clientes($dataClientes=''){
        /*if($this->session->userdata('compa_select')!=''){

        }else{

        }*/
        $query = $this->db->query("SELECT * FROM  `01_cpc` WHERE  `codcia` LIKE '".$this->session->userdata('compa_select')."' AND  `zona` LIKE '".$this->zona."' ORDER BY  `01_cpc`.`razsoc` ASC");


				foreach ($query->result() as $row)
				{
                   $dataClientes[]=array('codcte'=>$row->codcte,'razsoc'=>$row->razsoc,'rif'=>$row->rif);
				}

					return $dataClientes;    	
}//fin de la funcion de obtener clientes

    function get_vendedores_dideco(){
        $this->load->database('dideco',TRUE);
        $query=$this->db->query("SELECT `cod`,`nombre` FROM `maeven` WHERE `banvend` LIKE 'S'");
        return $query->result_array();
    }


function get_cliente($codCte='')
{
	$this->load->database($this->txtcompa,TRUE);
	$this->query = $this->db->query("SELECT * FROM  `01_cpc` WHERE  `codcte` LIKE '$codCte' LIMIT 1");

        		foreach ($this->query->result() as $row)
        				{
        					$dataCiuEst=$this->get_ciudad_estado($row->codciud,$row->codesta);
        				   	$this->temporal=array('codcte'=>$row->codcte,'zona'=>$row->zona,'ruta'=>$row->ruta,'razsoc'=>$row->razsoc,'rif'=>$row->rif,'ciudad'=>$dataCiuEst['ciudad'],'estado'=>$dataCiuEst['estado']);
        				}
    	if (count($this->temporal)>1) {
    			return $this->temporal;
    	}else{
    			return -1;
    	}
}//fin de la funcion get_cliente

function get_ciudad_estado($codciudad,$codestado){
	$this->load->database($this->txtcompa,TRUE);
	$query=$this->db->query("SELECT  `ciudades`.`nombre` ,  `estados`.`estado` FROM  `ciudades` ,  `estados` WHERE  `ciudades`.`codciud` LIKE  '".$codciudad."' AND  `estados`.`codesta` LIKE  '".$codestado."' LIMIT 1");
			foreach ($query->result() as $row)
				{
				   $this->temporal=array('ciudad'=>$row->nombre,'estado'=>$row->estado);
				}
	return $this->temporal;
}//fin de get_ciudad_estado

function get_proveedores(){
 $this->load->database($this->txtcompa,TRUE);
    $query=$this->db->query("SELECT * FROM  `01_cpp` WHERE `st` LIKE 'A'");
            foreach ($query->result() as $row)
                {
                   $data[]=array('codcia'=>$row->codcia,'codigo'=>$row->codigo,'razsoc'=>$row->razsoc);
                }
    return $data;

}
function get_productos_proveedor($codpro='',$data=''){
 //OEM $sql="SELECT  `01_inv`.`clave`, `01_inv`.`descr`, `01_inv`.`oferm`, `01_inv`.`oferd`, `01_inv`.`ofere`, `01_inv`.`ofers`, `01_inv`.`oferz`,`01inv`.`ventam`,`01inv`.`ventad`,`01inv`.`ventas`,`01inv`.`ventak`,`01inv`.`ventac`,`01inv`.`ventaz`,`01inv`.`existen`, `01_inv`.`st` FROM  `01_inv` ,  `01inv` WHERE  `01_inv`.`clave` LIKE  '$codpro%' AND  `01inv`.`clave` LIKE  `01_inv`.`clave` AND  `01_inv`.`st` LIKE  'A' ORDER BY  `01_inv`.`descr` DESC";
 $sql="SELECT `01_inv`.`clave`, `01_inv`.`descr`, `01_inv`.`st` FROM `01_inv` WHERE `01_inv`.`clave` LIKE '$codpro%' AND `01_inv`.`st` LIKE 'A' ORDER BY `01_inv`.`descr` DESC";
 //$this->load->database($this->txtcompa,TRUE);
 $temp="";
 switch ($this->session->userdata('compa_select')) {
     case '001':
         $temp="dideco";
         break;
     case '002':
         $temp="deimport";
         break;
     case '005':
         $temp="compacto";
         break;

     
     default:
         $temp='default';
         break;
 }
if($temp!='default'){
 $this->load->database($temp,TRUE);

    $query=$this->db->query($sql);
            foreach ($query->result() as $row)
                {
                  //OEM $data[]=array('clave'=>$row->clave,'descr'=>$row->descr,'oferm'=>$row->oferm,'oferd'=>$row->oferd,'ofere'=>$row->ofere,'ofers'=>$row->ofers,'oferz'=>$row->oferz,'ventam'=>$row->ventam,'ventad'=>$row->ventad,'ventas'=>$row->ventas,'ventak'=>$row->ventak,'ventac'=>$row->ventac,'ventaz'=>$row->ventaz,'st'=>$row->st,'existen'=>$row->existen);
                $data[]=array('clave'=>$row->clave,'descr'=>$row->descr,'st'=>$row->st);
                }
    return $data;    
}else{return 'DEBE SELECCIONAR UNA COMPAÑIA';}


}

function ultimo_pedido_usuario($idu){
    $sql="SELECT  `id` FROM  `pedidos` WHERE  `idu` LIKE  '".$idu."' ORDER BY  `pedidos`.`fecha` DESC LIMIT 1";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal=$row->id;
                }
return $this->temporal;
}//ultimo pedido  del usuario

function get_nombreCompletoUsuario($idu){
            $this->load->database('default',TRUE);
            $sql="SELECT  `nombre` ,  `apellido` 
                    FROM  `usuariosventas` 
                    WHERE  `idU` LIKE  '$idu'
                    LIMIT 1";
            $query=$this->db->query($sql);  
                foreach ($query->result() as $row){
                                $this->temporal=array('nombre'=>$row->nombre,'apellido'=>$row->apellido);
                            }
    return $this->temporal;

}//fin del la funcion de obtener el nombre ya apellido  de usuario

function procesar_pedido($pedido){
    $productos=$pedido['productos']; 
    $this->load->database('default',TRUE);
    $sql="INSERT INTO `grupoemp_ventas`.`pedidos` (`id`, `idu`,`nombre_completo`, `compa`, `zona`, `codcte`, `fecha`, `nota`, `status`, `tipo`) VALUES (NULL, '".$pedido['idU']."', '".strtoupper($pedido['nombre_usuario_completo'])."', '".$pedido['compa']."', '".$pedido['zona']."', '".$pedido['codCliente']."', NOW(), '".$pedido['nota']."', 'A','".$pedido['tipo']."');";
   
    
    if($this->db->query($sql)){
            return $this->procesar_productos_pedido($productos,$pedido['idU'],$pedido['nota']);
            
        }else{
            return -1;
        }
     
    //$this->procesar_productos_pedido($productos);

}//fin de la funcion procesar_pedido

function procesar_productos_pedido($productos,$idu,$nota){
    //return var_dump($productos);
    
    $this->load->model('data_complemento');
    $ult=$this->ultimo_pedido_usuario($idu);
    $resultado=FALSE;
    for ($i=0; $i < count($productos); $i++) { 
        $sql="INSERT INTO  `grupoemp_ventas`.`productos_pedidos` (
`id` ,
`idped` ,
`cod_producto` ,
`cantidad`
)
VALUES (
NULL ,  '".$ult."',  '".$productos[$i][0]."',  '".$productos[$i][1]."'
);
";

    $this->load->database('default',TRUE);
    if($this->db->query($sql)){
            $resultado=TRUE;
            /*Enviamos E-Mail*/


/**Preparamos  los Datos para enviar un Email con la Información*/
    $datos_session=$this->session->userdata('datos_usuario');
    $CompaZonaActiva=$this->session->userdata('zona_activa');
    $codigoCliente=$this->session->userdata('codigo_cliente_seleccionado');

$datos_ult_pedido=array(
    'nroP'=>$this->data_complemento->ultimo_pedido_usuario($datos_session['idU']),
    'usuario'=>$datos_session['usuario'],
    'compa'=>$this->session->userdata('compa_select')."-".$this->session->userdata('compa_select_txt'),
    'codigoCliente'=>$codigoCliente,
    'zona'=>$CompaZonaActiva,
    'productos'=>$productos,
    'nota'=>$nota
    );




        }else{
            $resultado=FALSE;
        }

    }//fin del for
    if($resultado==TRUE){
            //$this->data_complemento->enviar_email_vendedor($idu,$datos_ult_pedido);
            //**********************************************************************
    }
    return $resultado;
}//fin de la funcion porcesar_productos_pedido

}/*FIN DE CLASE DATA*/