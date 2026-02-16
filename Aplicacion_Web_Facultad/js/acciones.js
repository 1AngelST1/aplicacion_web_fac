function agregar(tipo){
  switch (tipo) {
    case 1:
        window.location.href = "estudiantes.php";
      break;
    case 2: //Para Profesores
      window.location.href = "profesores.php";
      break;
    case 3: //Para Materias
      window.location.href = "materias.php";
      break;
    case 4: //Para Actividades Extracurriculares
      window.location.href = "actividades.php";
      break;
  }
}

function editar(id,tipo){
  switch (tipo) {
    case 1: //Para BD
      window.location.href = "estudiantes.php?id="+id;
      break;
    case 2: //Para SD
      window.location.href = "profesores.php?id="+id;
      break;
    case 3: //Para ISI
      window.location.href = "materias.php?id="+id;
      break;
    case 4: //Para Actividades
      window.location.href = "actividades.php?id="+id;
      break;
  }
}

function editarEstudiante(id,tipo,area){
  switch (area) {
    case "BD": //Para BD
      window.location.href = "estudiantes.php?id="+id+"&area="+area;
      break;
    case "SD": //Para SD
      window.location.href = "estudiantes.php?id="+id+"&area="+area;
      break;
    case "ISI": //Para ISI
      window.location.href = "estudiantes.php?id="+id+"&area="+area;
      break;
    case "CM": //Para CM
      window.location.href = "estudiantes.php?id="+id+"&area="+area;
      break;
  }
}

function eliminar(id,tipo){
  var aviso = "Titulo";
  var aviso2 = "";
  
  switch (tipo) {
    case 1: //Para Estudiantes
      aviso = "¿Eliminar Estudiante?";
      aviso2 = "Estudiante Eliminado";
      break;
    case 2: //Para Profesores
      aviso = "¿Eliminar Profesor?";
      aviso2 = "Profesor Eliminado";
      break;
    case 3: //Para Materias
      aviso = "¿Eliminar Materia?";
      aviso2 = "Materia Eliminado";
      break;
    case 4: //Para Actividades
      aviso = "¿Eliminar Actividad?";
      aviso2 = "Actividad Eliminada";
      break;
  }

  $( "<div>Esta acción no se puede deshacer... ¿Desea continuar?</div>" ).dialog({
    title: aviso,
    resizable: false,
    height: "auto",
    width: 400,
    modal: true,
    buttons: {
      "Eliminar": function() {
        $( this ).dialog( "close" );
        $.ajax({
          //Eliminar Registro
          data: {acc:"3",id:id,tipo:tipo},
          url: "include/funciones.php",
          type: "post",
          success: function (response) {
            $( "<div>Accion Completada</div>" ).dialog({
              title:"Acción Completada",
              resizable: false,
              height: "auto",
              width: 400,
              modal: true,
              buttons: {
                "Entendido": function() {
                  $( this ).dialog( "close" );
                  location.reload();
                }
              }
            });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
          }
        });
      },
      "Cancelar": function() {
        $( this ).dialog( "close" );
      }
    }
  });
}
