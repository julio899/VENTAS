<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_clientes extends CI_Model {

function get_clientes(){
$this->load->database('compacto',TRUE);
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

}
