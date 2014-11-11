<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-09 17:38:59
 * @version $Id$
 */

class Event{
    public $id;
    public $title;
    public $description;
    public $start;
    public $end;
    function __construct($event){
        if (is_array($event)) {
        	$this->id = $event['event_id'];
        	$this->title = $event['event_title'];
        	$this->description = $event['event_desc'];
        	$this->start = $event['event_start'];
        	$this->end = $event['event_end'];
        } else {
        	throw new Exception("No event data was supplied.");
        	
        }
    }
}