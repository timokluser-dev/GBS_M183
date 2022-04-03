<?php

abstract class Helpers
{
    private static bool $isSanitized = false;

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
     * @param string $input string to sanitize
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

        self::$isSanitized = true;
    }

    /**
     * get a form field
     * @param string $key key of field (= name)
     * @param FieldTypes $type type of the field - default `FieldTypes::string`
     * @return null|array|object|mixed form field
     */
    public static function getFormField(string $key, FieldTypes $type = FieldTypes::string)
    {
        if (!self::$isSanitized) {
            self::sanitizePostAndGet();
        }

        if (!$_POST) {
            if ($_GET) {
                # code...
            }

            echo null;
        }

        if (!$_POST || ($_POST && !array_key_exists($key, $_POST))) {
            return null;
        }

        if (is_array($_POST[$key]) || is_object($_POST[$key])) {
            $value = $_POST[$key];
            return (self::checkType($value, $type)) ? $_POST[$key] : null;
        }

        // trim($_POST[$key]
        $value = self::checkType($_POST[$key], $type);
        return ($value) ? $value : null;
    }

    /**
     * get a form field with long text.
     * includes convert from nl to html <br />
     * @param string $key key of field with long text / textarea (= name)
     * @return string|null form field text - `null` if not string
     */
    public static function getFormFieldLongText(string $key)
    {
        $formField = self::getFormField($key);

        if (!is_string($formField)) {
            return null;
        }

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
     * @param string $email email to test
     * @return bool|string[] `false` if no email - `string[]` with parts if valid email
     * 
     * `string[1]` => mailbox  
     * `string[2]` => domain name  
     * `string[3]` => tld  
     */
    public static function formatEmail(string $email)
    {
        // @see https://ihateregex.io/expr/email/
        $emailPattern = '/^([^@ \t\r\n]+)@([^@ \t\r\n\.]+)\.([^@ \t\r\n]{2,6})$/';

        if (preg_match($emailPattern, $email, $matches)) {
            return $matches;
        } else {
            return false;
        }
    }

    /**
     * casts a value to specified type and checks if type matches
     * @param mixed $value value to check for type
     * @param FieldType $type type to check
     * @return mixed|bool value with specified type - `false` if type does not match
     */
    public static function checkType(mixed $value, FieldTypes $type)
    {
        switch ($type) {
            case FieldTypes::string:
                $value = strval($value);
                return (is_string($value)) ? $value : false;
                break;
            case FieldTypes::boolean:
                $value = boolval($value);
                return (is_bool($value)) ? $value : false;
                break;
            case FieldTypes::int:
                $value = intval($value);
                return (is_int($value)) ? $value : false;
                break;
            case FieldTypes::double:
                $value = doubleval($value);
                return (is_double($value)) ? $value : false;
                break;
            case FieldTypes::array:
                return (is_array($value)) ? $value : false;
                break;
            case FieldTypes::object:
                return (is_object($value)) ? $value : false;
                break;
        }

        return false;
    }

    /**
     * check if array includes an element
     * @param mixed $element element to check
     * @param array $array array to check
     * @return bool array includes element
     */
    public static function array_includes(mixed $element, array $array)
    {
        return array_search($element, $array) !== false;
    }
}

/**
 * possible field types for type check
 */
enum FieldTypes
{
    case string;
    case boolean;
    case int;
    case double;
    case array;
    case object;
}

Helpers::init();
