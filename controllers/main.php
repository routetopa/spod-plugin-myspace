<?php

class SPODPR_CTRL_Main extends OW_ActionController
{

    public function index()
    {
        OW::getDocument()->addStyleSheet(OW::getPluginManager()->getPlugin('spodpr')->getStaticUrl() . 'css/private_room.css');
        OW::getDocument()->getMasterPage()->setTemplate(OW::getPluginManager()->getPlugin('spodpr')->getRootDir() . 'master_pages/general.html');
        $this->assign('cards', $this->processCard(SPODPR_BOL_Service::getInstance()->getUserPrivateRoom(OW::getUser()->getId())));

        $this->assign('components_url', SPODPR_COMPONENTS_URL);
        $this->assign('plugin_root_dir', OW::getPluginManager()->getPlugin('spodpr')->getStaticUrl());

        OW::getDocument()->addScript(OW::getPluginManager()->getPlugin('spodpr')->getStaticJsUrl() . 'private-room.js', 'text/javascript');

        $js = UTIL_JsGenerator::composeJsString('
                SPODPR.components_url = {$components_url}
                SPODPR.ajax_add_text_link_card = {$ajax_add_text_link_card}
                SPODPR.ajax_delete_card = {$ajax_delete_card}
                SPODPR.ajax_mod_datalet_card = {$ajax_mod_datalet_card}
            ', array(
            'components_url' => SPODPR_COMPONENTS_URL,
            'ajax_add_text_link_card' => OW::getRouter()->urlFor('SPODPR_CTRL_Ajax', 'addTextLinkCard'),
            'ajax_delete_card' => OW::getRouter()->urlFor('SPODPR_CTRL_Ajax', 'deleteCard'),
            'ajax_mod_datalet_card' => OW::getRouter()->urlFor('SPODPR_CTRL_Ajax', 'modDataletCard'),
        ));

        OW::getDocument()->addOnloadScript($js);
    }

    private function processCard($bolCards)
    {
        $cards = array();

        foreach($bolCards as $bolCard)
        {
            $card = new SPODPR_CLASS_Card();
            $card->cardId = $bolCard->id;
            $card->isDatalet = false;
            $card->ownerId = $bolCard->ownerId;
            $card->cardType = $bolCard->cardType;
            $card->card = json_decode($bolCard->card);

            if($card->cardType == 'datalet')
            {
                $datalet = ODE_BOL_Service::getInstance()->getDataletById($card->card->dataletId);
                if($datalet)
                {
                    $card->isDatalet = true;
                    $card->dataletId = $datalet->id;
                    $card->component = $datalet->component;
                    $card->data = $datalet->data;
                    $card->fields = $datalet->fields;
                    $card->params = json_decode($datalet->params);
                    $card->params->dataUrl = $card->params->{'data-url'};
                    $card->preset = $datalet->params;
                }
            }

            array_push($cards, $card);

        }
        return $cards;
    }

}