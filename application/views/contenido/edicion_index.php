<div class="row">
		<!--Barra Lateral-->
		<div class="col m2 ocultar-en-movil600">
		  <div class="collection ">
        <a href="<?php echo base_url().index_page().'/editor/'; ?>" class="collection-item azul_txt_blanco">BANDEJA<span class="nuevo badge"><?php echo $cant_ped_new;?></span></a>
      </div>
    </div>
      <!--FIN DE Barra Lateral-->

		<div class="col m10 s12">
		<?php 
				if(isset($tabla)){
				echo $tabla;
				}
		?>
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