<?php
namespace Pafnuty\Less;

require __DIR__ . '/../libs/less/Less.php';

/**
 * Class lessCompiler
 *
 * @package Pafnuty\Less
 */
class lessCompiler {
	/**
	 * @var bool
	 */
	public $rootFolder = false;
	/**
	 * @var string
	 */
	public $lessFolder = '';
	/**
	 * @var array
	 */
	public $fileNames = array();
	/**
	 * @var bool
	 */
	public $compress = true;
	/**
	 * @var bool
	 */
	public $sourceMap = false;
	/**
	 * @var string
	 */
	public $cssFolder = '';

	/**
	 * lessCompiler constructor.
	 *
	 * @param $rootFolder
	 * @param $lessFolder
	 * @param $fileNames
	 * @param $cssFolder
	 * @param $compress
	 * @param $sourceMap
	 */
	function __construct($rootFolder, $lessFolder, $fileNames, $cssFolder, $compress, $sourceMap) {
		$lessConfig             = new \stdClass();
		$lessConfig->rootFolder = $rootFolder;
		$lessConfig->lessFolder = $lessFolder;
		$lessConfig->fileNames  = $fileNames;
		$lessConfig->cssFolder  = $cssFolder;
		$lessConfig->compress   = $compress;
		$lessConfig->sourceMap  = $sourceMap;
		$this->config           = $lessConfig;
	}

	/**
	 * @param $lessFiles
	 *
	 * @return array
	 */
	public function getFileList($lessFiles) {
		$arFiles = array();
		foreach ($lessFiles as $key => $lessFile) {
			$arFiles[$this->config->rootFolder . $this->config->lessFolder . $lessFile] = $this->config->rootFolder . $this->config->cssFolder;
		}

		return $arFiles;
	}

	/**
	 * @return array
	 */
	public function compile() {
		$lessFiles = $this->getFileList($this->config->fileNames);
		try {
			$filePath = \Less_Cache::Get($lessFiles, $this->setOptions());
			$error    = false;
		} catch (\Exception $e) {
			$filePath = false;
			$error    = $e->getMessage();
		}
		$arReturn = array(
			'filePath' => $filePath,
			'error'    => $error,
		);

		return $arReturn;
	}

	/**
	 * @return array
	 */
	public function setOptions() {
		$firstFileName = str_replace('.less', '', $this->config->fileNames[0]);

		$arOptions                      = array();
		$arOptions['cache_dir']         = $this->config->rootFolder . $this->config->lessFolder . '/../less_cache';
		$arOptions['compress']          = $this->config->compress;
		$arOptions['sourceMap']         = $this->config->sourceMap;
		$arOptions['sourceMapWriteTo']  = $this->config->rootFolder . $this->config->cssFolder . $firstFileName . '.map';
		$arOptions['sourceMapURL']      = $this->config->cssFolder . $firstFileName . '.map';
		$arOptions['sourceRoot']        = '/';
		$arOptions['sourceMapBasepath'] = $this->config->rootFolder;
		$arOptions['output']            = $this->config->rootFolder . $this->config->cssFolder . $firstFileName . '.css';
		$arOptions['relativeUrls']      = false;

		return $arOptions;
	}
}