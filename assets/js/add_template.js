$(document).ready(function () {
    var arr = clients[$("#select_client").first().val()].split(",");
    $.each( arr, function( _index, project ) {
        $("#select_project").append('<option>'+project+'</option>');
      });
});

$( "#select_client" ).change(function() {
    var arr = clients[$( this ).val()].split(",");
    $("#select_project").empty();
    $.each( arr, function( _index, project ) {
        $("#select_project").append('<option>'+project+'</option>');
      });
  });