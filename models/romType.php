<?php
class romType {
    public int $id;
    public string $navn;
    public string $beskrivelse;
    public int $pris;
    public int $maxGjester;
    public $ledigeRom;

    public function __construct($id, $navn, $beskrivelse, $pris, $maxGjester, $ledigeRom)
    {
        $this->id = $id;
        $this->navn = $navn;
        $this->beskrivelse = $beskrivelse;
        $this->pris = $pris;
        $this->maxGjester = $maxGjester;
        $this->ledigeRom = $ledigeRom;
    }

    public function getId() {
        return $this->id;
    }

    public function getNavn() {
        return $this->navn;
    }

    public function getPris() {
        return $this->pris;
    }


}