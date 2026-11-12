<?php
$situacao = "";
$nomeEmpresa = "SENAI";

$arquivoChamados = __DIR__ . "/../dados/chamados.json";
$conteudoJson = file_get_contents($arquivoChamados);
$chamados = json_decode($conteudoJson, true) ?: [];


function create(){
    $situacao = "aberto";
}

function read(){

}

function update(){
    
}

function delete(){
    
}



?>
