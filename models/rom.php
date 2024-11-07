<?php
class rom {
    public $id;              
    public $etasje;         
    public $romTypeId;      
    public $romType;         

    public function __construct($id, $etasje, $romTypeId, $romType) {
        $this->id = $id;           
        $this->etasje = $etasje;    
        $this->romTypeId = $romTypeId;
        $this->romType = $romType;  
    }
  
}

?>

