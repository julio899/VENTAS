<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_complemento extends CI_Model {
public $temporal;
public $query;
public $data;

function get_fac_ventas_dideco($mes,$year){
    $this->load->database('dideco',TRUE);
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '1' AND `fecemi` LIKE '%/$mes/$year' ORDER BY `numdoc` ASC";
    //var_dump($sql); exit();
    $query=$this->db->query($sql);
    $data=$query->result_array();
    $datos=null;
        foreach ($data as $key => $value) {
                $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
                $razon=$cliente['razsoc'];
                $rif=$cliente['rif'];
                $arreglo_fecha=explode('/',$value['fecemi']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];

                    $exento=0;
                    $monto_iva=trim($value['moniva']);
                    $monto_base=trim($value['monto']);
                    $rsult_o1=str_replace('-', '', ($monto_iva)/floatval('0.'.$value['iva']) );
                    $rsult_o1=explode('.', $rsult_o1);
                    $rsult_o2=str_replace('-', '', $monto_base );
                    $rsult_o2=explode('.', $rsult_o2);
                    if($rsult_o2[0]==$rsult_o1[0]||$rsult_o2[0]<($rsult_o1[0]+1) ){
                        $exento=0;
                    }else{
                        $exento=$monto_base-($monto_iva/ floatval('0.'.$value['iva']) );
                        
                        $exento=number_format($exento,2,',','.');

                        //$exento=$rsult_o2[0];
                    }

                
                if($key<10){$orden_fecha.=".0".$key;}else{$orden_fecha.=".".$key;}
                if(substr($orden_fecha, -1,1)=='0'){$orden_fecha.='1';}
             $datos[]=array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>$value['docref'],
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fecemi'],
                        'base'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$value['moniva'],
                        'retencion' =>$this->tiene_retencion_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'fecanul'      =>$value['fecanul'],
                        'tipo'=>'FAC',
                        'orden_fecha'=>$orden_fecha,
                        'exento'=>$exento

                        );
             //exit();
        }
    return $datos;
}//fin de get_fac_ventas

function get_ret_imp_slr($mes,$year){
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '.' AND `fecemi` LIKE '%/$mes/$year' ORDER BY `hiscpc`.`numdoc` ASC";
    $query=$this->db->query($sql);
    $data=$query->result_array();
    $datos=null;
        foreach ($data as $key => $value) {
                $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
                $razon=$cliente['razsoc'];
                $rif=$cliente['rif'];
                $arreglo_fecha=explode('/',$value['fecemi']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];
                
                    $exento=0;//esto es retencion de un impuesto no lleva retencion

                if($key<10){$orden_fecha.=".0".$key;}else{$orden_fecha.=".".$key;}
                if(substr($orden_fecha, -1,1)=='0'){$orden_fecha.='1';}
             $datos[]=array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>$value['docref'],
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fecemi'],
                        'base'      =>$value['monto'],
                        'monto'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$value['moniva'],
                        'retencion' =>$this->tiene_retencion_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'fecanul'      =>$value['fecanul'],
                        'tipo'=>'RISL',
                        'orden_fecha'=>$orden_fecha,
                        'exento'=>$exento

                        );
        }
    return $datos;

}//fin de get_ret_imp_slr


function get_ret_imp_muni($mes,$year){
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE ',' AND `fecemi` LIKE '%/$mes/$year' ORDER BY `hiscpc`.`numdoc` ASC";
    $query=$this->db->query($sql);
    $data=$query->result_array();
    $datos=null;
        foreach ($data as $key => $value) {
                $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
                $razon=$cliente['razsoc'];
                $rif=$cliente['rif'];
                $arreglo_fecha=explode('/',$value['fecemi']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];
                
                    $exento=0;//esto es retencion de un impuesto no lleva retencion

                if($key<10){$orden_fecha.=".0".$key;}else{$orden_fecha.=".".$key;}
                if(substr($orden_fecha, -1,1)=='0'){$orden_fecha.='1';}
             $datos[]=array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>$value['docref'],
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fecemi'],
                        'base'      =>$value['monto'],
                        'monto'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$value['moniva'],
                        'retencion' =>$this->tiene_retencion_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'fecanul'      =>$value['fecanul'],
                        'tipo'=>'IMNPL',
                        'orden_fecha'=>$orden_fecha,
                        'exento'=>$exento

                        );
        }
    return $datos;

}//fin de get_ret_imp_muni

