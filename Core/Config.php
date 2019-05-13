<?php
namespace Core;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{
    /**
     * Database OS
     * @var string
     * @options(windows, linux)
     */
    const DB_OS = 'windows';

    /**
     * Database Engine
     * @var string
     * @options(mysql, sqlserver)
     */
    const DB_ENGINE = 'mysql';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'erp-pousada';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;

    /**
     * Set the session name
     * @var string
     */
    const SESSION_NAME = 'app_erp_pousada';
}
