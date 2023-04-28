$(document).ready(function(){

  // session check
  var obj = {'Token' : sessionStorage.getItem("token")};
  const myJSON = JSON.stringify(obj);
  HandelApiCall(handelsessioncheckdata, "SessionCheck", myJSON);


  if (window.location.pathname == "/Beeway/beewaylijst.html") { // get all beeways the user can see
    HandelApiCall(handelbeewaylijstdata, "AllBeeways", myJSON, "beewaylijstdata");
  } else if (window.location.pathname == "/Beeway/klassenlijst.html") {

  } else if (window.location.pathname == "/Beeway/vakkenlijst.html") {

  } else if (window.location.pathname == "/Beeway/Hoofdthemalijst.html") {

  } else if (window.location.pathname == "/Beeway/userlijst.html") {
    HandelApiCall(handeluserlijstdata, "AllUsers", myJSON, "userlijstdata");
  } else if (window.location.pathname == "/Beeway/scholenlijst.html") {

  }

  $("#adduserbtn").on("click", function(){
    event.preventDefault();

    var obj = $(".adduserform").serializeJSON();
    var jsonString = JSON.stringify(obj);
  })
}); // end document ready

function handelsessioncheckdata (result){
  if (result == "OK") { // session valid
    // nothing happens
  } else if (result == "NOK1") { // session expired
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandelApiCall(handellogoutdata, "Logout", myJSON);

    sessionStorage.clear();
    sessionStorage.setItem("error", "session verlopen, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else if (result == "NOK2") { // session not found
    sessionStorage.clear();
    sessionStorage.setItem("error", "session error, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else {
    sessionStorage.clear();
    sessionStorage.setItem("error", "session error, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  }
}

function handelbeewaylijstdata(result, div) {
  // alert(result);
  div = "#" + div;

  if (result == "NOK") { // error
    sessionStorage.setItem("error", "Er ging iets mis, probeer latter opnieuw!");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("error", "De tabel die u probeerd te bekijken is leeg!");
  } else {
     $(div).append(result);
  }
}

function handeluserlijstdata(result, div) {
  alert(result);
  div = "#" + div;

  if (result == "NOK") { // error
    sessionStorage.setItem("error", "Er ging iets mis, probeer latter opnieuw!");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("error", "De tabel die u probeerd te bekijken is leeg!");
  } else {
     $(div).append(result);
  }
}
