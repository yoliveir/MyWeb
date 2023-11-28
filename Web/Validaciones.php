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

function ValidarEmail($email) {
    // Verificar o formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Separar o domínio do e-mail
    list($usuario, $dominio) = explode('@', $email);

    if (!checkdnsrr($dominio, 'MX')) {
        return false;
    }

    return true;
}

?>