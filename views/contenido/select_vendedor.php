<div class="container-fluid">
	<div class="row-fluid">
		    <div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    SELECCIONE VENDEDOR
	    <span class="caret"></span>
	    </a>
	    <ul class="dropdown-menu">
	    <!-- dropdown menu links -->
	    	<?php 

	    	if (isset($vendedores)){
	    		//echo "si";
	    		for($o=0;$o<count($vendedores);$o++){
	    			echo '<li><a href="'.base_url().index_page().'/facturacion/pedidos_vendedor/'.$vendedores[$o]['idU'].'">'.strtoupper('(002:'.$vendedores[$o]['ZONA002'].') ('.'005:'.$vendedores[$o]['ZONA005'].') / '.$vendedores[$o]['nombre'].' '.$vendedores[$o]['apellido']).'</a></li>';	
	    		}
	    		
				    	}else{

				    	}//fin del else
	    	?>
	    	
	    </ul>
	    </div>
<?php //var_dump($vendedores);?>
	</div>
</div>