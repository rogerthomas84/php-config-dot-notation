<?php
/**
 * Class ConfigDot
 */
class ConfigDot
{
    /**
     * Static variable, holding the instance of this Singleton.
     *
     * @var ConfigDot|null
     */
    protected static $_instance = null;

    /**
     * The configuration array
     *
     * @var array|null
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $resolvedConfig = [];

    /**
     * ConfigDot constructor. Protected to avoid direct construction.
     */
    protected function __construct()
    {
    }

    /**
     * Retrieve an instance of this object.
     *
     * @return ConfigDot
     */
    protected static function getInstance(): ConfigDot
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Set the configuration array
     *
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        $instance = self::getInstance();
        $instance->config = array_merge($instance->config, $config);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public static function update(string $key, $value)
    {
        $instance = self::getInstance();
        $instance->resolvedConfig[$key] = $value;
        $instance->config[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return self::get($key) !== null;
    }

    /**
     * Get a single config value, or pass null to get all config. Keys can be a single key, or dot notation.
     *
     * @param null $key
     * @return string|array|int|float|bool|null
     * @example ConfigDot::getInstance()->get(
     *      'foo.bar.joe.bloggs'
     * );
     *
     */
    public static function get($key = null)
    {
        $instance = self::getInstance();
        if ($key === null) {
            return $instance->config;
        }
        if (array_key_exists($key, $instance->config)) {
            return $instance->config[$key];
        }
        if (strstr($key, '.') !== false) {
            if (array_key_exists($key, $instance->resolvedConfig)) {
                return $instance->resolvedConfig[$key];
            }
            $instance->resolvedConfig[$key] = $instance->fromDot($key, $instance->config);
            return $instance->resolvedConfig[$key];
        }
        return null;
    }

    /**
     * Get a config value from a dot formatted key.
     *
     * @param string $key
     * @param array $conf
     * @param ConfigDot|null $instance
     * @return string|array|int|float|bool|null
     * @example self::fromDot(
     *      'foo.bar.joe.bloggs',
     *      $this->config
     * );
     */
    protected static function fromDot(string $key, array $conf, ConfigDot $instance = null)
    {
        if (null === $instance) {
            $instance = ConfigDot::getInstance();
        }
        if (array_key_exists($key, $conf)) {
            return $conf[$key];
        }
        if (strstr($key, '.') === false) {
            return null;
        }
        $pieces = explode('.', $key);
        if (array_key_exists($pieces[0], $conf)) {
            $conf = $conf[$pieces[0]];
            if (count($pieces) > 1) {
                unset($pieces[0]);
                return self::fromDot(implode('.', $pieces), $conf, $instance);
            }
            return $conf;
        }
        return null;
    }
}
