<?php
    /**
     * TNH Framework
     *
     * A simple PHP framework using HMVC architecture
     *
     * This content is released under the MIT License (MIT)
     *
     * Copyright (c) 2017 TNH Framework
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in all
     * copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
     * SOFTWARE.
     */

    /**
     * the directory separator, under windows it is \ and unix, linux /
     */
    define('DS', DIRECTORY_SEPARATOR);

    /**
     * The root directory of the application.
     *
     * you can place this directory outside of your web directory, for example "/home/your_app", etc.
     */
    define('ROOT_PATH', dirname(realpath(__FILE__)) . DS);

    /**
     * The path to the directory.
     *
     * That contains your static files (javascript, css, images, etc.)
     * Note: the path must be relative to the file index.php (the front-end controller).
     */
    define('ASSETS_PATH', 'assets/');

    /**
     * The path to the application directory. 
     *
     * It contains your most often used files that is to say which contains your files of the application, 
     * in MVC architecture (controllers, models, views, modules, config, lang, etc.).
     */
    define('APPS_PATH', ROOT_PATH . 'app' . DS);

    /**
     * The path to the controller directory of your application.
     *
     * If you already know the MVC architecture you know what a controller means; 
     * it is he who makes the business logic of your application in general.
     */
    define('APPS_CONTROLLER_PATH', APPS_PATH . 'controllers' . DS);

    /**
     * The path to the directory of your model classes of your application. 
     *
     * If you already know the MVC architecture you know what a model means; 
     * it's the one who interacts with the database, in one word persistent data from your application.
     */
    define('APPS_MODEL_PATH', APPS_PATH . 'models' . DS);

    /**
     * The path to the directory of your views.
     *
     * If you already know the MVC architecture you know what a view means, 
     * a view is just a user interface (html page, form, etc.) that is to say 
     * everything displayed in the browser interface, etc.
     */
    define('APPS_VIEWS_PATH', APPS_PATH . 'views' . DS);

    /**
     * The path to the configuration directory.
     *
     * That contains most of the configuration files for your 
     * application (database, class loading file, functions, etc.)
     */
    define('CONFIG_PATH', APPS_PATH . 'config' . DS);
    
    /**
     * The path to the directory of your PHP personal functions or helper.
     *
     * It contains your PHP functions that perform a particular task: utilities, etc.
     * Note: Do not put your personal functions or helpers in the system functions directory, 
     * because if you update the system you may lose them.
     */
    define('FUNCTIONS_PATH', APPS_PATH . 'functions' . DS);

    /**
     * The path to the app directory of personal language. 
     *
     * This feature is not yet available. 
     * You can help us do this if you are nice or wish to see the developed framework.
     */
    define('APP_LANG_PATH', APPS_PATH . 'lang' . DS);

    /**
     * The path to the directory of your personal libraries
     *
     * It contains your PHP classes, package, etc.
     * Note: you should not put your personal libraries in the system library directory, 
     * because it is recalled in case of updating the system you might have surprises.
     */
    define('LIBRARY_PATH', APPS_PATH . 'libraries' . DS);
    
    /**
     * The path to the modules directory. 
     *
     * It contains your modules used files (config, controllers, libraries, etc.) that is to say which contains your files of the modules, 
     * in HMVC architecture (hierichical, controllers, models, views).
     */
    define('MODULE_PATH', APPS_PATH . 'modules' . DS);


    /** 
     * The core directory
     *
     * It is recommended to put this folder out of the web directory of your server and 
     * you should not change its content because in case of update you could lose the modified files.
     */
    define('CORE_PATH', ROOT_PATH . 'core' . DS);
	
    /**
     * The path to the directory of core classes that used by the system.
     *
     * It contains PHP classes that are used by the framework internally.
     */
    define('CORE_CLASSES_PATH', CORE_PATH . 'classes' . DS);
	
    /**
     * The path to the directory of core classes for the cache used by the system.
     *
     * It contains PHP classes for the cache drivers.
     */
    define('CORE_CLASSES_CACHE_PATH', CORE_CLASSES_PATH . 'cache' . DS);
	
    /**
     * The path to the directory of core classes for the database used by the system.
     *
     * It contains PHP classes for the database library, drivers, etc.
     */
    define('CORE_CLASSES_DATABASE_PATH', CORE_CLASSES_PATH . 'database' . DS);
    
    /**
     * The path to the directory of core classes for the model used by the system.
     *
     * It contains PHP classes for the models.
     */
    define('CORE_CLASSES_MODEL_PATH', CORE_CLASSES_PATH . 'model' . DS);

    /**
     * The path to the directory of functions or helper systems.
     *
     * It contains PHP functions that perform a particular task: character string processing, URL, etc.
     */
    define('CORE_FUNCTIONS_PATH', CORE_PATH . 'functions' . DS);

    /**
     * The path to the core directory of languages files. 
     *
     */
    define('CORE_LANG_PATH', CORE_PATH . 'lang' . DS);

    /**
     * The path to the system library directory.
     *
     * Which contains the libraries most often used in your web application, as for the 
     * core directory it is advisable to put it out of the root directory of your application.
     */
    define('CORE_LIBRARY_PATH', CORE_PATH . 'libraries' . DS);

    /**
     * The path to the system view directory.
     *
     * That contains the views used for the system, such as error messages, and so on.
     */
    define('CORE_VIEWS_PATH', CORE_PATH . 'views' . DS);
	
    /**
     * The path to the directory of your var files (logs, cache, etc.).
     *
     */
    define('VAR_PATH', ROOT_PATH . 'var' . DS);
    
     /**
     * The path to the directory of your cache files.
     *
     * This feature is available currently for database and views.
     */
    define('CACHE_PATH', VAR_PATH . 'cache' . DS);
    
    /**
     * The path to the directory that contains the log files.
     *
     * Note: This directory must be available in writing and if possible must have as owner the user who launches your web server, 
     * under unix or linux most often with the apache web server it is "www-data" or "httpd" even "nobody" for more
     * details see the documentation of your web server.
     * Example for Unix or linux with apache web server:
     * # chmod -R 700 /path/to/your/logs/directory/
     * # chown -R www-data:www-data /path/to/your/logs/directory/
     */
    define('LOGS_PATH', VAR_PATH . 'logs' . DS);

    /**
     * The path to the directory of sources external to your application.
     *
     * If you have already used "composer" you know what that means.
     */
    define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);

    /**
     * The front controller of your application.
     *
     * "index.php" it is through this file that all the requests come, there is a possibility to hidden it in the url of 
     * your application by using the rewrite module URL of your web server .
     * For example, under apache web server, there is a configuration example file that is located at the root 
     * of your framework folder : "htaccess.txt" rename it to ".htaccess".
     */
    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
	
    /**
     * Check if user run the application under CLI
     */
    define('IS_CLI', stripos('cli', php_sapi_name()) !== false);

    /**
     * The environment of your application (production, test, development). 
     *
     * if your application is still in development you use the value "development" 
     * so you will have the display of the error messages, etc. 
     * Once you finish the development of your application that is to put it online 
     * you change this value to "production" or "testing", in this case there will be deactivation of error messages, 
     * the loading of the system, will be fast.
     */
    define('ENVIRONMENT', 'development');

    /* ---------------------------------------------------------------------------------- */
    ///////////////////////////////////////////////////////////////////////////////////////
    /******************** DO NOT CHANGE THE LINES BELOW *********************************/
    /////////////////////////////////////////////////////////////////////////////////////

    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;
        case 'testing':
        case 'production':
            ini_set('display_errors', 0);
            if (version_compare(PHP_VERSION, '5.3', '>=')) {
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
            } else {
                error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
            }
        break;
        default:
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo 'The application environment is not set correctly.';
            exit(1);
    }
	
    /**
     * let's go.
     * Everything is OK now we launch our application.
     */
    require_once CORE_PATH . 'bootstrap.php';