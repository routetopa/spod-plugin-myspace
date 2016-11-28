<?php

$preference = BOL_PreferenceService::getInstance()->findPreference('spodpr_components_url');
$spodpr_components_url = empty($preference) ? "http://deep.routetopa.eu/COMPONENTS/" : $preference->defaultValue;
define("SPODPR_COMPONENTS_URL", $spodpr_components_url);

OW::getRouter()->addRoute(new OW_Route('spodpr.index', 'spodpr', "SPODPR_CTRL_Main", 'index'));