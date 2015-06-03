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
                    <div class="card-panel teal">
                      <span class="white-text">Seleccione una Empresa con la que desea generar su pedido.
                      </span>
                    </div>
                  </div>
            </div>



              <ul class="collection">
                <li class="collection-item avatar">
                <a href="<?php echo base_url().index_page()."/ventas/setCompa/001";?>">
                  <i class="mdi-social-poll circle red"></i>
                  <span class="title">DIDECO</span>
                  <p>001 - DIDECO</p>
                  <a href="<?php echo base_url().index_page()."/ventas/setCompa/001";?>" class="secondary-content"><i class="mdi-social-pages"></i></a>
                  </a>
                </li>
                <li class="collection-item avatar">
                <a href="<?php echo base_url().index_page()."/ventas/setCompa/005";?>">
                  <i class="mdi-social-domain circle green"></i>
                  <span class="title">COMPACTO</span>
                  <p>005 - COMPACTO C.A.</p>
                  <a href="<?php echo base_url().index_page()."/ventas/setCompa/005";?>" class="secondary-content"><i class="mdi-social-pages"></i></a></a>
                </li>
                <li class="collection-item avatar">
                <a href="<?php echo base_url().index_page()."/ventas/setCompa/002";?>">
                  <i class="mdi-social-location-city circle blue"></i>
                  <span class="title">DEIMPORT</span>
                  <p>002 - DEIMPORT</p>
                  <a href="<?php echo base_url().index_page()."/ventas/setCompa/002";?>" class="secondary-content"><i class="mdi-social-pages"></i></a></a>
                </li>
              </ul>
        </div>

    </div>
          