function get_ret_fuera_mes_dideco($mes,$year){
    $this->load->database('dideco',TRUE);
    
    //$sql="SELECT `codcte`,`numdoc`,`fecemi`,`fechsit`,`monto` ,`tipref`,`docref` FROM `hiscpc` WHERE `tipdoc` LIKE '*' AND `fecemi` LIKE '%%/10/15' ORDER BY `hiscpc`.`fechsit` DESC";
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '*' AND `fecemi` LIKE '%/$mes/$year' ORDER BY `hiscpc`.`fechsit` ASC";
    $query=$this->db->query($sql);
    $data=$query->result_array();
    $datos=null;

        foreach ($data as $key => $value) {
            if("$mes/$year"!=substr(trim($this->get_doc_hiscpc_dideco($value['docref'],$value['tipref'])[0]['fecemi']),-5,5)){
                //echo "*)".$value['numdoc']." docR: ".$value['docref']." (fecemi: ".$value['fecemi']." ) / fechsit ".$value['fechsit']." - ".substr(trim($value['fechsit']),-5,5)." * tipref:".$value['tipref']." #[".$value['docref']."]FAC fc".$this->get_doc_hiscpc_dideco($value['docref'],$value['tipref'])[0]['fecemi']." - FAC fsit ".$this->get_doc_hiscpc_dideco($value['docref'],$value['tipref'])[0]['fechsit']."<br>";
                
                $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
                $razon=$cliente['razsoc'];
                $rif=$cliente['rif'];
                $arreglo_fecha=explode('/',$value['fechsit']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];

                    $exento=0;//es un impuesto no lleva exento
                
                $datos[]=
                array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>$value['docref'],
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fechsit'],
                        'base'      =>$value['monto'],
                        'monto'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$value['moniva'],
                        'retencion' =>$this->tiene_retencion_hische_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'fecanul'      =>$value['fecanul'],
                        'tipo'=>'RET',
                        'orden_fecha'=>$orden_fecha,
                        'exento'=>$exento

                        );
            }
        }
    return $datos;
}
function get_doc_hiscpc_dideco($numdoc,$tipdoc){
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '$tipdoc' AND `numdoc` LIKE '$numdoc' ORDER BY `hiscpc`.`numdoc`  ASC";
    $query=$this->db->query($sql);
    $data=$query->result_array();
        if(count($data)>0){
            return $data;
        }else{
            return FALSE;
        }
}

function get_nota_credito_dideco($mes,$year){
    $this->load->database('dideco',TRUE);
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '7' AND `fecemi` LIKE '%/$mes/$year' ORDER BY `hiscpc`.`numdoc`  ASC";
    $query=$this->db->query($sql);
    $this->data=$query->result_array();
    $datos=null;
    foreach ($this->data as $key => $value) {
        $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
        $razon=$cliente['razsoc'];
        $rif=$cliente['rif'];
        $sql2="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '8' AND `fecemi` LIKE '%/$mes/$year' AND `numdoc` LIKE '".$value['numdoc']."' ORDER BY `hiscpc`.`fecemi`  ASC LIMIT 1";
        $query2=$this->db->query($sql2);
        $sql_temp_iva=$query2->result_array();
                $arreglo_fecha=explode('/',$value['fecemi']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];
            $exento=0;
            $monto_iva=trim($sql_temp_iva[0]['monto']);
            $monto_base=trim($value['monto']);
            $rsult_o1=str_replace('-', '', ($monto_iva)/0.12 );
            $rsult_o1=explode('.', $rsult_o1);
            $rsult_o2=str_replace('-', '', $monto_base );
            $rsult_o2=explode('.', $rsult_o2);
            if($rsult_o2[0]==$rsult_o1[0]){
                $exento=0;
            }else{
                //$exento=$monto_iva-($monto_base/'0.'.$value['iva']);

                        $exento=$monto_base-($monto_iva/ floatval('0.'.$value['iva']) );
                        
                        $exento=number_format($exento,2,',','.');
            }

            //echo $rsult_o1[0]." / ".$rsult_o2[0] ." * ";
            //var_dump( $rsult_o2[0]==$rsult_o1[0] );

            //echo "<br>exento: $exento<br>";
            //echo $sql_temp_iva[0]['monto']."<-monto del iva =(".($sql_temp_iva[0]['monto']/0.12).")<br><br>";
            //echo "tipdoc[8]monto base "; var_dump($value['monto']); echo "<br><hr> = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = <br>";
           
                if($key<10){$orden_fecha.=".0".$key;}else{$orden_fecha.=".".$key;}
                if(substr($orden_fecha, -1,1)=='0'){$orden_fecha.='1';}
        $datos[]=array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>$value['docref'],
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fecemi'],
                        'base'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$sql_temp_iva[0]['monto'],
                        'retencion' =>$this->tiene_retencion_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'fecanul'      =>$value['fecanul'],
                        'tipo'=>'NC',
                        'orden_fecha'=>$orden_fecha,
                        'exento'=>$exento

                        );
    }
    //exit();
    return $datos;
}// FIN de  get_nota_credito_dideco


