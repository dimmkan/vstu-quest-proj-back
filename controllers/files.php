<?php


class Controller_Files extends Controller_Base
{

    function index()
    {

    }

    function getinstruction(){
        header("Content-Disposition: attachment; filename=\"Instrukciya.docx\"");
        header("Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-length: ".filesize("./files/instr.docx"));
        readfile("./files/instr.docx");
    }
}