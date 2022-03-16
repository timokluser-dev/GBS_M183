<?php

abstract class Helpers
{
    /**
     * static constructor
     */
    public static function init()
    {
        self::sanitizePostAndGet();
    }

    /**
     * print out variable in debug
     * @param mixed $output variable to print
     */
    public static function debug(mixed $output)
    {
        echo '<pre>';

        if (is_array($output) || is_object($output)) {
            print_r($output);
        } else {
            var_dump($output);
        }

        echo '</pre>';
    }

    /**
     * sanitize html input and prevent xss.
     * **IMPORTANT:** POST and GET variables are already sanitized!
     */
    public static function sanitize(string $input)
    {
        return htmlspecialchars($input);
    }

    /**
     * sanitizes global GET and POST variables
     */
    private static function sanitizePostAndGet()
    {
        global $_GET;
        global $_POST;
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public static function getFormField(string $key)
    {
        if (!$_POST || ($_POST && !array_key_exists($key, $_POST))) {
            return null;
        }

        if (is_array($_POST[$key]) || is_object($_POST[$key])) {
            return $_POST[$key];
        }

        return trim($_POST[$key]);
    }

    /**
     * get a form field with long text.
     * includes convert from nl to html <br />
     * @return string form field text
     */
    public static function getFormFieldLongText(string $key)
    {
        return nl2br(self::getFormField($key));
    }

    /**
     * get a json object
     * @param string $path relative path
     * @return object json object
     */
    public static function getJson(string $path)
    {
        $json = file_get_contents($path);
        $object = json_decode($json);
        return $object;
    }

    /**
     * if is a form post back
     */
    public static function isPost()
    {
        return $_POST && count($_POST);
    }

    /**
     * prevent a resubmit of the form with a JS approach
     */
    public static function preventReSubmit()
    {

        echo "
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
                console.log('cleared');
            }
        </script>
        ";
    }

    /**
     * check for valid email and get email parts
     * @return bool|string[] `false` if no email - `string[]` with parts if valid email
     * 
     * `string[1]` => mailbox  
     * `string[2]` => domain name  
     * `string[3]` => tld  
     */
    public static function formatEmail(string $email)
    {
        // @see https://ihateregex.io/expr/email/
        $emailPattern = '/([^@ \t\r\n]+)@([^@ \t\r\n]+)\.([^@ \t\r\n]+)/';

        if (preg_match($emailPattern, $email, $matches)) {
            return $matches;
        } else {
            return false;
        }
    }

    public static function array_includes(string $str, array $array)
    {
        return array_search($str, $array) !== false;
    }
}

Helpers::init();
