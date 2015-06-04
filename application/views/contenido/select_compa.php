<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3"></div>
			<div class="span9"><pre>SELECCIONE COMPA&Ntilde;IA</pre></div>
		</div>
	<div class="row-fluid">
		<div class="span3 bs-docs-sidebar">
		<!-- Inicio de Barra Lateral-->
			<ul class="nav nav-pills nav-stacked" style="max-width: 300px;">
			      <li class="active"><a href="#">Bandeja de Entrada</a></li>
			      <li><a href="<?php echo base_url().index_page().'/facturacion/consultarVendedor'; ?>">Consultar Vendedor</a></li>
			      <li><a href="#">Chequear</a></li>
			      <li><a href="#">Pedidos Facturados</a></li>
			      <li><div class="btn-group">
                <button class="btn btn-info">INVENTARIO</button>
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#">Consultar por Existencia</a></li>
                  <li><a href="#">Consultar por Nombre</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Entradas de Almacen</a></li>
                </ul>
              </div></li>
			    </ul>
		<!-- Fin de Barra Lateral-->
		</div>
		<div class="span3">
			<div class="contenedor_btn">
				<a href="<?php 
				if ($this->session->userdata("action")=="existencia") {
					echo base_url().index_page().'/facturacion/inventario_existencia/001';
				}
				if ($this->session->userdata('action')=="nombre") {
					echo base_url().index_page().'/facturacion/inventario_existencia_nom/001';
				}
				?>" class="btn btn-primary">DIDECO, C.A.</a></div>
		</div>
		<div class="span3">
			<div class="contenedor_btn">
				<a href="<?php 
				if ($this->session->userdata("action")=="existencia") {
					echo base_url().index_page().'/facturacion/inventario_existencia/002';
				}
				if ($this->session->userdata('action')=="nombre") {
					echo base_url().index_page().'/facturacion/inventario_existencia_nom/002';
				}
				?>" class="btn btn-success">DEIMPORT, C.A.</a>
			</div>
		</div>
		<div class="span3">
			<div class="contenedor_btn">
				<a href="<?php 
				if ($this->session->userdata("action")=="existencia") {
					echo base_url().index_page().'/facturacion/inventario_existencia/0015';
				}
				if ($this->session->userdata('action')=="nombre") {
					echo base_url().index_page().'/facturacion/inventario_existencia_nom/005';
				}
				?>" class="btn btn-primary">COMPACTO, C.A.</a>
			</div>
		</div>
	</div>
</div>