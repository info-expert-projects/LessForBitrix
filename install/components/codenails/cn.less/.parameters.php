<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Application as App;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$files      = array();
$context    = App::getInstance()->getContext();
$rootFolder = $context->getServer()->getDocumentRoot();
if (isset($arCurrentValues['PATH'])
	&& is_dir($rootFolder . $arCurrentValues['PATH'])
	&& $handle = opendir($rootFolder . $arCurrentValues['PATH'])
) {

	while (false !== ($file = readdir($handle))) {
		if (strpos($file, '.less') !== false) {
			$files[$file] = $file;
		}
	}
	closedir($handle);
}

$arGroups = array();
$rsGroups = CGroup::GetList(($by = 'c_sort'), ($order = 'desc'));

while ($arUserGroups = $rsGroups->Fetch()) {
	$arGroups[$arUserGroups['ID']] = '[' . $arUserGroups['ID'] . '] ' . $arUserGroups['NAME'];
}

$arComponentParameters = array(
	'GROUPS'     => array(
		'PERMISSIONS' => array(
			'NAME' => Loc::getMessage('CN_LESS_ACCESS'),
			'SORT' => 10,
		),
		'FILES_SETTINGS' => array(
			'NAME' => Loc::getMessage('CN_LESS_FILES_SETTINGS'),
			'SORT' => 20,
		),
		'COMPILE_SETTINGS' => array(
			'NAME' => Loc::getMessage('CN_LESS_COMPILE_SETTINGS'),
			'SORT' => 30,
		),
	),
	'PARAMETERS' => array(

		'ACCESS_GROUPS' => array(
			'PARENT'   => 'PERMISSIONS',
			'NAME'     => Loc::getMessage('CN_LESS_ACCESS_GROUPS'),
			'TYPE'     => 'LIST',
			'MULTIPLE' => 'Y',
			'DEFAULT'  => "1",
			'REFRESH'  => "N",
			'VALUES'   => $arGroups,
		),

		'PATH' => array(
			'PARENT'   => 'FILES_SETTINGS',
			'NAME'     => Loc::getMessage('CN_LESS_PATH'),
			'TYPE'     => 'STRING',
			'MULTIPLE' => "N",
			'DEFAULT'  => '',
			'REFRESH'  => "Y",
		),

		'FILES' => array(
			'PARENT'   => 'FILES_SETTINGS',
			'NAME'     => Loc::getMessage('CN_LESS_FILES'),
			'TYPE'     => 'LIST',
			'MULTIPLE' => "Y",
			'DEFAULT'  => '',
			'VALUES'   => $files,
		),

		'PATH_CSS' => array(
			'PARENT'   => 'FILES_SETTINGS',
			'NAME'     => Loc::getMessage('CN_LESS_PATH_CSS'),
			'TYPE'     => 'STRING',
			'MULTIPLE' => 'N',
			'DEFAULT'  => '',
			'REFRESH'  => 'N',
		),

		'COMPRESS'   => array(
			'PARENT'  => 'COMPILE_SETTINGS',
			'NAME'    => Loc::getMessage('CN_LESS_COMPRESS'),
			'TYPE'    => 'CHECKBOX',
			'DEFAULT' => "Y",
		),
		'SOURCE_MAP' => array(
			'PARENT'  => 'COMPILE_SETTINGS',
			'NAME'    => Loc::getMessage('CN_LESS_SOURCE_MAP'),
			'TYPE'    => 'CHECKBOX',
			'DEFAULT' => 'N',
		),

	),
);