<?php
 require_once('fpdf_helper.php');
 class PDF extends FPDF
{
public $compaTXT;
public $final=FALSE;
public $exentos=0; 
public $exentos_nc=0;
public $exentos_nd=0;
public $exentos_fac_contado=0;
public $exentos_fac_credito=0;
public $ivas=null;
public $detalle=null;

// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}
function ImpNroPaguina(){

    $this->SetY(300);
    $this->SetX(5);
    //$this->Cell(0,10,'Firma del Cliente:___________________________',0,0,'L');
    $this->Cell(0,10,'Firma del Cliente:',0,0,'L');
    $this->setY(305);$this->setX(38);
    $this->Cell(50,0,'','T');

    
    $this->setY(299);$this->SetX(100);
    $this->Cell(0,10,'Firma del Vendedor:',0,0,'L');
    $this->setY(305);$this->setX(138);
    $this->Cell(50,0,'','T');
    $this->Ln(10);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
}
function ImpNroPaguinaDidecoDeimport(){

    $this->SetY(290);
    $this->SetX(5);
    $this->Cell(0,10,'Firma del Cliente:___________________________',0,0,'L');
    
    $this->SetX(100);
    $this->Cell(0,10,'Firma del Vendedor:___________________________',0,0,'L');
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
}
function tabla_datos_cliente(){

        // Colors, line width and bold font
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0);
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(.3);
            $this->SetFont('Courier','B',9);
            //anco  de  columnas
            // CODIGO CTE | ZONA | VENDEDOR | TIPO
            $cabecera=array('RAZON SOCIAL','CODIGO CTE.','ZONA','VENDEDOR','TIPO');
            $w = array(70,25, 10, 27, 15);

                                $this->Ln();
            $this->setX(55);
                                for($i=0;$i<count($cabecera);$i++) {
                                    $this->Cell($w[$i],5,$cabecera[$i],1,0,'C',true);                            
                                }

                                $this->Ln();
            $this->setX(55);
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0);

                                for($i=0;$i<count($cabecera);$i++) {
                                    $this->Cell($w[$i],5,'',1,0,'C',true);                            
                                }

                                //recuadero de Direccion
                                $this->Ln();
                                $this->SetX(55);
                                $this->Cell(25,5,utf8_decode('DIRECCIÓN:'),1,0,'C',true);
                                $this->Cell(122,5,'',1,0,'C',true);

}
function membrete_cliente(){
        $this->SetFont('Courier','B',16);
        $this->SetY(8);
        $this->Cell(40,0,$this->compaTXT);
        $this->Ln();
        $this->SetY(13);
        $this->Cell(40,0,'DIDECO, C.A.');
        $this->Ln();
        $this->SetY(18);
        $this->Cell(40,0,'DEIMPORT, C.A');
        $this->SetY(5);
        $this->tabla_datos_cliente();
        $this->Ln(10);
}
function configuracionMenbrete($codCompa){
    switch ($codCompa) {
            case '001':
                # DIDECO
                $this->SetTitle("Talonario DIDECO, C.A.");
                //$this->Cell(40,0,'DIDECO, C.A.');
                $this->compaTXT="DIDECO, C.A.";
                break;
            case '002':
                # DEIMPORT
                $this->SetTitle("Talonario DEIMPORT, C.A.");
                //$this->Cell(40,0,'DEIMPORT, C.A.');
                $this->compaTXT="DEIMPORT, C.A.";
                break;
            case '005':
                # COMPACTO
                $this->SetTitle("Talonario COMPACTO, C.A.");
                //$this->Cell(40,0,'COMPACTO, C.A.');
                $this->compaTXT="COMPACTO, C.A.";
                break;
            
            default:
                # code...
                break;
    }
}


function configuracionMenbreteDidecoDeimport(){
                # DIDECO y DEIMPORT
                $this->SetTitle("Talonario DIDECO, C.A. DEIMPORT, C.A.");
                $this->Cell(40,0,"DIDECO, C.A.");
                $this->Ln();
                $this->Cell(40,10,"DEIMPORT, C.A."); 
                $this->membrete_cliente();
}

function cabeceraTabla($header){
    $this->membrete_cliente();
    // Colors, line width and bold font
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
            // Header
        $w = array(9, 8,8, 50, 10);
                             for($i=0;$i<count($header);$i++){

                                $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
                                }
                            $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
}

function cabeceraTabla2($header,$w,$x){
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    $this->SetY(22);
    $this->SetX($x);
        // Header

    //$w = array(9, 8,8, 63, 10);
                        for($i=0;$i<count($header);$i++){
                            $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
                            }
                        $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
}



function TableFantacy($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',9);
    // Header
    $w = array(10, 9,9,63, 11);

    $this->SetY(22);
    for($i=0;$i<count($header);$i++){

     $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
       }   
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    $u=0;

    $this->SetFont('Courier','',8);

                    $x=109;

                    //$this->SetY(32);
                    //$this->SetX(0);
                    
        foreach($data as $row)
        {
               $u++;
               $cantidad_lineas_primera_cols=65;
                if($u==$cantidad_lineas_primera_cols){
                    // Closing line Primera tabla
                    $this->Cell(array_sum($w),0,'','T');
                    $this->SetX(109);
                    $this->cabeceraTabla2($header,$w,$x);
                }
                
                if ($u>=$cantidad_lineas_primera_cols) {
                    $this->SetX($x);
                }
                //$this->SetX($x);

                $this->Cell($w[0],4,$row[0],'LR',0,'C',$fill);
                $this->Cell($w[1],4,'','LR',0,'C',$fill);
                $this->Cell($w[2],4,$row[1],'LR',0,'C',$fill);
                $this->Cell($w[3],4,$row[2],'LR',0,'L',$fill);
                $this->Cell($w[4],4,$row[3],'LR',0,'C',$fill);
                $this->Ln();

                $fill = !$fill;
        }



    //añadiendo los espacios en Blanco
    if($u<150){

        $this->SetX($x);
        //Posicion Vertical a partir de donde salen los espacios en blancos
        //$this->SetY();

        for ($o=$u; $o < 128; $o++) { 
              //$this->SetX(112);
              $this->SetX($x);

                        $this->Cell($w[0],4,'','LR',0,'L',$fill);
                        $this->Cell($w[1],4,'','LR',0,'L',$fill);
                        $this->Cell($w[2],4,'','LR',0,'L',$fill);
                        $this->Cell($w[3],4,'','LR',0,'R',$fill);
                        $this->Cell($w[4],4,'','LR',0,'R',$fill);
                        $this->Ln();
                        $fill = !$fill;
                }

    }
        /*Fin de espacios en blanco*/


    if($u<$cantidad_lineas_primera_cols){
        //cierre de la primera tabla
        $this->SetX(5);
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }else{

        $this->SetX(109);
        // Closing line ( SEGUNDA TABLA)
        $this->Cell(array_sum($w),0,'','T');

    }

                

                    $this->ImpNroPaguina();
}


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
function membrete_Tabla_fac_ventas($w,$mes,$year){
    $razon="Mayorista de Confites y Viveres ( DIDECO, C.A. ";
    $rif="J075168089";
    # MENBRETE
        #fuente
        $this->SetFont('Arial','IB',12);
        $this->Cell(0,5,$razon.' - '.$rif.' )',0,0,'C');
        $this->SetFont('Arial','IB',9);
        $this->Ln();
        $this->Cell(0,4,'Libro de Ventas',0,0,'C');
        $this->Ln();
        $this->Cell(0,4,$this->txt_mes($mes).' - 20'.$year,0,0,'C');
        $this->SetFont('Arial','I',9);

        $this->SetX(275);
        $this->Write(2,'Emitido el '.date('d/m/Y h:i A').' * Pagina '.$this->PageNo().'/{nb}'); 
        $this->SetX(0);    
            $this->Ln(); 
            $this->Ln();
         # FIN de solo TEXTO   

            // Colors, line width and bold font
            $this->SetFillColor(50,50,50); // 255 0 0 >ROJO
            $this->SetTextColor(255); // 255-> BLANCO
            $this->SetDrawColor(0,0,0);//128,0,0->Rojo
            $this->SetLineWidth(.2);//->grosor de linea Verticales
            $this->SetFont('','B',7);
            if($this->final!=TRUE){
                    $header=array('#', 'FECHA','NRO.','NRO','NOTA','NOTA','DOC.','FECHA','COMPROBANTE','RIF','RAZON SOCIAL','MONTO','EXENTO','BASE','%','MONTO','MONTO','FECHA DE','TIPO DE'); 

                    for($i=0;$i<count($header);$i++){
                            $this->Cell($w[$i],3,$header[$i],0,0,'C',true);
                       }   
                        
                        $this->Ln();
                    $header=array('','DOC.','DOC.','CONTROL','CREDITO','DEBITO','AFECT','RETENC.','DE RETENCION','','','CON IVA','','IMPONIBLE','IVA','IVA','RETENIDO','ANULACION','DOC.'); 
                for($i=0;$i<count($header);$i++){

                            $this->Cell($w[$i],3,$header[$i],0,0,'C',true);
                   }   
                    $this->Ln();
            }// fin de if($final) si es final que no imprima el encabzado de esta pagina

    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
}



