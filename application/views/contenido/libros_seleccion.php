<style>
     .waves-effect.waves-brown .waves-ripple {
     /* The alpha value allows the text and background color
     of the button to still show through. */
      background-color: rgba(121, 85, 72, 0.65);
    }
       
</style>
<div class="container">
    
    <div class="row">
      <!--
      <form action="#">   
          <div class="col s3">
          <select>
            <option value="" disabled selected>Seleccione una Empresa</option>
            <option value="005">COMPACTO, C.A.</option>
            <option value="008">COMPACTO LARA</option>
            <option value="001">DIDECO, C.A.</option>
            <option value="002">DEIMPORT, C.A.</option>
            <option value="004">DEIMPORT LARA</option>
          </select>
          <label>SELECCION DE EMPRESA</label>  
          </div>

          <div class="col s3">
            <input type="date" class="datepicker">
          </div>
          <div class="col s6">
          
          <button class="btn waves-effect waves-light" type="submit" name="action">GENERAR LIBRO
          <i class="material-icons right">library_books</i>
          </button>
              
          </div>
      </form>
        -->
    </div>

    <div class="row">
      <div class="col s4">
       <ul class="collection">
        <li class="collection-item">Compacto <input type="date" class="datepicker"></li>
        <li class="collection-item">Dideco</li>
        <li class="collection-item">Deimport</li>
      </ul>
              
      </div>
      <div class="col s8">
         
         <div class="collection waves-color-demo">
            <div class="collection-item">Por Defecto <a href="#!" class="waves-effect btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-light</code><a href="#!" class="waves-effect waves-light btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-red</code><a href="#!" class="waves-effect waves-red btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-yellow</code><a href="#!" class="waves-effect waves-yellow btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-orange</code><a href="#!" class="waves-effect waves-orange btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-purple</code><a href="#!" class="waves-effect waves-purple btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-green</code><a href="#!" class="waves-effect waves-green btn secondary-content">Send</a></div>
            <div class="collection-item"><code class=" language-markup">waves-teal</code><a href="#!" class="waves-effect waves-teal btn secondary-content">Send</a></div>
          </div>

      </div>
    </div>
              
</div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="../js/materialize.min.js"></script>
      <script>
$(document).ready(function() {
    $('select').material_select();

    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 5, // Creates a dropdown of 15 years to control year
      format: 'mm/yyyy', 
      formatSubmit: 'mm/yyyy',
      startView: "months", 
      minViewMode: "months",
      monthsFull: [ 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'optubre', 'noviembre', 'diciembre' ],
      monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'sep', 'Opt', 'Nov', 'Dic' ],
    
    });


    $('.collapsible').collapsible({
    });

  });
      </script>