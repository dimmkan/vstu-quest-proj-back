<?php


class Controller_Candidates extends Controller_Base
{

    function index()
    {
        $fields = ['id', 'fio', 'birthday', 'birthplace', 'passport', 'position', 'department', 'checkStartDate', 'checkEndDate', 'checkResult', 'checkStatus', 'checkComment', 'questionnariesName', 'workbookName', 'endResult'];
        $model = new Model_Candidates(false, $fields);
        $candidates = $model->getAllRows();
        echo json_encode($candidates);
    }

    function addquest()
    {
        $body = json_decode(file_get_contents('php://input'));
        $id = $this->vars[0];
        $select = array(
            'where' => "id = $id"
        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $model->questionnariesData = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        $model->questionnariesName = urldecode($this->removeFileExtention($_FILES['file']['name'])) . $this->removeFileName($_FILES['file']['name']);
        $model->questionnariesType = $_FILES['file']['type'];
        $model->questionnariesSize = $_FILES['file']['size'];
        $model->update();
        $log = new Model_Log();
        $log->username = $_POST['username'];
        $log->event = 'Add questionnaries';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();
    }

    function downloadquest()
    {
        $id = $this->vars[0];
        $select = array(
            'where' => "id = $id"
        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $filename = urlencode($model->questionnariesName);
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-type: $model->questionnariesType");
        header("Content-length: $model->questionnariesSize");
        print base64_decode($model->questionnariesData);
    }

    function addworkbook()
    {
        $id = $this->vars[0];
        $select = array(
            'where' => "id = $id"
        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $model->workbookName = urldecode($this->removeFileExtention($_FILES['file']['name'])) . $this->removeFileName($_FILES['file']['name']);
        $model->workbookType = $_FILES['file']['type'];
        $model->workbookSize = $_FILES['file']['size'];
        $model->workbookData = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        $model->update();
        $log = new Model_Log();
        $log->username = $_POST['username'];
        $log->event = 'Add workbook';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();
    }

    function downloadworkbook()
    {
        $id = $this->vars[0];
        $select = array(
            'where' => "id = $id"
        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $filename = urlencode($model->workbookName);
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-type: $model->workbookType");
        header("Content-length: $model->workbookSize");
        print base64_decode($model->workbookData);
    }

    public function removeFileExtention($fileName)
    {
        return substr($fileName, 0, strrpos($fileName, '.'));
    }

    public function removeFileName($fileName)
    {
        return substr($fileName, strrpos($fileName, '.'), strlen($fileName));
    }

    function delete()
    {
        $body = json_decode(file_get_contents('php://input'));
        $candidateId = $this->vars[0];
        $select = array(
            'where' => "id = $candidateId"
        );
        $model = new Model_Candidates();
        $model->deleteBySelect($select);
        $log = new Model_Log();
        $log->username = $body->username;
        $log->event = 'Delete candidate';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();

    }

    function update()
    {
        $body = json_decode(file_get_contents('php://input'));
        $candidateId = $this->vars[0];
        $select = array(
            'where' => "id = $candidateId",

        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $model->fio = $body->fio;
        $model->birthday = empty($body->birthday) ? null : $body->birthday;
        $model->birthplace = $body->birthplace;
        $model->passport = $body->passport;
        $model->position = $body->position;
        $model->department = $body->department;
        $model->checkStartDate = empty($body->checkStartDate) ? null : $body->checkStartDate;
        $model->checkEndDate = empty($body->checkEndDate) ? null : $body->checkEndDate;
        $model->checkResult = $body->checkResult;
        $model->checkStatus = $body->checkStatus;
        $model->checkComment = addslashes($body->checkComment);
        $model->endResult = addslashes($body->endResult);
        $model->update();
        $log = new Model_Log();
        $log->username = $body->username;
        $log->event = 'Update candidate';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();
    }

    function add()
    {
        $body = json_decode(file_get_contents('php://input'));
        $model = new Model_Candidates();
        $model->fio = empty($body->fio) ? null : $body->fio;
        $model->birthday = $body->birthday;
        $model->birthplace = $body->birthplace;
        $model->passport = $body->passport;
        $model->position = $body->position;
        $model->department = $body->department;
        $model->save();
        $log = new Model_Log();
        $log->username = $body->username;
        $log->event = 'Add candidate';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();


        $message = "
            <html>
                <head>
                    <title>Добавлен новый кандидат для проверки</title>
                </head>
                <body>
                    <p><strong>Добавлен новый кандидат для проверки</strong></p>
                    <p><strong>ФИО: </strong>$model->fio</p>
                    <p><strong>Должность: </strong>$model->position</p>
                    <p><strong>Подразделение: </strong>$model->department</p>
                    <br>
                    <br>
                    <p><strong><i>Добавлен пользователем: $log->username</i></strong></p>
                </body>
            </html>";

        Sender::mailer($message, "Добавлен новый кандидат для проверки");
    }

    function deletequest()
    {
        $body = json_decode(file_get_contents('php://input'));
        $candidateId = $this->vars[0];
        $select = array(
            'where' => "id = $candidateId"
        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $model->questionnariesData = null;
        $model->questionnariesName = '';
        $model->questionnariesType = '';
        $model->questionnariesSize = 0;
        $model->update();
        $log = new Model_Log();
        $log->username = $body->username;
        $log->event = 'Delete questionnaries';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();
    }

    function deleteworkbook()
    {
        $body = json_decode(file_get_contents('php://input'));
        $candidateId = $this->vars[0];
        $select = array(
            'where' => "id = $candidateId"
        );
        $model = new Model_Candidates($select);
        $model->fetchOne();
        $model->workbookData = null;
        $model->workbookName = '';
        $model->workbookType = '';
        $model->workbookSize = 0;
        $model->update();
        $log = new Model_Log();
        $log->username = $body->username;
        $log->event = 'Delete workbook';
        $d = new DateTime('NOW');
        $log->date = $d->format('d-m-Y H:i:s');
        $log->save();
    }

}