function get_nota_debito_dideco($mes,$year){
    $this->load->database('dideco',TRUE);
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '4' AND `fecanc` LIKE '%/$mes/$year' ORDER BY `hiscpc`.`numdoc`  ASC";
    $query=$this->db->query($sql);
    $this->data=$query->result_array();
    $datos=null;
    foreach ($this->data as $key => $value) {
        $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
        $razon=$cliente['razsoc'];
        $rif=$cliente['rif'];
        $sql2="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '3' AND `fecanc` LIKE '%/$mes/$year' AND `numdoc` LIKE '".$value['numdoc']."' ORDER BY `hiscpc`.`fecemi`  ASC LIMIT 1";
        $query2=$this->db->query($sql2);
        $sql_temp_iva=$query2->result_array();
                $arreglo_fecha=explode('/',$value['fecemi']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];
        $datos[]=array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>$value['docref'],
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fecemi'],
                        'base'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$sql_temp_iva[0]['monto'],
                        'retencion' =>$this->tiene_retencion_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'fecanul'      =>$value['fecanul'],
                        'tipo'=>'ND',
                        'orden_fecha'=>$orden_fecha

                        );
    }
    return $datos;
}// FIN de  get_nota_debito_dideco


function get_nota_debito_hische_dideco($mes,$year){
    $this->load->database('dideco',TRUE);
    $sql="SELECT * FROM `hische` WHERE `tipdoc` LIKE '3' AND `fecanc` LIKE '%/$mes/$year' ORDER BY `hische`.`numdoc` ASC";
    $query=$this->db->query($sql);
    $this->data=$query->result_array();
    $datos=null;
    foreach ($this->data as $key => $value) {
        $cliente=$this->get_cliente( substr($value['codcte'], -4,4) ,'001' );
        $razon=$cliente['razsoc'];
        $rif=$cliente['rif'];
        //var_dump($sql); exit();        
                $arreglo_fecha=explode('/',$value['fecemi']);
                $orden_fecha=$arreglo_fecha[2].$arreglo_fecha[1].$arreglo_fecha[0];
        $datos[]=array(
                        'razsoc'    =>$razon,
                        'rif'       =>$rif,
                        'numdoc'    =>$value['numdoc'],
                        'docref'    =>'',
                        'control'    =>$value['control'],
                        'fecemi'    =>$value['fecemi'],
                        'base'      =>$value['monto'],
                        '%'      =>$value['iva'],
                        'iva'       =>$value['moniva'],
                        'retencion' =>$this->tiene_retencion_hische_dideco($value['numdoc'],$mes,$year),
                        'st'      =>$value['st'],
                        'tipo'=>'ND',
                        'fecanul'      =>$value['fecanul'],
                        'orden_fecha'=>$orden_fecha

                        );
    }
    return $datos;
}// FIN de  get_nota_debito_hische_dideco


function tiene_retencion_dideco($numdoc,$mes,$year){
    $this->load->database('dideco',TRUE);
    $sql="SELECT *  FROM `hiscpc` WHERE `tipdoc` LIKE '*' AND `fecemi` LIKE '%/$mes/$year' AND `docref` LIKE '$numdoc' LIMIT 1";
    $query=$this->db->query($sql);
    $respuesta=FALSE;
    $datos=$query->result_array();
        if(count($datos)>0){ $respuesta=$datos; }
    return $respuesta;   
}

function tiene_retencion_hische_dideco($numdoc,$mes,$year){
    $this->load->database('dideco',TRUE);
    $sql="SELECT *  FROM `hische` WHERE `tipdoc` LIKE '*' AND `fecanc` LIKE '%/$mes/$year' AND `docref` LIKE '$numdoc' LIMIT 1";
    $query=$this->db->query($sql);
    $respuesta=FALSE;
    $datos=$query->result_array();
        if(count($datos)>0){ $respuesta=$datos; }
    return $respuesta;   
}

