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

    table{
    font-size: 1.1em;
    margin-left: 15px;
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
        <li><a class="collection-item active" href="<?php echo base_url().index_page()."/ventas/nuevo_pedido";?>">Generar Pedido</a></li> 
        <li><a class="collection-item" href="<?php echo base_url().index_page()."/ventas/pedidos_enviados";?>">Pedidos Enviados</a></li>
        <li><a class="collection-item" href="<?php echo base_url().index_page()."/imprimir";?>">IMPRESION DE FORMATO PEDIDO</a></li>                
               
                
                
      </ul>




      </div>
    </nav>
  </div>
<!-- // FIN DE BARRA DE NAVEGACION-->
  


<!-- INICIO DEL CONTENIDO -->
<main>
  <div id="contenido">