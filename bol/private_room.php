<?php

class SPODPR_BOL_PrivateRoom extends OW_Entity
{
    /**
     * @var int
     */
    public $ownerId;
    /**
     * @var string
     */
    public $cardType;
    /**
     * @var string
     */
    public $card;
    /**
     * @var string
     */
    public $timestamp;
    /**
     * @var string
     */
    public $status;
    /**
     * @var string
     */
    public $privacy;
}
