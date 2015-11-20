<?php 

$datauser=$this->session->userdata('datos_usuario');
if(isset($cliente)){ 
//var_dump($cliente);
}
if(isset($proveedores)){ 
//var_dump($proveedores);
}
?>
<div class="row">
	<div class="col s12 blue">
		<!-- Infirmacion del cliente -->
		<div class="container cliente white-text">
			<blockquote>
				<h6><?php echo "[".$cliente['codcte']."] - ".$cliente['razsoc']." - ZONA: ".$cliente['zona']." <br> ".$cliente['ciudad'].", EDO.".$cliente['estado'];?></h6>
			</blockquote>
		</div>
		<!-- //FIN de Infirmacion del cliente -->
	</div>
	<div class="input-field col s12 m4">
		<!-- Panel de seleccion de los Productos-->
				<!-- Proveedores -->
						  <!-- Proveedores Structure -->
							<select name="proveedor" id="proveedores" class="browser-default">
								<option value="" disabled selected>Seleccione un Proveedor de la lista</option>
							   		
							    	<?php foreach($proveedores as $key => $value){ ?>
							   		<option value="<?php echo $value['codigo']; ?>">[ <?php echo $value['codigo']; ?> ] - <?php echo $value['razsoc']; ?></option>
							    	<?php }//fin de foreach ?>
							</select>
						<!-- Productos-->
							<select id="productos" class="browser-default">
							</select>			
				
				<div class="row">
					<div class="col s6"><button id="btn_cargar" type="submit" class="btn blue" onClick="cargar()">CARGAR</button></div>
					<div class="col s6"><button id="btn_finalizar" type="submit" class="btn green" onClick="finalizarPedido()">FINALIZAR</button></div>
				</div>
				<div class="row">
					<div class="col s6">
						<input id="cantidad" placeholder="cantidad" name="cantidad" type="number" required="required" min="1" max="500" ></div>
					<div class="col s6">
						
						<select id="tipo" class="browser-default" required="required">
							<option value="0">TIPO DE VENTA >> </option>
							<option value="1">C.O.D.</option>
							<option value="2">CR-10</option>
							
						</select>
					</div>
				</div>

		<!-- FIN del Panel de seleccion de los Productos-->
	</div>
	<div class="col s12 m8">
		<!-- Informacion del pedido -->

						<div id="pedido">
							<table id="tabla" class="hoverable">
								<thead><tr><th>CODIGO</th><th>DESCRIPCION</th><th>CANTIDAD</th><th>OPCIONES</th></tr></thead> 
								<tbody></tbody>
							</table>
								
						</div>
						<div class="light-green lighten-4">
								<label for="nota"><strong>Nota:</strong></label>
								<textarea name="nota" id="nota" rows="5"></textarea>
							
						</div>
		<!-- FIN de Informacion del pedido -->
	</div>
</div>

