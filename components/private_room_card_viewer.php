<?php

class SPODPR_CMP_PrivateRoomCardViewer extends OW_Component
{
    public function __construct($selectedType=array(), $pluginKey="")
    {
        parent::__construct();

        OW::getDocument()->addScript(OW::getPluginManager()->getPlugin('spodpr')->getStaticJsUrl() . 'masonry.pkgd.min.js', 'text/javascript');
        OW::getDocument()->addScript(OW::getPluginManager()->getPlugin('spodpr')->getStaticJsUrl() . 'private-room-import.js', 'text/javascript');
        OW::getDocument()->addStyleSheet(OW::getPluginManager()->getPlugin('spodpr')->getStaticUrl() . 'css/private_room.css');

        $cards = SPODPR_CLASS_Helper::getInstance()->getUserPrivateRoom(OW::getUser()->getId(),$selectedType);
        $this->assign('cards', $cards);

        OW::getDocument()->addOnloadScript('SPODPR.init();');
    }

}