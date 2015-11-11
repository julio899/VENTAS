<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_clientes extends CI_Model {

function get_clientes(){
$this->load->database('dideco',TRUE);
//$sql="SELECT * FROM `01_cpc` WHERE `zona`<90";
$sql="SELECT `ciudades`.`nombre`,`estados`.`estado`,`01_cpc`.* FROM `01_cpc`,`ciudades`,`estados` WHERE `zona`<90 AND `01_cpc`.`codciud`= `ciudades`.`codciud` AND `ciudades`.`codesta`=`estados`.`codesta`"; //SELECT `ciudades`.`nombre`, `razsoc` FROM `01_cpc`,`ciudades` WHERE `01_cpc`.`codciud`= `ciudades`.`codciud`
$query=$this->db->query($sql);
$datos=null;
        foreach ($query->result() as $row)
                {
                	$datos[]=$row;
                }
return $datos;
}//fin de get_clientes


    function get_vendedores_dideco(){
        $this->load->database('dideco',TRUE);
        $query=$this->db->query("SELECT `cod`,`nombre` FROM `maeven` WHERE `banvend` LIKE 'S'");
        return $query->result_array();
    }
    function get_direccion_fiscal_001($codcte){
        $this->load->database('dideco',TRUE);
        $query=$this->db->query("SELECT `dirent1`,`dirent2`,`dirent3` FROM `pftpuen` WHERE `codclie` LIKE '$codcte'");
        return $query->result_array();

    }


function get_tipo_neg_001($tip_neg){
	$this->load->database('dideco',TRUE);
	$query=$this->db->query("SELECT `nombre` FROM `tabneg` WHERE `neg` LIKE '$tip_neg'");
    return $query->result_array();
}


function unique_multidim_array($array, $key){
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

function vendedores_001(){
 $this->load->model('data_clientes');
 $vendedores= $this->data_clientes->get_vendedores_dideco();
 header('Content-type: application/json');
 	foreach ($vendedores as $key => $value) {
 		//echo "000".$value['cod'].";".$value['nombre'].";000".$value['cod'].";ACT;;MARACAY;;;;;;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;N;N;;;;;";
 		echo "000".$value['cod']."	".$value['nombre']."	V-00000000-0	ACT	direccion	MARACAY		0243-2710000	FAX	CORREO@GMAIL.COM	NOTA	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	0	N	N					
";

 	}
}//fin de vendedores_001()



}
