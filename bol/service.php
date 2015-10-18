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

    public function getById($id)
    {
        $example = new OW_Example();
        $example->andFieldEqual('id', $id);
        $result = SPODPR_BOL_PrivateRoomDao::getInstance()->findObjectByExample($example);
        return $result;
    }

}
