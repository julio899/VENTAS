<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_complemento extends CI_Model {
public $temporal;
public $query;
public $data;

function get_vendedores(){
$sql="SELECT * FROM `usuariosventas` WHERE `ciudad` NOT LIKE '' AND `nombre` NOT LIKE '' AND `tipo` LIKE 'V' ORDER BY `usuariosventas`.`nombre` ASC";
$query=$this->db->query($sql);
    foreach ($query->result() as $row) {
        # mientras haya resultados
        $this->data[]=array('nombre' => $row->nombre,
                            'apellido' => $row->apellido, 
                            'ZONA001'=> $row->ZONA001 , 
                            'ZONA002'=> $row->ZONA002 , 
                            'ZONA005'=> $row->ZONA005 , 
                            'idU'=> $row->idU );
    }
return $this->data;
}//fin de get_vendedores

function get_archivos_generados(){
$sql="SELECT * FROM  `registro_impresion` ORDER BY  `registro_impresion`.`fecha` DESC"; 
$query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $usuario=$this->get_nombreCompletoUsuario($row->usuario);
                    $n=$usuario['nombre'];
                    $a=$usuario['apellido'];
                    $date=date_create($row->fecha);
                    $data[]=array(
                                            "id"=>$row->id,
                                            "secuencia"=>$row->secuencia,
                                            "usuario"=>"$n $a",
                                            "cantidad_pedidos"=>$row->cantidad_pedidos,
                                            "paginas"=>$row->pag_impresas,
                                            "desde"=>$row->desde,
                                            "hasta"=>$row->hasta,
                                            "fecha"=>date_format($date,"d-m-Y H:i:s a") 
                                            );
                }
return $data;
}

function get_ultimo_pedido(){
            $this->load->database('default',TRUE);
        $sql="  SELECT `id`
                FROM `pedidos`
                ORDER BY `pedidos`.`id` DESC
                LIMIT 1 ";
            $query=$this->db->query($sql);  
                foreach ($query->result() as $row){
                                $this->temporal=$row->id;
                            }
    return $this->temporal;
}

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

function get_email_vendedor($idVendedor){
	$sql="SELECT  `email` FROM  `usuariosventas` WHERE  `idU` LIKE  '$idVendedor' LIMIT 1";
	$this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal=$row->email;
                }
	
	return $this->temporal;
}//fin de la funcion get_email_vendedor()

function get_ciudad($id_vendedor){
    $sql="SELECT  `ciudad` FROM  `usuariosventas` WHERE  `idU` =$id_vendedor";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);
        foreach ($query->result() as $row) {
            $this->temporal=$row->ciudad;
        }
    return $this->temporal;
}

function enviar_email_vendedor($id_vendedor,$data){
	$this->load->library('email');
	$email_setting  = array('mailtype'=>'html');
	$this->email->initialize($email_setting);
	$this->email->from('ventas@didecoca.com', 'Aplicacion VENTAS');
	$this->email->to('grupodideco.valencia@gmail.com');
    //$this->email->to($this->get_email_vendedor($id_vendedor));
    //si es de VALENCIA el vendedor envio a Josemanuel una copia
    //if($this->get_ciudad($id_vendedor)=='VALENCIA'){  $this->email->cc("jomaor671967@hotmail.com");  }
    //if($this->get_ciudad($id_vendedor)=='VALENCIA'){  $this->email->cc("grupodideco.valencia@gmail.com");  }
    $compa=strtoupper($data['compa']);
	$this->email->subject('Hola '.strtoupper($data['usuario']).', Un Nuevo Pedido Ha sido Cargado./ '.$compa.' Nro['.$data['nroP'].']');
    $msj='<h1>Ha sido cargado en '.$compa.' un pedido bajo el Nro['.$data['nroP'].']</h1><pre>COMPAÑIA:'.$compa.'<br>zona: '.$data['zona'].'<br>CODIGO DEL CLIENTE: '.$data['codigoCliente'].'</pre>';
    $productos=$data['productos'];
//var_dump($productos);
    for ($i=0; $i < count($productos); $i++) { 
        $msj.="<br>CODIGO: ".$productos[$i][0]."  Cantidad:[".$productos[$i][1]."]";
    }
    if($data['nota']!=""){
        $msj.="<br><hr><p><strong>Nota:</strong>".$data['nota']."</p>";
    }
    $this->email->message($msj);
    $this->email->send();
	
}//rutina par el envio de emails

