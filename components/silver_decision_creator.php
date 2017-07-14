<?php

class SPODPR_CMP_SilverDecisionCreator extends OW_Component
{
    public function __construct($json_tree="")
    {
        $this->assign('components_url', SPODPR_COMPONENTS_URL);
        $this->assign('json_tree', $json_tree);
    }
}