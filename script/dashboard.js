$(document).ready(function(){

  // session check
  var obj = {'Token' : sessionStorage.getItem("token")};
  const myJSON = JSON.stringify(obj);
  HandleApiCall(handlesessioncheckdata, "DashboardCheck", myJSON);


  if (window.location.pathname == "/Beeway/beewaylijst.html") { // get all beeways the user can see
    HandleApiCall(handlebeewaylijstdata, "AllBeeways", myJSON, "beewaylijstdata");
  } else if (window.location.pathname == "/Beeway/klassenlijst.html") {

  } else if (window.location.pathname == "/Beeway/vakkenlijst.html") {

  } else if (window.location.pathname == "/Beeway/Hoofdthemalijst.html") {

  } else if (window.location.pathname == "/Beeway/userlijst.html") {
    HandleApiCall(handleuserlijstdata, "AllUsers", myJSON, "userlijstdata");
  } else if (window.location.pathname == "/Beeway/scholenlijst.html") {
    HandleApiCall(handlescholenlijstdata, "AllScholen", myJSON, "scholenlijstdata");
  }

// beeway lijst troep

  $("#beewaylijstdata").on("click", ".beewaybutton", function(){ // eddit a beeway
    const row = $(this).closest('tr');
    const content = row.find('td:eq(7)').text();

    var obj = {'Token' : sessionStorage.getItem("token"), 'BeewayId' : content};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlebeewayperpersondata, "getbeewayperuser", myJSON);
  });

  // $("#beewaylijstdata").on("click", ".loadmorebeeway", function(){ // loade more beeways
  //   const row = $(this).closest('tr:last');
  //   const content = row.find('td:eq(7)').text();
  //
  //   var obj = {'Token' : sessionStorage.getItem("token"), 'Lastbeewayid' : };
  //   const myJSON = JSON.stringify(obj);
  //
  //   alert("test");
  // });

  $("#beewaylijstdata").on("click", ".edituser", function(){ // eddit a beeway
    const row = $(this).closest('tr');
    const content = row.find('td:eq(5)').text();

    var obj = {'Token' : sessionStorage.getItem("token"), 'BeewayId' : content};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handleedituserdata, "getedituserdata", myJSON);
  });

  $("#adduserbtn").on("click", function(){
    event.preventDefault();

    var obj = $(".adduserform").serializeJSON();
    var jsonString = JSON.stringify(obj);
  });

}); // end document ready

function handlesessioncheckdata (result) { // handle session check
  console.log(result);

  // if (result == "OK") { // session valid
  //   // nothing happens
  // } else if (result == "NOK1") { // session expired
  //   var obj = {'Token' : sessionStorage.getItem("token")};
  //   const myJSON = JSON.stringify(obj);
  //   handleApiCall(handlelogoutdata, "Logout", myJSON);
  //
  //   sessionStorage.clear();
  //   sessionStorage.setItem("error", "session verlopen, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // } else if (result == "NOK2") { // session not found
  //   sessionStorage.clear();
  //   sessionStorage.setItem("error", "session error, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // } else {
  //   sessionStorage.clear();
  //   sessionStorage.setItem("error", "session error, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // }
}




function handlebeewaylijstdata(result, div) { // beewaylijst
  // alert(result);
  div = "#" + div;

  // if (result == "NOK") { // error
  //   sessionStorage.setItem("error", "Er ging iets mis, probeer latter opnieuw!");
  // } else if (result == "NOK1") { // session expired
  //   var obj = {'Token' : sessionStorage.getItem("token")};
  //   const myJSON = JSON.stringify(obj);
  //   handleApiCall(handlelogoutdata, "Logout", myJSON);
  //
  //   sessionStorage.clear();
  //   sessionStorage.setItem("error", "session verlopen, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // } else if (result == "NOK2") { // session not found
  //   sessionStorage.clear();
  //   sessionStorage.setItem("error", "session error, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // } else if (result == "NOK3") { // not found
  //   sessionStorage.setItem("error", "De tabel die u probeerd te bekijken is leeg!");
  // } else {
  //    $(div).append(result);
  // }
}

function handleuserlijstdata(result, div) { // userlijst
  alert(result);
  div = "#" + div;

  if (result == "NOK") { // error
    sessionStorage.setItem("error", "Er ging iets mis, probeer latter opnieuw!");
  } else if (result == "NOK1") { // session expired
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    handleApiCall(handlelogoutdata, "Logout", myJSON);

    sessionStorage.clear();
    sessionStorage.setItem("error", "session verlopen, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else if (result == "NOK2") { // session not found
    sessionStorage.clear();
    sessionStorage.setItem("error", "session error, log opnieuw in");
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else if (result == "NOK3") { // not found
    sessionStorage.setItem("error", "De tabel die u probeerd te bekijken is leeg!");
  } else {
     $(div).append(result);
  }
}

function handlescholenlijstdata(result, div) { // scholenlijst
  // alert(result);
  div = "#" + div;
  // alert("asdf");
  if (result == "NOK!") { // error
    sessionStorage.setItem("error", "Er ging iets mis, probeer latter opnieuw!");
  } else if (result == "NOK") { // error
    sessionStorage.setItem("error", "Er ging iets mis, probeer latter opnieuw!");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("error", "De tabel die u probeerd te bekijken is leeg!");
  } else {
     $(div).append(result);
  }
}



function handlebeewayperpersondata(result, div) {
  // alert(result);

}
function handleedituserdata(result, div) {
  // alert(result);

}
