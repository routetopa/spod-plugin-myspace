<?php

class SPODPR_CTRL_Main extends OW_ActionController
{

    public function index()
    {
        OW::getDocument()->addStyleSheet(OW::getPluginManager()->getPlugin('spodpr')->getStaticUrl() . 'css/private_room.css');
        OW::getDocument()->getMasterPage()->setTemplate(OW::getPluginManager()->getPlugin('spodpr')->getRootDir() . 'master_pages/general.html');
        $this->assign('cards', SPODPR_CLASS_Helper::getInstance()->getUserPrivateRoom(OW::getUser()->getId()));


        $this->assign('components_url', SPODPR_COMPONENTS_URL);
        $this->assign('plugin_root_dir', OW::getPluginManager()->getPlugin('spodpr')->getStaticUrl());
        $this->assign('user_language', BOL_LanguageService::getInstance()->getCurrent()->tag);

        OW::getDocument()->addScript(OW::getPluginManager()->getPlugin('spodpr')->getStaticJsUrl() . 'private-room.js', 'text/javascript');

        $js = UTIL_JsGenerator::composeJsString('
                SPODPR.components_url = {$components_url}
                SPODPR.ajax_text_link_card = {$ajax_text_link_card}
                SPODPR.ajax_delete_card = {$ajax_delete_card}
                SPODPR.ajax_mod_datalet_card = {$ajax_mod_datalet_card}
            ', array(
            'components_url' => SPODPR_COMPONENTS_URL,
            'ajax_text_link_card' => OW::getRouter()->urlFor('SPODPR_CTRL_Ajax', 'textLinkCard'),
            'ajax_delete_card' => OW::getRouter()->urlFor('SPODPR_CTRL_Ajax', 'deleteCard'),
            'ajax_mod_datalet_card' => OW::getRouter()->urlFor('SPODPR_CTRL_Ajax', 'modDataletCard'),
        ));

        OW::getDocument()->addOnloadScript($js);
    }
}