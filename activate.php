<?php

OW::getNavigation()->addMenuItem(OW_Navigation::MAIN, 'spodpr.index', 'spodpr', 'main', OW_Navigation::VISIBLE_FOR_MEMBER);
OW::getPluginManager()->addPluginSettingsRouteName('spodpr', 'spodpr-settings');