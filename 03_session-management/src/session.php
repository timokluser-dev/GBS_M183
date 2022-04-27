<?php
require_once 'autoload.php';

/**
 * Session Management Class
 */
class Session
{
    /**
     * the sessions config
     */
    public SessionConfig $config;

    /**
     * additional session options
     */
    private array $sessionOptions = [];

    /**
     * automatically starts a session
     * @param int $sessionExpirationSeconds in seconds
     * @param int $sessionExpirationHours in hours
     * @param array $additionalSessionOptions additional session options - https://www.php.net/manual/de/session.configuration.php
     */
    public function __construct(SessionConfig $config)
    {
        $this->config = $config;

        $this->sessionOptions = array_merge($this->sessionOptions, $config->options);

        $this->init();
        $this->checkSessionTimeout();
    }

    /**
     * start session with provided config
     */
    private function init()
    {
        // make cookie expire when browser closed
        session_set_cookie_params(0);

        return session_start($this->sessionOptions);
    }

    /**
     * check server side for cookie expiration
     */
    private function checkSessionTimeout()
    {
        if (!$this->config->expiration) {
            return;
        }

        $SESSION_EXPIRATION_SECONDS = $this->config->expiration->SESSION_EXPIRATION_SECONDS();

        if ($this->get('LAST_ACTIVITY') && (time() - $this->get('LAST_ACTIVITY') >= $SESSION_EXPIRATION_SECONDS)) {
            return $this->end();
        }

        $this->set('LAST_ACTIVITY', time());
    }

    /**
     * gets a session variable
     * @param string $key variable
     */
    public function get(string $key)
    {
        if ($_SESSION && array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * sets a session variable
     * @param string $key key
     * @param mixed $value value
     */
    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * clears a session variable
     * @param string $key key
     */
    public function remove(string $key)
    {
        if (!array_key_exists($key, $_SESSION)) {
            return;
        }

        $_SESSION[$key] = null;
    }

    /**
     * get session id
     * @return string id
     */
    public function id()
    {
        return session_id();
    }

    /**
     * ends the session cleanly
     * @return bool ending successful
     */
    public function end()
    {
        if (session_regenerate_id() && session_abort()) {
            $this->init();
        }
    }
}

/**
 * Session Configuration Class
 */
class SessionConfig
{
    /**
     * additional session configs
     * @see https://www.php.net/manual/de/session.configuration.php
     */
    public array $options = [];

    /**
     * session expiration
     */
    public ?SessionExpiration $expiration = null;
}

/**
 * Configuration Class for Session Expiration
 */
class SessionExpiration
{
    public int $hours = 0;
    public int $minutes = 0;
    public int $seconds = 0;

    public function __construct(int $hours, int $minutes, int $seconds)
    {
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    /**
     * get session expiration in seconds
     * @return int expiration in seconds
     */
    public function SESSION_EXPIRATION_SECONDS()
    {
        return ($this->hours * 60 * 60) + ($this->minutes * 60) + ($this->seconds);
    }
}
