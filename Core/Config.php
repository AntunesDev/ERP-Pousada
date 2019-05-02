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
    const DB_OS = 'DB_OS';

    /**
     * Database Engine
     * @var string
     * @options(mysql, sqlserver)
     */
    const DB_ENGINE = 'DB_ENGINE';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = '192.168.0.DB_HOST';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'DB_NAME';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'DB_USER';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'DB_PASSWORD';

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
