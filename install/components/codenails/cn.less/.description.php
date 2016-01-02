<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	'NAME'         => Loc::getMessage('CN_LESS_DESC_NAME'),
	'DESCRIPTION'  => Loc::getMessage('CN_LESS_DESC_DESCRIPTION'),
	'PATH'         => array(
		'ID' => "utility",
	),
	'AREA_BUTTONS' => array(
		array(
			'TITLE' => Loc::getMessage('CN_LESS_DESC_AREA_BUTTONS_TITLE'),
		),
	),
	'CACHE_PATH'   => 'Y',
	'COMPLEX'      => 'N',
);