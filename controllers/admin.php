<?php

class SPODPR_CTRL_Admin extends ADMIN_CTRL_Abstract
{
    public function settings($params)
    {
        $this->setPageTitle(OW::getLanguage()->text('spodpr', 'settings_title'));
        $this->setPageHeading(OW::getLanguage()->text('spodpr', 'settings_heading'));

        $form = new Form('settings');
        $this->addForm($form);

        /* DEEP ULR */
        $componentsUrl = new TextField('components_url');
        $preference = BOL_PreferenceService::getInstance()->findPreference('spodpr_components_url');
        $spodpr_components_url = empty($preference) ? "http://deep.routetopa.eu/COMPONENTS/" : $preference->defaultValue;
        $componentsUrl->setValue($spodpr_components_url);
        $componentsUrl->setRequired();
        $form->addElement($componentsUrl);

        $submit = new Submit('add');
        $submit->setValue(OW::getLanguage()->text('ode', 'add_key_submit'));
        $form->addElement($submit);

        if ( OW::getRequest()->isPost() && $form->isValid($_POST))
        {
            $data = $form->getValues();

            /* spodpr_components_url */
            $preference = BOL_PreferenceService::getInstance()->findPreference('spodpr_components_url');

            if(empty($preference))
                $preference = new BOL_Preference();

            $preference->key = 'spodpr_components_url';
            $preference->sectionName = 'general';
            $preference->defaultValue = $data['components_url'];
            $preference->sortOrder = 1;
            BOL_PreferenceService::getInstance()->savePreference($preference);

        }
    }
}