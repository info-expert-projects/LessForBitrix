<?php
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

class pafnuty_less extends CModule {
	var $MODULE_ID = 'pafnuty.less';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function pafnuty_less() {
		$arModuleVersion = array();
		$path            = str_replace("\\", "/", __FILE__);
		$path            = substr($path, 0, strlen($path) - strlen("/index.php"));
		include $path . "/version.php";

		$this->MODULE_VERSION      = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME         = Loc::getMessage("PAFNUTY_LESS_MODULE_NAME");
		$this->MODULE_DESCRIPTION  = Loc::getMessage("PAFNUTY_LESS_MODULE_DESCRIPTION");

		$this->PARTNER_NAME = GetMessage("PAFNUTY_LESS_PARTNER_NAME");
		$this->PARTNER_URI  = GetMessage("PAFNUTY_LESS_PARTNER_URI");
	}

	function GetModuleTasks() {
		return array();
	}

	function InstallDB($arParams = array()) {
		global $DB, $DBType, $APPLICATION;

		$this->InstallTasks();
		RegisterModule($this->MODULE_ID);
		CModule::IncludeModule($this->MODULE_ID);

		return true;
	}

	function UnInstallDB($arParams = array()) {
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;

		UnRegisterModule($this->MODULE_ID);

		if ($this->errors !== false) {
			$APPLICATION->ThrowException(implode("<br>", $this->errors));

			return false;
		}

		return true;
	}

	function InstallEvents() {
		return true;
	}

	function UnInstallEvents() {
		return true;
	}

	function InstallFiles($arParams = array()) {
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/components/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components", true, true);

		return true;
	}

	function UnInstallFiles() {
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/components/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components");

		return true;
	}

	function DoInstall() {
		global $USER, $APPLICATION;

		if ($USER->IsAdmin()) {
			if ($this->InstallDB()) {
				$this->InstallEvents();
				$this->InstallFiles();
			}
			$GLOBALS["errors"] = $this->errors;
		}
	}

	function DoUninstall() {
		global $DB, $USER, $DOCUMENT_ROOT, $APPLICATION, $step;

		if ($USER->IsAdmin()) {
			if ($this->UnInstallDB()) {
				$this->UnInstallEvents();
				$this->UnInstallFiles();
			}
			$GLOBALS["errors"] = $this->errors;
		}
	}
}