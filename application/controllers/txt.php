<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Txt extends CI_Controller {

	public function index(){
		$temporal=null;
		$arreglo_unico=null;
		$datos=null;
		$this->load->model('data_clientes');
		header('Content-type: application/json');
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
					$datos[]=array('rif' => $rif_formateado,'razsoc'=>$value->razsoc,'telefono'=>$telefono,'direccion'=>trim($value->direc1." ".$value->direc2),"ciudad"=>$value->nombre,"estado"=>$value->estado  );
				}

			}//fin de IF !=0000000000 y si la primera letra no comienza con C de CI
		}//fin de foreach
$arreglo_unico=array_unique($temporal);
$unicos=$this->unique_multidim_array($datos,'rif');
//echo "solo elementos validos: ".count($arreglo_unico);
//echo "\nen datos existen elementos validos: ".count($unicos)."\n";
				foreach ($unicos as $key => $value) {
					// echo $value['rif']."\t".$value['razsoc']." \t".$value['rif']."\t\t\t\tActivo\t".$value['telefono']."\t\t".$value['direccion']."\t".$value['ciudad']."\t\t".$value['estado']."\t"."No Asignado\t00001\tN\t\t\t\tN\t\t\t0\t1\t".date("d/m/Y")."\n";
					if(strtoupper($value['ciudad'])=='MARACAY' ):
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
								
					endif;
				}

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
 	echo "<pre>VENDEDORES DE DIDECO</pre>";
 	foreach ($vendedores as $key => $value) {
 		echo "COD: ".$value['cod'];
 		echo " / ".$value['nombre']."<br>";
 	}
}


}//fin de clase
