<?php

$nomeEscola = "SENAI";

//exibir mensagem
function saudacao()
{
    return "BEM VINDO AO SISTEMA!";
}

//receber um nome
function cumprimentar($nome)
{
    return "OLÁ, " . $nome . "!";
}

//somar dois numeros
function somar($num1, $num2)
{
    $resultado = $num1 + $num2;
    return $resultado;
}

function calcularMedia($nota1, $nota2){
    $media = ($nota1 + $nota2) / 2;
    return $media;
}

function verificarStatus($media){
    if($media >= 7){
        return "APROVADO";
    }

    if($media >= 5 && $media <7){
        return "RECUPERAÇAO";
    }

    if($media < 5){
        return "REPROVADO";
    }
}