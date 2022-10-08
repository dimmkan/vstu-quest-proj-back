<?php


class Controller_Users extends Controller_Base
{

    function index()
    {
        $model = new Model_Users();
        $userInfo = $model->getAllRows();
        echo json_encode($userInfo);
    }

    function delete(){
        $userId = $this->vars[0];
        $select = array(
            'where' => "id = $userId"
        );
        $model = new Model_Users();
        $model->deleteBySelect($select);
    }

    function update(){
        $body = json_decode(file_get_contents('php://input'));
        $userId = $this->vars[0];
        $select = array(
          'where' => "id = $userId",

        );
        $model = new Model_Users($select);
        $model->fetchOne();
        $model->login = $body->login;
        $model->password = md5($body->password);
        $model->update();
    }

    function auth(){
        $body = json_decode(file_get_contents('php://input'));
        $pw = md5($body->password);
        $select = array(
          'where' => "login = '$body->login' AND password = '$pw'"
        );
        $model = new Model_Users($select);
        $isAuth = $model->fetchOne();
        echo json_encode(array('isAuth' => $isAuth, 'roles' => $model->roles, 'userId' => $model->id));
    }

    function refreshpass(){
        $body = json_decode(file_get_contents('php://input'));
        $userId = $this->vars[0];
        $select = array(
            'where' => "id = $userId",

        );
        $model = new Model_Users($select);
        $model->fetchOne();
        $model->password = md5($body->newpass);
        $model->update();
    }
}