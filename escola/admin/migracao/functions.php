<?php 
    require "../connect/connect.php";
    class Caneta{
        var $tampada; 
        var $tinta;
        var $ponta;

        function __construct($tampada, $tinta, $ponta){
            $this->tampada = $tampada;
            $this->tinta = $tinta;
            $this->ponta = $ponta;
        }

        public function  exibirCaneta(){
            return "A caneta está tampada?" . $this->tampada . " e possui tinta " . $this->tinta . " e possui ponta " . $this->ponta;
        }
    }
?>