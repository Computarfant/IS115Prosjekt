<?php
class rom {
    public int $id;
    public string $navn;
    public string $beskrivelse;
    public int $etasje;
    public int $rtid;
    public ?romType $romType;

    public function __construct($id, $navn, $beskrivelse, $etasje, $rtid, $romType) {
        $this->id = $id;
        $this->navn = $navn;
        $this->beskrivelse = $beskrivelse;
        $this->etasje = $etasje;    
        $this->rtid = $rtid;
        $this->romType = $romType;  
    }
  

    public function getId() {
        return $this->id;
    }

    public function getRomType() {
        return $this->romType;
    }





}


