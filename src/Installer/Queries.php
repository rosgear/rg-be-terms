<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * Файл конфигурации Карты SQL-запросов.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

return [
    'drop'   => ['{{term}}'],
    'create' => [
        '{{term}}' => function () {
            return "CREATE TABLE `{{term}}` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `component_id` varchar(100) DEFAULT NULL,
                `component_type` varchar(20) DEFAULT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE={engine} 
                DEFAULT CHARSET={charset} COLLATE {collate}";
        }
    ],

    'run' => [
        'install'   => ['drop', 'create'],
        'uninstall' => ['drop']
    ]
];