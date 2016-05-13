<?php

namespace app\classes\widgets;

use Yii;
use yii\helpers\Url;
use yii\caching\FileDependency;

/**
 * Description of Route
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Route
{
    public static $currentName;
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
        }
        Yii::trace("Route '{$route}' not found");
    }

    protected static function init()
    {
        if (self::$_menus === null) {
            $cache = Yii::$app->getCache();
            if ($cache && ($data = $cache->get(__METHOD__)) !== false) {
                list(self::$_menus, self::$_names, self::$_routes) = $data;
                return;
            }

            $items = require(Yii::getAlias('@app/routes/routes.php'));
            self::$_menus = static::resolveRecursive($items, '');
            if ($cache) {
                $data = [self::$_menus, self::$_names, self::$_routes];
                $cache->set(__METHOD__, $data, 0, new FileDependency(['fileName' => '@app/routes/routes.php']));
            }
        }
    }

    protected static function resolveRecursive($items, $prefix)
    {
        $result = [];
        foreach ($items as $label => $item) {
            if (!isset($item['url'])) {
                $result[] = [
                    'label' => $label,
                    'name' => md5($prefix . $label),
                    'items' => static::resolveRecursive($item, $prefix . $label . '/'),
                ];
            } else {
                $url = $item['url'];
                $url[0] = '/' . ltrim($url[0], '/');
                $item['name'] = $name = md5(serialize($url));
                $item['canonical'] = Url::to($url, true);
                if (!isset($item['label'])) {
                    $item['label'] = $label;
                }

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
                if(isset($item['source']) && preg_match('/^[@\/][\w\/\-\.]+.md$/', $item['source'])){
                    $item['source'] = file_get_contents(Yii::getAlias($item['source']));
                }
                self::$_routes[$name] = $item;
                $result[] = $item;
            }
        }
        return $result;
    }
}