function pedido_especifico($idp){
    $ult=$this->get_ultimo_pedido();
    $sql="SELECT  * FROM  `pedidos` WHERE  `id` LIKE  '".$idp."' ORDER BY  `pedidos`.`fecha` DESC LIMIT 1";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal=$row;
                }

return  array('cabecera' => $this->temporal,'productos'=> $this->productos_del_pedido($idp),'ultimo'=>$ult );
}//fin de la funcion pedido especifico

function productos_del_pedido($idp){
    $sql="SELECT * 
FROM  `productos_pedidos` 
WHERE  `idped` =$idp";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->data[]=$row;
                }
return $this->data;
}//fin de la funcion productos_del_pedido()

function todos_pedidos_usuario($idu){
    $sql="SELECT  * FROM  `pedidos` WHERE  `idu` LIKE  '".$idu."' ORDER BY  `pedidos`.`fecha` DESC LIMIT 30";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal[]=array('id'=>$row->id,'compa'=>$row->compa,'zona'=>$row->zona,'codcte'=>$row->codcte,'fecha'=>$row->fecha,'nota'=>$row->nota,'status'=>$row->status,'tipo'=>$row->tipo, 'razsoc'=>$this->get_cliente($row->codcte,$row->compa));
                }
return $this->temporal;
}//ultimo pedido  del usuario


function todos_pedidos_A(){
    $sql="SELECT  * FROM  `pedidos` WHERE `pedidos`.`status` LIKE 'A' ORDER BY  `pedidos`.`fecha` DESC";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal[]=array('id'=>$row->id,'compa'=>$row->compa,'nombre_completo'=>$row->nombre_completo,'zona'=>$row->zona,'codcte'=>$row->codcte,'fecha'=>$row->fecha,'nota'=>$row->nota,'status'=>$row->status,'tipo'=>$row->tipo);
                }
    //Actualizo el Status
    $sql="UPDATE `pedidos` SET `pedidos`.`status`='I' WHERE `pedidos`.`status` LIKE 'A'"; 
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
          
return $this->temporal;
}//ultimo pedido  del usuario


function todos_pedidos(){
    $sql="SELECT  * FROM  `pedidos` ORDER BY  `pedidos`.`fecha` DESC LIMIT 200";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal[]=array('id'=>$row->id,'compa'=>$row->compa,'nombre_completo'=>$row->nombre_completo,'zona'=>$row->zona,'codcte'=>$row->codcte,'fecha'=>$row->fecha,'nota'=>$row->nota,'status'=>$row->status,'tipo'=>$row->tipo);
                }         
return $this->temporal;
}//todos_pedidos

function pedidos_desde_hasta($desde,$hasta){
    $sql="SELECT  * FROM  `pedidos` WHERE `pedidos`.`id`>='$desde' AND `pedidos`.`id`<='$hasta' ORDER BY  `pedidos`.`fecha` DESC";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal[]=array('id'=>$row->id,'compa'=>$row->compa,'nombre_completo'=>$row->nombre_completo,'zona'=>$row->zona,'codcte'=>$row->codcte,'fecha'=>$row->fecha,'nota'=>$row->nota,'status'=>$row->status,'tipo'=>$row->tipo);
                }         
return $this->temporal;
}//todos_pedidos

function cantidad_pedidos_nuevos(){
$sql="SELECT `id` FROM `grupoemp_ventas`.`pedidos` WHERE `status` LIKE 'A'";
    $query=$this->db->query($sql); 
    
    return $query->num_rows();
}

