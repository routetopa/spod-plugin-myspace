<?php

class SPODPR_CMP_SilverDecisionCreator extends OW_Component
{
    public function __construct()
    {
        $this->assign('components_url', SPODPR_COMPONENTS_URL);
    }
}