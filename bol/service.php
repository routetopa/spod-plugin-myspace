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

    //public function dataletCard($userId, $component, $fields, $params, $data='', $comment='', $dataletId='', $cardId='')
    public function dataletCard($userId, $component, $fields, $params, $data='', $dataletId='', $cardId='')
    {
        $dtId = ODE_BOL_Service::getInstance()->privateRoomDatalet($component, $fields, $userId, $params, $data, $dataletId);

        if(empty($cardId))
        {
            $card = new SPODPR_BOL_PrivateRoom();
        }
        else
        {
            $example = new OW_Example();
            $example->andFieldEqual('id', $cardId);
            $example->andFieldEqual('ownerId', $userId);
            $card = SPODPR_BOL_PrivateRoomDao::getInstance()->findObjectByExample($example);
        }

        $paramsObj = json_decode($params);

        $card->ownerId   = $userId;
        $card->cardType  = 'datalet';
        $card->card      = json_encode(array("dataletId" => $dtId, "title" => $paramsObj->title, "comment" => $paramsObj->description));
        $card->status    = 'approved';
        $card->privacy   = 'everybody';
        SPODPR_BOL_PrivateRoomDao::getInstance()->save($card);

        return array("card-id" => $card->id, "datalet-id" => $dtId);
    }

    public function textLinkCard($ownerId, $type, $title, $content, $comment, $id)
    {

        if(empty($id))
        {
            $card = new SPODPR_BOL_PrivateRoom();
        }
        else
        {
            $example = new OW_Example();
            $example->andFieldEqual('id', $id);
            $example->andFieldEqual('ownerId', $ownerId);
            $card = SPODPR_BOL_PrivateRoomDao::getInstance()->findObjectByExample($example);
        }

        $card->ownerId   = $ownerId;
        $card->cardType  = $type;
        $card->card      = json_encode(array("title" => $title, "content" => $content, "comment" => $comment));
        $card->status    = 'approved';
        $card->privacy   = 'everybody';
        SPODPR_BOL_PrivateRoomDao::getInstance()->save($card);

        return $card->id;
    }

    public function deleteCard($ownerId, $type, $cardId, $dataletId)
    {
        $ex = new OW_Example();
        $ex->andFieldEqual('id', $cardId);
        $ex->andFieldEqual('ownerId', $ownerId);

        if(!empty($dataletId))
        {
            $e = new OW_Example();
            $e->andFieldEqual('id', $dataletId);
            $e->andFieldEqual('ownerId', $ownerId);
            ODE_BOL_DataletDao::getInstance()->deleteByExample($e);
        }

        SPODPR_BOL_PrivateRoomDao::getInstance()->deleteByExample($ex);
    }

}
