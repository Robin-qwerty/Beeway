$(document).ready(function(){ // display errors
  if (typeof sessionStorage.getItem("error") !== 'undefined') {
    $("#errormsg").html(sessionStorage.getItem("error"));
    sessionStorage.removeItem('error');
  }
}); // end document ready
