<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

if (getenv('app_baseURL') || getenv('app.baseURL')) {
  $base = (getenv('app_baseURL')) ? getenv('app_baseURL') : getenv('app.baseURL');
  defined('BASE') || define('BASE', $base);
  defined('SERVERME') || define('SERVERME', $base);
} else {
  if (isset($_SERVER['HTTP_HOST'])) {
    $explodeFolder = explode('/index.php', $_SERVER['SCRIPT_NAME'])[0];
    $cekPublicFolder = explode('/public', $explodeFolder);
    $cekPort = ($_SERVER['SERVER_PORT'] != 80) ?  $explodeFolder : ((count($cekPublicFolder) == 1) ? $explodeFolder . ''  : $cekPublicFolder[0]);
    $folderProject = $cekPort;

    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? 'https://' . $_SERVER['HTTP_HOST'] . $folderProject : 'http://' . $_SERVER['HTTP_HOST'] . $folderProject;
    defined('BASE') || define('BASE', $protocol);

    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'];
    defined('SERVERME') || define('SERVERME', $protocol);
  } else {
    defined('BASE') || define('BASE', '');
    defined('SERVERME') || define('SERVERME', '');
  }
}

// EMAIL
defined('EMAIL_SEND') || define('EMAIL_SEND', getenv('EMAIL_SEND'));
defined('EMAIL_DEBUG') || define('EMAIL_DEBUG', getenv('EMAIL_DEBUG'));
defined('EMAIL_HOST') || define('EMAIL_HOST', getenv('EMAIL_HOST'));
defined('EMAIL_SMTP_AUTH') || define('EMAIL_SMTP_AUTH', getenv('EMAIL_SMTP_AUTH'));
defined('EMAIL_PROTOCOL') || define('EMAIL_PROTOCOL', getenv('EMAIL_PROTOCOL'));
defined('EMAIL_USERNAME') || define('EMAIL_USERNAME', getenv('EMAIL_USERNAME'));
defined('EMAIL_FROM') || define('EMAIL_FROM', getenv('EMAIL_FROM'));
defined('EMAIL_FROM_NAME') || define('EMAIL_FROM_NAME', getenv('EMAIL_FROM_NAME'));
defined('EMAIL_PASSWORD') || define('EMAIL_PASSWORD', getenv('EMAIL_PASSWORD'));
defined('EMAIL_RECIPIENTS') || define('EMAIL_RECIPIENTS', getenv('EMAIL_RECIPIENTS'));
defined('EMAIL_SMTP_SECURE') || define('EMAIL_SMTP_SECURE', getenv('EMAIL_SMTP_SECURE'));
defined('EMAIL_PORT') || define('EMAIL_PORT', getenv('EMAIL_PORT'));
defined('EMAIL_MAIL_TYPE') || define('EMAIL_MAIL_TYPE', getenv('EMAIL_MAIL_TYPE'));
defined('EMAIL_CC') || define('EMAIL_CC', getenv('EMAIL_CC'));

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);
