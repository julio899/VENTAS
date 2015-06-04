		<div class="row">
		<?php if(isset($pedido_completo)):?>
			<div class="col s4">
					<?php 	
						echo '<a class="btn blue" href="'.base_url().index_page().'/ventas/detallar_pedido/'.(($pedido_completo['cabecera']['id'])-1).'" title="Pedido Anteior"><i class="mdi-content-reply-all"></i> Pedido Anteior</a>';
					?>
			</div>
			<div class="col s4">
					<?php
					echo '<a class="btn orange" href="'.base_url().index_page().'/ventas/pedidos_enviados" title="Regresar"><i class="mdi-content-reply"></i> Regresar</a>';
					?>
			</div>
			<div class="col s4">
				<?php
						//echo '<a class="btn disabled" href="#" title="Siguiente Pedido"> Sig. Pedido <i class="mdi-content-forward" title="Siguiente Pedido"></i>  Siguiente</a>';
					
					      	if($ultimo==$pedido_completo['cabecera']['id']){

					      		echo '<a class="btn disabled" href="#" title="Siguiente Pedido"> Sig. Pedido <i class="mdi-content-forward" title="Siguiente Pedido"></i>  </a>';
					      	}else{
						    		echo '<a class="btn" href="'.base_url().index_page().'/ventas/detallar_pedido/'.(($pedido_completo['cabecera']['id'])+1).'" title="Siguiente Pedido"><i class="mdi-content-forward" title="Siguiente Pedido"></i> Siguiente Pedido</a>';
					      	}
				?>
			</div>
		<?php endif;?>
		</div>

<div class="row">

			      <div class="col s12">
			        <div class="card-panel teal">
			          <span class="white-text">
							
				      		<?php 
									echo "<hr>Detalle del Pedido <span class=\"label\">Nro. # ".$pedido_completo['cabecera']['id']."</span>";

				      			if($pedido_completo['cabecera']['tipo']==1){echo " -- Tipo : <span class=\"label label-success\">C.O.D</span>";}
				      			if($pedido_completo['cabecera']['tipo']==2){echo " -- Tipo : <span class=\"label label-warning\">CR-10</span>";}

				      			?>
				      			<br>Vendedor <?php echo $pedido_completo['cabecera']['nombre_vendedor'];?>
								<br>Fecha: 	<?php echo date_format(date_create($pedido_completo['cabecera']['fecha']),"d-m-Y g:i A");?>
								<br>Compa&ntilde;ia: <?php echo $pedido_completo['cabecera']['compa'];?> - Zona: <?php echo $pedido_completo['cabecera']['zona'];?><br> CODIGO CLIENTE:<?php echo $pedido_completo['cabecera']['codcte']." - ".$pedido_completo['cabecera']['clienteTXT']['razsoc']." <br>RIF: [ ".$pedido_completo['cabecera']['clienteTXT']['rif']." ]";?> 
								<hr>
			          </span>
			        </div>
			      </div>
	
</div>





<!--  ************************************************* -->




								
								
								<table class="striped">
								<thead>
									<tr><th>Nro.</th><th>CODIGO</th><th>DESCRIPCION</th><th>CANTIDAD</th></tr>
								</thead>
									<?php
										$productos=$pedido_completo['productos'];
										for ($i=0; $i < count($productos); $i++) { 
											//var_dump($productos[$i]);
											echo "<tr><td>".($i+1)."</td><td>".$productos[$i]['codpro']."</td><td>".$productos[$i]['descr']."</td><td>".$productos[$i]['cantidad']."</td></tr>";
										}
									?>
								</table>
			
		<?php if($pedido_completo['cabecera']['nota']!=""):?>
		   <div class="row">
	        <div class="col s12">
	          <div class="card blue-grey darken-2">
	            <div class="card-content white-text">
	              <span class="card-title">.:: Nota ::.</span>
	              <p><?php echo "<div class=\"alert alert-info\"><strong>Nota: </strong> ".$pedido_completo['cabecera']['nota']."</div>";?></p>
	            </div>
	            <div class="card-action">
	              <a href="#">Gracias por la Revision.</a>
	            </div>
	          </div>
	        </div>
	      </div>
		<?php endif;?>
      	</div>
      	<div class="span1"></div>
      </div>
     </div>