<?php

class SPODPR_CTRL_Ajax extends OW_ActionController
{

    public function addTextLinkCard()
    {
        $id = SPODPR_BOL_Service::getInstance()->addTextLinkCard(
          OW::getUser()->getId(),
          $_REQUEST['type'],
          $_REQUEST['title'],
          $_REQUEST['content'],
          $_REQUEST['comment']
        );

        echo json_encode(array("status" => "ok", "id" => $id));
        exit;
    }

    public function deleteCard()
    {
        SPODPR_BOL_Service::getInstance()->deleteCard(
            OW::getUser()->getId(),
            $_REQUEST['type'],
            $_REQUEST['id']
        );

        echo json_encode(array("status" => "ok"));
        exit;
    }

    public function modDataletCard()
    {
        SPODPR_BOL_Service::getInstance()->modPrivateRoomDatalet(
            OW::getUser()->getId(),
            $_REQUEST['dataletId'],
            $_REQUEST['component'],
            $_REQUEST['fields'],
            $_REQUEST['params'],
            $_REQUEST['data']
        );

        echo json_encode(array("status" => "ok"));
        exit;
    }
}