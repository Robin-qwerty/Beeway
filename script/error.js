$(document).ready(function(){ // display errors
  if ("notification" in sessionStorage) {
    $("#notifipopup").html('<div class="alert warning"><strong>error,</strong> ' + sessionStorage.getItem("notification") + '</div>');
    sessionStorage.removeItem('notification');
  }
}); // end document ready
