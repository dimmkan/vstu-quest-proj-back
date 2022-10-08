<?php
// модель
Class Model_Users extends Model_Base {

    public $id;
    public $login;
    public $password;
    public $roles;

    public function fieldsTable(){
        return array(
            'id' => 'Id',
            'login' => 'Username',
            'password' => 'User password',
            'roles' => 'User roles',
        );
    }
}