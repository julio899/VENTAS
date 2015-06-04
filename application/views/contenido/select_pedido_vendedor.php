
<a class="btn btn-primary" href=<?php echo '"'.base_url().index_page().'/facturacion/consultarVendedor/"';?> title="Regresar">Cambiar VENDEDOR</a>
<table class="table table-hover table-condensed tbl-ped-env"><thead><tr><th>Nro.Pedido</th><th>COMPAÑIA</th><th>ZONA</th><th>COD. CLIENTE</th><th>Razón Social</th><th>FECHA</th><th>TIPO</th><th>Detalle</th></tr></thead>

<tbody>
<?php
	if(isset($pedidos_vendedor)){
		for ($i=0; $i < count($pedidos_vendedor); $i++) { 
			# armo tabla.

			if($pedidos_vendedor[$i]['tipo']==1){$tipo='<span class="label label-success">C.O.D</span>';}
			if($pedidos_vendedor[$i]['tipo']==2){$tipo='<span class="label label-warning">CR-10</span>';}
			echo '<tr><th>'.$pedidos_vendedor[$i]['id'].'</th><th>'.$pedidos_vendedor[$i]['compa'].'</th><th>'.$pedidos_vendedor[$i]['zona'].'</th><th>'.$pedidos_vendedor[$i]['codcte'].'</th><th>'.$pedidos_vendedor[$i]['razsoc']['razsoc'].'</th><th>'.$pedidos_vendedor[$i]['fecha'].'</th><th>'.$tipo.'</th><th> <a class="btn btn-info" href="'.base_url().index_page().'/ventas/detallar_pedido/'.$pedidos_vendedor[$i]['id'].'"><i class="icon-search" title="Mostrar Detalles"></i> Ver</a> </th></tr>';
		}
	}
?>
</tbody>
</table>
<?php //var_dump($pedidos_vendedor);?>