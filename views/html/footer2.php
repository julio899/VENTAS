<?php

$datauser=$this->session->userdata('datos_usuario');
?>
     
    </div>
  </main>
<!-- // FIN DEL CONTENIDO -->


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

      <script>
      $(document).ready(function(){
         $('.dropdown-button').dropdown();
         $(".button-collapse").sideNav();
      });
      </script>
</body>
</html>