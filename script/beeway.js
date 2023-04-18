document.querySelectorAll(
  'input[type=radio][name=Hoofdthema]').forEach((elem) => {
    elem.addEventListener('click', allowUncheck);
});

document.querySelectorAll(
  'input[type=radio][id=done]').forEach((elem) => {
    elem.addEventListener('click', allowUncheck);
});

function allowUncheck(e) {
  if (this.previous) {
    this.checked = false;
}

document.querySelectorAll(
    `input[type=radio][name=${this.name}]`).forEach((elem) => {
    elem.previous = elem.checked;
  });
}


// let num = 9;
//
// $(document).ready(function(){
//   $("#addplanning").click(function(){
//
//     event.preventDefault();
//
//     var planning = "<div><textarea type=text name=PlaningTxt" + num + " rows=2 maxlength=74></textarea></div>";
//     var wat = "<div><textarea type=text name=WatTxt" + num + " rows=2 maxlength=74></textarea></div>";
//     var wie = "<div><textarea type=text name=WieTxt" + num + " WieTxt rows=2 maxlength=74></textarea></div>";
//     var deadline = "<div><textarea type=text name=DeadlineTxt" + num + " rows=2 maxlength=74></textarea></div>";
//     var done = "<div><input type=radio id=done name=done" + num + "></div>";
//
//     $("#planning").append(planning);
//     $("#wat").append(wat);
//     $("#wie").append(wie);
//     $("#deadline").append(deadline);
//     $("#done").append(done);
//
//     num ++;
//     console.log(num);
//   });
// });


$(document).ready(function(){
  $("#opslaan").click(function(){
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
    //
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

    HandelApiCall(handeldata, "beeway", jsonString3);

    // console.log(jsonString3);

  })
});


function handeldata (result, div){
  alert(result);
}
