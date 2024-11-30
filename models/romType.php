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
}