function get_enlace($codcte,$codcia){
    $sql="SELECT `enlace` FROM `01_cpc` WHERE `codcte` LIKE '$codcte' LIMIT 1";
    $this->load->database($this->get_compaTXT(strtolower($codcia)),TRUE);
    $query=$this->db->query($sql);
    $respuesta=FALSE; 
            if($query->num_rows()>0){
                foreach ($query->result() as $row)
                {
                    $respuesta=$row->enlace;
                }
            }

    return $respuesta;
}

function tieneDocPendiente($codcteCompleto){
$respuesta=array();
$sql="SELECT * FROM  `02_cpc` WHERE  `enlace` LIKE  '".$codcteCompleto."'";
$empresa = array('dideco','compacto','deimport');
    for($z=0;$z<count($empresa);$z++){
            $this->load->database($empresa[$z],TRUE);
            $query=$this->db->query($sql); 
            if($query->num_rows()>0){
                foreach ($query->result() as $row)
                {
                    $respuesta[]=array('codcia'=>$row->codcia,'numdoc'=>$row->numdoc,'fecemi'=>$row->fecemi,'monto'=>$row->monto,'saldo'=>$row->saldo);
                }
            }
    }
    if(count($respuesta)<1){$respuesta=FALSE;}
return $respuesta;
}//fin de funcion tieneDocPendiente



function tieneChequesDevueltos($codcteCompleto){
$respuesta=FALSE;
$sql="SELECT * FROM  `02_che` WHERE  `codcte` LIKE  '".$codcteCompleto."'";
$empresa = array('dideco','compacto','deimport');
    for($z=0;$z<count($empresa);$z++){
            $this->load->database($empresa[$z],TRUE);
            $query=$this->db->query($sql); 
            if($query->num_rows()>0){
                $respuesta=array();
                foreach ($query->result() as $row)
                {
                    $respuesta[]=array('codcia'=>$row->codcia,'numdoc'=>$row->numdoc,'fecemi'=>$row->fecemi,'monto'=>$row->monto,'saldo'=>$row->saldo);
                }
            }
    }
return $respuesta;
}//fin de funcion tieneChequesDevueltos


function get_descripcion_producto($codigo,$compaTXT){
    $sql="SELECT  `descr` FROM  `01_inv` WHERE  `clave` LIKE  '$codigo' LIMIT 1";
    $this->load->database($compaTXT,TRUE);
        $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal=$row->descr;
                }
return $this->temporal;

}//fin de la funcion del producto

function get_cliente($codCte='',$codCompa='')
{
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
			}
	
	$this->load->database($compaTXT,TRUE);

	$this->query = $this->db->query("SELECT * FROM  `01_cpc` WHERE  `codcte` LIKE '$codCte' LIMIT 1");


				foreach ($this->query->result() as $row)
						{
						   	$datos=array('codcte'=>$row->codcte,'zona'=>$row->zona,'ruta'=>$row->ruta,'razsoc'=>$row->razsoc,'rif'=>$row->rif);
						}

			if (count($datos)>1) {
					return $datos;
			}else{
					return -1;
			}

}//fin de la funcion get_cliente


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
                    
            }
    return $compaTXT;
}/*fin de funcion get_compaTXT*/

public function registrar_impresion($data){
    $this->load->database('default',TRUE);
    $sql="INSERT INTO `grupoemp_ventas`.`registro_impresion` (`id`, `secuencia`, `usuario`, `desde`, `hasta`, `cantidad_pedidos`, `pag_impresas`, `fecha`) VALUES (NULL, '".$data['secuencia']."', '".$data['idU']."', '".$data['desde']."', '".$data['hasta']."', '".$data['cantidad_pedidos']."', '".$data['pag_impresas']."', NOW());";

    $query=$this->db->query($sql); 
    //return $query->num_rows();
}//fin de registrar_impresion
}