<div class="container-fluid">
	<div class="row-fluid">
		<!--Barra Lateral-->
		<div class="span2 bs-docs-sidebar">
		        <ul class="nav nav-pills nav-stacked" style="max-width: 300px;">
			      <li class="active"><a href="#">Bandeja de Entrada</a></li>
			      <li><a href="<?php echo base_url().index_page().'/facturacion/consultarVendedor'; ?>">Consultar Vendedor</a></li>
			      <li><a href="#">Chequear</a></li>
			      <li><a href="#">Pedidos Facturados</a></li>
			      <li><div class="btn-group">
                <button class="btn btn-info">INVENTARIO</button>
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url().index_page().'/facturacion/select_compa/existencia';?>">Consultar por Existencia</a></li>
                  <li><a href="<?php echo base_url().index_page().'/facturacion/select_compa/nombre';?>">Consultar por Nombre</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Entradas de Almacen</a></li>
                </ul>
              </div></li>
			    </ul>

              <a href="<?php echo base_url().index_page().'/imprimir_carta/imprimir_pedidos'; ?>" target="_blank" class="btn btn-success">IMPRIMIR PEDIDOS NUEVOS <span class="label label-success"><?php echo $cant_ped_new;?></span></a>
              <br><br>
              <a id="btn_reimprimir" href="#" class="btn btn-warning">RE-IMPRIMIR X LOTES</a>
              <br><br>
              <a href="<?php echo base_url().index_page().'/facturacion/generados'; ?>" class="btn btn-inverse">ARCHIVOS GENERADOS</a>
      </div>
      <!--FIN DE Barra Lateral-->

		<div class="span10">
		<?php 
				if(isset($tabla)){
				echo $tabla;
				}
		?>
		</div>
	</div>
</div>


<div id="div_reimprimir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Pedidos a Imprimir</h3>
  </div>
  <div class="modal-body">
    <p id="detalle_pedido"></p>
  </div>
  <div class="modal-footer">
         <form id="form_x_lotes" target="_blank" class="form-inline" method="post" action="<?php echo base_url().index_page()."/imprimir_carta/imprimir_pedidos_desde_hasta/";?>">
          <label>Desde el Pedido Nro#
		          <input id="txt_desde" name="desde" type="text" class="input-small" placeholder="Desde" required="required">
          </label>

          <label>Hasta el Pedido Nro#
		        <input id="txt_hasta" name="hasta" type="text" class="input-small" placeholder="Hasta" required="required">
		      </label>
       <button id="link_x_lotes" class="btn btn-success">CONFIRMAR</button>
		   <!-- <a id="link_imprimir_x_lotes" target="_blank"  class="btn btn-info disabled">IMPRIMIR</a> -->
	    </form>
  </div>
</div>