<?php $datauser=$this->session->userdata('datos_usuario');?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>..:: Sistema de Ventas::..</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="<?php echo base_url();?>css/bootstrap-responsive.css" rel="stylesheet">
    
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?php echo base_url().index_page()."/identificacion/redireccion";?>">Sistema de Ventas</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Te has Identificado como <a href="#" class="navbar-link"><?php echo strtoupper($datauser['usuario'])?></a>
            <a style="margin-left:15px" href="<?php echo base_url().index_page()."/identificacion/cerrarSesion";?>" class="btn btn-danger">Salir</a>
            </p>
            <ul class="nav">
              <li class="active"><a href="<?php echo base_url().index_page()."/identificacion/redireccion";?>">Inicio</a></li>
              
              <li>
              <style type="text/css">
              .navbar-inner{  padding-bottom: 10px;}
.google-nav { margin-right: 2cm; width: 320px; height: 35px; }
@media (min-width:500px) { .adslot_1 { width: 468px; height: 35px; } }
@media (min-width:800px) { .adslot_1 { width: 728px; height: 35px; } }
</style>
              	<div class="google-nav">	
              		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- cabeceraBlack -->
			<ins class="adsbygoogle"
			     style="display:block"
			     data-ad-client="ca-pub-8600651661481362"
			     data-ad-slot="4003561532"
			     data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Opciones</li>
              <li><a href="<?php echo base_url().index_page()."/ventas/nuevo_pedido";?>">Generar Pedido</a></li>
              
              <li class="nav-header">Consultas</li>
              <li><a href="<?php echo base_url().index_page()."/ventas/buscar_producto";?>">Buscar Codigo de Producto</a></li>
              <li><a href="#">Buscar Codigo de Clientes</a></li>
              <li><a href="#">Cambios Recientes</a></li>
              <li><a href="#">Productos Agotados</a></li>
              <li><a href="<?php echo base_url().index_page()."/ventas/pedidos_enviados";?>">Pedidos Enviados</a></li>
              <li><a href="#">Estado de Cliente</a></li>
              <li><a href="<?php echo base_url().index_page()."/imprimir";?>">IMPRESION DE FORMATO PEDIDO</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div class="hero-unit">
            <h1>Hola, <?php echo strtoupper($datauser['usuario'])?>!</h1>
            <p>Ahora desde este panel podras hacer el envio de tus pedidos, en una forma rapida. recuerda informar cualquier incoveniente.</p>
            <p><a href="#" class="btn btn-primary btn-large">Learn more »</a></p>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <h2>Noticia</h2>
              <p>Comenzo la prueba de la aplicacion en su primera version. </p>
              <p><a class="btn" href="#">Ver Detalles »</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Informaci&oacute;n de Promociones</h2>
              <p>Espacio pensado para informar sobre alguna promocion u oferta a los vendedores. </p>
              <p><a class="btn" href="#">Ver Detalles »</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Condiciones para productos</h2>
              <p>Informacion sobre alguna condicion de venta sobre un producto regulado o descuento especial. </p>
              <p><a class="btn" href="#">Ver Detalles »</a></p>
            </div><!--/span-->
          </div>


        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
      	<div class="google">
      		<!-- google adsen -->
      		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- didecoca -->
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-8600651661481362"
		     data-ad-slot="8073834337"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
      	</div>
        <p>Grupo Empresarial Dideco 2013 ©</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>js/jquery.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-button.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-collapse.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-typeahead.js"></script>

  </body></html>