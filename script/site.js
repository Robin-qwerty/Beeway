$(document).ready(function(){
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
