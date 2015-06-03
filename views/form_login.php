
	<header>
	<!-- Barra de Navegacion -->
		 <nav class="green">
		    <div class="container nav-wrapper">
		      <a href="<?php echo base_url();?>" class="brand-logo">Sistema de Ventas</a>
		      <ul id="nav-mobile" class="right hide-on-med-and-down">
		        <li><a href="didecoca.com">Portal</a></li>
		      </ul>
		    </div>
	  	</nav>
	<!-- Fin de Barra de Navegacon-->
	</header>

	<main>
	<!-- Inicio del Formulario -->
		<div class="container">
			<!-- en caso de algun error-->

			    <div id="div_cabecera" class="row">
			        <!--cabecera --> 
			        <div class="col s12 red">
			        <?php if(isset($error)){ echo "<pre><b>Error: </b>$error</pre>";}?>
			        </div>
			        
			    </div>
			    


				  <div class="row">
				    <form id="form-ingreso" class="col s12" method="post" action="<?php echo base_url().index_page().'/identificacion';?> " >
				      <div class="row">
				        <div class="input-field col s12">
				        	<i class="mdi-action-account-circle prefix"></i>
				          	<input name="usu" placeholder="Usuario" id="usurario" type="text" class="validate" required>
				          <label for="usurario">Usuario</label>
				        </div>
				        <div class="input-field col s12">
				        	<i class="mdi-communication-vpn-key prefix"></i>
				          <input name="pass" id="clave" type="password" class="validate" required>
				          <label for="clave">Contrase&ntilde;a</label>
				        </div>
				      </div>

				        <div class="input-field col s12">
				        	<button class="btn blue" type="submit">Ingresar</button>
				        </div>
				      </div>

				    </form>
				  </div>
    	</div>
	<!-- Fin del Formulario -->
    </main>

