<?php

class SPODPR_CMP_PrivateRoomCardViewer extends OW_Component
{
    public function __construct($selectedType=array(), $pluginKey="")
    {
        parent::__construct();

        $cards = SPODPR_CLASS_Helper::getInstance()->getUserPrivateRoom(OW::getUser()->getId(),$selectedType);
        $this->assign('components_url', SPODPR_COMPONENTS_URL);
        $this->assign('card_definition', $this->get_datalet_definition($cards));
        $this->assign('cards', $cards);
    }

    public function get_datalet_definition($cards)
    {
        $definition = [];

        foreach ($cards as $card)
        {
            if(!in_array($card->component, $definition))
                array_push($definition, $card->component);
        }

        return $definition;
    }
}