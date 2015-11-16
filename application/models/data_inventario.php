<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_inventario extends CI_Model {
public function get_compaTXT($codCompa=''){
	$compaTXT='default';
	switch ($codCompa) {
		case '001':
			$compaTXT=strtolower('dideco');
			break;
		case '002':
			$compaTXT=strtolower('deimport');
			break;
		case '005':
			$compaTXT=strtolower('compacto');
			break;
		
		default:
			$compaTXT="default";
			break;
	}
return $compaTXT;
}

function get_proveedores($CodCompa=''){
$data=NULL;
 $this->load->database($this->get_compaTXT($CodCompa),TRUE);
    $query=$this->db->query("SELECT * FROM  `01_cpp` WHERE `ina` LIKE 'A'");
    //$query=$this->db->query("SELECT * FROM  `01_cpp`");
            foreach ($query->result() as $row)
                {
                	/*EXCLUIR PROVEEDORES AQUI*/
               if($CodCompa!='001'){
                    //ANTES if($row->codigo!='007'&&$row->codigo!='555'&&$row->codigo!='551'&&$row->codigo!='507'&&$row->codigo!='405'&&$row->codigo!='005'&&$row->codigo!='035'){
                    if($row->codigo!='007'&&$row->codigo!='555'&&$row->codigo!='507'&&$row->codigo!='551'){
                            $data[]=array('codcia'=>$row->codcia,'codigo'=>$row->codigo,'razsoc'=>$row->razsoc);
                        }
                 //FIN DE SI NO ES DIDECO       
                }else{
                        if($row->codigo=='027'||$row->codigo=='013'||$row->codigo=='040'||$row->codigo=='002'){

                            $data[]=array('codcia'=>$row->codcia,'codigo'=>$row->codigo,'razsoc'=>$row->razsoc);
                 
                        }
                    } 

         
                
/*
            if(isset($row->codigo)){
                    if($row->codigo!='007'&&$row->codigo!='555'&&$row->codigo!='551'&&$row->codigo!='507'&&$row->codigo!='405'&&$row->codigo!='005'&&$row->codigo!='035'){
                        $data[]=array('codcia'=>$row->codcia,'codigo'=>$row->codigo,'razsoc'=>$row->razsoc);                     
                    }
            }*/

            }//fin del for
                
                
    return $data;

}

public function get_20productos_compa($codCompa='',$aBuscar='',$data=''){
    $sql="SELECT * FROM  `01_inv` WHERE `descr` LIKE '%".$aBuscar."%' LIMIT 20";

    $this->load->database($this->get_compaTXT($codCompa),TRUE);
    $query=$this->db->query($sql);
    foreach ($query->result() as $row) {
        $data[]=array('clave'=>$row->clave,'descr'=>$row->descr);    
    }
    return $data;
}/*Fin de la funcon get_productos_compa devuelve max 15 productos
 para esa compa que contengan esa descripcion*/


//obtener los productos activos de una compañia ordenados por existencia
public function get_productos_act_existencia($CodCompa=""){
    $sql="SELECT 01_inv.codcia, 01_inv.clave,01_inv.clavprov, 01_inv.descr, 01inv.costo, 01inv.ventas, 01inv.ventaz, 01inv.ventam, 01inv.ventad, 01inv.ventae, 01_inv.ofers, 01_inv.ofere, 01_inv.oferd, 01_inv.oferm, 01_inv.oferz, 01inv.existen
FROM `01_inv` , `01inv`
WHERE 01_inv.st LIKE 'A'
AND 01_inv.clave LIKE 01inv.clave
ORDER BY 01inv.existen DESC";
    $this->load->database($this->get_compaTXT($CodCompa),TRUE);
    $query=$this->db->query($sql);
    $data=array();
            foreach ($query->result() as $row)
                {
                        $data[]=array(
                            "clave"=>$row->clave,
                            "descr"=>$row->descr,
                            "clavprov"=>$row->clavprov,
                            "ventam"=>$row->ventam,
                            "ventad"=>$row->ventad,
                            "ventas"=>$row->ventas,
                            "ventaz"=>$row->ventaz,
                            "ventae"=>$row->ventae,
                            "costo"=>$row->costo,
                            "oferd"=>$row->oferd,
                            "ofere"=>$row->ofere,
                            "ofers"=>$row->ofers,
                            "oferm"=>$row->oferm,
                            "existen"=>$row->existen
                            );
                }/*fin de foreach*/
return $data;

}//fin de la funcion get_productos_act_existencia


//obtener los productos activos de una compañia ordenados por NOMBRE
public function get_productos_act_nombre($CodCompa=""){
    $sql="SELECT 01_inv.codcia, 01_inv.clave,01_inv.clavprov, 01_inv.descr, 01inv.costo, 01inv.ventas, 01inv.ventaz, 01inv.ventam, 01inv.ventad, 01inv.ventae, 01_inv.ofers, 01_inv.ofere, 01_inv.oferd, 01_inv.oferm, 01_inv.oferz, 01inv.existen
FROM `01_inv` , `01inv`
WHERE 01_inv.st LIKE 'A'
AND 01_inv.clave LIKE 01inv.clave
ORDER BY 01_inv.descr ASC";
    $this->load->database($this->get_compaTXT($CodCompa),TRUE);
    $query=$this->db->query($sql);
    $data=array();
            foreach ($query->result() as $row)
                {
                        $data[]=array(
                            "clave"=>$row->clave,
                            "descr"=>$row->descr,
                            "clavprov"=>$row->clavprov,
                            "ventam"=>$row->ventam,
                            "ventad"=>$row->ventad,
                            "ventas"=>$row->ventas,
                            "ventaz"=>$row->ventaz,
                            "ventae"=>$row->ventae,
                            "costo"=>$row->costo,
                            "oferd"=>$row->oferd,
                            "ofere"=>$row->ofere,
                            "ofers"=>$row->ofers,
                            "oferm"=>$row->oferm,
                            "existen"=>$row->existen
                            );
                }/*fin de foreach*/
return $data;

}//fin de la funcion get_productos_act_nombre

function get_productos_proveedor($CodCompa='',$codpro=''){

    $sql="SELECT  `01_inv`.`clave`, `01_inv`.`descr`, `01_inv`.`oferm`, `01_inv`.`oferd`, `01_inv`.`ofere`, `01_inv`.`ofers`, `01_inv`.`oferz`,`01inv`.`ventam`,`01inv`.`ventad`,`01inv`.`ventas`,`01inv`.`ventak`,`01inv`.`ventac`,`01inv`.`ventaz`,`01inv`.`existen`, `01_inv`.`st` FROM  `01_inv` ,  `01inv` WHERE  `01_inv`.`clave` LIKE  '$codpro%' AND  `01inv`.`clave` LIKE  `01_inv`.`clave` AND  `01_inv`.`st` LIKE  'A' ORDER BY  `01_inv`.`descr` ASC";
 $this->load->database($this->get_compaTXT($CodCompa),TRUE);
    $query=$this->db->query($sql);
            $data=array();
            foreach ($query->result() as $row)
                {
                	/*excluir productos aqui*/
                	/*
                	$codProductosExcluidos=array('035006','035007','035008','035009','035010','03511','03512','03513','160023','160022','160013','160016','160009');
                	for($l=0;$l<count($codProductosExcluidos);$l++){
                			if($row->clave!=$codProductosExcluidos[$l]){

                			}
                	}*/


                    /*CONDICIONO Y SACO  A LOS PRODUCTOS QUE NO SALDRAN EN LA LISTA*/
                    $CODIGO_PRODUCTO=trim($row->clave);
                    $PRODUCTOS_EXCLUIDOS=array('035006','035007',   '035008','035009','035010','035011','035012','035013');
                   /* for ($j=0; $j < count($PRODUCTOS_EXCLUIDOS) ; $j++) { 
                        if($PRODUCTOS_EXCLUIDOS[$j]!=$CODIGO_PRODUCTO){
                                $data[]=array('clave'=>$row->clave,'descr'=>$row->descr,'oferm'=>$row->oferm,'oferd'=>$row->oferd,'ofere'=>$row->ofere,'ofers'=>$row->ofers,'oferz'=>$row->oferz,'ventam'=>$row->ventam,'ventad'=>$row->ventad,'ventas'=>$row->ventas,'ventak'=>$row->ventak,'ventac'=>$row->ventac,'ventaz'=>$row->ventaz,'st'=>$row->st,'existen'=>$row->existen);
                        }
                    }   */
                    //si la compañia es dideco
                    if($CodCompa=='001'){

                    if($CODIGO_PRODUCTO!='035006'&&$CODIGO_PRODUCTO!='035007'&&$CODIGO_PRODUCTO!='035008'&&$CODIGO_PRODUCTO!='035009'&&$CODIGO_PRODUCTO!='035010'&&$CODIGO_PRODUCTO!='035011'&&$CODIGO_PRODUCTO!='035012'&&$CODIGO_PRODUCTO!='035013'&&$CODIGO_PRODUCTO!='160023'&&$CODIGO_PRODUCTO!='160022'&&$CODIGO_PRODUCTO!='160013'&&$CODIGO_PRODUCTO!='160016'&&$CODIGO_PRODUCTO!='160309'&&$CODIGO_PRODUCTO!='160309'&&$CODIGO_PRODUCTO!='027201'&&$CODIGO_PRODUCTO!='027503'&&$CODIGO_PRODUCTO!='027502'&&$CODIGO_PRODUCTO!='014010'){
                        $cod3Dig=substr($row->clave, 3,3);
                        $data[]=array('clave'=>$cod3Dig,'descr'=>$row->descr,'oferm'=>$row->oferm,'oferd'=>$row->oferd,'ofere'=>$row->ofere,'ofers'=>$row->ofers,'oferz'=>$row->oferz,'ventam'=>$row->ventam,'ventad'=>$row->ventad,'ventas'=>$row->ventas,'ventak'=>$row->ventak,'ventac'=>$row->ventac,'ventaz'=>$row->ventaz,'st'=>$row->st,'existen'=>$row->existen);
             

                    }//fin 001
                    

                    }
                    //si la compañia es deimport
                    if($CodCompa=='002'){

                    if($CODIGO_PRODUCTO!='007635'&&$CODIGO_PRODUCTO!='007716'&&$CODIGO_PRODUCTO!='007160'&&$CODIGO_PRODUCTO!='007056'&&$CODIGO_PRODUCTO!='007500'&&$CODIGO_PRODUCTO!='007150'&&$CODIGO_PRODUCTO!='007722'&&$CODIGO_PRODUCTO!='007416'&&$CODIGO_PRODUCTO!='007517'&&$CODIGO_PRODUCTO!='007052'&&$CODIGO_PRODUCTO!='007208'&&$CODIGO_PRODUCTO!='007400'&&$CODIGO_PRODUCTO!='007172'&&$CODIGO_PRODUCTO!='007719'&&$CODIGO_PRODUCTO!='007070'&&$CODIGO_PRODUCTO!='007522'&&$CODIGO_PRODUCTO!='007049'&&$CODIGO_PRODUCTO!='007108'&&$CODIGO_PRODUCTO!='007515'){
                        $cod3Dig=substr($row->clave, 3,3);
                        $codProv=substr($row->clave, 0,3);
                        $data[]=array('clave'=>$cod3Dig,'descr'=>$row->descr,'oferm'=>$row->oferm,'oferd'=>$row->oferd,'ofere'=>$row->ofere,'ofers'=>$row->ofers,'oferz'=>$row->oferz,'ventam'=>$row->ventam,'ventad'=>$row->ventad,'ventas'=>$row->ventas,'ventak'=>$row->ventak,'ventac'=>$row->ventac,'ventaz'=>$row->ventaz,'st'=>$row->st,'existen'=>$row->existen);
             

                    }

                    }//fin 002

                    //si la compañia es compacto
                    if($CodCompa=='005'){

                    if($CODIGO_PRODUCTO!='552709'&&$CODIGO_PRODUCTO!='552730'&&$CODIGO_PRODUCTO!='552712'&&$CODIGO_PRODUCTO!='552705'&&$CODIGO_PRODUCTO!='552711'&&$CODIGO_PRODUCTO!='552713'&&$CODIGO_PRODUCTO!='552351'&&$CODIGO_PRODUCTO!='552145'&&$CODIGO_PRODUCTO!='552404'&&$CODIGO_PRODUCTO!='552310'&&$CODIGO_PRODUCTO!='552200'&&$CODIGO_PRODUCTO!='552310'&&$CODIGO_PRODUCTO!='552158'&&$CODIGO_PRODUCTO!='552097'&&$CODIGO_PRODUCTO!='552302'&&$CODIGO_PRODUCTO!='552155'&&$CODIGO_PRODUCTO!='552020'&&$CODIGO_PRODUCTO!='552451'&&$CODIGO_PRODUCTO!='552099'&&$CODIGO_PRODUCTO!='552350'&&$CODIGO_PRODUCTO!='552101'&&$CODIGO_PRODUCTO!='552305'&&$CODIGO_PRODUCTO!='552156'&&$CODIGO_PRODUCTO!='552303'&&$CODIGO_PRODUCTO!='552300'&&$CODIGO_PRODUCTO!='552219'&&$CODIGO_PRODUCTO!='552150'&&$CODIGO_PRODUCTO!='552146'&&$CODIGO_PRODUCTO!='552180'){
                        $cod3Dig=substr($row->clave, 3,3);
                        $data[]=array('clave'=>$cod3Dig,'descr'=>$row->descr,'oferm'=>$row->oferm,'oferd'=>$row->oferd,'ofere'=>$row->ofere,'ofers'=>$row->ofers,'oferz'=>$row->oferz,'ventam'=>$row->ventam,'ventad'=>$row->ventad,'ventas'=>$row->ventas,'ventak'=>$row->ventak,'ventac'=>$row->ventac,'ventaz'=>$row->ventaz,'st'=>$row->st,'existen'=>$row->existen);
             

                    }

                    }//fin 005
                    
                      	
                }
    return $data;
}



public function get_nombre_producto($CodCompa,$codCompleto){
    $this->load->database($this->get_compaTXT($CodCompa),TRUE);
    $sql="SELECT  `descr` FROM  `01_inv` WHERE  `clave` LIKE  '$codCompleto'";
    $query=$this->db->query($sql);
    $respuesta=NULL;
    foreach ($query->result() as $row)
                {
                    $respuesta=$row->descr;
                }
    return $respuesta;
}//fin de get_nombre_producto




}//fin de la clase