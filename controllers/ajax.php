<?php

class SPODPR_CTRL_Ajax extends OW_ActionController
{

    public function addTextLinkCard()
    {
        SPODPR_BOL_Service::getInstance()->addTextLinkCard(
          OW::getUser()->getId(),
          $_REQUEST['type'],
          $_REQUEST['title'],
          $_REQUEST['content'],
          $_REQUEST['comment']
        );

        echo json_encode(array("status" => "ok"));
        exit;
    }
}