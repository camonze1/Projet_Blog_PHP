<?php

namespace blogapp\conf;
use Illuminate\Database\Capsule\Manager as DB;

/**
 *  La classe ConnectionFactory : fabrique des connexions BD
 * 
 *  Elle implante un singleton sur la connexion.
 */

class ConnectionFactory {
    private static $db = null;

    public static function makeConnection($configFile) {
        if (is_null(self::$db)) {
            self::$db = new DB();
            self::$db->addConnection(parse_ini_file($configFile));

            self::$db->setAsGlobal();
            self::$db->bootEloquent();
        }
    }

    public static function getDB() {
        return self::$db;
    }
}

?>
