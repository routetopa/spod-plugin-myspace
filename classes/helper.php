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

    public function getUserPrivateRoom($userId, $selectedType=array())
    {
        return $this->processCard(SPODPR_BOL_Service::getInstance()->getUserPrivateRoom($userId), $selectedType);
    }

    private function processCard($bolCards, $selectedType)
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
                    $card->data = $this->htmlSpecialChar($datalet->data);
                    $card->params = json_decode($datalet->params);
                    if(!empty($card->params->querylogicmap))
                        $card->params->querylogicmap = json_encode($card->params->querylogicmap);
                    $card->dataletTitle = empty($card->params->datalettitle) ? '' : $card->params->datalettitle;

                    foreach ($card->params as $key => $value)
                    {
                        $card->parameters .= $key. "='" . $this->htmlSpecialChar($value) . "' ";
//                        $card->parameters .= $key. '="' . $value . '" ';
                    }

                    $card->preset = $this->htmlSpecialChar($datalet->params);
                }
            }

            if($card->cardType == 'link')
            {
                $card->isDatalet = true;
                $card->component = 'preview-datalet';
                $card->preset = json_encode(array("data-url" => $card->card->content, "url" => $card->card->content));
            }

            if(empty($selectedType))
            {
                array_push($cards, $card);
            }
            else
            {
                if (in_array($card->cardType, $selectedType))
                {
                    array_push($cards, $card);
                }
            }

        }
        return $cards;
    }

    protected function htmlSpecialChar($string)
    {
        return str_replace("'","&#39;", $string);
    }
}