<?php
/**
 * ===============================================================
 * LessForBitrix - примочка для подключения класса phpless в шаблон bitrix 
 * Примочка писалась для своих нужд и для удобства разработки.
 * Что эта хрень умеет делать:
 * - Автоматическая компиляция less при изменении файла, при этом отслеживаются изменения и в импортированных файлах.
 * - Сжатие выходного css-файла (с возможностью отключать сжатие).
 * - Вывод ошибок компиляции (особо не проверял какие ошибки выводятся, но если будет явный косяк - класс скажет в какой строке искать и не станет делать компиляцию, но может и не точно сказать т.к. защиты от кривых рук там нет).
 * ===============================================================
 * Файл: less.php
 * ---------------------------------------------------------------
 * Версия: 1.1.0 (30.04.2013)
 * ===============================================================
 * 
 * Использование: 
 * ---------------------------------------------------------------
 * Где нибудь в начале header.php прописать:
	<?require_once('less/less.php');?>
 * 
 * По умолчанию подключается файл template_styles.less текущего шаблона сайта.
 * туда же записывается одноимённый css-файл (который и используется в bitrix).
 * Все настройки чуть ниже.
 */


// Определяем входящий и выходящий файлы и определяем сжимать или нет выходящий файл.
$inputFile = $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/template_styles.less"; //Файл template_styles.less, лежащий в текущем шаблоне сайта
$outputFile = str_ireplace('.less', '.css', $inputFile); //Файл template_styles.css - который подключается к шаблону
$normal = false; // true для отключения сжатия.

// Выполняем функцию компиляции
try {
	autoCompileLess($inputFile, $outputFile, $normal);
} catch (exception $e) {
	// Если что-то пошло не так - скажем об этом пользователю.
	echo '<div style="text-align: center; background: #fff; color: red; padding: 5px;">Less error: '.$e->getMessage().'</div>';
}

/**
	 * Функция автокомпиляции less, запускается даже если изменён импортированный файл - очень удобно.
	 * функция взята из документации к классу.
	 * @param string $inpFile - входной файл (в котором могут быть и импортированные файлы)
	 * @param string $outFile - выходной файл
	 * @param string $nocompress - отключает сжатие выходного файла
	 * @return file
	 */
	function autoCompileLess($inpFile, $outFile, $nocompress = false) {

		$cacheFile = $inpFile.".cache";

		if (file_exists($cacheFile)) {
			$cache = unserialize(file_get_contents($cacheFile));
		} else {
			$cache = $inpFile;
		}

		// Подключаем класс для компиляции less 
		require "lessphp.class.php";
		$less = new lessc;
		if ($nocompress) {
			// Если запрещено сжатие - форматируем по нормальному с табами вместо пробелов.
			$formatter = new lessc_formatter_classic;
	        $formatter->indentChar = "\t";
	        $less->setFormatter($formatter);
		} else {
			// Иначе сжимаем всё в одну строку.
			$less->setFormatter('compressed');
		}
		
		$newCache = $less->cachedCompile($cache);

		if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
			file_put_contents($cacheFile, serialize($newCache));
			file_put_contents($outFile, $newCache['compiled']);
		}
	}

?>