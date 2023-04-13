$(document).ready(function(){

  HandelCall1();

  function HandelCall1() {
    //eerste call
    // var obj = { 'Week' : 1 };
    // const myJSON = JSON.stringify(obj);

    HandelApiCall(HandelData1, 'User', "", 'table');
  }

  function HandelData1(result, div) {
    let str = "#";
    str += div;
    $(str).html(result);
  }

  function HandelApiCall(callback, func, txtJSON, div) {
    if (func === "User") { var data = {User : txtJSON}; }

    $.ajax({
      type: "POST",
      url: "http://192.168.1.100//test/test.php",
      data: data,
        cache: false,
        crossDomain: true,
        success: function (msg) {
          callback(msg, div);
      }
    });
  }
});
