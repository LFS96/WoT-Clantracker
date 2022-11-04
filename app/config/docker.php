<?php

return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    /*
    * Security and encryption configuration
    *
    * - salt - A random string used in security hashing methods.
    *   The salt value is also used as the encryption key.
    *   You should treat it as extremely sensitive data.
    */
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],


    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => env("MARIADB_HOST",'localhost'),
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',

            'username' => env("MARIADB_USER",'root'),
            'password' => env("MARIADB_ROOT_PASSWORD",'123456'),

            'database' => env("MARIADB_DATABASE",'claninterface'),

            /*
             * You can use a DSN string to set the entire configuration
             */
            'url' => env('DATABASE_URL'),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => env("EMAIL_HOST",'localhost'),
            'port' => env("EMAIL_PORT",25),
            'username' => env("EMAIL_USER"),
            'password' => env("EMAIL_PASS"),
            'client' => env("EMAIL_CLIENT",null),
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL',null),
            'tls' => env("EMAIL_TLS",true)
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => [env("EMAIL_FROM_MAIL",'some@email.com') => env("EMAIL_FROM_NAME","WoT-Claninterface")],
            /*
             * Will by default be set to config value of App.encoding, if that exists otherwise to UTF-8.
             */
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
        ],
    ],

    /*
     * Output Format of websites:
     *  - html
     *  - json
     *  - xml
     */
    "outputFormat" => env("OUTPUT_FORMAT","html"),
    "wot_api_key" => env("WOT_API_KEY"),
    "wot_lang" => env("WOT_LANGUAGE","de"),
];

