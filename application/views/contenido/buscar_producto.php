
<style type="text/css">
ul.resultados_busqueda,ul.resultados_busqueda>li{
	margin: 0px;
	padding: 0px;
	border: 0px;
}
ul.resultados_busqueda{
	width: 400px;
	border: 1px solid gray;
}
ul.resultados_busqueda li{
	list-style:none;
	color: olive;
	text-transform: uppercase;
	padding-left: 5px;
	}
	ul.resultados_busqueda>li:hover{
		background-color: orange;
		color: black;
	}
div#contenido{
	margin-top: 50px;
}
#cajaBuscar{
	text-transform: uppercase;
	width:400px;
}

</style>
<div id="contenido_centro" class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
			<!--BARRA LATERAL DE OPCIONES-->
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Opciones</li>
              <li><a href="<?php echo base_url().index_page()."/ventas/nuevo_pedido";?>">Generar Pedido</a></li>
              
              <li class="nav-header">Consultas</li>
              <li><a href="<?php echo base_url().index_page()."/ventas/buscar_producto";?>">Buscar Codigo de Producto</a></li>
              <li><a href="<?php echo base_url().index_page()."/ventas/pedidos_enviados";?>">Pedidos Enviados</a></li>
              <li><a href="<?php echo base_url().index_page()."/imprimir";?>">IMPRESION DE FORMATO PEDIDO</a></li>
            </ul>
          </div><!--/.well -->
			<!--./FIN DE BARRA LATERAL DE OPCIONES-->
		</div>
		<div class="span9">
			<!--INICIO DEL CONTENIDO DE BUSCAR PRODUCTOS-->
				<form action="">	

					<!--Serleccion de COMPAÑIA-->
							<div class="btn-group">
							  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							    SELECCIONE COMPA&Ntilde;IA
							    <span class="caret"></span>
							  </a>
							  <ul class="dropdown-menu">
							    <!-- dropdown menu links -->
							    <li>
							    	<a href="?compa=001">DIDECO</a>
							    	<a href="?compa=002">DEIMPORT</a>
							    	<a href="?compa=005">COMPACTO</a>
							    </li>
							  </ul>
							</div>
							<?php 
							function getCompaTXT($codComp){
								$temp="";
								switch ($codComp) {
									case '001':
										$temp="DIDECO C.A.";
										break;
									case '002':
										$temp="DEIMPORT C.A.";
										break;
									case '005':
										$temp="COMPACTO C.A.";
										break;
								}
								return $temp;
							}/*fin de la funcion Obtener compañia*/

							if(isset($_GET)){
									if(isset($_GET['compa'])){
										echo '<br><span class="label label-info">Buscar por la Compa&ntilde;ia : '.$_GET['compa'].'-'.getCompaTXT($_GET['compa']).'</span><br>';
										echo '<input type="search" class="buscar" id="cajaBuscar" autocomplete="off"><div id="resultado"></div>';
										echo '<input type="hidden" id="hcompa" name="codcomp" value="'.$_GET['compa'].'" />';
?>	 
<!--INICIO del Ajax que hara funcionar mi Busqueda-->
<script type="text/javascript">
jQuery(function($){
		//$("#cajaBuscar").watermark('Introduzca su busqueda');

		$(".buscar").keyup(function(){
			var texto=$(this).val();
			var codcomp="<?echo $_GET['compa'];?>";
			var dataString="palabra="+texto+"&compa="+codcomp;
			if(texto!=''){
				$("#resultado").html("Buscando...");
				$.ajax({
					type:"POST",
					url:"<?php echo base_url().index_page();?>/ventas/getProductosCompa",
					data:dataString,
					cache:false,
					success:function(html){
						var respuesta=JSON.parse(html);
						console.log(respuesta.length);
						if(respuesta.length==0){
						$("#resultado").html('No se encontraron coincidencias con "'+texto.toUpperCase()+'"').show();
						}else{
								var itens="<ul class=\"resultados_busqueda\">";
								for (var i = 0; i < respuesta.length; i++) {
									itens=itens+"<li class=\"itenBusqueda\">[ "+respuesta[i].clave+" ] - "+respuesta[i].descr+"</li>";
									console.log(respuesta[i].descr);
								};		
								var itens=itens+"</ul>";				
								$("#resultado").html(itens).show();
								$(".itenBusqueda").click(function(){
									var cliqueado=$(this).text();
									//alert('presiono a :'+cliqueado);
									$("#cajaBuscar").val(cliqueado);
									$("#resultado").html("").hide();
								});
						}/*fin del else si respuesta.length!=o*/
					}
				});
			}else{
				$("#resultado").html("").hide();
			}
		});

	});/*Fin jQuery(function($){*/
</script>
<?
										}
								}
							?>
							
					<!--fin de btones de seccion de COMPAÑIA-->	
				
				</form>
			<!--FIN DE BUSCAR PRODUCTOS-->
		</div>
	</div>
</div>