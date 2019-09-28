function comprobar(){
    var http = new XMLHttpRequest();
    http.open("POST", "./nexo.php", true);
    http.setRequestHeader("content-type","application/x-www-form-urlencoded");
    let correo = (<HTMLInputElement>document.getElementById('correoTxt')).value;
    let clave = (<HTMLInputElement>document.getElementById("claveTxt")).value;
    let usu = {"correo": correo,"clave": clave};
    http.send("usuario="+JSON.stringify(usu));
    var respuesta;
    http.onreadystatechange = () => {
        if (http.readyState == 4 && http.status == 200) {
            respuesta = JSON.parse(http.responseText);
            console.log(respuesta);
        }
    }
}
function insertar(){
    var http = new XMLHttpRequest();
    http.open("POST", "./nexo.php", true);
    http.setRequestHeader("enctype", "multipart/form-data");
    let form : FormData = new FormData();
    let nombre = (<HTMLInputElement>document.getElementById("nombreTxt")).value;
    let apellido = (<HTMLInputElement>document.getElementById("apellidoTxt")).value;
    let correo = (<HTMLInputElement>document.getElementById('correoTxt')).value;
    let clave = (<HTMLInputElement>document.getElementById("claveTxt")).value;
    let perfil = (<HTMLInputElement>document.getElementById("perfilTxt")).value;
    let foto : any = (<HTMLInputElement>document.getElementById("foto"));

    let usu = {"nombre":nombre,"apellido":apellido, "perfil":perfil,"correo": correo,"clave": clave};

    form.append('op', "insertar");
    form.append('foto', foto.files[0]);
    form.append('usuario', JSON.stringify(usu));

    //http.send("usuario="+JSON.stringify(usu)+"&op=insertar");
    http.send(form);

    var respuesta;
    http.onreadystatechange = () => {
        if (http.readyState == 4 && http.status == 200) {
            respuesta = http.responseText;
            console.log(respuesta);
        }
    }
}