function membrete_Tabla_fac_ventas2($w,$mes,$year,$empresa){
    //$this->Cell(array_sum($w),0,'','T');
        #Establecemos los márgenes izquierda, arriba y derecha:
     
   // $this->AddPage();
    $razon=$empresa['razon'];
    $rif=$empresa['rif'];
    //var_dump($razon); exit();
    # MENBRETE
        #fuente
        $this->SetFont('Arial','IB',12);
    $this->Cell(0,5,$razon.' - '.$rif.' )',0,0,'C');
        $this->SetFont('Arial','IB',9);
        $this->Ln();
    $this->Cell(0,4,'Libro de Ventas',0,0,'C');
        $this->Ln();
    $this->Cell(0,4,$this->txt_mes($mes).' - 20'.$year,0,0,'C');
       // $this->Ln();
    //$this->Cell(0,3, ,0,0,'C');

        $this->SetFont('Arial','I',9);
    $this->SetX(275);
    $this->Write(2,'Emitido el '.date('d/m/Y h:i A').' * Pagina '.$this->PageNo().'/{nb}'); 
    $this->SetX(0);    
        $this->Ln(); 
        $this->Ln();
     # FIN de solo TEXTO   

    // Colors, line width and bold font
    $this->SetFillColor(50,50,50); // 255 0 0 >ROJO
    $this->SetTextColor(255); // 255-> BLANCO
    $this->SetDrawColor(0,0,0);//128,0,0->Rojo
    $this->SetLineWidth(.2);//->grosor de linea Verticales
    $this->SetFont('','B',7);
    if($this->final!=TRUE){
    $header=array('#', 'FECHA','NRO.','NRO','NOTA','NOTA','DOC.','FECHA','COMPROBANTE','RIF','RAZON SOCIAL','MONTO','EXENTO','BASE','%','MONTO','MONTO','FECHA DE','TIPO DE'); 

    for($i=0;$i<count($header);$i++){

     $this->Cell($w[$i],3,$header[$i],0,0,'C',true);
       }   
    $this->Ln();
    $header=array('','DOC.','DOC.','CONTROL','CREDITO','DEBITO','AFECT','RETENC.','DE RETENCION','','','CON IVA','','IMPONIBLE','IVA','IVA','RETENIDO','ANULACION','DOC.'); 
    for($i=0;$i<count($header);$i++){

     $this->Cell($w[$i],3,$header[$i],0,0,'C',true);
       }   
    $this->Ln();
    }// fin de if($final) si es final que no imprima el encabzado de esta pagina

    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
}

function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

