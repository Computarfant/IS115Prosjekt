<?php
class romType {
    public $id;
    public $navn;
    public $beskrivelse;
    public $pris;
    public $maxGjester;
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
}
