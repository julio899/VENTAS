<table class="table table-bordered table-hover">
	<tr>
		<td>CLAVE</td>
		<td>CLAVE PROV.</td>
		<td>DESCRIPCI&Oacute;N</td>
		<td>COSTO</td>
		<td>VENTAS</td>
		<td>OFERS</td>
		<td>OFERM</td>
		<td>OFERE</td>
		<td>OFERD</td>
		<td>EXISTENCIA</td>
	</tr>
	
<?php
	if(isset($inventario)){
		for ($i=0; $i < count($inventario); $i++) { 
		 	echo "<tr>
		<td>".$inventario[$i]['clave']."</td>
		<td>".$inventario[$i]['clavprov']."</td>
		<td>".$inventario[$i]['descr']."</td>
		<td>".$inventario[$i]['costo']."</td>
		<td>".$inventario[$i]['ventas']."</td>
		<td>".$inventario[$i]['ofers']."%</td>
		<td>".$inventario[$i]['oferm']."%</td>
		<td>".$inventario[$i]['ofere']."%</td>
		<td>".$inventario[$i]['oferd']."%</td>
		<td>".$inventario[$i]['existen']."</td>
		</tr>";
		 } 
	}
?>
</table>