function tabla_libro_ventas($data,$mes,$year){

    // Header
    $w = array(8,13, 10,15, 15,10,11,13,22,17,85,17,17,17,7,17,17,15,13);
    $x=5;
    // Data
    $fill = false;
    $this->SetFont('Courier','',10);
    # ACUMULADORES
    $retenciones=0;
    $notas_credito=0; $IVA_notas_credito=0;
    $notas_debito=0; $IVA_notas_debito=0;
    $ventas_contado=0; $IVA_ventas_contado=0; 
    $ventas_credito=0; $IVA_ventas_credito=0;
    $retenciones_islr=0;
    $this->exentos=0;

    $this->membrete_Tabla_fac_ventas($w,$mes,$year);  
        for($c=0 ; $c < count($data) ; $c++)
    {
        if($this->GetY()==192){   $this->Cell(array_sum($w),0,'','T');  $this->AddPage(); $this->membrete_Tabla_fac_ventas($w,$mes,$year);  }

        $this->Cell($w[0],3,$c+1,'LR',0,'C',$fill);
        # LA FECHA SE MUESTRA FECHSIT EN CASO DE RETENCION FUERA DE MES
          $this->Cell($w[1],3,$data[$c]['fecemi'],'LR',0,'C',$fill);
                    
        
        # SI ES UNA FACTURA
        if($data[$c]['tipo']=='FAC'){
            if(trim($data[$c]['condi'])==0){
            $this->Cell($w[2],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//COLUMNA Nro DOC    
            
            }else{
            $this->Cell($w[2],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//COLUMNA Nro DOC

            }
        }
        # en caso de ser NOTA de DEBIO o Credito
        if($data[$c]['tipo']=='ND'||$data[$c]['tipo']=='NC'||$data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
            $this->Cell($w[2],3,'','LR',0,'C',$fill);//COLUMNA Nro DOC
                if($data[$c]['tipo']=='ND'&& $data[$c]['st']!='A'){ 
                                                $notas_debito+=($data[$c]['base']-$data[$c]['iva']);
                                                $IVA_notas_debito+=$data[$c]['iva'];
                                             } 
            }
        # SI ES UNA RETENCION FUERA DEL MES
        /*if($data[$c]['tipo']=='RET'){
            $this->Cell($w[2],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//COLUMNA Nro DOC
        }*/
        
            # imprimo el control si no es una retencion
            if($data[$c]['tipo']!='RET'){
                $this->Cell($w[3],3,$data[$c]['control'],'LR',0,'C',$fill);
            }else{
                $this->Cell($w[ 3],3,'','LR',0,'C',$fill);
                }
            # si tipo es NC (NOTA de CREDITO)
             if($data[$c]['tipo']=='NC'){
                    $this->Cell($w[4],3,$data[$c]['numdoc'],'LR',0,'C',$fill);

             }else{
                    $this->Cell($w[4],3,'','LR',0,'C',$fill);
             }
            # si tipo es ND (NOTA de DEBITO)
            if($data[$c]['tipo']=='ND'){
                    $this->Cell($w[5],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//columna nota de DEBITO
            }else{
                    $this->Cell($w[5],3,'','LR',0,'C',$fill);//columna nota de DEBITO
            }

            #SI es FAC no se imprime doc REFE
            if($data[$c]['tipo']=='FAC'){
                $this->Cell($w[6],3,'','LR',0,'C',$fill);
            
            }else{
                    $this->Cell($w[6],3,$data[$c]['docref'],'LR',0,'C',$fill);
            }
            #en caso que tenga retencion
            if($data[$c]['retencion']){
                $this->Cell($w[7],3,$data[$c]['retencion'][0]['fecemi'],'LR',0,'C',$fill);
                $this->Cell($w[8],3,$data[$c]['retencion'][0]['control'],'LR',0,'C',$fill);
            }else{
                 if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                    $this->Cell($w[7],3,$data[$c]['fecemi'],'LR',0,'C',$fill);
                    $this->Cell($w[8],3,$data[$c]['control'],'LR',0,'C',$fill);
                }else{

                        $this->Cell($w[7],3,'','LR',0,'C',$fill);
                        $this->Cell($w[8],3,'','LR',0,'C',$fill);   
                }
            }   

        $this->Cell($w[9],3,$data[$c]['rif'],'LR',0,'C',$fill);
        $this->Cell($w[10],3,$data[$c]['razsoc'],'LR',0,'L',$fill);
        if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                         $this->Cell($w[11],3,'','LR',0,'R',$fill);//MONTO CON IVA
                 }else{
                        //si la BASE (-)menos IVA == BASE es porque la base ya incluye el iva en hische 
                   $base_comparativa=$data[$c]['base']/'1.'.$data[$c]['%'];
                   $base_=explode('.',$base_comparativa);
                   $base_full_comparativa=explode('.',$data[$c]['base']+$data[$c]['iva']); 
                    if($base_[0]!=$base_full_comparativa[0]&&$data[$c]['tipo']=='ND'){
                        $this->Cell($w[11],3,number_format($data[$c]['base'],2,',','.'),'LR',0,'R',$fill);//MONTO CON IVA
                    }else{
                        $this->Cell($w[11],3,number_format($data[$c]['base']+$data[$c]['iva'],2,',','.'),'LR',0,'R',$fill);//MONTO CON IVA    
                        //$this->Cell($w[11],3,$base_[0]."/".($base_full_comparativa[0]),'LR',0,'R',$fill);//MONTO CON IVA    
                        }


                    }
        #para los exentos
        if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A'){
            if($data[$c]['tipo']=='NC'){$this->exentos_nc+=$data[$c]['exento'];}
            if($data[$c]['tipo']=='ND'){$this->exentos_nd+=$data[$c]['exento'];}
            if($data[$c]['tipo']=='FAC'&&trim($data[$c]['condi'])==0){$this->exentos_fac_contado+=$data[$c]['exento'];}
            if($data[$c]['tipo']=='FAC'&&trim($data[$c]['condi'])!=0){$this->exentos_fac_credito+=$data[$c]['exento'];}
            $this->exentos+=$data[$c]['exento'];
            $this->Cell($w[12],3,number_format($data[$c]['exento'],2,',','.'),'LR',0,'R',$fill);//EXCENTO
            //$this->Cell($w[12],3,$data[$c]['orden_fecha'],'LR',0,'R',$fill);//EXCENTO
        }else{
            $this->Cell($w[12],3,'','LR',0,'R',$fill);//EXCENTO
        }
        

                    # si es RET suelta no se coloca base
                 if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                         $this->Cell($w[13],3,'','LR',0,'R',$fill);//BASE
                 }else{     
                        if($data[$c]['tipo']=='NC'&& $data[$c]['st']!='A'){$notas_credito+=$data[$c]['base'];} //ACUMULADOR para NC
                        if($data[$c]['tipo']=='FAC' && $data[$c]['st']!='A'){
                                                        if(trim($data[$c]['condi'])==0){  
                                                                                            $ventas_contado+=$data[$c]['base'];
                                                                                            $IVA_ventas_contado+=$data[$c]['iva'];
                                                                                        }else{
                                                                                            $ventas_credito+=$data[$c]['base'];
                                                                                            $IVA_ventas_credito+=$data[$c]['iva'];
                                                                                                }
                                                     
                                                    } //ACUMULADOR para NC
                        $base_temp=$data[$c]['base'];
                        if($data[$c]['tipo']=='ND'){$base_temp=$data[$c]['base']-$data[$c]['iva'];}
                        if(isset($data[$c]['exento'])&&trim($data[$c]['exento'])>0){
                                if($data[$c]['tipo']=='FAC'&&isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A' &&$data[$c]['exento']!=$data[$c]['base']){
                                    // cuando es exento la nd 
                                      $this->Cell($w[13],3,number_format($data[$c]['base']-$data[$c]['exento'],2,',','.'),'LR',0,'R',$fill);//BASE
                 
                                }else{

                                      $this->Cell($w[13],3,"",'LR',0,'R',$fill);//BASE
                    
                                }
                        }else{
                                # la base en caso que tenga un exento y tambien tenga productos sin exento
                                if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A' ){
                                    if ($data[$c]['base']-$data[$c]['exento']==0) {
                                          $this->Cell($w[13],3,'','LR',0,'R',$fill);//BASE
                                    }else{
                                        $this->Cell($w[13],3,number_format($data[$c]['base']-$data[$c]['exento'],2,',','.'),'LR',0,'R',$fill);//BASE
                                    }
                                }else{
                                    $this->Cell($w[13],3,number_format($base_temp,2,',','.'),'LR',0,'R',$fill);//BASE   
                                }
                        }
                    }
        $this->Cell($w[14],3,$data[$c]['%'],'LR',0,'C',$fill);//% de IVA
            if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0' ){
                            if($data[$c]['iva']==0){

                                $this->Cell($w[15],3,'','LR',0,'R',$fill);// IVA
                            }else{

                                $this->Cell($w[15],3,number_format($data[$c]['iva'],2,',','.'),'LR',0,'R',$fill);// IVA
                            }
            }else{                         
                        if(trim($data[$c]['iva'])=='0'){
                            $this->Cell($w[15],3,'','LR',0,'R',$fill);// IVA
                          }else{
                                $this->Cell($w[15],3,number_format($data[$c]['iva'],2,',','.'),'LR',0,'R',$fill);// IVA
                            }   
            }

            #ACUMULADORES DE IVA SEGUN EL TIPO
            if($data[$c]['tipo']=='NC'&& $data[$c]['st']!='A'){$IVA_notas_credito+=$data[$c]['iva'];}

        #en caso que tenga retencion
            if($data[$c]['retencion']){
                    #acumulador de reencion en caso que no este anulada
                    if($data[$c]['st']!='A'){
                        if($data[$c]['tipo']=='RISL'){
                                $retenciones_islr+=$data[$c]['retencion'][0]['monto'];   
                        }else{
                             $retenciones+=$data[$c]['retencion'][0]['monto'];   
                            }                         
                    }

                    $this->Cell($w[16],3,number_format(trim($data[$c]['retencion'][0]['monto']),2,',','.') ,'LR',0,'R',$fill);
            }else{
                    if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                        //$cant_ret=str_replace(',', '.', $data[$c]['monto']);
                        if($data[$c]['tipo']=='RISL'){
                                $retenciones_islr+=$data[$c]['monto'];   
                        }else{
                                $retenciones+=$data[$c]['monto'];
                        }
                        $this->Cell($w[16],3,number_format(trim($data[$c]['monto']),2,',','.'),'LR',0,'R',$fill);
                    }else{
                        $this->Cell($w[16],3,'','LR',0,'C',$fill);   
                    }

            }
        #en CASO de ANULACION
            if($data[$c]['st']=='A'){
                    $fecha=$data[$c]['fecanul'];
                    $y=substr($fecha, 0,4);
                    $m=substr($fecha, 4,2);
                    $d=substr($fecha, -2,2);
                $this->Cell($w[17],3,$d.'/'.$m.'/'.$y,'LR',0,'C',$fill);
            }else{
                $this->Cell($w[17],3,'','LR',0,'C',$fill);
            }
                $this->Cell($w[18],3,$data[$c]['tipo'],'LR',0,'C',$fill);



        $this->Ln(); $fill = !$fill;

    }//fin de for
    
    $this->Cell(array_sum($w),0,'','T');
    $this->SetFont('Courier','B',12);
    $retenciones=str_replace('-', '', $retenciones);
    /*
    $this->Write(5,'FAC a CREDITO) Monto VENTAS  : '.number_format($ventas_credito,2,',','.')."\t\t\tIVA CREDITO: ".number_format($IVA_ventas_credito,2,',','.') ); $this->Ln();
    $this->Write(5,'FAC a CONTADO) Monto VENTAS  : '.number_format($ventas_contado,2,',','.')."\t\tIVA CONTADO: ".number_format($IVA_ventas_contado,2,',','.') ); $this->Ln();
    $this->Write(5,'ND) Monto en NOTAS de DEBITO : '.number_format($notas_debito,2,',','.')  ."\t\t\t\t\t\t\t\t\tIVA en ND..: ".number_format($IVA_notas_debito,2,',','.')); $this->Ln();
    $this->Write(5,'NC) Monto en Notas de CREDITO: '.number_format($notas_credito,2,',','.') ."\t\t\t\tIVA de NC......: ".number_format($IVA_notas_credito,2,',','.') ); $this->Ln();
    $this->Write(5,'Monto en Retenciones.........: '.number_format($retenciones,2,',','.')); $this->Ln();
   */ 

     if($this->GetY()>141){ $this->final=TRUE;
                            $this->AddPage(); $this->membrete_Tabla_fac_ventas($w,$mes,$year);
                            }
    $this->detalle_libro_ventas_dideco($ventas_credito, $ventas_contado, $notas_credito, $notas_debito, $retenciones,$retenciones_islr,$IVA_ventas_credito,$IVA_ventas_contado,$IVA_notas_credito,$IVA_notas_debito );
}




