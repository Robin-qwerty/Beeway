$(document).ready(function(){
  if ("notification" in sessionStorage) {
    handlenotification();
  }
  // session check
  var obj = {'Token' : sessionStorage.getItem("token")};
  const myJSON = JSON.stringify(obj);
  HandleApiCall(handlesessioncheckdata, "DashboardCheck", myJSON);


  if (window.location.pathname == "/Beeway/beewaylijst.html") { // get all beeways the user can see
    HandleApiCall(handlebeewaylistdata, "AllBeeways", myJSON, "beewaylijstdata");
  } else if (window.location.pathname == "/Beeway/klassenlijst.html") {
    HandleApiCall(handlegrouplistdata, "AllGroups", myJSON, "klassenlijstdata");
  } else if (window.location.pathname == "/Beeway/vakkenlijst.html") {
    HandleApiCall(handldisciplineslistdata, "AllDisciplines", myJSON, "vakkenlijstdata");
  } else if (window.location.pathname == "/Beeway/Hoofdthemalijst.html") {
    HandleApiCall(handlemainthemelistdata, "AllMainthemes", myJSON, "hoofdthemalijstdata");
  } else if (window.location.pathname == "/Beeway/userlijst.html") {
    HandleApiCall(handleuserlistdata, "AllUsers", myJSON, "userlijstdata");
  } else if (window.location.pathname == "/Beeway/scholenlijst.html") {
    HandleApiCall(handleschoollistdata, "AllSchools", myJSON, "scholenlijstdata");
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
  // console.log(result);

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




function handlebeewaylistdata(result, div) { // beewaylijst
  // alert(result);
  div = "#" + div;

  // if (result == "NOK") { // error
  //   sessionStorage.setItem("notification", "Er ging iets mis, probeer latter opnieuw!");
  // } else if (result == "NOK1") { // session expired
  //   var obj = {'Token' : sessionStorage.getItem("token")};
  //   const myJSON = JSON.stringify(obj);
  //   HandleApiCall(handlelogoutdata, "Logout", myJSON);
  //
  //   sessionStorage.clear();
  //   sessionStorage.setItem("notification", "session verlopen, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // } else if (result == "NOK2") { // session not found
  //   sessionStorage.clear();
  //   sessionStorage.setItem("notification", "session error, log opnieuw in");
  //   window.location.replace("http://192.168.1.100/Beeway/login.html");
  // } else if (result == "NOK3") { // not found
  //   sessionStorage.setItem("notification", "De tabel die u probeerd te bekijken is leeg!");
  // } else {
  //    $(div).append(result);
  // }
}

function handleuserlistdata(result, div) { // userlijst for supper users and school admins
  // alert(result);
  div = "#" + div;

  if (result == "NOK!") { // no user found
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlelogoutdata, "Logout", myJSON);
    sessionStorage.clear();
    sessionStorage.setItem("notification", "session error, log opnieuw in");
  } else if (result == "NOK") { // error
    sessionStorage.setItem("notification", "daar mag je niet komen, pech");
    window.location.replace("http://192.168.1.100/Beeway/beewaylijst.html");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("notification", "De tabel die u probeerd te bekijken is leeg!");
    handlenotification();
  } else {
     $(div).append(result);
  }
}

function handleschoollistdata(result, div) { // schools table
  // alert(result);
  div = "#" + div;

  if (result == "NOK!") { // no user found
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlelogoutdata, "Logout", myJSON);
    sessionStorage.clear();
    sessionStorage.setItem("notification", "session error, log opnieuw in");
  } else if (result == "NOK") { // error
    sessionStorage.setItem("notification", "daar mag je niet komen, pech");
    window.location.replace("http://192.168.1.100/Beeway/beewaylijst.html");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("notification", "De tabel die u probeerd te bekijken is leeg!");
    handlenotification();
  } else {
     $(div).append(result);
  }
}

function handlemainthemelistdata(result, div) { // maintheme table
  // alert(result);
  div = "#" + div;

  if (result == "NOK!") { // no user found
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlelogoutdata, "Logout", myJSON);
    sessionStorage.clear();
    sessionStorage.setItem("notification", "session error, log opnieuw in");
  } else if (result == "NOK") { // error
    sessionStorage.setItem("notification", "daar mag je niet komen, pech");
    window.location.replace("http://192.168.1.100/Beeway/beewaylijst.html");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("notification", "De tabel die u probeerd te bekijken is leeg!");
    handlenotification();
  } else {
     $(div).append(result);
  }
}

function handldisciplineslistdata(result, div) { // maintheme table
  // alert(result);
  div = "#" + div;

  if (result == "NOK!") { // no user found
    var obj = {'Token' : sessionStorage.getItem("token")};
    const myJSON = JSON.stringify(obj);
    HandleApiCall(handlelogoutdata, "Logout", myJSON);
    sessionStorage.clear();
    sessionStorage.setItem("notification", "session error, log opnieuw in");
  } else if (result == "NOK") { // error
    sessionStorage.setItem("notification", "daar mag je niet komen, pech");
    window.location.replace("http://192.168.1.100/Beeway/beewaylijst.html");
  } else if (result == "NOK1") { // not found
    sessionStorage.setItem("notification", "De tabel die u probeerd te bekijken is leeg!");
    handlenotification();
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


function handlelogoutdata (result, div) { // hadle user logout
  if (result == "NOK") {
    sessionStorage.setItem("notification", "er was iets mis gegaan, pech!");
  }
}

function handlenotification() {
  $("#notifipopup").html('<div class="alert warning"><strong>error.</strong> ' + sessionStorage.getItem("notification") + '</div>').fadeIn();
  setTimeout(function(){ // popup fade out
    sessionStorage.removeItem('notification');
    $("#notifipopup").fadeOut();
  }, 3000);
}
