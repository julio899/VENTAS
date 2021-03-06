<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imprimir_carta extends CI_Controller {
public function index(){
$this->load->view('html/head2');
$this->load->view('imprimir/select_compa_imp_format');
$this->load->view('html/footer2');
}

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
		
		$datosTabla=null;
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
		//$pdf = new PDF('P','mm','Legal');
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(5,5,5);
		#Establecemos el margen inferior:
		$pdf->SetAutoPageBreak(true,5);  
		$pdf->AddPage();
		$pdf->SetFont('Courier','B',16);

		/*CADENA de Secuencia*/
		$cadena=sha1(date("YhisA"));
		$array = str_split(substr($cadena, 0,9) , 3);
		$cad2="";
		for ($l=0; $l < count($array); $l++) { 
			$cad2.=$array[$l]."-";
		}

		$pedidos=$this->data_complemento->todos_pedidos_A();

		$cad2.=count($pedidos);


		if(count($pedidos)==0){
			$pdf->Cell(1,8," * No tiene pedidos Pendientes por Imprimir. ");
			$pdf->Ln();
			$pdf->Cell(1,8," * Ya fueron impresos. ");
			$pdf->Ln();
			$pdf->Cell(1,8,"   [ ".count($pedidos)." pedidos por imprimir...]");
			$pdf->Ln();$pdf->Ln();
		}//si ya fueron impresos
		$ult="";
		for ($i=0; $i < count($pedidos); $i++) { 

		$pdf->Cell(1,8, "Secuencia de Impresion:[ $cad2 ]" );$pdf->Ln();
		//$pdf->SetTextColor(220,50,50);rojo
		$pdf->SetTextColor(200,00,50);
		$pdf->SetFont('Courier','',16);
			/*Zona+codCliente*/ //VERIFICANDO DOCUMENTOS PENDIENTES POR TODAS LAS COMPAÑIAS
			$codcteCompleto=$pedidos[$i]['zona'].$pedidos[$i]['codcte'];
			$enlace=$this->data_complemento->get_enlace($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
			$datos_respuesta=FALSE;
			$datos_respuesta=$this->data_complemento->tieneDocPendiente($enlace);
			$algoPendiente=0;
			if($datos_respuesta!=FALSE){	
			$pdf->Cell(1,8,"ENLACE:".$enlace);  $pdf->Ln();
				for($a=0;$a<count($datos_respuesta);$a++){
					$pdf->Cell(1,8,utf8_decode(" pendiente [ ".strtoupper($this->data_complemento->get_compaTXT($datos_respuesta[$a]['codcia']))."  / ".$datos_respuesta[$a]['numdoc']."-".$datos_respuesta[$a]['fecemi']."] [monto: ".$datos_respuesta[$a]['monto']."]"));	
					$pdf->Ln();
					$algoPendiente++;
				}

			}
			// # Fin de DOCUMENTOS PENDIENTES


			/*Zona+codCliente*/ //VERIFICANDO CHEQUES DEVUELTOS POR TODAS LAS COMPAÑIAS
			$datos_respuesta2=$this->data_complemento->tieneChequesDevueltos($codcteCompleto);	
			if($datos_respuesta2!=FALSE){
			$pdf->Ln();
				for($a=0;$a<count($datos_respuesta2);$a++){
					$pdf->Cell(1,8,utf8_decode(" CHEQUE [ ".strtoupper($this->data_complemento->get_compaTXT($datos_respuesta2[$a]['codcia']))."  / ".$datos_respuesta2[$a]['numdoc']." - (".$datos_respuesta2[$a]['fecemi'].")] [monto: ".$datos_respuesta2[$a]['monto']."]"));	
					$pdf->Ln();
					$algoPendiente++;
				}

			}
			if($algoPendiente==0){
			$pdf->SetTextColor(0,100,0);
			$pdf->Cell(1,6,"              <<  * * * [ S O L V E N T E ] * * *  >>");
			}
			// # Fin de CHEQUES DEVUELTOS
			$pdf->SetTextColor(0,0,0);

				if($pedidos[$i]['nota']!=""){
					$pdf->Ln();
					$pdf->Cell(1,6,"* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *");
					$pdf->Ln();
				 	$pdf->SetFont('Courier','I',16);
					$nota=utf8_decode("NOTA: ".$pedidos[$i]['nota']);
					$pdf->MultiCell(200, 6,$nota);
					$pdf->Cell(1,6,"* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *");
					$pdf->Ln();
			}


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
							
							if($pdf->GetY()>262){
								//º$pdf->Cell(1,7,"Continuacion del pedido [".$pedidos[$i]['id']."] en la siguiente paguina  sig. producto (".$nro.")  >>>>>");
								$pdf->Cell(1,7,"Pag. Act (".$pdf->PageNo().") Continuacion del pedido [".$pedidos[$i]['id']."] en la siguiente paguina  sig. producto (".$nro.")>>");
								$pdf->Ln();
							}
							if($obj[$e]->cantidad<10){
								$pdf->Cell(1,7,$nro.")      ".$obj[$e]->cod_producto."      [ ".$obj[$e]->cantidad."]       ".$descr);
							}else{
								$pdf->Cell(1,7,$nro.")      ".$obj[$e]->cod_producto."      [".$obj[$e]->cantidad."]       ".$descr);
							}

							$pdf->Ln();

						}	
					}

					if($pedidos[$i]['nota']!=""){
					$pdf->Ln();
					//si contiene la palabra camion y si no es de deimport 002
					if($this->es_para_anexar($pedidos[$i]['nota'])==TRUE && $pedidos[$i]['compa']!="002" ){
					$pdf->Cell(1,6,"* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *");
					$pdf->Ln();
				 	$pdf->SetFont('Courier','I',16);

					$nota=utf8_decode("NOTA: ".strstr(strtoupper($pedidos[$i]['nota']), 'CHEQUE'));
					
					$pdf->MultiCell(200, 6,$nota);
					$pdf->Ln();
					}//fin de si es para anezar
					}else{ $pdf->Ln(); }

							$pdf->SetX(1);
							$pdf->Cell(1,6,"PEDIDO: ".$pedidos[$i]['id']." - Cantidad de productos: ".$nro."");
							$pdf->Ln();$pdf->SetX(1);
							/*while($nro<5 && $datos_respuesta==FALSE && $datos_respuesta2==FALSE){
								$pdf->Ln();
								$nro++;
							}*/

				$pdf->SetFont('Courier','I',16);
				if($pdf->GetY()<260){$pdf->Cell(1,6,"- - - - - - - - - - - - - - - Pag.( ".$pdf->PageNo()." ) - - - - - - - - - - - - - - -");}
				$pdf->Ln();
				$pdf->AddPage();
				//if($pdf->GetY()>250){ $pdf->AddPage();}
				//if($pdf->GetY()>158){ $pdf->AddPage();}
				$ult=$i;
				

		}
		
		$this->imprimir_comprobante($pdf,$pedidos[$ult]['id'],$pedidos[0]['id'],$cad2);
		$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
		$this->imprimir_comprobante($pdf,$pedidos[$ult]['id'],$pedidos[0]['id'],$cad2);
		$datos_session=$this->session->userdata('datos_usuario');
		$this->data_complemento->registrar_impresion(array('secuencia'=>$cad2,'idU'=>$datos_session['idU'],'desde'=>$pedidos[$ult]['id'],'hasta'=>$pedidos[0]['id'],'cantidad_pedidos'=>($ult+1),'pag_impresas'=>$pdf->PageNo()));
		
		$pdf->Footer();
		$pdf->Output();
		
		$pdf->Output("archivos/".$cad2.".pdf","F");
}


