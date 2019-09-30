function comprobar() {
    var http = new XMLHttpRequest();
    http.open("POST", "./nexo.php", true);
    http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    var correo = document.getElementById('correoTxt').value;
    var clave = document.getElementById("claveTxt").value;
    var usu = { "correo": correo, "clave": clave };
    http.send("usuario=" + JSON.stringify(usu) + "&op=existe");
    var respuesta;
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            //respuesta = JSON.parse(http.responseText);
            console.log(http.responseText);
        }
    };
}
function insertar() {
    var http = new XMLHttpRequest();
    http.open("POST", "./nexo.php", true);
    http.setRequestHeader("enctype", "multipart/form-data");
    var form = new FormData();
    var nombre = document.getElementById("nombreTxt").value;
    var apellido = document.getElementById("apellidoTxt").value;
    var correo = document.getElementById('correoTxt').value;
    var clave = document.getElementById("claveTxt").value;
    var perfil = document.getElementById("perfilTxt").value;
    var foto = document.getElementById("foto");
    var usu = { "nombre": nombre, "apellido": apellido, "perfil": perfil, "correo": correo, "clave": clave };
    form.append('op', "insertar");
    form.append('foto', foto.files[0]);
    form.append('usuario', JSON.stringify(usu));
    //http.send("usuario="+JSON.stringify(usu)+"&op=insertar");
    http.send(form);
    var respuesta;
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            respuesta = http.responseText;
            console.log(respuesta);
        }
    };
}
