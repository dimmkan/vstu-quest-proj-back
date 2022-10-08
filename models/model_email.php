<?php


class Model_Email extends Model_Base
{
    public $id;
    public $email;

    public function fieldsTable()
    {
        return array(
            'id' => 'id',
            'email' => 'email'
        );
    }
}