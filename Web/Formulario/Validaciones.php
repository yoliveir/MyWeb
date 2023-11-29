<?php

function ValidarNombre($usu){

    if (!ctype_upper($usu[0])){
        return false;
    }
    if (strlen($usu) > 12){
        return false;
    }
    return true;
}

function ValidarClave($clave){

    if (!ctype_upper($clave[0])){
        return false;
    }
    if (strlen($clave) < 5){
        return false;
    }
    return true;
}

function ValidarTitulo($titulo){

    if (!ctype_upper($titulo[0])){
            return false;
    }
    if (strlen($titulo) < 5){
        return false;
    }
    return true;
}

function gerarNomeAleatorio() {
    return mt_rand(100000000000000000, 999999999999999999);
}

?>