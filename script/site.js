$(document).ready(function(){ // gaat acties van knopen over de hele site afhandelen (?)
  $("#adduserbtn").on("click", function(){
    alert("test");

    event.preventDefault();

    var obj = $(".adduserform").serializeJSON();
      var jsonString = JSON.stringify(obj);
      console.log(jsonString);
  })

  // var obj = $(".adduserform").serializeToJSON();
  //   var jsonString = JSON.stringify(obj);
  //   console.log(jsonString);

  $("#logoutbtn").on("click", function(){
    event.preventDefault();

    sessionStorage.clear();
    window.location.replace("http://192.168.1.100/Beeway/login.html");
  })

  $("#cookiebutton").on("click", function(){
    HandelApiCall(handelcookiedata, "sessiontest", "");
  })

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
});

function handelcookiedata (result){
  console.log(result);
}

function handellogindata (result, div){
  if (result == "NOK1") {
    $("#errormsg").html("Selecteer een school!");
  } else if (result == "NOK2") {
    $("#errormsg").html("Het email en wachtwoord komen niet overeen!");
  } else {
    const obj = JSON.parse(result);

    sessionStorage.setItem("token", obj['Token']);
    sessionStorage.setItem("voornaam", obj['Voornaam']);
    window.location.replace("http://192.168.1.100/Beeway/scholenlijst.html");
  }
}