public function imprimir_pedidos_desde_hasta($desde="",$hasta=""){
	if($_POST['desde']&&$_POST['hasta']){
		$desde=$_POST['desde'];
		$hasta=$_POST['hasta'];
	}
	$this->load->helper('pdf');
	$this->load->model('data_complemento');
		//$pdf = new PDF('P','mm','Legal');
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(5,5,5);
		#Establecemos el margen inferior:
		$pdf->SetAutoPageBreak(true,5);  
		$pdf->AddPage();
		$pdf->SetFont('Courier','',16);
		$cadena=sha1(date("YhisA"));
		$array = str_split(substr($cadena, 0,9) , 3);
		$cad2="";
		for ($l=0; $l < count($array); $l++) { 
			$cad2.=$array[$l]."-";
		}
		$pedidos=$this->data_complemento->pedidos_desde_hasta($desde,$hasta);
		$cad2.=count($pedidos);
		

		if(count($pedidos)==0){
			$pdf->Cell(1,8," * No tiene pedidos Pendientes por Imprimir. ");
			$pdf->Ln();
			$pdf->Cell(1,8," * Ya fueron impresos. ");
			$pdf->Ln();
			$pdf->Cell(1,8,"   [ ".count($pedidos)." pedidos por imprimir...]");
				$pdf->Ln();	$pdf->Ln();
		}//si ya fueron impresos
		$ult="";
		for ($i=0; $i < count($pedidos); $i++) { 
		$algoPendiente=0;
		$pdf->Cell(1,8, "Secuencia de Impresion:[ $cad2 ]" );$pdf->Ln();
		//$pdf->SetTextColor(220,50,50);rojo
		$pdf->SetTextColor(200,00,50);
		$pdf->SetFont('Courier','',16);
			/*Zona+codCliente*/ //VERIFICANDO DOCUMENTOS PENDIENTES POR TODAS LAS COMPAÑIAS
			$codcteCompleto=$pedidos[$i]['zona'].$pedidos[$i]['codcte'];
			$enlace=$this->data_complemento->get_enlace($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
			$datos_respuesta=FALSE;
			$datos_respuesta=$this->data_complemento->tieneDocPendiente($enlace);
			if($datos_respuesta!=FALSE){	
			$pdf->Cell(1,8,"ENLACE:".$enlace);  $pdf->Ln();
				for($a=0;$a<count($datos_respuesta);$a++){
					$pdf->Cell(1,8,utf8_decode(" pendiente [ ".strtoupper($this->data_complemento->get_compaTXT($datos_respuesta[$a]['codcia']))."  / ".$datos_respuesta[$a]['numdoc']."-".$datos_respuesta[$a]['fecemi']."] [monto: ".$datos_respuesta[$a]['monto']."]"));	
					$pdf->Ln();
					$algoPendiente++;
				}

			}
			// # Fin de DOCUMENTOS PENDIENTES


			/*Zona+codCliente*/ //VERIFICANDO CHEQUES DEVUELTOS POR TODAS LAS COMPAÑIAS
			$datos_respuesta2=$this->data_complemento->tieneChequesDevueltos($codcteCompleto);	
			if($datos_respuesta2!=FALSE){
			$pdf->Ln();
				for($a=0;$a<count($datos_respuesta2);$a++){
					$pdf->Cell(1,8,utf8_decode(" CHEQUE [ ".strtoupper($this->data_complemento->get_compaTXT($datos_respuesta2[$a]['codcia']))."  / ".$datos_respuesta2[$a]['numdoc']." - (".$datos_respuesta2[$a]['fecemi'].")] [monto: ".$datos_respuesta2[$a]['monto']."]"));	
					$pdf->Ln();
					$algoPendiente++;
				}

			}

			if($algoPendiente==0){
			$pdf->SetTextColor(0,100,0);
			$pdf->Cell(1,6,"              <<  * * * [ S O L V E N T E ] * * *  >>");
			}

			// # Fin de CHEQUES DEVUELTOS
			$pdf->SetTextColor(0,0,0);

				if($pedidos[$i]['nota']!=""){
					$pdf->Ln();
					$pdf->Cell(1,6,"* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *");
					$pdf->Ln();
				 	$pdf->SetFont('Courier','I',16);
					$nota=utf8_decode("NOTA: ".$pedidos[$i]['nota']);
					$pdf->MultiCell(200, 6,$nota);
					$pdf->Cell(1,6,"* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *");
					$pdf->Ln();
			}


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
							
							if($pdf->GetY()>262){
								$pdf->Cell(1,7,"Pag. Act (".$pdf->PageNo().") Continuacion del pedido [".$pedidos[$i]['id']."] en la siguiente paguina  sig. producto (".$nro.")>>");
								$pdf->Ln();
							}
							if($obj[$e]->cantidad<10){
								$pdf->Cell(1,7,$nro.")      ".$obj[$e]->cod_producto."      [ ".$obj[$e]->cantidad."]       ".$descr);
							}else{
								$pdf->Cell(1,7,$nro.")      ".$obj[$e]->cod_producto."      [".$obj[$e]->cantidad."]       ".$descr);
							}

							$pdf->Ln();

						}	
					}

					if($pedidos[$i]['nota']!=""){
					$pdf->Ln();
					//si contiene la palabra camion y si no es de deimport 002
					if($this->es_para_anexar($pedidos[$i]['nota'])==TRUE && $pedidos[$i]['compa']!="002" ){
					$pdf->Cell(1,6,"* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *");
					$pdf->Ln();
				 	$pdf->SetFont('Courier','I',16);

					$nota=utf8_decode("NOTA: ".strstr(strtoupper($pedidos[$i]['nota']), 'CHEQUE'));
					
					$pdf->MultiCell(200, 6,$nota);
					$pdf->Ln();
					}//fin de si es para anezar
					}else{ $pdf->Ln(); }

							$pdf->SetX(1);
							$pdf->Cell(1,6,"PEDIDO: ".$pedidos[$i]['id']." - Cantidad de productos: ".$nro."");
							$pdf->Ln();$pdf->SetX(1);
							/*while($nro<5 && $datos_respuesta==FALSE && $datos_respuesta2==FALSE){
								$pdf->Ln();
								$nro++;
							}*/

				$pdf->SetFont('Courier','I',16);
				if($pdf->GetY()<260){$pdf->Cell(1,6,"- - - - - - - - - - - - - - - Pag.( ".$pdf->PageNo()." ) - - - - - - - - - - - - - - -");}
				$pdf->Ln();
				$pdf->AddPage();
				//if($pdf->GetY()>250){ $pdf->AddPage();}
				//if($pdf->GetY()>158){ $pdf->AddPage();}
				$ult=$i;

		}

		//$pdf->Cell(1,6,"Secuencia desde el pedido: #[ ".$pedidos[0]['id']."] - hasta #[ ".$pedidos[$ult]['id']." ]");
		$this->imprimir_comprobante($pdf,$pedidos[$ult]['id'],$pedidos[0]['id'],$cad2);
		$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
		$this->imprimir_comprobante($pdf,$pedidos[$ult]['id'],$pedidos[0]['id'],$cad2);
		//`secuencia`, `desde`, `hasta`, `cantidad_pedidos`, `pag_impresas`
		$datos_session=$this->session->userdata('datos_usuario');
		$this->data_complemento->registrar_impresion(array('secuencia'=>$cad2,'idU'=>$datos_session['idU'],'desde'=>$pedidos[$ult]['id'],'hasta'=>$pedidos[0]['id'],'cantidad_pedidos'=>($ult+1),'pag_impresas'=>$pdf->PageNo()));
		$pdf->Footer();
		$pdf->Output();
		$pdf->Output("archivos/".$cad2.".pdf","F");
}//desde hasta

