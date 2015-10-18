<?php

class SPODPR_CTRL_Main extends OW_ActionController
{

    public function index()
    {
        /*echo OW::getUser()->getId();*/

        OW::getDocument()->addStyleSheet(OW::getPluginManager()->getPlugin('spodpr')->getStaticUrl() . 'css/private_room.css');
        OW::getDocument()->getMasterPage()->setTemplate(OW::getPluginManager()->getPlugin('spodpr')->getRootDir() . 'master_pages/general.html');
    }

}