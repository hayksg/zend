<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Mvc\I18n\Translator as T;
use Zend\Session\ManagerInterface;
use Zend\Session\Service\SessionManagerFactory;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Storage\SessionArrayStorage;

return [
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => getcwd() . '/data/languages/phpArray',
                'pattern'  => '%s.php',
            ],
            [
                'type'     => 'gettext',
                'base_dir' => getcwd() . '/data/languages/getText',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'translator' => T::class,
        ],
    ],
    'session_config' => [
        // Срок действия cookie сессии истечет через 1 час.
        'cookie_lifetime' => 60*60*1,
        // Данные сессии будут храниться на сервере до 30 дней.
        'gc_maxlifetime'     => 60*60*24*30,
    ],
    // Настройка менеджера сессий.
    'session_manager' => [
        // Валидаторы сессии (используются для безопасности).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    // Настройка хранилища сессий.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
];
