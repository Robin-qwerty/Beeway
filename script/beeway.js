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
