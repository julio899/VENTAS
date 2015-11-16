<?php

$datauser=$this->session->userdata('datos_usuario');
?>
     
    </div>
  </main>
<!-- // FIN DEL CONTENIDO -->



  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Pedido Cargado con Exito</h4>
      <p>detalle de su pedido</p>
      <div id="carga_detalle"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="btn red modal-action modal-close waves-effect waves-green btn-flat"> Continuar </a>
      <a title="Nuevo Pedido" class="btn" href="<?php echo base_url().index_page();?>/ventas/nuevo_pedido">Nuevo Pedido</a>
                
    </div>
  </div>


<!-- Footer -->
<footer class="page-footer green">
      <div class="container">
        <div class="row">
          <div class="col s12">
            <!-- Google Adsense -->
<!--
            <script async="" type="text/javascript" src="http://pagead2.googlesyndication.com/pub-config/ca-pub-8600651661481362.js"></script><script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            

            <ins class="adsbygoogle" style="display: block; height: 90px;" data-ad-client="ca-pub-8600651661481362" data-ad-slot="6536395538" data-ad-format="auto" data-adsbygoogle-status="done"><ins id="aswift_0_expand" style="display:inline-table;border:none;height:90px;margin:0;padding:0;position:relative;visibility:visible;width:911px;background-color:transparent"><ins id="aswift_0_anchor" style="display:block;border:none;height:90px;margin:0;padding:0;position:relative;visibility:visible;width:911px;background-color:transparent"><iframe width="911" height="90" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no" allowfullscreen="true" onload="var i=this.id,s=window.google_iframe_oncopy,H=s&amp;&amp;s.handlers,h=H&amp;&amp;H[i],w=this.contentWindow,d;try{d=w.document}catch(e){}if(h&amp;&amp;d&amp;&amp;(!d.body||!d.body.firstChild)){if(h.call){setTimeout(h,0)}else if(h.match){try{h=s.upd(h,i)}catch(e){}w.location.replace(h)}}" id="aswift_0" name="aswift_0" style="left:0;position:absolute;top:0;"></iframe></ins></ins></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
 Fin de Google Adsense -->
          </div>
        </div>
      </div>

      <div class="footer-copyright">
            <div class="container">
            © 2015 Copyright Desarrollado por Julio Vinachi
            <a class="grey-text text-lighten-4 right" href="#!">julio899@gmail.com</a>
            </div>
        </div>
      
    </footer>




      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>js/materialize.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-modal.js"></script>

      <script>

//variables de la tabla y que usaremos a lo largo de la ejecucion
var tabla=$('#tabla');
var tablallena=new Array();

      $('#proveedores').on('change', function() {

        //Armo la URL que me generara el Json de los productos para ese proveedor
        var url_json='<?php echo base_url().index_page();?>/ventas/buscar_productos_por_proveedor/'+this.value;
        
/*
$.getJSON(url_json, {format: "json"}, function(data) { 
//$("h1").html(data[0].title); 
//$("p").html(data[0].description); 
$("h1").html(data[0].descr);
});*/

$.ajax({
            'async': true,
            'global': false,
            'url': url_json,
            'dataType': "json",
            'success': function (data) {
                json = data;        
                $('#productos').html('');
                   for (var i = 0; i < json.length; i++) {
                     //alert(json[i].clave);
                     $('#productos').append('<option value="'+json[i].clave+'">'+json[i].clave+' - '+json[i].descr+'</option>');
                   };
               }
        });/*fin del Ajax para el Select de productos*/

}); //fin de las acciones cuando cambie de prooveedor



      $(document).ready(function(){


         $('.dropdown-button').dropdown();
         $(".button-collapse").sideNav();
         $('.modal-trigger').leanModal();

  $('.button-collapse').sideNav({
      menuWidth: 280, // Default is 240
    });




      });

/* ###########################  
   #    F U N C I O N E S    #
   ###########################  */
      
