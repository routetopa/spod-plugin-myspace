<?php

class SPODPR_BOL_Service
{
    const ENTITY_TYPE = 'private_room_entity';

    /**
     * Singleton instance.
     *
     * @var ODE_BOL_Service
     */
    private static $classInstance;

    /**
     * Returns an instance of class (singleton pattern implementation).
     *
     * @return ODE_BOL_Service
     */
    public static function getInstance()
    {
        if ( self::$classInstance === null )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    private function __construct()
    {
    }

    public function getAll()
    {
        return SPODPR_BOL_PrivateRoomDao::getInstance()->findAll();
    }

    public function getUserPrivateRoom($userId)
    {
        $example = new OW_Example();
        $example->andFieldEqual('ownerId', $userId);
        $example->setOrder('timestamp');
        $result = SPODPR_BOL_PrivateRoomDao::getInstance()->findListByExample($example);
        return $result;
    }

    public function getById($id)
    {
        $example = new OW_Example();
        $example->andFieldEqual('id', $id);
        $result = SPODPR_BOL_PrivateRoomDao::getInstance()->findObjectByExample($example);
        return $result;
    }

    public function addDataletCard($ownerId, $component, $fields, $params, $data='')
    {
        $dtId = ODE_BOL_Service::getInstance()->addPrivateRoomDatalet(
            $component,
            $fields,
            $ownerId,
            $params,
            $data
        );

        $card = new SPODPR_BOL_PrivateRoom();
        $card->ownerId   = $ownerId;
        $card->cardType  = 'datalet';
        $card->card      = '{"dataletId":'.$dtId.', "title":"datalet"}';
        $card->status    = 'approved';
        $card->privacy   = 'everybody';
        SPODPR_BOL_PrivateRoomDao::getInstance()->save($card);

        return $card->id;
    }

    public function addTextLinkCard($ownerId, $type, $title, $content, $comment)
    {

        $card = new SPODPR_BOL_PrivateRoom();
        $card->ownerId   = $ownerId;
        $card->cardType  = $type;
        $card->card      = json_encode(array("title" => $title, "content" => $content, "comment" => $comment));
        $card->status    = 'approved';
        $card->privacy   = 'everybody';
        SPODPR_BOL_PrivateRoomDao::getInstance()->save($card);

        return $card->id;
    }

    public function deleteCard($ownerId, $type, $cardId)
    {
        $ex = new OW_Example();
        $ex->andFieldEqual('id', $cardId);
        $ex->andFieldEqual('ownerId', $ownerId);
        //$ex->andFieldEqual('cardType', $type);
        SPODPR_BOL_PrivateRoomDao::getInstance()->deleteByExample($ex);
    }

}
