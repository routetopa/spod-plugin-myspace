<?php

class SPODPR_CMP_PrivateRoomCardViewer extends OW_Component
{
    public function __construct($selectedType=array(), $pluginKey="")
    {
        parent::__construct();

        $this->assign('components_url', SPODPR_COMPONENTS_URL);
        $this->assign('cards', SPODPR_CLASS_Helper::getInstance()->getUserPrivateRoom(OW::getUser()->getId(),$selectedType));
    }
}