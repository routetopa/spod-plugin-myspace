<?php

class SPODPR_CLASS_Helper
{
    private static $classInstance;

    public static function getInstance()
    {
        if(self::$classInstance === null)
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    public function getUserPrivateRoom($userId, $onlyDatalet=false)
    {
        return $this->processCard(SPODPR_BOL_Service::getInstance()->getUserPrivateRoom($userId), $onlyDatalet);
    }

    private function processCard($bolCards, $onlyDatalet)
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

            if($onlyDatalet)
            {
                if ($card->isDatalet)
                {
                    array_push($cards, $card);
                }
            }
            else
            {
                array_push($cards, $card);
            }

        }
        return $cards;
    }
}