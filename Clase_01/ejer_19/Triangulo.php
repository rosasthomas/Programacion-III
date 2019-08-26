<?php
require_once "FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica{
 private $altura;
 private $base;

 public function _construct(float $b, float $h){
     $this->altura = h;
     $this->base = b;
 }

 public function Dibujar(){
     parent::$superficie = ($this->altura * $this->base) /2;
     parent::$perimetro = $this->altura + $this->base;
 }










}
?>