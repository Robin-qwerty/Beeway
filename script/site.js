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

});
