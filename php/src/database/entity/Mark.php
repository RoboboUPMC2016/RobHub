<?php

/**
 * The class Mark is the object representation
 * of a mark entry of the database.
 */
class Mark
{
    /** 
     * integer The Id of the mark.
     */
    public $id;

    /** 
     * integer The value of the mark.
     */
    public $value;

    /** 
     * integer The Id of the behavior.
     */
    public $behaviorId;

    /** 
     * string The username of the user who rates the mark.
     */
    public $userUsername;
}
?>