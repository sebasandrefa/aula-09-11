<?php
$situacao = "";
$nomeEmpresa = "SENAI";

$conteudoJson = __DIR__ ; "dados/teste.json";
$JsonAtualizado = file_get_contents($conteudoJson);
$chamados = json_decode($conteudoJson, true);


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