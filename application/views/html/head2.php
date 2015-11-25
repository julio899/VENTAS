<?php $datauser=$this->session->userdata('datos_usuario');?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>..:: Sistema de Ventas::..</title>
    <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css"  media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        <!-- Iconos de Materializacss-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
.centrado{
  text-align: center;
}
div#contenido{
  min-height: 80%;
}
#btn-ingreso{
  margin-top:5%;
}
h1{
  margin:0px;
  padding:0px;
}
a.brand-logo{
  font-size: 1.2em;
}
  body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }

  main {
    flex: 1 0 auto;
  }

  li.collection-item:hover{
background-color: #ffca28;
color: white;
font-weight: bold;
  }
    li.collection-item>a{
text-decoration: none;
color:#212121;
  }
  li.collection-item>a:hover{color:white;}
a#btn-inventario{
  width: 100%;
}
    table{
    font-size: 1.1em;
    margin-left: 15px;
  }

  .proveedores{
    width: 100%;
  }
  #btn_cargar,#btn_finalizar,.btn100{
   width: 100%;
  }
  select{
    background-color:#00838f;
    color: #c6ff00;
  }
  #productos{ color:#00e5ff;}
  select>option{
    color:white;
  }
span.badge.nuevo {
  font-weight: 300;
  font-size: 0.8rem;
  color: #fff;
  background-color: #26a69a;
  border-radius: 2px;
}

ul#lateral-sup>li{
  margin-top: 7px;
}


  @media only screen and (max-width: 800px) {
.ocultar-en-movil{
  display:none!important;
  }
  a.brand-logo{
    font-size: 1em;
  }

  table{
    font-size: 0.8em;
    margin-left: 0px;
  }
}

  @media only screen and (max-width: 600px) {
.ocultar-en-movil600{
  display:none!important;
  }
  .row .col {
    padding: 0px!important;
  }
}

.azul_txt_blanco{

    color: #FFF !important;
    background-color: #2196F3  !important;
}
span.badge.nuevo:after {
    content: " nuevo";
}
</style>
</head>
<body>
<!-- INICIO DE BARRA DE NAVEGACION-->
<div class="navbar-fixed">
    <nav class="green">
      <div class="nav-wrapper container">
        <a href="<?php echo base_url().index_page()."/ventas/nuevo_pedido";?>" class="brand-logo">Sistema de Ventas</a>  



        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <ul class="right hide-on-med-and-down">
        <li>
            <!--
             <div class="google-nav">  
                         <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-8600651661481362"
                         data-ad-slot="4003561532"
                         data-ad-format="auto">
                    </ins>
                    <script>
                          (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
              </div> -->
        </li>
        <li><div style="margin-left:15px; margin-right:15px;">Te has Identificado como <?php echo strtoupper($datauser['usuario'])?></div></li>
        <li><a style="margin-left:15px; margin-right:15px;" href="<?php echo base_url().index_page()."/identificacion/cerrarSesion";?>" class="btn red">Salir</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a style="margin-left:15px; margin-right:15px;" href="<?php echo base_url().index_page()."/identificacion/cerrarSesion";?>" class="btn red">Salir</a></li>
        <?php if($datauser['tipo']=='F'){
          ?>
          
                <li><a class="collection-item active" href="<?php echo base_url().index_page()."/facturacion";?>">INICIO</a></li> 
      
                <li><a href="<?php echo base_url().index_page().'/facturacion/'; ?>" class="collection-item blue">Bandeja de Entrada</a></li>
                <li><a href="<?php echo base_url().index_page().'/facturacion/consultarVendedor'; ?>" class="collection-item blue">Consultar Vendedor</a></li>
                <li>
                            <li><a href="<?php echo base_url().index_page().'/facturacion/select_compa/existencia';?>">INVENTARIO Por Existencia</a></li>
                            <li><a href="<?php echo base_url().index_page().'/facturacion/select_compa/nombre';?>">INVENTARIO Por Nombre</a></li>
                          
                </li>
    

          <?php 
                //fin de if TIPO=F 
                }else{
                  ?>
                      <li><a class="collection-item active" href="<?php echo base_url().index_page()."/ventas/nuevo_pedido";?>">Generar Pedido</a></li> 
                      <li><a class="collection-item" href="<?php echo base_url().index_page()."/ventas/pedidos_enviados";?>">Pedidos Enviados</a></li>
                      <li><a class="collection-item" href="<?php echo base_url().index_page()."/imprimir";?>">IMPRESION DE FORMATO PEDIDO</a></li>                
                             
                  <?php
                }//fin del else en caso del vendedor
           ?>
                
                
      </ul>




      </div>
    </nav>
  </div>
<!-- // FIN DE BARRA DE NAVEGACION-->
  


<!-- INICIO DEL CONTENIDO -->
<main>
  <div id="contenido">