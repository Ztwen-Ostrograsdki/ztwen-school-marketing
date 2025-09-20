<?php

return [

    'users_list_sections' => [
        'all' => "Tout",
        'blocked' => "Les utilisateurs bloqués",
        'unlockeds' => "Les utilisateurs non bloqués",
        'confirmeds' => "Les utilisateurs confirmés",
        'unconfirmeds' => "Les utilisateurs non confirmés",
        'subscribing' => "Avec abonnéments actifs",
        'unsubscribing' => "Sans abonnéments actifs",
        'schooled' => "Ayant une école ",
        'unschooled' => "N'ayant pas d'école ",

    ],
    'infos_types' => [
        'cv' => "Cours de vacances",
        'cr' => "Cours de renforcements",
        'ot' => "Besoins d'enseignants",
        'infos' => "Informations",
        'ofe' => "Offres d'emploi",
        'bd' => "Bulletins disponibles",
        'cp' => "Conseil | Réunion des parents",
        'ce' => "Conseil des enseignants",

    ],

    'targets_types' => [
        "Enseignants du primaire" => "Enseignants du primaire",
        "Enseignants du secondaire" => "Enseignants du secondaire",
        "Enseignants du supérieur" => "Enseignants du supérieur",
        "Parents d'élèves" => "Parents d'élèves",
        "Ecoliers" => "Ecoliers",
        "Ecoliers" => "Ecoliers",
        "Elèves" => "Elèves",
        "Elèves" => "Elèves",
        "Etudiants" => "Etudiants",
        "Tout le monde" => "Tout le monde",
    ],

    'notifications_sections' => [
        'news' => "Récentes",
        'unread' => "Non lues",
        'read' => "Déjà lues",
        'all' => "Toutes les notifications",
        'hidden' => "Masquées",
    ],

    'exams' => [
        'cep' => 'CEP',
        'bepc' => 'BEPC',
        'cap' => 'CAP',
        'bts' => 'BTS',
        'bac' => 'BAC',
        'bac-F1' => 'BAC F1',
        'bac-F2' => 'BAC F2',
        'bac-F3' => 'BAC F3',
        'bac-F4' => 'BAC F4',
        'bac-D' => 'BAC F3',
        'bac-C' => 'BAC F3',
        'bac-E' => 'BAC E',
        'bac-A1' => 'BAC F3',
        'bac-A2' => 'BAC F3',
        'bac-AB' => 'BAC F3',
        'dt-EA' => 'DT EA',
        'dt-EL' => 'DT EL',
        'dt-FC' => 'DT FC',
        'dt-FM' => 'DT FM',
        'dt-MA' => 'DT MA',
        'dt-OG' => 'DT OG',
        'dt-BTP' => 'DT BTP',
        'dt-DPB' => 'DT DPB',
        'dt-OBB' => 'DT OBB',

    ],

    'app_packs' => [

        'Basic' => "Basic",
        'Pro' => "Pro",
        'Premium' => "Premium",
        'Premium-Gold' => "Premium-Gold"

    ],

    'mtn_phone_number' => "01-61-100-804",
    'celtiis_phone_number' => "01-43-289-301",

    'my_token'=> "883hxxeduusedk787iixcdegshe_jehde002dee99782deeffgKMngXYategdeWzdehhde71jjxef_dqx345xedxusedk787ikgxcdegsffejehde220dee9=validate",

    "subcriptions_task_report" => "Tâche de suppression de l'abonnement une fois le delai expiré",


    'max_quotes_by_user' => 3,



    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'ZtweN-MySchool'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
