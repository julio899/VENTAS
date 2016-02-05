<div class="container">
    
    <div class="row">
      <br><br><br><br>
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
              <!-- Mes y año -->
            <input type="date" class="datepicker">
          </div>
          <div class="col s6">
          
          <button class="btn waves-effect waves-light" type="submit" name="action">GENERAR LIBRO
          <i class="material-icons right">library_books</i>
          </button>
              
          </div>
      </form>
        
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

  });
      </script>