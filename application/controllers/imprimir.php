<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imprimir extends CI_Controller {
public function index(){
$this->load->view('html/head2');
$this->load->view('imprimir/select_compa_imp_format');
$this->load->view('html/footer2');
}

public function pruebas(){
	$this->load->model('data_complemento');

	$notas_credito=$this->data_complemento->get_nota_credito_dideco('10','15');
	echo "<pre>";
	var_dump($notas_credito);
	echo "</pre>";
}

public function procesos_productos($proveedores,$datosTabla,$compa){

	 $this->load->model('data_inventario');

		for ($i=0; $i < count($proveedores); $i++) { 
			$datosTabla[]=array('#'.$proveedores[$i]['codigo'].'#','***',"[".$proveedores[$i]['codigo']."] ".$proveedores[$i]['razsoc'],'###');

			$ProductosDeLProveedor=$this->data_inventario->get_productos_proveedor($compa,$proveedores[$i]['codigo']);
			
				//echo "[".$proveedores[$i]['codigo']."] - ".$proveedores[$i]['razsoc']."<br>";
			for ($o=0; $o < count($ProductosDeLProveedor); $o++) { 
				# sacar productos
				// if($ProductosDeLProveedor[$o]['clave']!="139"){}
				$datosTabla[]=array($ProductosDeLProveedor[$o]['clave'],' ',$ProductosDeLProveedor[$o]['descr'],' ');
				//echo $ProductosDeLProveedor[$o]['clave']."<br>";
				
			}

		}
	return $datosTabla;
}//proceso de recorrer los productos

public function txt_mes($n_mes){
	$txt="";
	switch ($n_mes) {
		case '1':
			$txt="ENERO";
			break;
		case '01':
			$txt="ENERO";
			break;
		case '2':
			$txt="FEBRERO";
			break;
		case '02':
			$txt="FEBRERO";
			break;
		case '3':
			$txt="MARZO";
			break;
		case '03':
			$txt="MARZO";
			break;
		case '4':
			$txt="ABRIL";
			break;
		case '04':
			$txt="ABRIL";
			break;
		case '05':
			$txt="MAYO";
			break;
		case '5':
			$txt="MAYO";
			break;
		case '06':
			$txt="JUNIO";
			break;
		case '6':
			$txt="JUNIO";
			break;
		case '07':
			$txt="JULIO";
			break;
		case '7':
			$txt="JULIO";
			break;
		case '08':
			$txt="AGOSTO";
			break;
		case '8':
			$txt="AGOSTO";
			break;
		case '09':
			$txt="SEPTIEMBRE";
			break;
		case '9':
			$txt="SEPTIEMBRE";
			break;
		case '10':
			$txt="OCTUBRE";
			break;
		case '11':
			$txt="NOVIEMBRE";
			break;
		case '12':
			$txt="DICIEMBRE";
			break;
		
		default:
			# code...
			break;
	}
		return $txt;
}//fin de txt_mes

public function menbrete_fac_ventas($pdf,$mes,$year){
	#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(5,5,5);

	$razon="Mayorista de Confites y Viveres ( DIDECO, C.A.";
	$rif="J075168089";
	# MENBRETE
		#fuente
		$pdf->SetFont('Arial','IB',12);
    $pdf->Cell(0,5,$razon.' - '.$rif.' )',0,0,'C');
    	$pdf->SetFont('Arial','I',9);
    	$pdf->Ln();
    $pdf->Cell(0,4,'Libro de Ventas',0,0,'C');
    	$pdf->Ln();
    $pdf->Cell(0,4,$this->txt_mes($mes).' - '.$year,0,0,'C');
    	$pdf->Ln();
    $pdf->Cell(0,3,'Emitido el '.date('d/m/Y h:i A'),0,0,'C');

		//$pdf->Setx(5);
    		//$pdf->Cell(0,5,'FECHA     NRO. DOCUMENT     Nro CONTROL     MODO PAGO',0,0,'L'); $pdf->Ln();

}

public function pie_pag($pdf){

	//El Numero de Pagina		
		#fuente
		$pdf->SetFont('Arial','I',8);
		$pdf->SetY(185);
		$pdf->Setx(335);
    	$pdf->Cell(10,10,'Pagina '.$pdf->PageNo().'/{nb}',0,0,'C');$pdf->Ln();
}

public function imp_fac_ventas_dideco($mes="",$year=""){
	$this->load->helper('pdf');
	$this->load->model('data_complemento');
	$fac_ventas=$this->data_complemento->get_fac_ventas_dideco($mes,$year);	
	$notas_credito=$this->data_complemento->get_nota_credito_dideco($mes,$year);
	$notas_debito=$this->data_complemento->get_nota_debito_dideco($mes,$year);
	$notas_debito_hische=$this->data_complemento->get_nota_debito_hische_dideco($mes,$year);
	$pdf = new PDF('L','mm','Legal');
	$pdf->SetMargins(5,5,5);   
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	//$this->menbrete_fac_ventas($pdf,$mes,$year);
	
		$header=array('FECHA DOC','NRO. DOC.','NRO. CONTROL','MODO PAGO','N. CREDITO','N. DEBITO','DOC. REF','RIF','RAZON'); 
		$datos=null;
    	foreach ($fac_ventas as $key => $value) {
    		
/*
    		$tiene_retencion_en_mes=$this->data_complemento->tiene_retencion_en_mes_dideco($value['numdoc'],$mes,$year);
    		if($tiene_retencion_en_mes){
    			//var_dump($tiene_retencion_en_mes); exit();
    			$datos[]=array($value['fecemi'],$value['numdoc'],$value['control'],'','','','',strtoupper($cliente['rif']),strtoupper( trim($cliente['razsoc']) ), $value['monto']+$value['moniva'] ,$value['bsexento'],trim($value['monto']-$value['bsexento'] ) ,$value['iva'],$value['moniva'],'control_comprobante'=>$tiene_retencion_en_mes[0]['control'],'fecemi_comprobante'=>$tiene_retencion_en_mes[0]['fecemi'],'monto_retenido'=>$tiene_retencion_en_mes[0]['monto']);
    		}else{
    				$datos[]=array($value['fecemi'],$value['numdoc'],$value['control'],'','','','',strtoupper($cliente['rif']),strtoupper( trim($cliente['razsoc']) ), $value['monto']+$value['moniva'] ,$value['bsexento'],trim($value['monto']-$value['bsexento'] ) ,$value['iva'],$value['moniva'] );		
    		}*/
    	}

    	/*Recorrido de NOTAS DE CREDITO*/
    	/*FIN de NOTAS DE CREDITO*/
    #$pdf->tabla_libro_ventas($notas_credito,$mes,$year);
    	//var_dump($notas_debito); echo count($notas_debito); exit();
    	$todos_datos=array_merge((array)$notas_credito,(array)$notas_debito,(array)$notas_debito_hische,(array)$this->data_complemento->get_fac_ventas_dideco($mes,$year) );
    	//var_dump($todos_datos); exit();
    	$orden=$pdf->array_orderby($todos_datos, "numdoc",SORT_ASC);
    	$pdf->tabla_libro_ventas($orden,$mes,$year);
	    # TRABAJANDO AUN EN FUNCION $this->data_complemento->get_ret_fuera_mes_dideco($mes,$year);
	    	/*if(count($notas_debito)>0 && $notas_debito!=NULL){
	    		$pdf->tabla_libro_ventas($notas_debito,$mes,$year);
		   	}
		   	if(count($notas_debito_hische)>0){
		   		$pdf->tabla_libro_ventas($notas_debito_hische,$mes,$year);
		   	}*/
    	//$pdf->Tabla_fac_ventas($header, $datos,$mes,$year);
    	
	
		


		$pdf->AliasNbPages();
		$pdf->Output();



}//imp_fac_ventas

public function imp_talonario_pedidos($compa=''){
	 $this->load->helper('pdf');
	 $this->load->model('data_inventario');

		//$pdf = new PDF('P','mm','Letter');
		//$pdf = new PDF('P','mm','Legal');
		$pdf = new PDF('P','mm','Legal');

		#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(5,5,5);

		#Establecemos el margen inferior:
		$pdf->SetAutoPageBreak(true,5);  
		$pdf->AddPage();
		$pdf->SetFont('Courier','B',16);

		$pdf->configuracionMenbrete($compa);

			$proveedores=$this->data_inventario->get_proveedores($compa);
			$proveedores002=$this->data_inventario->get_proveedores('002');
			$proveedores001=$this->data_inventario->get_proveedores('001');

		
		$datosTabla=null;
		$datosTabla=$this->procesos_productos($proveedores,$datosTabla,$compa);
for ($p=0; $p < 10; $p++) { 
	# 15 espacios
	$datosTabla[]=array('','',"",'');
}
		
		$datosTabla[]=array('---','---',"-------- [ D E I M P O R T ] -------",'---');
		$datosTabla=$this->procesos_productos($proveedores002,$datosTabla,'002');
for ($p=0; $p < 13; $p++) { 
	# 15 espacios
	$datosTabla[]=array('','',"",'');
}



		$datosTabla[]=array('---','---',"--------- [ D I D E C O ] ----------",'---');
		$datosTabla=$this->procesos_productos($proveedores001,$datosTabla,'001');


		/*
		for ($i=0; $i < count($proveedores); $i++) { 

			$datosTabla[]=array('#'.$proveedores[$i]['codigo'].'#','***',"[".$proveedores[$i]['codigo']."] ".$proveedores[$i]['razsoc'],'###');

			$ProductosDeLProveedor=$this->data_inventario->get_productos_proveedor($compa,$proveedores[$i]['codigo']);
			
				//echo "[".$proveedores[$i]['codigo']."] - ".$proveedores[$i]['razsoc']."<br>";
			for ($o=0; $o < count($ProductosDeLProveedor); $o++) { 
				# sacar productos
				// if($ProductosDeLProveedor[$o]['clave']!="139"){}
				$datosTabla[]=array($ProductosDeLProveedor[$o]['clave'],' ',$ProductosDeLProveedor[$o]['descr'],' ');
				//echo $ProductosDeLProveedor[$o]['clave']."<br>";
				
			}

		}*/
		//var_dump($datosTabla);
		$pdf->membrete_cliente();
		$cabecera=array('COD.','INV','CANT','DESCRIPCION','OFERT');

		$pdf->TableFantacy($cabecera, $datosTabla);
		$pdf->AliasNbPages();
		$pdf->Output();


}

public function imprimir_pedidos(){
$this->load->helper('pdf');
$this->load->model('data_complemento');
		$pdf = new PDF('P','mm','Legal');
		$pdf->AliasNbPages();
		#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(5,5,5);
		#Establecemos el margen inferior:
		$pdf->SetAutoPageBreak(true,5);  
		$pdf->AddPage();
		$pdf->SetFont('Courier','B',16);

		$pedidos=$this->data_complemento->todos_pedidos_A();
		for ($i=0; $i < count($pedidos); $i++) { 

				$pdf->SetX(5);
				$tipo="";

				if($pedidos[$i]['tipo']==1){$tipo="C.O.D.";}else{$tipo="CR-10";}
				$pdf->Ln();
				$pdf->SetFont('Courier','B',16);
				$pdf->Cell(1,8,utf8_decode("pedido id:".$pedidos[$i]['id']." Zona:".$pedidos[$i]['zona']."     CODIGO Cliente:[ ".$pedidos[$i]['codcte']." ] ".strtoupper($this->data_complemento->get_compaTXT($pedidos[$i]['compa'])) ));
				$pdf->Ln();
				$pdf->SetX(5);
				$pdf->Cell(1,8,utf8_decode("[ CONDICION: ")); 
				$pdf->SetTextColor(220,50,50);
				$pdf->SetX(50);  
				$pdf->Cell(1,8,utf8_decode($tipo));
				$pdf->SetX(72);  
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(1,8,"]");
				//VENDEDOR
				$pdf->SetX(107);
				$pdf->SetTextColor(200,100,0);
				$pdf->Cell(1,6,utf8_decode("VENDEDOR: ".$pedidos[$i]['nombre_completo']));

				$cliente=$this->data_complemento->get_cliente($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
				$pdf->Ln();
				$pdf->SetX(5);
				$pdf->SetTextColor(40,100,100);
				$pdf->Cell(1,6,utf8_decode("[ ".$cliente['razsoc']." ]"));
				

				$pdf->SetTextColor(50,50,50);
				
				//Fecha		
				if(strlen(($cliente['razsoc']))<36){
									$pdf->SetX(137);
									$pdf->Cell(1,8,utf8_decode(date_format(date_create($pedidos[$i]['fecha']),"d-m-Y H:i:s") ));  

				}else{
					$pdf->Ln();
					$pdf->SetX(137);
					$pdf->Cell(1,8,utf8_decode(date_format(date_create($pedidos[$i]['fecha']),"d-m-Y H:i:s") ));  

				}		

				$pdf->SetFont('Courier','I',16);
				$pdf->Ln();
				$obj=$this->data_complemento->productos_del_pedido($pedidos[$i]['id']);
				
				$pdf->SetX(10); 
				$pdf->Ln(); 
				$nro=0;

				$cantidad_prod=count($obj);
				$pdf->Cell(1,8,"Nro.  CODIGO   CANT.        DESCRIPCION");
				$pdf->Ln();

				 $pdf->SetFont('Courier','I',12);
				//for que rrecorre los productos >>

				for ($e=0; $e <$cantidad_prod ; $e++) { 

						if($obj[$e]->idped==$pedidos[$i]['id']){
							$nro++;
							
							$pdf->SetX(5);
							if($nro<10){$nro=" ".$nro;}

							$descr=$this->data_complemento->get_descripcion_producto($obj[$e]->cod_producto,$this->data_complemento->get_compaTXT($pedidos[$i]['compa']));
							if($obj[$e]->cantidad<10){
								$pdf->Cell(1,8,$nro.")      ".$obj[$e]->cod_producto."      [ ".$obj[$e]->cantidad."]       ".$descr);
							}else{
								$pdf->Cell(1,8,$nro.")      ".$obj[$e]->cod_producto."      [".$obj[$e]->cantidad."]       ".$descr);
							
							}
							$pdf->Ln();

						}	
					}

					if($pedidos[$i]['nota']!=""){
					$pdf->Ln();
				 	$pdf->SetFont('Courier','I',16);
					$nota=utf8_decode("NOTA: ".$pedidos[$i]['nota']);
					$pdf->MultiCell(200, 6,$nota);
					$pdf->Ln();
					}else{ $pdf->Ln(); }
				$pdf->SetX(0);

							$pdf->SetX(1);
							$pdf->Cell(1,8,"PEDIDO: ".$pedidos[$i]['id']." - Cantidad de productos: ".$nro."");
							$pdf->Ln();$pdf->SetX(1);
				$pdf->Cell(1,6," - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -");
				$pdf->Ln();
				if($pdf->GetY()>250){ $pdf->AddPage();}
		}
				/*foreach ($pedidos as $key => $value) {
					echo "key : $key  - value:".$value['id']." <-(ID) - Fecha: ".$value['fecha'];
						$productos=$this->data_complemento->productos_del_pedido($value['id']);

							echo "cantidad: ".count($productos);

							//var_dump($productos);
						
					echo "<br><br>";
				}*/

		$pdf->Footer();
		$pdf->Output();
}

public function imp_talonario_pedidos_DI_DE(){

	 $this->load->helper('pdf');
	 $this->load->model('data_inventario');
		$pdf = new PDF('P','mm','Legal');
		#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(5,5,5);

		#Establecemos el margen inferior:
		$pdf->SetAutoPageBreak(true,5);  
		$pdf->AddPage();
		$pdf->SetFont('Courier','B',16);

		$pdf->configuracionMenbreteDidecoDeimport();
		$cabecera=array('COD.','INV','CANT','DESCRIPCION','OFERT');

			$proveedores_dideco=$this->data_inventario->get_proveedores('001');
			$proveedores_deimport=$this->data_inventario->get_proveedores('002');
			#Generando la tabla del Inventario de DIDECO
			$datosTablaDideco=null;
			for ($i=0; $i < count($proveedores_dideco); $i++) { 
							$datosTablaDideco[]=array('#'.$proveedores_dideco[$i]['codigo'].'#','***',"[".$proveedores_dideco[$i]['codigo']."] ".$proveedores_dideco[$i]['razsoc'],'###');
							$ProductosDeLProveedor=$this->data_inventario->get_productos_proveedor('001',$proveedores_dideco[$i]['codigo']);
							for ($o=0; $o < count($ProductosDeLProveedor); $o++) { 
								$datosTablaDideco[]=array($ProductosDeLProveedor[$o]['clave'],' ',utf8_decode($ProductosDeLProveedor[$o]['descr']),' ');
							}
				
			}

			#Generando la tabla del Inventario de DEIMPORT
			$datosTablaDeimport=null;
			for ($i=0; $i < count($proveedores_deimport); $i++) { 
							$datosTablaDeimport[]=array('#'.$proveedores_deimport[$i]['codigo'].'#','***',"[".$proveedores_deimport[$i]['codigo']."] ".$proveedores_deimport[$i]['razsoc'],'###');
							$ProductosDeLProveedorDeimport=$this->data_inventario->get_productos_proveedor('002',$proveedores_deimport[$i]['codigo']);
							for ($o=0; $o < count($ProductosDeLProveedorDeimport); $o++) { 
								$datosTablaDeimport[]=array($ProductosDeLProveedorDeimport[$o]['clave'],' ',$ProductosDeLProveedorDeimport[$o]['descr'],' ');
							}
				
				
			}
		$pdf->Ln();
    	$pdf->SetFont('','B',14);
    	$pdf->SetY(24);
		$pdf->Cell(0,0,"DIDECO");
		$pdf->Ln();
		$pdf->TableDideco($cabecera, $datosTablaDideco);

		$pdf->TableDeimport($cabecera, $datosTablaDeimport);

		$pdf->AliasNbPages();
		$pdf->Output();

}

}
