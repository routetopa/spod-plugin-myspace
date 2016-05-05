<?php

class SPODPR_CTRL_Ajax extends OW_ActionController
{

    public function textLinkCard()
    {
        $clean = ODE_CLASS_InputFilter::getInstance()->sanitizeInputs($_REQUEST);
        if ($clean == null){
            /*echo json_encode(array("status" => "error", "massage" => 'Insane inputs detected'));*/
            OW::getFeedback()->info(OW::getLanguage()->text('cocreationep', 'insane_user_email_value'));
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
        $clean = ODE_CLASS_InputFilter::getInstance()->sanitizeInputs($_REQUEST);
        if ($clean == null){
            /*echo json_encode(array("status" => "error", "massage" => 'Insane inputs detected'));*/
            OW::getFeedback()->info(OW::getLanguage()->text('cocreationep', 'insane_user_email_value'));
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