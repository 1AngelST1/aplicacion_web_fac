<?php
$xml = simplexml_load_file("xmlgeneral.xml");
$alumnos = $xml->xpath("/facultad/posgrado/maestria/areas/area/alumnos/alumno");

if (isset($_GET["id"])) {
  #Recuperar datos el ID dado
  $actividad = $xml->xpath("/facultad/posgrado/maestria/actividades_extracurriculares/actividad[@clave_actividad='".$_GET["id"]."']");
}
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Actividades Extracurriculares</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="css/estilos.css"/>
    <script src="js/external/jquery/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
  </head>
  <script type="text/javascript">
    function guardar() {
      $.ajax({
        //Guardar/Editar Registro
        url: "include/funciones.php",
        type: "post",
        data: $("#formulario").serialize(),
        success: function (response) {
          console.log(response);
          if ( response == "0" ) {
            //Error Clave de actividad ya existe
              $( "<div>La clave de actividad ya ha sido establecida.</div>" ).dialog({
                title:"Error",
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                  "Entendido": function() {
                    $( this ).dialog( "close" );
                  }
                }
              });
          } else if ( response == "-1" ) {
            //Error: Alumno no existe
              $( "<div>La matrícula del alumno no existe en el sistema.</div>" ).dialog({
                title:"Error - Alumno no existe",
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                  "Entendido": function() {
                    $( this ).dialog( "close" );
                  }
                }
              });
          } else if ( response == "-2" ) {
            //Error: Alumno ya inscrito en esta actividad
              $( "<div>El alumno ya está inscrito en esta actividad.</div>" ).dialog({
                title:"Error - Inscripción duplicada",
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                  "Entendido": function() {
                    $( this ).dialog( "close" );
                  }
                }
              });
          } else {
            $( "<div>Acción Completada.</div>" ).dialog({
              title:"Acción Completada",
              resizable: false,
              height: "auto",
              width: 400,
              modal: true,
              buttons: {
                "Entendido": function() {
                  $( this ).dialog( "close" );
                  document.location='xmlgeneral.xml';
                }
              }
            });
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
        }
  		});
    }
  </script>
  <body class="fondo_main">
    <br/>
    <div class="container">
      <div align="center" class="logo-container">
        <img src="assets/escudo_buap.png" width="200px" height="200px"/>
        <img src="assets/letras.png" width="350px" height="90px" style="margin-left: 25px;"/>
      </div>
    </div>
    <h2 align="center" class="titulo" style="color: #FFFFFF !important;">Registrar Actividad Extracurricular</h2>
      <form role="form" id="formulario" name="formulario" action="javascript:guardar();">
        <div class="container" style="margin-top:50px; max-width:1200px;">
          <div class="card">
            <h5 class="card-header d-flex justify-content-center align-items-center" style="color: #FFFFFF !important; font-weight: 600;"><i class="fas fa-futbol" style="margin-right: 10px;"></i>Datos de la Actividad</h5>
            <div class="card-body">
              <div class="container" style="margin-top:20px; margin-bottom:20px; padding:20px;">
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Clave de Actividad:</label>
                    <input type="text" name="clave_actividad" id="clave_actividad" class="form-control" required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->attributes()->clave_actividad."' disabled";}?>>
                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET["id"])?$_GET["id"]:"") ?>" />
                    <input type="hidden" name="acc" id="acc" value="<?php echo (isset($_GET["id"])?"2":"1") ?>" />
                    <input type="hidden" name="tipo" id="tipo" value="4" />
                  </div>
                  <div class="form-group col-md-9">
                    <label>Nombre de la Actividad:</label>
                    <input type="text" name="nombre_actividad" class="form-control" required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->nombre_actividad."'";}?>>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Tipo de Actividad:</label>
                    <select class="custom-select" name="tipo_actividad" required>
                      <option value="">Seleccione una opción</option>
                      <option value="Cultural" <?php if (isset($_GET["id"]) && $actividad[0]->tipo == "Cultural") {echo "selected";}?>>Cultural</option>
                      <option value="Deportivo" <?php if (isset($_GET["id"]) && $actividad[0]->tipo == "Deportivo") {echo "selected";}?>>Deportivo</option>
                      <option value="Idiomas" <?php if (isset($_GET["id"]) && $actividad[0]->tipo == "Idiomas") {echo "selected";}?>>Idiomas</option>
                      <option value="Social" <?php if (isset($_GET["id"]) && $actividad[0]->tipo == "Social") {echo "selected";}?>>Social</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Instructor/Responsable:</label>
                    <input type="text" name="instructor" class="form-control" required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->instructor."'";}?>>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Matrícula del Alumno:</label>
                    <select class="custom-select" name="matricula_alumno" required>
                      <option value="">Seleccione un alumno</option>
                      <?php foreach ($alumnos as $alumno): ?>
                        <option value="<?php echo $alumno->matricula; ?>" 
                        <?php if (isset($_GET["id"]) && $actividad[0]->matricula_alumno == $alumno->matricula) {echo "selected";}?>>
                          <?php echo $alumno->matricula." - ".$alumno->nombre; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Días de la Semana:</label>
                    <input type="text" name="dias_semana" class="form-control" placeholder="Ej: L-M-V, Sábados, etc." required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->dias_semana."'";}?>>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Horario:</label>
                    <input type="text" name="horario" class="form-control" placeholder="Ej: 14:00 - 16:00" required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->horario."'";}?>>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Lugar/Sede:</label>
                    <input type="text" name="lugar" class="form-control" placeholder="Ej: Complejo Deportivo, Centro de Lenguas" required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->lugar."'";}?>>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Costo Semestral:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                      </div>
                      <input type="number" name="costo_semestral" class="form-control" step="0.01" min="0" required
                      <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->costo_semestral."'";}?>>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Créditos Complementarios:</label>
                    <input type="number" name="creditos_complementarios" class="form-control" min="0" required
                    <?php if (isset($_GET["id"])) {echo "value='".$actividad[0]->creditos_complementarios."'";}?>>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <?php if (!isset($_GET["id"])): ?>
            <div align="center" style="margin-bottom: 20px;">
              <button type="submit" class="btn btn-primary boton_guardar" style="width:100%; max-width:350px;">Guardar</button>
            </div>
          <?php else: ?>
            <div align="center" style="margin-bottom: 20px;">
              <button type="submit" class="btn btn-primary boton_editar" style="width:100%; max-width:350px;">Editar</button>
            </div>
          <?php endif; ?>
        </div>
      </form>
  </body>
</html>
