<?php 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Application as App;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$files      = array();
$context    = App::getInstance()->getContext();
$rootFolder = $context->getServer()->getDocumentRoot();
if (isset($arCurrentValues["PATH"])
	&& is_dir($rootFolder . $arCurrentValues["PATH"])
	&& $handle = opendir($rootFolder . $arCurrentValues["PATH"])
) {

	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			$files[$file] = $file;
		}
	}
	closedir($handle);
}

$arComponentParameters = array(
	"GROUPS"     => array(),
	"PARAMETERS" => array(

		"PATH"      => array(
			"PARENT"   => "BASE",
			"NAME"     => Loc::getMessage('PAF_LESS_PATH'),
			"TYPE"     => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT"  => "",
			"REFRESH"  => "Y",
		),

		"FILES"     => array(
			"PARENT"   => "BASE",
			"NAME"     => Loc::getMessage('PAF_LESS_FILES'),
			"TYPE"     => "LIST",
			"MULTIPLE" => "Y",
			"DEFAULT"  => "",
			"VALUES"   => $files,
		),

		"PATH_CSS"  => array(
			"PARENT"   => "BASE",
			"NAME"     => Loc::getMessage('PAF_LESS_PATH_CSS'),
			"TYPE"     => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT"  => "",
			"REFRESH"  => "N",
		),

		"COMPRESS"  => array(
			"PARENT"  => "BASE",
			"NAME"    => Loc::getMessage('PAF_LESS_COMPRESS'),
			"TYPE"    => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"SOURSEMAP" => array(
			"PARENT"  => "BASE",
			"NAME"    => Loc::getMessage('PAF_LESS_SOURSEMAP'),
			"TYPE"    => "CHECKBOX",
			"DEFAULT" => "N",
		),

	),
);