# LESS Компилятор для Bitrix
![version](https://img.shields.io/badge/version-1.1.0-brightgreen.svg?style=flat-square "Version")
![MIT License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)

Простой и удобный компонент, реализующий компиляцию LESS файлов.
:exclamation: **Компонент не подключает CSS к шаблону, а только компилирует LESS файлы.** Это сделано специально для более гибкого управления подулючением css-файлов.

## Преимущества
- Быстрая работа.
- Автоматическая компиляция только изменённых файлов.
- Генерация SourceMap.
- Минификация CSS-кода.
- Управление доступом к компиляции.

## Установка
- Разместить файлы в папку `/bitrix/modules/pafnuty.less`. Компонент появится в списке установленных решений.
- Выполнить установку.

## Использование
В нужном месте шаблона прописать вызов компонента:
```php
<?$APPLICATION->IncludeComponent(
    "pafnuty:pafnuty.less", 
    "", 
    array(),
    false
);?>
```

При необходимости можно настроить параметры.

По умолчанию компонент будет искать файл `SITE_TEMPLATE_PATH/less/template_styles.less` и положит скомпилированный `template_styles.css` в папку с текущим шаблоном сайта.

Не забывайте прописать в шаблон подключение CSS-файла, если настройки отличаются от стандартных:
```php
<?\Bitrix\Main\Page\Asset::getInstance()->addCss('/local/assets/css/compiled_file.css');?>
```

## Вопросы и поддержка
Если у вас возник вопрос, или есть пожелания к улучшению компонента — [воспользуйтесь формой](https://github.com/pafnuty/LessForBitrix/issues)

## Куда делась старая примочка?
- Живёт в ветке [old](https://github.com/pafnuty/LessForBitrix/tree/old) и её развитие не планируется.