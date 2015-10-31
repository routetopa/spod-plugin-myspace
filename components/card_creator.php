<?php

class SPODPR_CMP_CardCreator extends OW_Component
{
    public function __construct($params)
    {
        $this->assign('type', $params['type']);

        // TEXT Card
        if(isset($params['content']))
        {
            $this->assign('type', $params['type']);
            $this->assign('title', trim($params['title']));
            $this->assign('content', trim($params['content']));
            $this->assign('comment', trim($params['comment']));
            $this->assign('cardId', trim($params['cardId']));
        }

        // LINK Card
        if(isset($params['link']))
        {
            $this->assign('type', $params['type']);
            $this->assign('title', trim($params['title']));
            $this->assign('link', trim($params['link']));
            $this->assign('comment', trim($params['comment']));
            $this->assign('cardId', trim($params['cardId']));
        }

        $this->assign('components_url', SPODPR_COMPONENTS_URL);
    }
}