function cargar(){
              var codProveedor=$('#productos').val();
              var cantidad=$('#cantidad').val();
              var descripcion=$('#productos option:selected').text().substring(9);
              if(codProveedor!=null||codProveedor==0){

                                  if(cantidad!=null && cantidad>0){
                                          $('table#tabla > tbody').append('<tr><td>'+codProveedor+'</td><td>'+descripcion+'</td><td>'+cantidad+'</td></tr>');
                                          $('#cantidad').val('');
                    
                    
                                          
                                  }else{alert('INDIQUE LA CANTIDAD');}
      
              }else{alert('SELECCIONE UN PROVEEDOR');}
              
}/*fin de la funcion cargar*/

function finalizarPedido(){
  var tipo=$('#tipo').val();

  if($('#tabla tr').length >1 ){

      if(tipo!=null && tipo!=0){

              if(confirm("Esta seguro  de Finalizar y enviar este pedido?")){
                        var x=0;
                        $('#tabla tr').each(function(){
                          if(!this.rowIndex)return;//pasa la primera fila es decir la ignoramos por que es la cabecera de la tabla
                          var codigo=this.cells[0].innerHTML;
                          //var descripcion=this.cells[1].innerHTML;
                          var cantidad=this.cells[2].innerHTML;
                          
                            tablallena[x]=[codigo,cantidad];
                          x++;
                          });
                        
                          console.clear();
                         /*for(var z=1;z<tablallena.length;z++){
                            console.log('Registro: '+z+' *** codigo:'+tablallena[z][0]+' - Descripcion:'+tablallena[z][1]+'\tcantidad:'+tablallena[z][2]);
                             }*/

                              $('#detalle_pedido').append('<p class="alert alert-warning"><strong>Porfavor espere mientras es cargado su pedido...<strong></p>');
                              $('#detalle_pedido').append('<pre><h4>NO SALGA NI CANCELE ESTE PROCESO.<BR>PORFAVOR ESPERE...</h4></pre>');
                              $('#detalle_pedido').append('<div class="progress"><div class="indeterminate"></div></div>');

                              $('#myModal>div.modal-footer').hide();
                              $('#myModal').modal('show');
                              $('#myModal>div.modal-footer').show();
                              $('#myModal').show();
                        var nota_txt=$("#nota").val();
                        $.post('<?php echo base_url().index_page();?>/ventas/generar_pedido_confirmado/',{ productos: tablallena, tipo_venta:tipo , nota:nota_txt}, function(data) {
                            console.log(data);
                            if (data) {
                                                detalle_pedido();
                                                /*
                                               $('#tabla tr').each(function(){
                                               if(!this.rowIndex)return;//pasa la primera fila   
                                                //this.deleteCell();  //borra una celda interna   
                                                //this.remove();  
                                                $(this).find('td').html("");  
                                                $('#myModal').modal({
                                                    keyboard: false
                                                  });
                                                $('#myModal>div.modal-footer').show();
                                                $('#myModal').modal('show');  
                                                //console.log(this);
                                          });*/

                                 console.log('su pedido se ha registrado satisfactoriamente.');
                                                $("table#tabla > tbody").remove();
                                                console.log('borrando tabla');
                            }else{
                              alert('Ocurrio un prolema durante el proceso...\nNo se pudo procesar su pedido.');
                            }

                        });//fin del post


              }//fin del if de confirmacion

        }else{ alert("SELECCIONE TIPO DE VENTA\n\tCOD o CR-10"); }
            
    
  }else{
        alert("Tienes que agregar almenos (1) un producto.\nEste Pedido se encuentra vacio");
      }
}/*fin de la funcion de finalizar pedido*/

function detalle_pedido() {
   var url_json="<?php echo base_url().index_page();?>/ventas/ultimo_pedido/";
  $.ajax({
            'async': false,
            'global': false,
            'url': url_json,
            'dataType': "json",
            'success': function (data) {
                json = data;        
                $('#detalle_pedido').html('');
                     //alert(json);
                     $('#carga_detalle').append('<p><b>Pedido Cargado bajo el Nro.</b> <span class="nuevo badge">'+json+'</span><br></p>');
                    $('#modal1').openModal();
               }
        });/*fin del Ajax para pedido*/
}
      </script>
</body>
</html>