/*function retencion_notas_de_credito_dideco($mes,$year){

    $this->load->database('dideco',TRUE);
     $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '*' AND `fecemi` LIKE '%$mes/$year' AND `tipref` LIKE '8' ORDER BY `docref` ASC";
    $query=$this->db->query($sql);
    $respuesta=FALSE;
    $datos=$query->result_array();
        if(count($datos)>0){ $respuesta=$datos; }

    return $respuesta;
}*/

function tiene_retencion_en_mes_dideco($nro_fac,$mes,$year){
    /*
    SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '*' AND `fecemi` LIKE '%$mes/$year' AND `docref` LIKE '$nro_fac' LIMIT 1 
    */
    $this->load->database('dideco',TRUE);
    $sql="SELECT * FROM `hiscpc` WHERE `tipdoc` LIKE '*' AND `fecemi` LIKE '%$mes/$year' AND `docref` LIKE '$nro_fac' LIMIT 1";
    $query=$this->db->query($sql);
    $respuesta=FALSE;
    $datos=$query->result_array();
        if(count($datos)>0){ $respuesta=$datos; }

    return $respuesta;
}

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
    $this->load->model('data_inventario');
	$email_setting  = array('mailtype'=>'html');
	$this->email->initialize($email_setting);
	$this->email->from('ventas@didecoca.com', 'Aplicacion VENTAS');
	$this->email->to('grupodideco.valencia@gmail.com');
    $this->email->to($this->get_email_vendedor($id_vendedor));
    //si es de VALENCIA el vendedor envio a Josemanuel una copia
    //if($this->get_ciudad($id_vendedor)=='VALENCIA'){  $this->email->cc("jomaor671967@hotmail.com");  }
    if($this->get_ciudad($id_vendedor)=='VALENCIA'){  $this->email->cc("grupodideco.valencia@gmail.com");  }
    $compa=strtoupper($data['compa']);
	$this->email->subject('Hola '.strtoupper($data['usuario']).', Un Nuevo Pedido Ha sido Cargado./ '.$compa.' Nro['.$data['nroP'].']');
    $msj='<h1>Ha sido cargado en '.$compa.' un pedido bajo el Nro['.$data['nroP'].']</h1><pre>COMPAÑIA:'.$compa.'<br>zona: '.$data['zona'].'<br>CODIGO DEL CLIENTE: '.$data['codigoCliente'].'</pre>';
    $productos=$data['productos'];
//var_dump($productos);
    for ($i=0; $i < count($productos); $i++) { 
        $msj.="<br>CODIGO: ".$productos[$i][0]."  (".$this->data_inventario->get_nombre_producto($compa,$productos[$i][0]).") / Cantidad:[".$productos[$i][1]."]";
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


function pedidos_por_procesar(){
    $sql="SELECT  * FROM  `pedidos` WHERE `pedidos`.`status` LIKE 'A' ORDER BY  `pedidos`.`fecha` DESC";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal[]=array('id'=>$row->id,'compa'=>$row->compa,'nombre_completo'=>$row->nombre_completo,'zona'=>$row->zona,'codcte'=>$row->codcte,'fecha'=>$row->fecha,'nota'=>$row->nota,'status'=>$row->status,'tipo'=>$row->tipo);
                }         
return $this->temporal;
}//pedidos_por_procesar

function pedidos_desde_hasta($desde,$hasta){
    $sql="SELECT  * FROM  `pedidos` WHERE `pedidos`.`id`>='$desde' AND `pedidos`.`id`<='$hasta' ORDER BY  `pedidos`.`fecha` DESC";
    $this->load->database('default',TRUE);
    $query=$this->db->query($sql);  
        foreach ($query->result() as $row)
                {
                    $this->temporal[]=array('id'=>$row->id,'compa'=>$row->compa,'nombre_completo'=>$row->nombre_completo,'zona'=>$row->zona,'codcte'=>$row->codcte,'fecha'=>$row->fecha,'nota'=>$row->nota,'status'=>$row->status,'tipo'=>$row->tipo);
                }         
return $this->temporal;
}//pedidos_desde_hasta

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
    $datos=null;
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
