<?php

class SPODPR_CMP_PrivateRoomCard extends OW_Component
{
    public function __construct($cssClass, $onlyDatalet=true)
    {
        parent::__construct();

        $this->assign('components_url', SPODPR_COMPONENTS_URL);
        $this->assign('css_class', $cssClass);
        $this->assign('cards', SPODPR_CLASS_Helper::getInstance()->getUserPrivateRoom(OW::getUser()->getId(),$onlyDatalet));
    }
}