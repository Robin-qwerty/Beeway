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


// function addobservatie() {
//   alert("dfsadf");
//   var inputsDiv = document.getElementById("textareaobservatie");
//   var inputCount = inputsDiv.getElementsByTagName("input").length + 1;
//   var newInput = document.createElement("div");
//   newInput.innerHTML = '<label for="ingredient' + inputCount + '">ingredient ' + inputCount + ':</label> <br> <input type="text" placeholder="Enter ingredient ' + inputCount + '" name="ingredient' + inputCount + '" required> <button type="button" class="deletebutton" onclick="removeInput(this)">-</button>';
//   inputsDiv.appendChild(newInput);
// }
//
// function removeInput(button) {
//   button.parentNode.remove();
// }


$(document).ready(function(){
  $("#addplanning").click(function(){
    event.preventDefault();

    var done = "<div><input type=radio id=done name=done8></div>";


    $("#done").html(done);
  });
});
