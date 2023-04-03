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
  // need to update previous on all elements of this group
  // (either that or store the id of the checked element)
  document.querySelectorAll(
      `input[type=radio][name=${this.name}]`).forEach((elem) => {
    elem.previous = elem.checked;
  });
}


//add row button
// var content = document.getElementById('WieTxt').value;
//
//    if(content === "")
//    {
//         window.alert ("This field cant be left empty");
//    }