public function imprimir_comprobante($pdf,$primero,$ult,$cad2){
		$pdf->MultiCell(200, 10, "Secuencia desde el pedido: #[ ".$primero."] - hasta #[ ".$ult." ]\nSERIAL DE SECUENCIA # [ $cad2 ]", "TLRB","L",0);
		$pdf->MultiCell(200, 10, "Fecha de Impresion: #[ ".date('d-m-Y H:i:s')."] \nCANTIDAD TOTAL de Pag. IMPRESAS:".$pdf->PageNo()."\n\nIMPRESO POR:__________________________\n\nRECIBIDO POR:_________________________\n\n", "TLRB","L",0);
		
}//fin de imprimir_comprobante


public function es_para_anexar($cadena){
	$respuesta=FALSE;
	if(strstr($cadena, "CAMION")){ $respuesta=TRUE;}
	if(strstr($cadena, "CAMIÓN")){ $respuesta=TRUE;}
	if(strstr($cadena, "camión")){ $respuesta=TRUE;}
	if(strstr($cadena, "camion")){ $respuesta=TRUE;}
	return $respuesta;
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

public function pedidos_txt(){
	$this->load->helper('file');
	$this->load->model('data_complemento');
	$txt="";
	$txt2="";
	$pedidos=$this->data_complemento->todos_pedidos_A();
		for ($i=0; $i < count($pedidos); $i++) { 

			/*Zona+codCliente*/ //VERIFICANDO DOCUMENTOS PENDIENTES POR TODAS LAS COMPAÑIAS
			$codcteCompleto=$pedidos[$i]['zona'].$pedidos[$i]['codcte'];
			$enlace=$this->data_complemento->get_enlace($pedidos[$i]['codcte'],$pedidos[$i]['compa']);



				$tipo="";

				if($pedidos[$i]['tipo']==1){$tipo="C.O.D.";}else{$tipo="CR-10";}
 /* ############################################# */				
	echo "$codcteCompleto,".$pedidos[$i]['id'].",".$pedidos[$i]['compa'].",".utf8_decode(date_format(date_create($pedidos[$i]['fecha']),"d/m/Y") ).",".$tipo.",".utf8_decode($pedidos[$i]['nota'])."<br>";
if(strlen($codcteCompleto)<6){
	
}
$txt.=$pedidos[$i]['compa'].",".$codcteCompleto.",".$pedidos[$i]['id'].",".utf8_decode(date_format(date_create($pedidos[$i]['fecha']),"d/m/Y") ).",".$tipo.",".utf8_decode( str_replace(",", "", $pedidos[$i]['nota']) )."\n";








				//$pdf->Cell(1,8,utf8_decode("pedido id:".$pedidos[$i]['id']." Zona:".$pedidos[$i]['zona']."     CODIGO Cliente:[ ".$pedidos[$i]['codcte']." ] ".strtoupper($this->data_complemento->get_compaTXT($pedidos[$i]['compa'])) ));
				
				//$pdf->Cell(1,8,utf8_decode("[ CONDICION: ")); 
				//$pdf->Cell(1,8,utf8_decode($tipo));
				//$pdf->Cell(1,8,"]");
				
				//VENDEDOR
				//$pdf->Cell(1,6,utf8_decode("VENDEDOR: ".$pedidos[$i]['nombre_completo']));

				$cliente=$this->data_complemento->get_cliente($pedidos[$i]['codcte'],$pedidos[$i]['compa']);
				
				//$pdf->Cell(1,6,utf8_decode("[ ".$cliente['razsoc']." ]"));
				

				//Fecha		
				//$pdf->Cell(1,8,utf8_decode(date_format(date_create($pedidos[$i]['fecha']),"d-m-Y H:i:s") ));  

				$obj=$this->data_complemento->productos_del_pedido($pedidos[$i]['id']);
				
				$nro=0;

				$cantidad_prod=count($obj);
				//$pdf->Cell(1,8,"Nro.  CODIGO   CANT.        DESCRIPCION");
				

				 //$pdf->SetFont('Courier','I',12);
				//for que rrecorre los productos >>

				for ($e=0; $e <$cantidad_prod ; $e++) { 

						if($obj[$e]->idped==$pedidos[$i]['id']){
							$txt2.=$pedidos[$i]['compa'].",".$pedidos[$i]['id'].",".$obj[$e]->cod_producto.",".$obj[$e]->cantidad."\n";
							/*
							if($pdf->GetY()>262){
								$pdf->Cell(1,7,"Continuacion del pedido [".$pedidos[$i]['id']."] en la siguiente paguina  sig. producto (".$nro.")  >>>>>");
								$pdf->Ln();
							}
							if($obj[$e]->cantidad<10){
								$pdf->Cell(1,7,$nro.")      ".$obj[$e]->cod_producto."      [ ".$obj[$e]->cantidad."]       ".$descr);
							}else{
								$pdf->Cell(1,7,$nro.")      ".$obj[$e]->cod_producto."      [".$obj[$e]->cantidad."]       ".$descr);
							}
							*/

						}	
					}
/*
					if($pedidos[$i]['nota']!=""){
					$pdf->Ln();
				 	$pdf->SetFont('Courier','I',16);
					$nota=utf8_decode("NOTA: ".$pedidos[$i]['nota']);
					$pdf->MultiCell(200, 6,$nota);
					$pdf->Ln();
					}else{ $pdf->Ln(); }

							$pdf->Cell(1,6,"PEDIDO: ".$pedidos[$i]['id']." - Cantidad de productos: ".$nro."");
					*/

				

		}

//GENERANDO ARCHIVO DE PEDIDOS
if ( ! write_file('archivos/WEBENCA.txt', $txt))
{
     echo 'Unable to write the file';
}
else
{
     echo 'Archivo archivos/WEBENCA.txt generado Exitosamente!<br>';
}
//GENERANDO ARCHIVO DE PRODUCTOS
if ( ! write_file('archivos/WEBDETA.txt', $txt2))
{
     echo 'Unable to write the file';
}
else
{
     echo 'Archivo archivos/WEBDETA.txt generado Exitosamente!';
}


}/*fin de pedidos txt*/

}