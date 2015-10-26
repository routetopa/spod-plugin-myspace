<?php

BOL_PreferenceService::getInstance()->deletePreference('spodpr_components_url');
OW::getRouter()->removeRoute('spodpr.index');
OW::getRouter()->removeRoute('spodpr-settings');