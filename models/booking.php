<?php

class booking
{

    public int $id;
    public int $bid;
    public int $rid;
    public int $antallVoksne;
    public string $antallBarn;
    public string $startPeriode;
    public string $sluttPeriode;
    public string $totalPris;
    public string $status;
    public ?rom $room = null;
    public function __construct($id,  $bid,  $rid, $antallVoksne, $antallBarn ,$startPeriode,  $sluttPeriode,  $totalPris,  $status)
    {
        $this->id = $id;
        $this->bid = $bid;
        $this->rid = $rid;
        $this->antallVoksne = $antallVoksne;
        $this->antallBarn = $antallBarn;
        $this->startPeriode = $startPeriode;
        $this->sluttPeriode = $sluttPeriode;
        $this->status = $status;
        $this->totalPris = $totalPris;

    }
}