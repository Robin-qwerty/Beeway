$(document).ready(function(){

  var obj = {'Token' : sessionStorage.getItem("token")};
  const myJSON = JSON.stringify(obj);
  HandelApiCall(handelsessioncheckdata, "SessionCheck", myJSON);

  if (window.location.pathname !== "/Beeway/beewaylijst.html") {
    HandelApiCall(handelbeewaylijstdata, "AllBeeways", "");
  }
  function handelbeewaylijstdata(result, div) {
    // alert(result);
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
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else if (result == "NOK2") { // session not found
    sessionStorage.clear();
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  } else {
    sessionStorage.clear();
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  }
}
