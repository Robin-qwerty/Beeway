function HandelApiCall(callback, func, txtJSON, target = "") {

  const key = func;
  const data = {[key] : txtJSON};

  $.ajax({
    type: "POST",
    url: "http://192.168.1.100//beeway/php/beeway.php",
    data: data,
    cache: false,
    crossDomain: true,
    success: function (msg) {
      callback(msg, target);
    }
  });
}
