<?php

class Model_Candidates extends Model_Base
{
    public $id;
    public $fio;
    public $birthday = null;
    public $birthplace;
    public $passport;
    public $position;
    public $department;
    public $checkStartDate = null;
    public $checkEndDate = null;
    public $checkResult;
    public $checkStatus;
    public $checkComment;
    public $questionnariesData = null;
    public $questionnariesName;
    public $questionnariesType;
    public $questionnariesSize = 0;
    public $workbookData = null;
    public $workbookName;
    public $workbookType;
    public $workbookSize = 0;
    public $endResult;

    public function fieldsTable()
    {
        return array(
            'id' => 'id',
            'fio' => 'fio',
            'birthday' => 'birthday',
            'birthplace' => 'birthplace',
            'passport' => 'passport',
            'position' => 'position',
            'department' => 'department',
            'checkStartDate' => 'checkStartDate',
            'checkEndDate' => 'checkEndDate',
            'checkResult' => 'checkResult',
            'checkStatus' => 'checkStatus',
            'checkComment' => 'checkComment',
            'questionnariesData' => 'questionnariesData',
            'questionnariesName' => 'questionnariesName',
            'questionnariesType' => 'questionnariesType',
            'questionnariesSize' => 'questionnariesSize',
            'workbookData' => 'workbookData',
            'workbookName' => 'workbookName',
            'workbookType' => 'workbookType',
            'workbookSize' => 'workbookSize',
            'endResult' => 'endResult'
        );
    }
}