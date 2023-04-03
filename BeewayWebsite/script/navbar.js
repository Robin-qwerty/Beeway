var menulist = document.getElementById('menulist')
var menu = document.getElementById('menu')

menulist.style.height = '60px';
menu.style.display = 'none';

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


var radios = document.getElementsByTagName('input');
for(i=0; i<radios.length; i++ ) {
    radios[i].onclick = function(e) {
        if(e.ctrlKey || e.metaKey) {
            this.checked = false;
        }
    }
}
