
	<div class="row">
		<!--Barra Lateral-->
		<div class="col s3 ocultar-en-movil600">
			    <ul id="lateral-sup">
			      <li><a href="<?php echo base_url().index_page().'/facturacion/'; ?>" class="btn btn100 blue">Bandeja de Entrada</a></li>
			      <li><a href="<?php echo base_url().index_page().'/facturacion/consultarVendedor'; ?>" class="btn btn100 blue">Consultar Vendedor</a></li>
			      <li>
                <div class="btn-group">
                <a id="btn-inventario" class='dropdown-button btn' href='#' data-activates='dropdownINVENTARIO'>INVENTARIO</a>
                      <ul id='dropdownINVENTARIO' class='dropdown-content'>
                        <li><a href="<?php echo base_url().index_page().'/facturacion/select_compa/existencia';?>">Por Existencia</a></li>
                        <li><a href="<?php echo base_url().index_page().'/facturacion/select_compa/nombre';?>">Por Nombre</a></li>
                      </ul>
                </div>
            </li>
			    </ul>

              <a href="<?php echo base_url().index_page().'/imprimir_carta/imprimir_pedidos'; ?>" target="_blank" class="btn btn100 lime">IMPRIMIR NUEVOS ( <?php echo $cant_ped_new;?> ) </a>
              <br><br>
              <a id="btn_reimprimir" href="#" class="btn btn100 orange">RE-IMPRIMIR X LOTES</a>
              <br><br>
              <a href="<?php echo base_url().index_page().'/facturacion/generados'; ?>" class="btn btn100 black">ARCHIVOS GENERADOS</a>
   		
		</div>
      <!--FIN DE Barra Lateral-->

		<div class="col s9">
	
			<table class="hoverable">
				<thead>
				<tr>
					<th>Nro#</th>
					<th>SECUENCIA</th>
					<th>USUARIO</th>
					<th><CENTER>CANTIDAD<BR>PEDIDOS</CENTER></th>
					<th>PAG. IMPRESAS</th>
					<th>DESDE</th>
					<th>HASTA</th>
					<th>FECHA</th>
				</tr>
				</thead>
				<tbody>

			<?php if (isset($archivos_generados)){
					for($q=0;$q<count($archivos_generados);$q++){
						echo "<tr><td>".($q+1)."</td><td><a href=\"".base_url()."archivos/".$archivos_generados[$q]['secuencia'].".pdf\" target=\"_blank\" >".$archivos_generados[$q]['secuencia']."</a></td><td>".$archivos_generados[$q]['usuario']."</td><td>".$archivos_generados[$q]['cantidad_pedidos']."</td><td>".$archivos_generados[$q]['paginas']."</td><td>".$archivos_generados[$q]['desde']."</td><td>".$archivos_generados[$q]['hasta']."</td><td>".$archivos_generados[$q]['fecha']."</td></tr>";
					}
			}?>
					
				</tbody>
			</table>
			<?php //var_dump($archivos_generados);?>
		</div>
	</div>


<!--
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
	    </form>
  </div>
</div> -->