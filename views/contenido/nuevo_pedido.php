<?php 

$datauser=$this->session->userdata('datos_usuario');
if(isset($cliente)){ 
//var_dump($cliente);
}
if(isset($proveedores)){ 
//var_dump($proveedores);
}
?>
<style type="text/css">
#cliente {
font: 15px 'Lucida Sans Unicode', 'Trebuchet MS', Arial, Helvetica;
text-transform: uppercase;
border: 0px;
color: white;
background-color: #272727;
}
h1.barra{

text-align: center;
position: relative;
color: #fff;
margin: 0 -15px 5px -15px;
padding: 10px 0;
text-shadow: 0 1px rgba(0,0,0,.8);
background: #5c5c5c;
background-image: -moz-linear-gradient(rgba(255,255,255,.3), rgba(255,255,255,0));
background-image: -webkit-linear-gradient(rgba(255,255,255,.3), rgba(255,255,255,0));
background-image: -o-linear-gradient(rgba(255,255,255,.3), rgba(255,255,255,0));
background-image: -ms-linear-gradient(rgba(255,255,255,.3), rgba(255,255,255,0));
background-image: linear-gradient(rgba(255,255,255,.3), rgba(255,255,255,0));
-moz-box-shadow: 0 2px 0 rgba(0,0,0,.3);
-webkit-box-shadow: 0 2px 0 rgba(0,0,0,.3);
box-shadow: 0 2px 0 rgba(0,0,0,.3);
clear: both;

display: block;
font-size: 2em;
-webkit-margin-before: 0.67em;
-webkit-margin-after: 0.67em;
-webkit-margin-start: 0px;
-webkit-margin-end: 0px;
font-weight: bold;

}
.select-proveedores{
	width: 300px;
	height: 45px;
	padding-top: 5px;
	padding-bottom: 5px;
	font-size: 1em;
}
#nota{
	width: 40em;
}
</style>
<div class="row-fluid">
	<div class="span3">
		<a href="<?php echo base_url().index_page().'/ventas/nuevo_pedido';?>" id="btn_Npedido" class="btn btn-large btn-block btn-warning">Nuevo Pedido</a><hr>

		<label for="proveedores">Proveedores</label><select id="proveedores" class="select-proveedores">
		<option value="0">SELECCIONE >> </option>
			<?php 
				foreach ($proveedores as $key => $value) {
					echo "<option value=\"".$value['codigo']."\">[".$value['codigo']."] - ".$value['razsoc']."</option>";
				}
			?></select>

			<label  for="productos">Productos</label>
			<select id="productos" class="select-proveedores">
				<?php

				?>
			</select>

			<label  for="cantidad">Cantidad</label>
			<input id="cantidad" name="cantidad" type="number" required="required" min="1" max="500" >
			<label for="tipo">TIPO DE VENTA</label>

			<select id="tipo" required="required">
				<option value="0">SELECCIONE >> </option>
				<option value="1">C.O.D.</option>
				<option value="2">CR-10</option>
				
			</select>
			<button id="btn_cargar" type="submit" class="btn btn-large btn-block btn-primary" onClick="cargar()">CARGAR</button>
			<button id="btn_finalizar" type="submit" class="btn btn-large btn-block btn-success" onClick="finalizarPedido()">FINALIZAR</button>
		
	</div>
	<!-- Final de la barra lateral-->

	<!-- Inicio del contenido span9 -->
	<div class="span9">
						<div id="pedido">
							<h1 id="cliente" class="barra"><?php echo "[".$cliente['codcte']."] - ".$cliente['razsoc']." - ZONA: ".$cliente['zona']." - ".$cliente['ciudad'].", EDO.".$cliente['estado'];?></h1>
							<table id="tabla" class="table table-hover table-condensed"><tr><th>CODIGO</th><th>DESCRIPCION</th><th>CANTIDAD</th></tr></table>
								
						</div>
						<div class="alert alert-info">
								<label for="nota"><strong>Nota:</strong></label>
								<textarea name="nota" id="nota" rows="5"></textarea>
							
						</div>
	</div>
	<!-- Fin de  la primera columna 3 y 9 que serian los 12 -->


</div>