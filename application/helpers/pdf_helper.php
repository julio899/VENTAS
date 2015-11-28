<?php
 require_once('fpdf_helper.php');
 class PDF extends FPDF
{
public $compaTXT;
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
//$this->Cell(array_sum($w),0,'','T');
        #Establecemos los márgenes izquierda, arriba y derecha:
     
   // $this->AddPage();
    $razon="Mayorista de Confites y Viveres ( DIDECO, C.A.";
    $rif="J075168089";
    # MENBRETE
        #fuente
        $this->SetFont('Arial','IB',12);
    $this->Cell(0,5,$razon.' - '.$rif.' )',0,0,'C');
        $this->SetFont('Arial','I',8);
        $this->Ln();
    $this->Cell(0,4,'Libro de Ventas',0,0,'C');
        $this->Ln();
    $this->Cell(0,4,$this->txt_mes($mes).' - 20'.$year,0,0,'C');
       // $this->Ln();
    //$this->Cell(0,3, ,0,0,'C');
    $this->SetX(288);
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

    $header=array('#', 'FECHA','NRO.','NRO','NOTA','NOTA','DOC.','FECHA','COMPROBANTE','RIF','RAZON SOCIAL','MONTO','EXENTO','BASE','%','MONTO','MONTO'); 
    for($i=0;$i<count($header);$i++){

     $this->Cell($w[$i],3,$header[$i],0,0,'C',true);
       }   
    $this->Ln();
    $header=array('','DOC.','DOC.','CONTROL','CREDITO','DEBITO','REFER.','RETENCION','RETENCION IVA','','','CON IVA','','IMPONIBLE','IVA','IVA','RETENIDO'); 
    for($i=0;$i<count($header);$i++){

     $this->Cell($w[$i],3,$header[$i],0,0,'C',true);
       }   
    $this->Ln();
    
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
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
                                        $this->Cell($w[16],3,$data[$c]['monto_retenido'],'LR',0,'C',$fill);
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
                                        $this->Cell($w[16],3,$data[$c]['monto_retenido'],'LR',0,'C',$fill);
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

/* RESPALDO
    

function Table_Dideco_Deimport($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',8);
    // Header
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
                    $this->SetY($y);
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
    if($u<70){
        for ($o=$u; $o < 70; $o++) { 
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
                

                    $this->ImpNroPaguina();
}
*/

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