<?php

class VersenySzam {

    private $nev;
    private $orszag;
    private $technikai;
    private $komponens;
    private $levonas;
    
    function __construct($nev, $orszag, $technikai, $komponens, $levonas) {
        $this->nev = $nev;
        $this->orszag = $orszag;
        $this->technikai = $technikai;
        $this->komponens = $komponens;
        $this->levonas = $levonas;
    }
    function getNev() {
        return $this->nev;
    }

    function getOrszag() {
        return $this->orszag;
    }

    function getTechnikai() {
        return $this->technikai;
    }

    function getKomponens() {
        return $this->komponens;
    }

    function getLevonas() {
        return $this->levonas;
    }

    function setNev($nev): void {
        $this->nev = $nev;
    }

    function setOrszag($orszag): void {
        $this->orszag = $orszag;
    }

    function setTechnikai($technikai): void {
        $this->technikai = $technikai;
    }

    function setKomponens($komponens): void {
        $this->komponens = $komponens;
    }

    function setLevonas($levonas): void {
        $this->levonas = $levonas;
    }

    function AktOsszPont(){
        return $this->getKomponens()+$this->getTechnikai()-$this->getLevonas();
    }
}