function tabla_libro_ventas2($data,$mes,$year,$empresa){

    // Header
    $w = array(8,13, 10,15, 15,10,11,13,22,17,85,17,17,17,7,17,17,15,13);
    $x=5;
    // Data
    $fill = false;
    $this->SetFont('Courier','',10);
    # ACUMULADORES
    $retenciones=0;
    $notas_credito=0; $IVA_notas_credito=0;
    $notas_debito=0; $IVA_notas_debito=0;
    $ventas_contado=0; $IVA_ventas_contado=0; 
    $ventas_credito=0; $IVA_ventas_credito=0;
    $retenciones_islr=0;
    $this->exentos=0;
    
    $this->membrete_Tabla_fac_ventas2($w,$mes,$year,$empresa);  
        for($c=0 ; $c < count($data) ; $c++)
    {                       $mA=100;

                               if($data[$c]['st']=='A'){
                                    $fecha_anulacion=$data[$c]['fecanul'];
                                    $yA=substr($fecha_anulacion, 0,4);
                                    $mA=substr($fecha_anulacion, 4,2);
                                    $dA=substr($fecha_anulacion, -2,2);
                                }
        if($this->GetY()==192){   $this->Cell(array_sum($w),0,'','T');  $this->AddPage(); $this->membrete_Tabla_fac_ventas2($w,$mes,$year,$empresa);  }

                //var_dump($data[$c]['%']); exit();
               # Guardo los % de IVAS
               # Preparacion del Resumen
                //var_dump($data[$c]['%']); exit();
                if(isset($this->ivas[$data[$c]['%']])){
                    
                        #si es NC
                               // var_dump($mA); exit();
                        if($data[$c]['tipo']=='NC' && $mA>$mes ){

                            if(isset($this->detalle['NC'][$data[$c]['%']])){

                                                $this->detalle['NC'][$data[$c]['%']]+=$data[$c]['iva'];
                                     
                                     if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0' ){
                                                $this->detalle['NC']['base'.$data[$c]['%']]+=$data[$c]['base']-$data[$c]['exento'];
                                        }else{
                                                $this->detalle['NC']['base'.$data[$c]['%']]+=$data[$c]['base'];  
                                        }
                                  }else{
                                         $this->detalle['NC'][$data[$c]['%']]=$data[$c]['iva']; 
                                         #en caso de ser excento la base cambia
                                        if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0' ){
                                                $this->detalle['NC']['base'.$data[$c]['%']]=$data[$c]['base']-$data[$c]['exento'];
                                        }else{
                                                $this->detalle['NC']['base'.$data[$c]['%']]=$data[$c]['base'];   
                                        }
                                      }
                        }//cierre si es una NC
                        # NC <<<<<<<<<<<<<<<<<<<<<<<
                }else{
                        $this->ivas[$data[$c]['%']]=$data[$c]['%'];
                        #si es NC
                        if($data[$c]['tipo']=='NC' && $mA>$mes ){
                            $this->detalle['NC'][$data[$c]['%']]=$data[$c]['iva'];
                            #en caso de ser excento la base cambia
                            if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A'){
                                    $this->detalle['NC']['base'.$data[$c]['%']]=$data[$c]['base']-$data[$c]['exento'];
                            }else{
                                    $this->detalle['NC']['base'.$data[$c]['%']]=$data[$c]['base'];   
                            }
                        }

                }// CIERRE DE IF y ELSE de los IVAS


                # - - - - - - - - - - - - - - - - #
                # INICIO de CREACION de la TABLA  #
                # - - - - - - - - - - - - - - - - #
        $this->Cell($w[0],3,$c+1,'LR',0,'C',$fill);
        # LA FECHA SE MUESTRA FECHSIT EN CASO DE RETENCION FUERA DE MES
          $this->Cell($w[1],3,$data[$c]['fecemi'],'LR',0,'C',$fill);
                    
        
        # SI ES UNA FACTURA
        if($data[$c]['tipo']=='FAC'){
            if(trim($data[$c]['condi'])==0){
            $this->Cell($w[2],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//COLUMNA Nro DOC    
            
            }else{
            $this->Cell($w[2],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//COLUMNA Nro DOC

            }
        }
        # en caso de ser NOTA de DEBIO o Credito
        if($data[$c]['tipo']=='ND'||$data[$c]['tipo']=='NC'||$data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
            $this->Cell($w[2],3,'','LR',0,'C',$fill);//COLUMNA Nro DOC
                if($data[$c]['tipo']=='ND'&& $data[$c]['st']!='A'){ 
                                                $notas_debito+=($data[$c]['base']-$data[$c]['iva']);
                                                $IVA_notas_debito+=$data[$c]['iva'];
                                             } 
            }
        # SI ES UNA RETENCION FUERA DEL MES
        /*if($data[$c]['tipo']=='RET'){
            $this->Cell($w[2],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//COLUMNA Nro DOC
        }*/
        
            # imprimo el control si no es una retencion
            if($data[$c]['tipo']!='RET'){
                $this->Cell($w[3],3,$data[$c]['control'],'LR',0,'C',$fill);
            }else{
                $this->Cell($w[ 3],3,'','LR',0,'C',$fill);
                }
            # si tipo es NC (NOTA de CREDITO)
             if($data[$c]['tipo']=='NC'){
                    $this->Cell($w[4],3,$data[$c]['numdoc'],'LR',0,'C',$fill);

             }else{
                    $this->Cell($w[4],3,'','LR',0,'C',$fill);
             }
            # si tipo es ND (NOTA de DEBITO)
            if($data[$c]['tipo']=='ND'){
                    $this->Cell($w[5],3,$data[$c]['numdoc'],'LR',0,'C',$fill);//columna nota de DEBITO
            }else{
                    $this->Cell($w[5],3,'','LR',0,'C',$fill);//columna nota de DEBITO
            }

            #SI es FAC no se imprime doc REFE
            if($data[$c]['tipo']=='FAC'){
                $this->Cell($w[6],3,'','LR',0,'C',$fill);
            
            }else{
                    $this->Cell($w[6],3,$data[$c]['docref'],'LR',0,'C',$fill);
            }
            #en caso que tenga retencion
            if($data[$c]['retencion']){
                $this->Cell($w[7],3,$data[$c]['retencion'][0]['fecemi'],'LR',0,'C',$fill);
                $this->Cell($w[8],3,$data[$c]['retencion'][0]['control'],'LR',0,'C',$fill);
            }else{
                 if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                    $this->Cell($w[7],3,$data[$c]['fecemi'],'LR',0,'C',$fill);
                    $this->Cell($w[8],3,$data[$c]['control'],'LR',0,'C',$fill);
                }else{

                        $this->Cell($w[7],3,'','LR',0,'C',$fill);
                        $this->Cell($w[8],3,'','LR',0,'C',$fill);   
                }
            }   

        $this->Cell($w[9],3,$data[$c]['rif'],'LR',0,'C',$fill);
        $this->Cell($w[10],3,$data[$c]['razsoc'],'LR',0,'L',$fill);
        if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                         $this->Cell($w[11],3,'','LR',0,'R',$fill);//MONTO CON IVA
                 }else{
                        //si la BASE (-)menos IVA == BASE es porque la base ya incluye el iva en hische 
                   $base_comparativa=$data[$c]['base']/'1.'.$data[$c]['%'];
                   $base_=explode('.',$base_comparativa);
                   $base_full_comparativa=explode('.',$data[$c]['base']+$data[$c]['iva']); 
                    if($base_[0]!=$base_full_comparativa[0]&&$data[$c]['tipo']=='ND'){
                        $this->Cell($w[11],3,number_format($data[$c]['base'],2,',','.'),'LR',0,'R',$fill);//MONTO CON IVA
                    }else{
                        $this->Cell($w[11],3,number_format($data[$c]['base']+$data[$c]['iva'],2,',','.'),'LR',0,'R',$fill);//MONTO CON IVA    
                        //$this->Cell($w[11],3,$base_[0]."/".($base_full_comparativa[0]),'LR',0,'R',$fill);//MONTO CON IVA    
                        }


                    }
        #para los exentos
        if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A'){
            if($data[$c]['tipo']=='NC'){
                $this->exentos_nc+=$data[$c]['exento'];
                #acumulador para el detalle en caso de varios IVAS
                if(isset($this->detalle['NC']['exento'.$data[$c]['%']])){
                    $this->detalle['NC']['exento'.$data[$c]['%']]+=$data[$c]['exento'];
                }else{
                    $this->detalle['NC']['exento'.$data[$c]['%']]=$data[$c]['exento'];
                }
            }
            if($data[$c]['tipo']=='ND'){$this->exentos_nd+=$data[$c]['exento'];}
            if($data[$c]['tipo']=='FAC'&&trim($data[$c]['condi'])==0){$this->exentos_fac_contado+=$data[$c]['exento'];}
            if($data[$c]['tipo']=='FAC'&&trim($data[$c]['condi'])!=0){$this->exentos_fac_credito+=$data[$c]['exento'];}
            $this->exentos+=$data[$c]['exento'];
            $this->Cell($w[12],3,number_format($data[$c]['exento'],2,',','.'),'LR',0,'R',$fill);//EXCENTO
            //$this->Cell($w[12],3,$data[$c]['orden_fecha'],'LR',0,'R',$fill);//EXCENTO
        }else{
            $this->Cell($w[12],3,'','LR',0,'R',$fill);//EXCENTO
             #acumulador para el detalle en caso de varios IVAS en caso que no haya exentos
                if(isset($this->detalle['NC']['exento'.$data[$c]['%']])){
                    $this->detalle['NC']['exento'.$data[$c]['%']]+=0;
                }else{
                    $this->detalle['NC']['exento'.$data[$c]['%']]=0;
                }
        }
        

                    # si es RET suelta no se coloca base
                 if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                         $this->Cell($w[13],3,'','LR',0,'R',$fill);//BASE
                 }else{     
                        if($data[$c]['tipo']=='NC'&& $data[$c]['st']!='A'){$notas_credito+=$data[$c]['base'];} //ACUMULADOR para NC
                        if($data[$c]['tipo']=='FAC' && $data[$c]['st']!='A'){
                                                        if(trim($data[$c]['condi'])==0){  
                                                                                            $ventas_contado+=$data[$c]['base'];
                                                                                            $IVA_ventas_contado+=$data[$c]['iva'];
                                                                                        }else{
                                                                                            $ventas_credito+=$data[$c]['base'];
                                                                                            $IVA_ventas_credito+=$data[$c]['iva'];
                                                                                                }
                                                     
                                                    } //ACUMULADOR para NC
                        $base_temp=$data[$c]['base'];
                        if($data[$c]['tipo']=='ND'){$base_temp=$data[$c]['base']-$data[$c]['iva'];}
                        if(isset($data[$c]['exento'])&&trim($data[$c]['exento'])>0){
                                if($data[$c]['tipo']=='FAC'&&isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A' &&$data[$c]['exento']!=$data[$c]['base']){
                                    // cuando es exento la nd 
                                      $this->Cell($w[13],3,number_format($data[$c]['base']-$data[$c]['exento'],2,',','.'),'LR',0,'R',$fill);//BASE
                 
                                }else{

                                      $this->Cell($w[13],3,"",'LR',0,'R',$fill);//BASE
                    
                                }
                        }else{
                                # la base en caso que tenga un exento y tambien tenga productos sin exento
                                if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0'  && $data[$c]['st']!='A' ){
                                    if ($data[$c]['base']-$data[$c]['exento']==0) {
                                          $this->Cell($w[13],3,'','LR',0,'R',$fill);//BASE
                                    }else{
                                        $this->Cell($w[13],3,number_format($data[$c]['base']-$data[$c]['exento'],2,',','.'),'LR',0,'R',$fill);//BASE
                                    }
                                }else{
                                    $this->Cell($w[13],3,number_format($base_temp,2,',','.'),'LR',0,'R',$fill);//BASE   
                                }
                        }
                    }
                $this->Cell($w[14],3,$data[$c]['%'],'LR',0,'C',$fill);//% de IVA


            if(isset($data[$c]['exento']) && trim($data[$c]['exento'])!='0' ){
                            if($data[$c]['iva']==0){

                                $this->Cell($w[15],3,'','LR',0,'R',$fill);// IVA
                            }else{

                                $this->Cell($w[15],3,number_format($data[$c]['iva'],2,',','.'),'LR',0,'R',$fill);// IVA
                            }
            }else{                         
                        if(trim($data[$c]['iva'])=='0'){
                            $this->Cell($w[15],3,'','LR',0,'R',$fill);// IVA
                          }else{
                                $this->Cell($w[15],3,number_format($data[$c]['iva'],2,',','.'),'LR',0,'R',$fill);// IVA
                            }   
            }

            #ACUMULADORES DE IVA SEGUN EL TIPO
            if($data[$c]['tipo']=='NC'&& $data[$c]['st']!='A'){$IVA_notas_credito+=$data[$c]['iva'];}

        #en caso que tenga retencion
            if($data[$c]['retencion']){
                    #acumulador de reencion en caso que no este anulada
                    if($data[$c]['st']!='A'){
                        if($data[$c]['tipo']=='RISL'){
                                $retenciones_islr+=$data[$c]['retencion'][0]['monto'];   
                        }else{
                             $retenciones+=$data[$c]['retencion'][0]['monto'];   
                            }                         
                    }

                    $this->Cell($w[16],3,number_format(trim($data[$c]['retencion'][0]['monto']),2,',','.') ,'LR',0,'R',$fill);
            }else{
                    if($data[$c]['tipo']=='RET'||$data[$c]['tipo']=='RISL'){
                        //$cant_ret=str_replace(',', '.', $data[$c]['monto']);
                        if($data[$c]['tipo']=='RISL'){
                                $retenciones_islr+=$data[$c]['monto'];   
                        }else{
                                $retenciones+=$data[$c]['monto'];
                        }
                        $this->Cell($w[16],3,number_format(trim($data[$c]['monto']),2,',','.'),'LR',0,'R',$fill);
                    }else{
                        $this->Cell($w[16],3,'','LR',0,'C',$fill);   
                    }

            }
        #en CASO de ANULACION && $mA>$mes
            //if($data[$c]['st']=='A'){
              if($data[$c]['st']=='A'){
                    $fecha=$data[$c]['fecanul'];
                    $y=substr($fecha, 0,4);
                    $m=substr($fecha, 4,2);
                    $d=substr($fecha, -2,2);
                    if($m>$mes){
                        $this->Cell($w[17],3,'','LR',0,'C',$fill);
                    }else{
                          $this->Cell($w[17],3,$d.'/'.$m.'/'.$y,'LR',0,'C',$fill);   
                    }
            }else{
                $this->Cell($w[17],3,'','LR',0,'C',$fill);
            }
                $this->Cell($w[18],3,$data[$c]['tipo'],'LR',0,'C',$fill);



        $this->Ln(); $fill = !$fill;

    }//fin de for
    
    $this->Cell(array_sum($w),0,'','T');
    $this->SetFont('Courier','B',12);
    $retenciones=str_replace('-', '', $retenciones);
    /*
    $this->Write(5,'FAC a CREDITO) Monto VENTAS  : '.number_format($ventas_credito,2,',','.')."\t\t\tIVA CREDITO: ".number_format($IVA_ventas_credito,2,',','.') ); $this->Ln();
    $this->Write(5,'FAC a CONTADO) Monto VENTAS  : '.number_format($ventas_contado,2,',','.')."\t\tIVA CONTADO: ".number_format($IVA_ventas_contado,2,',','.') ); $this->Ln();
    $this->Write(5,'ND) Monto en NOTAS de DEBITO : '.number_format($notas_debito,2,',','.')  ."\t\t\t\t\t\t\t\t\tIVA en ND..: ".number_format($IVA_notas_debito,2,',','.')); $this->Ln();
    $this->Write(5,'NC) Monto en Notas de CREDITO: '.number_format($notas_credito,2,',','.') ."\t\t\t\tIVA de NC......: ".number_format($IVA_notas_credito,2,',','.') ); $this->Ln();
    $this->Write(5,'Monto en Retenciones.........: '.number_format($retenciones,2,',','.')); $this->Ln();
   */ 

     if($this->GetY()>140){ $this->final=TRUE;
                            $this->AddPage(); $this->membrete_Tabla_fac_ventas2($w,$mes,$year,$empresa);
                            }
    $this->detalle_libro_ventas_dideco($ventas_credito, $ventas_contado, $notas_credito, $notas_debito, $retenciones,$retenciones_islr,$IVA_ventas_credito,$IVA_ventas_contado,$IVA_notas_credito,$IVA_notas_debito );
}


