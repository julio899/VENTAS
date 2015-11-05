      <?php $datauser=$this->session->userdata('datos_usuario');?>
     
    <div class="row">
        <div class="col m4 ocultar-en-movil600">
            <div class="collection">
                <a class="collection-item active" href="<?php echo base_url().index_page()."/ventas/nuevo_pedido";?>">Generar Pedido</a>
                <a class="collection-item" href="<?php echo base_url().index_page()."/ventas/pedidos_enviados";?>">Pedidos Enviados</a>
                <a class="collection-item" href="<?php echo base_url().index_page()."/imprimir";?>">IMPRESION DE FORMATO PEDIDO</a>
            </div>
        </div>


        <div class="col s12 m8">
            
            <?php if ( isset($error) ):?>
                  <div class="row">
                        <div class="col s12">
                          <div class="card-panel red">
                            <span class="white-text"><strong>Ocurrio un Problema!</strong> <?php echo $error;?>.</span>
                          </div>
                        </div>
                  </div>
            <?php endif;?>

            <div class="row">
                  <div class="col s12">
                    <div class="card-panel blue">
                      <p>Hola, <?php echo strtoupper($datauser['usuario'])?>! Selecciona un CLIENTE para crear pedido en <label class="btn blue lighten-1"><?php echo strtoupper($this->session->userdata('compa_select_txt'));?> </label></p>
                    </div>
                  </div>
            </div>


        
            
              <?php
                $json_clientes=null;
                  if(isset($clientes) && count($clientes)>0 && $clientes!=""){
                    echo "<pre>Cantidad de Clientes ".count($clientes)."<br>Zona: ".$this->session->userdata('zona_activa')."</pre>";
                    $json_clientes=json_encode($clientes);
                  }
              ?>

            <!-- Dropdown Trigger -->
  

            <a class='dropdown-button btn' href='#' data-activates='dropdown1'>Presione un Click para Selecconar cliente de la  siguiente Lista</a>

              <!-- Dropdown Structure -->
              <ul id='dropdown1' class='dropdown-content'>
                               <?php 
                               if(isset($clientes) && count($clientes)>0 && $clientes!=""){
                                     foreach ($clientes as $key => $value) {
                                       echo "<li><a href=\"".base_url().index_page()."/ventas/genera_pedido_get/".$value['codcte']."\">[".$value['codcte']."] - ".$value['razsoc']."</a></li>";
                                     }
                                   
                               
                               }else{ echo "<li class=\"divider\"></li><li>NO TIENE CLIENTES ASIGNADOS</li>"; }
                               ?>
              </ul>
                                     
        </div> 
    </div>



                            <!-- si se sabe el codigo usar este formulario-->
                            <div class="row">

                              <div class="col m4 ocultar-en-movil"><br></div>
                              <div class="col s12 m8">
                                <div class="card-panel  brown lighten-2">
                                  <span class="white-text">Si Usted Sabe el codigo del  cliente Introduzcalo AQUI.</span>

                                      <form method="post" action="<?php echo base_url().index_page()."/ventas/genera_pedido";?>">
                                        Codigo del Cliente:
                                        <input name="codcte" class="span2" id="appendedInputButton" type="text" required="required">
                                        <input class="btn orange" type="submit" value="CONFIRMAR"></input>
                                      </form>
                                </div>
                              </div>
                            </div>
                            <!-- fin del formulario si sabe el codigo del cliente-->
                             <hr>



                          </div>


        </div>

    </div>
          

