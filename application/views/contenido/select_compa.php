		<div class="row">
			<div class="col m3 ocultar-en-movil600">
			<!-- Inicio de Barra Lateral-->
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

		              <br><br>
		              <a id="btn_reimprimir" href="#" class="btn btn100 orange">RE-IMPRIMIR X LOTES</a>
		              <br><br>
		              <a href="<?php echo base_url().index_page().'/facturacion/generados'; ?>" class="btn btn100 black">ARCHIVOS GENERADOS</a>
		   		
			<!-- Fin de Barra Lateral-->
			</div>

			<div class="col m9 s12">
					<div class="col s4">
						<div class="contenedor_btn">
							<a href="<?php 
							if ($this->session->userdata("action")=="existencia") {
								echo base_url().index_page().'/facturacion/inventario_existencia/001';
							}
							if ($this->session->userdata('action')=="nombre") {
								echo base_url().index_page().'/facturacion/inventario_existencia_nom/001';
							}
							?>" class="btn btn-primary">DIDECO, C.A.</a></div>
					</div>
					<div class="col s4">
						<div class="contenedor_btn">
							<a href="<?php 
							if ($this->session->userdata("action")=="existencia") {
								echo base_url().index_page().'/facturacion/inventario_existencia/002';
							}
							if ($this->session->userdata('action')=="nombre") {
								echo base_url().index_page().'/facturacion/inventario_existencia_nom/002';
							}
							?>" class="btn btn-success">DEIMPORT, C.A.</a>
						</div>
					</div>
					<div class="col s4">
						<div class="contenedor_btn">
							<a href="<?php 
							if ($this->session->userdata("action")=="existencia") {
								echo base_url().index_page().'/facturacion/inventario_existencia/005';
							}
							if ($this->session->userdata('action')=="nombre") {
								echo base_url().index_page().'/facturacion/inventario_existencia_nom/005';
							}
							?>" class="btn btn-primary">COMPACTO, C.A.</a>
						</div>
					</div>
				
			</div>	
		</div>