<?php

namespace app\classes\widgets;

use Yii;
use yii\helpers\Inflector;
use yii\caching\FileDependency;

/**
 * Description of Route
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Route
{
    public static $configFile = '@app/routes/routes.php';
    public static $currentName;
    protected static $basePath;
    private static $_routes;
    private static $_names;
    private static $_menus;
    private static $_route;

    public static function getMenuItems()
    {
        static::init();
        return self::$_menus;
    }

    public static function get()
    {
        if (self::$_route === null) {
            static::init();
            static::resolveRoute();
        }
        return self::$_route;
    }

    public static function set($name)
    {
        static::init();
        static::$currentName = $name;
        self::$_route = self::$_routes[$name];
    }

    protected static function resolveRoute()
    {
        $route = '/' . Yii::$app->controller->route;
        $params = Yii::$app->getRequest()->get();
        if (isset(self::$_names[$route])) {
            foreach (self::$_names[$route] as $config) {
                $match = true;
                foreach ($config['params'] as $key => $value) {
                    if (!isset($params[$key]) || $params[$key] != $value) {
                        $match = false;
                        break;
                    }
                }
                if ($match) {
                    static::$currentName = $config['name'];
                    self::$_route = self::$_routes[$config['name']];
                    return;
                }
            }
            Yii::trace("Route '{$route}' not match");
        } else {
            Yii::trace("Route '{$route}' not found");
        }
    }

    protected static function init()
    {
        if (self::$_menus === null) {
            $cache = Yii::$app->getCache();
            if ($cache && ($data = $cache->get(__METHOD__)) !== false) {
                list(self::$_menus, self::$_names, self::$_routes) = $data;
                return;
            }

            static::$configFile = Yii::getAlias(static::$configFile);
            static::$basePath = dirname(static::$configFile);

            $items = static::requireFile(static::$configFile);
            self::$_menus = static::resolveRecursive($items, '');
            if ($cache) {
                $data = [self::$_menus, self::$_names, self::$_routes];
                $cache->set(__METHOD__, $data, 0, new FileDependency(['fileName' => static::$configFile]));
            }
        }
    }

    protected static function resolveRecursive($items, $prefix)
    {
        $result = [];
        foreach ($items as $label => $item) {
            $name = $prefix . Inflector::slug($label);
            if (is_array($item) && !isset($item['url'])) {
                $result[] = [
                    'label' => $label,
                    'name' => $name,
                    'items' => static::resolveRecursive($item, $name . '/'),
                ];
            } else {
                if (is_string($item)) {
                    if (strncmp($item, '@', 1) === 0) {
                        $file = Yii::getAlias($item);
                    } else {
                        $file = static::$basePath . '/' . ltrim($item, '/');
                    }
                    $item = static::requireFile($file);
                }

                $result[] = static::resolveItem($item, $name, $label);
            }
        }
        return $result;
    }

    protected static function requireFile($_file_)
    {
        if (!is_file($_file_) && is_file($_file_ . '.php')) {
            $_file_ = $_file_ . '.php';
        }
        return require $_file_;
    }

    protected static function resolveItem($item, $name, $label)
    {
        $item['name'] = $name;
        $url = $item['url'];
        $url[0] = '/' . ltrim($url[0], '/');

        if (!isset($item['label'])) {
            $item['label'] = $label;
        }
        $result = isset($item['menuOptions']) ? $item['menuOptions'] : [];
        $result = array_merge($result, [
            'url' => $url,
            'name' => $name,
            'label' => $item['label'],
        ]);

        $route = $url[0];
        unset($url[0]);
        self::$_names[$route][] = [
            'params' => $url,
            'name' => $name,
        ];
        if (isset($item['urls'])) {
            foreach ($item['urls'] as $url) {
                $route = '/' . ltrim($url[0], '/');
                unset($url[0]);
                self::$_names[$route][] = [
                    'params' => $url,
                    'name' => $name,
                ];
            }
        }
        self::$_routes[$name] = $item;
        return $result;
    }
}
