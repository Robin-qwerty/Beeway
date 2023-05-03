$(document).ready(function(){
  if ("notification" in sessionStorage) {
    handlenotification()
  }

  if (window.location.pathname !== "/Beeway/login.html") {
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlesessioncheckdata, "SessionCheck", myJSON);
  }

  $("#loginbtn").on("click", function(){
    event.preventDefault();

    var school = $("#schoolselect option:selected").val();
    var email = $("#email").val();
    var psw = $("#psw").val();

    var psw5 = $.md5(psw);

    var obj = {'Email' : email, 'Psw' : psw5, 'School' : school};
    const myJSON = JSON.stringify(obj);

    HandleApiCall(handlelogindata, "Login", myJSON);
  })

}); // end document ready

function handlesessioncheckdata (result) {
  // alert(result);

  if (result == "OK") { // session valid
    // nothing happens
  } else if (result == "NOK1") { // session expired
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlelogoutdata, "Logout", myJSON);

    sessionStorage.clear();
    sessionStorage.setItem("notification", "session verlopen, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else if (result == "NOK2") { // session not found
    sessionStorage.clear();
    sessionStorage.setItem("notification", "session error, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else {
    sessionStorage.clear();
    sessionStorage.setItem("notification", "session error, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  }
}

function handlelogindata (result, div) {
  // alert(result);
  if (result == "NOK1") {
    sessionStorage.setItem("notification", "Selecteer een school!");
    handlenotification();
  } else if (result == "NOK2") {
    sessionStorage.setItem("notification", "Het email, wachtwoord of school komen niet overeen!");
    handlenotification();
  } else if (result == "NOK3") {
    sessionStorage.setItem("notification", "vul een eemail en een wachtwoord in!");
    handlenotification();
  } else {
    const obj = JSON.parse(result);

    sessionStorage.setItem("token", obj['Token']);
    sessionStorage.setItem("voornaam", obj['Voornaam']);
    window.location.replace("http://192.168.1.100/Beeway/beewaylijst.html");
  }
}


function handlelogoutdata (result, div){
  if (result == "NOK") {
    $("#errormsg").html("er was iets mis gegaan, pech!");
  }
}

function handlenotification() {
  $("#notifipopup").html('<div class="alert warning"><strong>error.</strong> ' + sessionStorage.getItem("notification") + '</div>').fadeIn();
  setTimeout(function(){ // popup fade out
    sessionStorage.removeItem('notification');
    $("#notifipopup").fadeOut();
  }, 3000);
}
