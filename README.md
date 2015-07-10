# Что это такое

Meme - это утилита для автоматизации процесса сборки программного продукта или выполнения других рутинных задач. Процесс сборки описывается специальными сценариями с использованием языка PHP, используя встроенные в Meme задачи. Также можно без ограничений применять возможности самого PHP.

### Термины и соглашения

**Проект** - это каталог .meme, который содержит файлы конфигурации и сценарии сборки

**Сценарий сборки** - это PHP скрипт, описывающий последовательность целей (targets). Можно задавать зависимость одной цели от других и, таким образом, объединять их последовательности для выполнения в определенном порядке.

**Цель** - это функция, состоящая из последовательности задач (tasks), имеет уникальное имя в проекте. Цель может зависеть от других целей.

**Задача** - это PHP-класс, выполняющий какое-то действие. Например, копирование файла, изменение прав доступа и пр.

### Установка

Можно скачать готовый к употреблению [PHAR файл](https://github.com/solo-framework/Meme/releases) или собрать из исходного кода:

```
$ composer install
$ php box.phar build
```

# Команды

### Инициализация проекта

Команда **init** создает каталог .meme, в нем файл с настройками config.yml и пример сценария сборки demo-env.php (В дальнейшем, сценарии сборки добавляются вручную)

```
$ php meme.phar init demo-env
```

### Информация о проекте

Команда **info** выводит список сценариев, описанных в файле конфигурации и их статус.
```
$ php meme.phar info
```
### Запуск сценария

Команда запускает сценарий, определенный в файле *./meme/demo-dev.php*

```
$ php meme.phar run -e demo-env
```

# Начало работы

### Конфигурация проекта

Файл конфигурации config.yml имеет формат YAML и определяет настройки окружения (environment) для каждого сценария.
Параметр **name** является обязательным для каждого окружения.

```yaml
#
# пример конфигурационного файла проекта
#
demo-env:

	# Наименование сценария (выводится при выполнении)
	name: environment description here

	# например, подключение к БД
	database:
		username: root
		password: password
		isDebug: true
		dsn: mysql:host=hostname;dbname=dbname
```

Секция настроек в файле конфигурации и соответствующий ему файл сценария создаются автоматически только при первом выполнении команды **init**.
Дополнительные сценарии и настройки нужно создавать вручную.
			
### Составление сценария

Рассмотрим простейший сценарий в файле demo-env.php

```php
use Meme\Output;
use Meme\Project;
use Meme\Types;
use Meme\Target;

// указываем имя цели, которая будет выполняться первой
$project->setStartTarget("start");

// далее описываем цели
$start = new Target("start", function(){

	// внутри цели описываем последовательность задач
	Output::info("Hello, world!");

});

// добавим цель в проект
$project->addTarget($start);
```

Запустим его командой

```
$ php meme.phar run -e demo-env
```

в результате, в консоль будет выведено

```
run target > 'start':

	Hello, world!
```

### Цели

Как было сказано выше, цель - это функция, состоящая из последовательности задач (tasks).
Цель имеет уникальное имя в проекте и список названий других целей, от которых она зависит.

Например, если цель A зависит от цели B, то сначала выполнится B, затем A.
В примере ниже выполнение будет происходить в порядке: end, middle, start

```php
use Meme\Output;
use Meme\Project;
use Meme\Types;
use Meme\Target;

// указываем имя цели, которая будет выполняться первой
$project->setStartTarget("start");

// первый параметр - уникальное имя (идентификатор) цели
// второй - анонимная функция, описывает последовательность задач
// третий - список целей через запятую, от которых зависит текущая цель
$start = new Target(
	"start", 
	function(){
		Output::info("Hello, world!"); 
	},
	"end,middle"
);


$end = new Target("end", function(){
	Output::info("Hello from the end!");
});

$middle = new Target("middle", function(){
	Output::info("Hello from the middle!");
});

// не забываем добавить существующие цели в проект
$project->addTarget($start);
$project->addTarget($middle);
$project->addTarget($end);
```

Результат выполнения:

```
run target > 'end':
	Hello from the end!
	
run target > 'middle':
	Hello from the middle!
	
run target > 'start':
	Hello, world!
```

### Сделаем что-нибудь полезное
		
Допустим, у нас есть задача - вывести список всех файлов и директорий в каталоге **.meme**, затем сформировать из них архив и сохранить в файле с именем **meme_project.zip**

```php
use Meme\Output;
use Meme\Project;
use Meme\Types;
use Meme\Target;

// указываем имя цели, которая будет выполняться первой
$project->setStartTarget("default");

// далее описываем цели
$target = new Target("default", function(){

	// получить список всех файлов в каталоге .meme
	$fileSet = new Types\FileSet(".meme");
	$files = $fileSet->getFiles();

	Output::info("I've got files:\n");
	foreach ($files as $file)
		Output::info($file);

	// получить список только PHP файлов во всех вложенных каталогах
	// и упаковать их в архив meme_project.zip
	$fileSet = new Types\FileSet(".meme", array("**.php"));
	(new \Meme\Task\Zip("meme_project.zip", $fileSet))
		->run();

});

// добавить существующие цели в проект
$project->addTarget($target);
```

Результат:
```
Start Meme project 'make-zip'

run target > 'default':

	I've got files:

	config.yml
	custom/.gitignore
	deploy-demo.php
	deploy-dev.php
	make-zip.php
	release-demo.php
	release-production.php
	custom

>> Start Zip task
	Created zip file meme_project.zip
```

# Встроенные задачи