<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Txt extends CI_Controller {

	public function index(){
		$temporal=null;
		$arreglo_unico=null;
		$datos=null;
		$this->load->model('data_clientes');
		header('Content-type: application/json');
		//header("Content-Type: text/plain");
		//`razsoc`,`rif`,`telef`,`direc1`
		$clientes=$this->data_clientes->get_clientes();
		$contador=0;
		foreach ($clientes as $key => $value) {
			$telefono=$value->telef;
				if($telefono==''){$telefono='0';}
				$rif_formateado=str_replace('-', '', $value->rif);
				$rif_formateado=str_replace(' ', '', $rif_formateado);
				$rif_formateado=str_replace('_', '', $rif_formateado);
				$rif_formateado=str_replace('.', '', $rif_formateado);
				$rif_formateado=str_replace(',', '', $rif_formateado);
				$rif_formateado=strtoupper($rif_formateado);
				$rif_formateado=trim($rif_formateado);
						for($i=strlen($rif_formateado);$i<10;$i++){
							//echo "*\n";
							$letra=substr($rif_formateado, 0,1);
							$num=substr($rif_formateado, 1,strlen($rif_formateado) );
							$num="0".$num;
							$rif_formateado=$letra.$num;
						}
						/*for($i=strlen($rif_formateado);$i<11;$i++){
							$letra=substr($rif_formateado, 0,1);
							$num=count($rif_formateado);
							$num="0".$num;
							$rif_formateado=$letra.$num;
						}	*/
			$primera_letra=substr($rif_formateado,0,1);
			if($rif_formateado!='0000000000'&&$primera_letra!='0'&&$primera_letra!='C')
			{

				$cadena1 =$rif_formateado;
				$patron = "/^[[:digit:]]+$/";

				if (preg_match($patron, $cadena1)) {
				    //print "***La cadena $cadena1 son sólo números.\n";
				} else {
				  $contador++;  $temporal[]=$rif_formateado;
					//echo "$contador - $rif_formateado $value->razsoc \t$value->rif \t\t\tActivo $telefono \t00001 N \t\t\tN\n";
					
							$datos[]=array('rif' => $rif_formateado,'razsoc'=>$value->razsoc,'telefono'=>$telefono,'direccion'=>trim($value->direc1." ".$value->direc2),"ciudad"=>$value->nombre,"estado"=>$value->estado,"ruta"=>$value->ruta,"zona"=>$value->zona,"nomfir"=>$value->nomfir,"codcte"=>$value->codcte,"tipneg"=>$value->tipneg,"ciuest"=>$value->ciuest  );
				}

			}//fin de IF !=0000000000 y si la primera letra no comienza con C de CI
		}//fin de foreach
$arreglo_unico=array_unique($temporal);
$unicos=$this->data_clientes->unique_multidim_array($datos,'rif');
//echo "solo elementos validos: ".count($arreglo_unico);
//echo "\nen datos existen elementos validos: ".count($unicos)."\n";
$solo=0;
				foreach ($unicos as $key => $value) {
					// echo $value['rif']."\t".$value['razsoc']." \t".$value['rif']."\t\t\t\tActivo\t".$value['telefono']."\t\t".$value['direccion']."\t".$value['ciudad']."\t\t".$value['estado']."\t"."No Asignado\t00001\tN\t\t\t\tN\t\t\t0\t1\t".date("d/m/Y")."\n";
					

					//if(strtoupper($value['ciudad'])=='MARACAY' && $value['zona']!='11'):
					if($value['zona']!='11'):
					

								/*
								#Ahora en CSV por ;
								echo $value['rif'].";";
								echo $value['razsoc'].";";
								echo $value['rif'].";";
								echo ";";//NIT
								echo ";";//CxC Opcional
								echo ";";//cuenta contable Ingresos Opcional
								echo "Activo;";//status
								echo $value['telefono'].";";
								echo ";";//fax
								echo $value['direccion'].";";
								echo $value['ciudad'].";";
								echo ";";//zona postal
								echo ";";//zona de cobranza
								echo ";";//sector de negocio
								echo "1;";//cod vendedor
								echo "N;";//Extrangero S o N
								echo ";";//email
								echo ";";//persona contacto
								echo ";";//razon inactividad
								echo "N;";// S o N activar aviso al escoger
								echo ";";//texto de aviso
								echo ";";//cuenta contable anticipo
								echo "0;";//Nivel de precio
								echo "1;";//Origen del cliente 0=origen del cliente factura / 1=origen manual
								echo date("d/m/Y")."\n";//fecha de creacion del cliente
								*/
								$zona=''; 
								if($value['zona']=='01'){ 
															$zona='11'; 
														}else{
																$zona=$value['zona'];
														}




								//SOLO if($solo<1000){		
								if($value['zona']=='13'){		
								$di=$this->data_clientes->get_direccion_fiscal_001($value['codcte']);
								 $direccion_fiscal="";
					  			 if(count($di)>0){
						  			 	$direccion_fiscal=$di[0]['dirent1']." ".$di[0]['dirent2']." ".$di[0]['dirent3']." * ".$value['ciuest']." (Ruta:".$value['ruta'].") / Despacho: ".$value['direccion'];
					  			 }else{ 
					  			 		$direccion_fiscal = $value['direccion']." * ".$value['ciuest']." (Ruta:".$value['ruta'].")" ;
					  			 	 }

					  			// echo "\n\n\n* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * \n"; 
						  		//	 echo "\nDireccion Fiscal: ".$direccion_fiscal."\n\n";
					  			// var_dump( $di ); exit();
											
								//echo $value['rif']."	".$value['razsoc']."	".$value['rif']."				Activo	".$value['telefono']."		".$value['direccion']."	".$value['ciudad']."		".$value['ruta']."	No Asignado	000".$zona."	N				N			0	0	".date("d/m/Y")."
								//";
										$telefono=str_replace(";", "/", $value['telefono']);
										# Punto y coma 1
											//echo $value['rif'].";".$value['razsoc'].";".$value['rif'].";;;;Activo;$telefono;;".$value['direccion'].";".$value['ciudad'].";;".$value['ruta'].";SUPERMERCADOS;000".$zona.";N;s_marvie@hotmail.com;SANDRA VIEIRA;;N;;;0;1;".date("d/m/Y")."\n";
										# tab 1
										//echo $value['rif']."\t".$value['razsoc']."\t".$value['rif']."\t\t\t\tActivo\t$telefono\t\t".$value['direccion']."\t".$value['ciudad']."\t\t".$value['ruta']."\tSUPERMERCADOS\t000".$zona."\tN\ts_marvie@hotmail.com\tSANDRA VIEIRA\t\tN\t\t\t0\t1\t".date("d/m/Y")."\n";
										if( strlen($zona)==2 ){
										//echo $value['rif']."\t".$value['razsoc']."\t".$value['rif']."\t\t\t\tActivo\t$telefono\t\t".$value['direccion']."\t".$value['ciudad']."\t\t".$value['ruta']."\tSUPERMERCADOS\t000".$zona."\tN\tcorreo@gmail.com\t".$value['nomfir']."\t\tN\t\t\t0\t1\t".date("d/m/Y")."\n";
										$zona="000".$zona;
										$tipo_neg=$this->data_clientes->get_tipo_neg_001($value['tipneg']);
										$tipo_negocio = substr(trim($tipo_neg[0]['nombre']), 0,20)  ;
										echo $value['rif']."	".$value['razsoc']."	".$value['rif']."				Activo	".$value['telefono']."		".$direccion_fiscal."	".$value['ciudad']."		".$value['ruta']."	".$tipo_negocio."	$zona	N	correo@gmail.com	".$value['nomfir']."		N			0	1	09/11/2015\n";
										//echo $value['rif']."	".$value['razsoc']."	".$value['rif']."				Activo	".$value['telefono']."		".$value['direccion']."	".$value['ciudad']."		".$value['ruta']."	SUPERMERCADOS	000".$zona."	N				N			0	1	10/11/2015\n";
										//NO echo $value['rif']."\t".$value['razsoc']."\t".$value['rif']."\t\t\t\tActivo\t$telefono\t\t".$value['direccion']."\t".$value['ciudad']."\t\t".$value['ruta']."\tSUPERMERCADOS\t000$zona\tN\t*\t".$value['nomfir']."\t\tN\t\t\t0\t1\t".date("d/m/Y")."\n";	
										}
								}//si la zona es
								//$solo++;		
								//SOLO	}//solo tantos registros
					endif;
				}//fin de foreach

	}//fin de funcion Index()

public function unique_multidim_array($array, $key){
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val){
        if(!in_array($val[$key],$key_array)){
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

public function vendedores_001(){
 $this->load->model('data_clientes');
 $vendedores= $this->data_clientes->get_vendedores_dideco();
 header('Content-type: application/json');
 	foreach ($vendedores as $key => $value) {
 		//echo "000".$value['cod'].";".$value['nombre'].";000".$value['cod'].";ACT;;MARACAY;;;;;;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;N;N;;;;;";
 		echo "000".$value['cod']."	".$value['nombre']."	V-00000000-0	ACT	direccion	MARACAY		0243-2710000	FAX	CORREO@GMAIL.COM	NOTA	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	N	N					
";

 	}
}


}//fin de clase
