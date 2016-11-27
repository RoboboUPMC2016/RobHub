<?php
class Behavior
{
    public $id;           // Integer
    public $label;        // String
    public $description;  // String
    public $username;     // String
    public $timestamp;    // Date

    public function __construct($label, $description, $username)
    {
    	$this->label = $label;
    	$this->description = $description;
    	$this->username = $username;
    }
}
?>