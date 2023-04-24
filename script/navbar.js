var menulist = document.getElementById('menulist')
var menu = document.getElementById('menu')

menulist.style.height = '60px';
menu.style.display = 'none';
menu1.style.display = 'none';

function toggleresponsivemenu() {
  if (menulist.style.height == '60px') {
      menulist.style.height = '100%';
  }
  else {
    menulist.style.height = '60px';
  }
}

function togglemenu() {
  if (menu.style.display == 'none') {
      menu.style.display = 'block';
  }
  else {
    menu.style.display = 'none';
  }
}

function togglemenu1() {
  if (menu1.style.display == 'none') {
      menu1.style.display = 'block';
  }
  else {
    menu1.style.display = 'none';
  }
}

var radios = document.getElementsByTagName('input');
for(i=0; i<radios.length; i++ ) {
    radios[i].onclick = function(e) {
        if(e.ctrlKey || e.metaKey) {
            this.checked = false;
        }
    }
}

// display Good Morning/Afternoon/Evening

$(document).ready(function() {
  function dateTime() {
    var ndate = new Date();
    var hours = ndate.getHours();
    var message = hours < 12 ? 'Goedemorgen!' : hours < 18 ? 'Goedemiddag!' : 'Goedeavond!';
    $("h2.day-message").text(message);
  }

  setInterval(dateTime, 1000);
});

Number.prototype.leadingZeroes = function(len) {
  return (new Array(len).fill('0', 0).join('') + this).slice(-Math.abs(len));
}
