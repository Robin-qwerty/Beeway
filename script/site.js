$(document).ready(function(){

  if (window.location.pathname !== "/Beeway/login.html") {
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandelApiCall(handelsessioncheckdata, "SessionCheck", myJSON);
  }

  $("#loginbtn").on("click", function(){
    event.preventDefault();

    var school = $("#schoolselect option:selected").val();
    var email = $("#email").val();
    var psw = $("#psw").val();

    var psw5 = $.md5(psw);

    var obj = {'Email' : email, 'Psw' : psw5, 'School' : school};
    const myJSON = JSON.stringify(obj);

    HandelApiCall(handellogindata, "Login", myJSON);
  })

}); // end document ready

function handelsessioncheckdata (result) {
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

function handellogindata (result, div) {
  // alert(result);
  if (result == "NOK1") {
    $("#errormsg").html("Selecteer een school!");
  } else if (result == "NOK2") {
    $("#errormsg").html("Het email, wachtwoord of school komen niet overeen!");
  } else {
    const obj = JSON.parse(result);

    sessionStorage.setItem("token", obj['Token']);
    sessionStorage.setItem("voornaam", obj['Voornaam']);
    window.location.replace("http://192.168.1.100/Beeway/beewaylijst.html");
  }
}