function detalle_libro_ventas_dideco($ventas_credito, $ventas_contado, $notas_credito, $notas_debito, $retenciones,$retenciones_islr,$IVA_ventas_credito,$IVA_ventas_contado,$IVA_notas_credito,$IVA_notas_debito )
{

    $total_general_gravable=0;
    $total_general_iva=0;
    $total_general_exento=0;

    $TOTAL_IVA=$IVA_ventas_contado+$IVA_ventas_credito+$IVA_notas_debito+$IVA_notas_credito;
    $TOTAL_BASES=$ventas_credito+$ventas_contado+$notas_debito+$notas_credito;

    $total_general_gravable=($ventas_credito-$this->exentos_fac_credito)+($ventas_contado-$this->exentos_fac_contado)+($notas_debito-$this->exentos_nd);
    $total_general_iva=$IVA_ventas_credito+$IVA_ventas_contado+$IVA_notas_debito;
    $total_general_exento=($this->exentos_fac_credito+$this->exentos_fac_contado);
    $contenido=array(
                        array('SUB-TOTAL VENTAS A CREDITO',number_format($ventas_credito-$this->exentos_fac_credito,2,',','.'),number_format($IVA_ventas_credito,2,',','.'),number_format($this->exentos_fac_credito,2,',','.'),number_format($ventas_credito+$IVA_ventas_credito,2,',','.')),
                        array('SUB-TOTAL VENTAS A CONTADO',number_format($ventas_contado-$this->exentos_fac_contado,2,',','.'),number_format($IVA_ventas_contado,2,',','.'),number_format($this->exentos_fac_contado,2,',','.'),number_format($ventas_contado+$IVA_ventas_contado,2,',','.')), 
                        array('SUB-TOTAL NOTAS DE DEBITO  (12%)',number_format($notas_debito-$this->exentos_nd,2,',','.'),number_format($IVA_notas_debito,2,',','.'),'0.00',number_format($notas_debito+$IVA_notas_debito,2,',','.')),
                        //array('SUB-TOTAL NOTAS DE CREDITO (12%)',number_format($notas_credito-$this->exentos_nc,2,',','.'),number_format($IVA_notas_credito,2,',','.'),number_format($this->exentos_nc,2,',','.'),number_format($notas_credito+$IVA_notas_credito,2,',','.')),
                        array('- - - - - - - - - - - - - - - - - - - - - - - - - - - - ','- - - - - - - - - ','- - - - - - - - - ','- - - - - - - - - ','- - - - - - - - - '),
                        array('TOTAL GENERAL LIBRO MOVIMIENTOS EN VENTAS',number_format( $TOTAL_BASES-$this->exentos ,2,',','.'),number_format( $TOTAL_IVA,2,',','.'),number_format($this->exentos,2,',','.'),number_format($TOTAL_BASES+$TOTAL_IVA,2,',','.')),
                        array('TOTAL RETENCIONES IMPUESTO FISCAL...(75%)','','','',number_format( $retenciones,2,',','.')),
                        array('TOTAL RETENCIONES ISLR','','','',$retenciones_islr)
                    );
    // Header
    $w = array(120,40,40,40,40);
    $this->SetFillColor(50,50,50); // 255 0 0 >ROJO
    $this->SetTextColor(255); // 255-> BLANCO
    $this->SetDrawColor(0,0,0);//128,0,0->Rojo
    $this->SetLineWidth(.2);//->grosor de linea Verticales
    $header=array(strtoupper('Descripcion'),'Monto Gravable','IVA','Monto Exento','Monto TOTAL'); 
    $x=5;
    $this->SetX($x);
    $this->SetY($this->GetY()+10);
    // Data
    $this->SetFont('Courier','B',12);

        foreach ($header as $key=>$value) {
                $this->Cell($w[$key],7,$value,'LR',0,'C',true);
        }
        $this->Ln();

    $this->SetFont('Courier','',12);
        #CIERRE DE CABECERA
        #INICIO de CONTENIDO
        $this->SetTextColor(0); // 255-> BLANCO
        $fill=false; 
            $this->Cell($w[0],5,$contenido[0][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[0][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[0][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[0][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,$contenido[0][4],'LR',0,'R',$fill);
            $this->Ln();

            $this->Cell($w[0],5,$contenido[1][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[1][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[1][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[1][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,$contenido[1][4],'LR',0,'R',$fill);
            $this->Ln();


            $this->Cell($w[0],5,$contenido[2][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[2][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[2][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[2][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,$contenido[2][4],'LR',0,'R',$fill);
            $this->Ln();
            
            /*
            $this->Cell($w[0],5,$contenido[3][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[3][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[3][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[3][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,$contenido[3][4],'LR',0,'R',$fill);
            $this->Ln();
            */
//var_dump($this->ivas); exit();
        foreach ($this->ivas as $key) {
//            var_dump($this->detalle['NC']); exit();
            if(isset($this->detalle['NC']['base'.$key])){

                $total_general_gravable+=$this->detalle['NC']['base'.$key];
                $total_general_iva+=$this->detalle['NC'][$key];
                $total_general_exento+=$this->detalle['NC']['exento'.$key];
                
                $this->Cell($w[0],5,'SUB-TOTAL NOTAS DE CREDITO ('.$key.'%)','LR',0,'L',$fill);
                $this->Cell($w[1],5,number_format( $this->detalle['NC']['base'.$key],2,',','.'),'LR',0,'R',$fill);
                $this->Cell($w[2],5,number_format( $this->detalle['NC'][$key],2,',','.'),'LR',0,'R',$fill);
                $this->Cell($w[3],5,number_format( $this->detalle['NC']['exento'.$key],2,',','.'),'LR',0,'R',$fill);
                $this->Cell($w[4],5,number_format( ($this->detalle['NC'][$key]+$this->detalle['NC']['base'.$key]+$this->detalle['NC']['exento'.$key]),2,',','.'),'LR',0,'R',$fill);
                $this->Ln();       
            }
            //$this->Write(5,"IVA: ".$key. " NC base:".$this->detalle['NC']['base'.$key]. " IVA:".$this->detalle['NC'][$key]. " excento:".$this->detalle['NC']['exento'.$key]." TOTAL:".($this->detalle['NC'][$key]+$this->detalle['NC']['base'.$key]-$this->detalle['NC']['exento'.$key]) );     
           
        }


            $this->Cell($w[0],5,$contenido[3][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[3][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[3][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[3][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,$contenido[3][4],'LR',0,'R',$fill);
            $this->Ln();

            $this->Cell($w[0],5,$contenido[4][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,number_format($total_general_gravable,2,',','.'),'LR',0,'R',$fill);
            $this->Cell($w[2],5,number_format($total_general_iva,2,',','.'),'LR',0,'R',$fill);
            $this->Cell($w[3],5,number_format($total_general_exento,2,',','.'),'LR',0,'R',$fill);
            $this->Cell($w[4],5,number_format(($total_general_gravable+$total_general_iva),2,',','.'),'LR',0,'R',$fill);
            $this->Ln();

            $this->Cell($w[0],5,$contenido[5][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[5][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[5][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[5][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,$contenido[5][4],'LR',0,'R',$fill);
            $this->Ln();

            # si islr es 0 no se imprime
            if(trim($contenido[6][4])!=0){
            $this->Cell($w[0],5,$contenido[6][0],'LR',0,'L',$fill);
            $this->Cell($w[1],5,$contenido[6][1],'LR',0,'R',$fill);
            $this->Cell($w[2],5,$contenido[6][2],'LR',0,'R',$fill);
            $this->Cell($w[3],5,$contenido[6][3],'LR',0,'R',$fill);
            $this->Cell($w[4],5,number_format($contenido[6][4],2,',','.'),'LR',0,'R',$fill);
            $this->Ln();   
            }


    $this->Cell(array_sum($w),0,'','T');
    $this->Ln();
        /*
        foreach ($this->ivas as $key) {

            $this->Write(5,"IVA: ".$key. " NC base:".$this->detalle['NC']['base'.$key]. " IVA:".$this->detalle['NC'][$key]. " excento:".$this->detalle['NC']['exento'.$key]." TOTAL:".($this->detalle['NC'][$key]+$this->detalle['NC']['base'.$key]-$this->detalle['NC']['exento'.$key]) );     
            $this->Ln();  
        }*/


      //  foreach ($this->detalle as $key => $value ) {
            //key es NC o FAC  la posicion del tipo
            //$this->Write(5,"detalle $key: ".$this->detalle[$key]);
                /*foreach ($value as $porcentaje_IVA=>$x) {
                 $this->Write(5,"%IVA: ".$x);$this->Ln(); 
                }*/
      //      foreach ($this->detalle[$key] as $llave => $o) {
      //          $this->Write(5," detalle $key ".number_format( $o,2,',','.').": ".$llave);   $this->Ln();  
      //      }
      //   }

    //$this->Write(5,"EXENTOS: ".$this->exentos);

        
}

function Tabla_fac_ventas($header, $data,$mes,$year)
{
    // Header
    $w = array(8,13, 10,15, 20,20,20,15,28,17,85,17,17,17,7,17,17);
    $x=5;
       //$this->membrete_Tabla_fac_ventas($w); 

    // Data
    $fill = false;

    $this->SetFont('Courier','',10);


          $this->membrete_Tabla_fac_ventas($w,$mes,$year);  
    for($c=0 ; $c < count($data) ; $c++)
    {  
        //if($this->GetY()<37)  {   $this->membrete_Tabla_fac_ventas($w,$mes,$year);   }
        if($this->GetY()==192){   $this->Cell(array_sum($w),0,'','T');  $this->AddPage(); $this->membrete_Tabla_fac_ventas($w,$mes,$year);  }

        $palabras=explode(' ', trim($data[$c][8]));

        # SI LA CADENA PASA DE 40 CARACTERES
        if(strlen(trim($data[$c][8]))>60){

                    $primera_linea="";$segunda_linea="";
                    for($p=0;$p<count($palabras);$p++){
                        if($p<6){
                            $primera_linea.=$palabras[$p].' ';
                        }else{
                            $segunda_linea.=$palabras[$p].' ';
                        }
                    }// fin del for llenado de lineas

                        # PRIMERA LINEA
                            $this->Cell($w[0],3,$c+1,'LR',0,'C',$fill);
                            $this->Cell($w[1],3,$data[$c][0],'LR',0,'C',$fill);
                            $this->Cell($w[2],3,$data[$c][1],'LR',0,'C',$fill);
                            $this->Cell($w[3],3,$data[$c][2],'LR',0,'C',$fill);
                            $this->Cell($w[4],3,$data[$c][3],'LR',0,'C',$fill);
                            $this->Cell($w[5],3,$data[$c][4],'LR',0,'C',$fill);
                            $this->Cell($w[6],3,$data[$c][5],'LR',0,'C',$fill);
                                if(isset($data[$c]['control_comprobante'])){
                                        $this->Cell($w[7],3,$data[$c]['fecemi_comprobante'],'LR',0,'C',$fill);
                                        $this->Cell($w[8],3,$data[$c]['control_comprobante'],'LR',0,'C',$fill);
                                }else{
                                        $this->Cell($w[7],3,'','LR',0,'C',$fill);   
                                        $this->Cell($w[8],3,'','LR',0,'C',$fill);   
                                }
                            //$this->Cell($w[8],3,$data[$c][6],'LR',0,'C',$fill); 
                            $this->Cell($w[9],3,$data[$c][7],'LR',0,'C',$fill); 
                            /*
                            $this->Cell($w[8],3,$data[$c][8],'LR',0,'C',$fill); 
                            $this->Cell($w[9],3,$primera_linea ,'L',0,'L',$fill);  
                            $this->Cell($w[10],3,number_format($data[$c][10],2,',','.').'/'.$c  ,'R',0,'R',$fill); 
                           */
                            $this->Cell($w[10], 3,$primera_linea,'LR',0,'L',$fill); 
                            $this->Cell($w[11], 3,number_format($data[$c][9],2,',','.') ,'LR',0,'R',$fill); 
                            $this->Cell($w[12],3,number_format($data[$c][10],2,',','.') ,'LR',0,'R',$fill); 
                            $this->Cell($w[13],3,number_format($data[$c][11],2,',','.') ,'LR',0,'R',$fill);
                            $this->Cell($w[14],3,$data[$c][12],'LR',0,'C',$fill); 
                            $this->Cell($w[15],3,number_format($data[$c][13],2,',','.') ,'LR',0,'R',$fill);
                            //$this->Cell($w[16],3,'','LR',0,'R',$fill);

                                if(isset($data[$c]['monto_retenido'])){
                                        $this->Cell($w[16],3,number_format($data[$c]['monto_retenido'],2,',','.') ,'LR',0,'R',$fill);
                                }else{
                                        $this->Cell($w[16],3,'','LR',0,'R',$fill);
 
                                }
                            $this->Ln();
                        # FIN PRIMERA LINEA

                        // - * - * - * - * - * - * - * - * - * - * - * 
                            if(strlen($segunda_linea)>0){

                                    # SEGUNDA LINEA                    
                                        $this->Cell($w[0],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[1],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[2],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[3],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[4],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[5],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[6],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[7],3,'','LR',0,'C',$fill);
                                        $this->Cell($w[8],3,'','LR',0,'C',$fill); 
                                        $this->Cell($w[9],3,'','LR',0,'C',$fill); 
                                        $this->Cell($w[10],3,$segunda_linea,'LR',0,'L',$fill); 
                                        $this->Cell($w[11],3,'' ,'LR',0,'R',$fill);  
                                        $this->Cell($w[12],3,'' ,'LR',0,'R',$fill); 
                                        $this->Cell($w[13],3,'' ,'LR',0,'R',$fill); 
                                        $this->Cell($w[14],3,'' ,'LR',0,'R',$fill);
                                        $this->Cell($w[15],3,'' ,'LR',0,'R',$fill);
                                        $this->Cell($w[16],3,'' ,'LR',0,'R',$fill);

                          
                                        $this->Ln();
                                    # FIN SEGUNDA LINEA
           
                            }
                    

        }else{
                $this->Cell($w[0],3,$c+1,'LR',0,'C',$fill);
                $this->Cell($w[1],3,$data[$c][0],'LR',0,'C',$fill);
                $this->Cell($w[2],3,$data[$c][1],'LR',0,'C',$fill);
                $this->Cell($w[3],3,$data[$c][2],'LR',0,'C',$fill);
                $this->Cell($w[4],3,$data[$c][3],'LR',0,'C',$fill);
                $this->Cell($w[5],3,$data[$c][4],'LR',0,'C',$fill);
                $this->Cell($w[6],3,$data[$c][5],'LR',0,'C',$fill);
                                if(isset($data[$c]['control_comprobante'])){
                                        $this->Cell($w[7],3,$data[$c]['fecemi_comprobante'],'LR',0,'C',$fill);
                                        $this->Cell($w[8],3,$data[$c]['control_comprobante'],'LR',0,'C',$fill);
                                }else{
                                        $this->Cell($w[7],3,'','LR',0,'C',$fill); 
                                        $this->Cell($w[8],3,'','LR',0,'C',$fill);   
                                }
                //$this->Cell($w[8],3,$data[$c][6],'LR',0,'C',$fill); 
                $this->Cell($w[9],3,$data[$c][7],'LR',0,'C',$fill); 
                $this->Cell($w[10],3,$data[$c][8],'LR',0,'L',$fill); 
                $this->Cell($w[11], 3,number_format($data[$c][9],2,',','.') ,'LR',0,'R',$fill);
                $this->Cell($w[12],3,number_format($data[$c][10],2,',','.') ,'LR',0,'R',$fill);
                $this->Cell($w[13],3,number_format($data[$c][11],2,',','.') ,'LR',0,'R',$fill);
                $this->Cell($w[14],3,$data[$c][12],'LR',0,'C',$fill);
                $this->Cell($w[15],3,number_format($data[$c][13],2,',','.') ,'LR',0,'R',$fill);
                //$this->Cell($w[16],3,'','LR',0,'R',$fill);

                                if(isset($data[$c]['monto_retenido'])){
                                        $this->Cell($w[16],3,number_format($data[$c]['monto_retenido'],2,',','.') ,'LR',0,'R',$fill);
                                }else{
                                        $this->Cell($w[16],3,'','LR',0,'R',$fill);
 
                                }
                           
            
                $this->Ln();

        }
                /*
                if( $this->GetY()>178){                                    
                    //El Numero de Pagina       
                        #fuente
                        $this->SetFont('Arial','I',8);
                        $this->SetY(183);$this->SetX(290);
                        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
                        $this->Ln();
                     }*/

        $fill = !$fill;
    }
    $this->Cell(array_sum($w),0,'','T');


}



function TableDideco($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',8);
    // Header
    $this->SetY(27);
    $w = array(9, 8,8, 70, 10);
    for($i=0;$i<count($header);$i++){
     $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
       }   
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    $u=0;

    $this->SetFont('Courier','',8);

                    $y=32;
                    $x=105;
    foreach($data as $row)
    {
       $u++;
                if($u==71){
                        $this->Cell(array_sum($w),0,'','T');
                    $this->cabeceraTabla2($header);
                    $this->SetX($x);
                }
                if($u>71){
                    $this->SetX($x);
                }


        $this->Cell($w[0],4,$row[0],'LR',0,'C',$fill);
        $this->Cell($w[1],4,'','LR',0,'C',$fill);
        $this->Cell($w[2],4,$row[1],'LR',0,'C',$fill);
        $this->Cell($w[3],4,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[4],4,$row[3],'LR',0,'C',$fill);
        $this->Ln();

        $fill = !$fill;
    }

    //añadiendo los espacios en Blanco
    if($u<63){
        for ($o=$u; $o < 63; $o++) { 
              $this->SetX(5);

                        $this->Cell($w[0],4,'','LR',0,'L',$fill);
                        $this->Cell($w[1],4,'','LR',0,'L',$fill);
                        $this->Cell($w[2],4,'','LR',0,'L',$fill);
                        $this->Cell($w[3],4,'','LR',0,'R',$fill);
                        $this->Cell($w[4],4,'','LR',0,'R',$fill);
                        $this->Ln();
                        $fill = !$fill;
                }

    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
                

                    $this->ImpNroPaguinaDidecoDeimport();
}

function TableDeimport($header, $data)
{

 $x=113;
    $this->SetY(24);
    $this->SetX($x);
    $this->SetFont('','B',14);
    $this->Cell(0,0,'DEIMPORT');
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',8);
    $this->SetY(27);
    $this->SetX($x);
    // Header
    $w = array(9, 8,8, 63, 10);
    for($i=0;$i<count($header);$i++){
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);      
    }
        
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    $u=0;

    $this->SetFont('Courier','',8);

                    $y=32;
    foreach($data as $row)
    {
       $u++;

    $this->SetX($x);

        $this->Cell($w[0],4,$row[0],'LR',0,'C',$fill);
        $this->Cell($w[1],4,'','LR',0,'C',$fill);
        $this->Cell($w[2],4,$row[1],'LR',0,'C',$fill);
        $this->Cell($w[3],4,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[4],4,$row[3],'LR',0,'C',$fill);
        $this->Ln();

        $fill = !$fill;
    }
    
    //añadiendo los espacios en Blanco
    if($u<63){
        for ($o=$u; $o < 63; $o++) { 
              $this->SetX($x);

                        $this->Cell($w[0],4,'','LR',0,'L',$fill);
                        $this->Cell($w[1],4,'','LR',0,'L',$fill);
                        $this->Cell($w[2],4,'','LR',0,'L',$fill);
                        $this->Cell($w[3],4,'','LR',0,'R',$fill);
                        $this->Cell($w[4],4,'','LR',0,'R',$fill);
                        $this->Ln();
                        $fill = !$fill;
                }

    }
      

    $this->SetX($x);
    // Closing line
    $this->Cell(array_sum($w),0,'','T');


                    //$this->ImpNroPaguina();
}

}//fin de clase PDF