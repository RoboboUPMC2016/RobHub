<?php

/**
 * The class Behavior is the object representation
 * of a behavior entry of the database.
 */
class Behavior
{
    /** 
     * integer The Id of the behavior.
     */
    public $id;

    /** 
     * string The label of the behavior.
     */
    public $label;

    /** 
     * string The description of the behavior.
     */
    public $description;

    /** 
     * string The author of the behavior.
     */
    public $username;

    /** 
     * date The date of creation of the behavior.
     */
    public $timestamp;
}
?>