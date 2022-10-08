<?php


class Model_Log extends Model_Base
{
    public $id;
    public $username;
    public $event;
    public $date;

    public function fieldsTable(){
        return array(
            'id' => 'Id',
            'username' => 'Username',
            'event' => 'Event',
            'date' => 'Date of event',
        );
    }
}