$(document).ready(function(){
  // dynamisch beewaybewerken.html inladen
  let num = 1;

  while (num < 9) {
    var planning = "<div><input type=hidden name=planingid value=" + num + "><textarea type=text name=planning" + num + " rows=2 maxlength=74></textarea></div>";
    var wat = "<div><textarea type=text name=planningwat" + num + " rows=2 maxlength=74></textarea></div>";
    var wie = "<div><textarea type=text name=planningwie" + num + " WieTxt rows=2 maxlength=74></textarea></div>";
    var deadline = "<div><textarea type=text name=planningdeadline" + num + " rows=2 maxlength=74></textarea></div>";
    var done = "<div><input type=checkbox name=planninggedaan" + num + "></div>";

    $("#planning").append(planning);
    $("#wat").append(wat);
    $("#wie").append(wie);
    $("#deadline").append(deadline);
    $("#done").append(done);

    num ++;
  }

  while (num !== 14) {
    var observatie = "<div><input type=hidden name=observatieid value=" + num + "><textarea type=text name=observatietxt" + num + " rows=3 maxlength=155></textarea></div>";
    var leerdoel = "<div><textarea type=text name=leerdoeltxt" + num + " rows=3 maxlength=155></textarea></div>";
    var evaluatie = "<div><textarea type=text name=evaluatietxt" + num + " rows=3 maxlength=155></textarea></div>";
    var werkdoel = "<div><textarea type=text name=werkdoeltxt" + num + " rows=3 maxlength=155></textarea></div>";
    var actie = "<div><textarea type=text name=actietxt" + num + " rows=3 maxlength=155></textarea></div>";

    $("#observatie").append(observatie);
    $("#leerdoel").append(leerdoel);
    $("#evaluatie").append(evaluatie);
    $("#werkdoel").append(werkdoel);
    $("#actie").append(actie);

    num ++;
  }


  $("#opslaan").click(function(){ // handle data and send it to api when you click save button
    event.preventDefault();

    // var naam = $("#BeewayNaam").val();
    // var groepen = $("#Groepentxt").val();
    // var thema = $("input:radio[name='Hoofdthema']:checked").val();
    // var vak = $("#vakgebied option:selected").val();
    // var doel = $("#doel").val();
    // var beoordeling1 = $("#beoordeling1").val();
    // var beoordeling2 = $("#beoordeling2").val();
    // var beoordeling3 = $("#beoordeling3").val();
    //
    // console.log(naam + ", " + groepen + ", " + thema + ", " + vak + ", " + doel + ", " + beoordeling1 + ", " + beoordeling2 + ", " + beoordeling3);

    var object = $("#form0").serializeToJSON();
    var jsonString0 = JSON.stringify(object);
    // console.log(jsonString0);

    object = $("#form1").serializeToJSON();
    var jsonString1 = JSON.stringify(object);
    // console.log(jsonString1);

    object = $("#form2").serializeToJSON();
    var jsonString2 = JSON.stringify(object);
    // console.log(jsonString2);

    const data = {
      gen : jsonString0,
      plan : jsonString1,
      obs : jsonString2
    };

    var jsonString3 = JSON.stringify(data);

    HandleApiCall(handledata, "beeway", jsonString3);
    // console.log(jsonString3);
  })



  // send alerts if try to check/uncheck the status checkbox for beeway

  const checkbox = document.getElementById("my-checkbox");

  checkbox.addEventListener("click", function(event) {
    if (checkbox.checked) {
      if (!window.confirm("Weet je zekker dat je deze beeway als afgerond wilt markeren!? Je kan deze dan niet meer bewerken")) {
        event.preventDefault();
      }
    } else {
      if (!window.confirm("Weet je zekker dat je deze beeway niet langer wilt markeren als afgerond!?")) {
        event.preventDefault();
      }
    }
  });

}); // end document ready


function handledata(result, div){
  // alert(result);
}
