<?php

class SPODPR_CTRL_Ajax extends OW_ActionController
{

    private function validateTextInputVsSqlInjection($input){
        return !preg_match("/(script)|(&lt;)|(&gt;)|(%3c)|(%3e)".
            "|(SELECT)|(UPDATE)|(INSERT)|(DELETE)|(GRANT)|(REVOKE)|(UNION)".
            "|(select)|(update)|(insert)|(delete)|(grant)|(revoke)|(union)|(database)".
            "|(--)|(;)".
            "|(&amp;lt;)|(&amp;gt;)/", $input);
    }

    public function textLinkCard()
    {
        $clean = array();
        $clean['type'] = "";
        $clean['title'] = "";
        $clean['content'] = "";
        $clean['comment'] = "";
        $clean['id'] = "";
        if($this->validateTextInputVsSqlInjection($_REQUEST['type']) &&
           $this->validateTextInputVsSqlInjection($_REQUEST['title']) &&
           $this->validateTextInputVsSqlInjection($_REQUEST['content']) &&
           $this->validateTextInputVsSqlInjection($_REQUEST['comment']) &&
           $this->validateTextInputVsSqlInjection($_REQUEST['id']))
        {
            $clean['id']      = strval(intval($_REQUEST['id']));
            $clean['type']    = filter_var($_REQUEST['type'], FILTER_SANITIZE_STRING);
            $clean['title']   = filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING);
            $clean['content'] = filter_var($_REQUEST['content'], FILTER_SANITIZE_STRING);
            $clean['comment'] = filter_var($_REQUEST['comment'], FILTER_SANITIZE_STRING);
        }else{
            echo json_encode(array("status" => "error", "message" => "Insane inputs provided"));
            exit;
        }

        $id = SPODPR_BOL_Service::getInstance()->textLinkCard(
          OW::getUser()->getId(),
            $clean['type'],
            $clean['title'],
            $clean['content'],
            $clean['comment'],
            $clean['id']
        );

        echo json_encode(array("status" => "ok", "id" => $id));
        exit;
    }

    public function deleteCard()
    {
        $clean = array();
        $clean['type'] = "";
        $clean['dataletId'] = "";
        $clean['id'] = "";
        if($this->validateTextInputVsSqlInjection($_REQUEST['type']) &&
            $this->validateTextInputVsSqlInjection($_REQUEST['dataletId']) &&
            $this->validateTextInputVsSqlInjection($_REQUEST['id']))
        {
            $clean['id']        = strval(intval($_REQUEST['id']));
            $clean['dataletId'] = strval(intval($_REQUEST['dataletId']));
            $clean['type']      = filter_var($_REQUEST['type'], FILTER_SANITIZE_STRING);
        }else{
            echo json_encode(array("status" => "error", "message" => "Insane inputs provided"));
            exit;
        }

        SPODPR_BOL_Service::getInstance()->deleteCard(
            OW::getUser()->getId(),
            $clean['type'],
            $clean['id'],
            $clean['dataletId']
        );

        echo json_encode(array("status" => "ok"));
        exit;
    }

    private function modDataletCard()
    {
        $clean = array();
        $clean['dataletId'] = "";
        $clean['component'] = "";
        $clean['fields'] = "";
        $clean['params'] = "";
        $clean['data'] = "";
        if($this->validateTextInputVsSqlInjection($_REQUEST['dataletId']) &&
            $this->validateTextInputVsSqlInjection($_REQUEST['component']) &&
            /*$this->validateTextInputVsSqlInjection($_REQUEST['data']) &&
            $this->validateTextInputVsSqlInjection($_REQUEST['params']) &&*//*This inputs should be tested in a specific way*/
            $this->validateTextInputVsSqlInjection($_REQUEST['fields']))
        {
            $clean['dataletId'] = strval(intval($_REQUEST['dataletId']));
            $clean['component'] = filter_var($_REQUEST['component'], FILTER_SANITIZE_STRING);
            $clean['fields']    = filter_var($_REQUEST['fields'], FILTER_SANITIZE_STRING);
            $clean['params']    = filter_var($_REQUEST['params'], FILTER_SANITIZE_STRING);
            $clean['data']      = filter_var($_REQUEST['data'], FILTER_SANITIZE_STRING);
        }else{
            echo json_encode(array("status" => "error", "message" => "Insane inputs provided"));
            exit;
        }

        SPODPR_BOL_Service::getInstance()->modPrivateRoomDatalet(
            OW::getUser()->getId(),
            $clean['dataletId'],
            $clean['component'],
            $clean['fields'],
            $clean['params'],
            $clean['data']
        );

        echo json_encode(array("status" => "ok"));
        exit;
    }
}