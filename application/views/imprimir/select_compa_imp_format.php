     <!--  Inicia el contenedor dentro de el colocaremos los div.row-fluid y los div.span3 y div.span9 -->            
<?php $datauser=$this->session->userdata('datos_usuario');?>
<div class="row-fluid">

        <div class="span12">

          <div class="hero-unit">
            
            <h3>Hola, <?php echo strtoupper($datauser['usuario'])?>!</h3>
            <p>Debes seleccionar una compañía la cual imprimiras el formato de pedidos manuales.</p>
 


          <div class="row-fluid">
            <div class="span8 recuadro_blanco">
              <h2>DIDECO Y DEIMPORT</h2>
              <p>Contenido Referente a promociones y cambios a tener en cuenta.</p>
              <p><a class="btn" href="<?php echo base_url().index_page()."/imprimir/imp_talonario_pedidos_DI_DE";?>">Imprimir Formato »</a></p>
            </div><!--/span-->

            <div class="span4 recuadro_blanco">
              <h2>COMPACTO</h2>
              <p>Contenido Referente a promociones y cambios a tener en cuenta.</p>
              <p><a class="btn" href="<?php echo base_url().index_page()."/imprimir/imp_talonario_pedidos/005";?>">Imprimir Formato »</a></p>
            </div><!--/span-->
          </div><!--/row-->

          </div>


        </div><!--/span-->
      </div><!--/row-->
    