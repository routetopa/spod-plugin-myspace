<?php

class SPODPR_CMP_CardCreator extends OW_Component
{
    public function __construct($type)
    {
        $this->assign('type', $type);
        $this->assign('components_url', SPODPR_COMPONENTS_URL);
    }
}