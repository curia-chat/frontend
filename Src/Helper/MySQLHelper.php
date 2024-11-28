<?php

namespace Src\Helper;

use PDO;
use PDOException;

class MySQLHelper
{
    protected static $pdo;

    // Diese Methode stellt eine Verbindung zur MySQL-Datenbank her und gibt ein PDO-Objekt zurück
    public static function getPDO($config)
    {
        // Prüfen, ob die Verbindung bereits existiert (Singleton-Muster)
        if (self::$pdo === null) {
            try {
                $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';port=' . $config['db_port'];
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Fehler als Exception
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Standard Fetch-Modus
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true          // SSL verwenden, wenn verfügbar
                ];

                // Verbindung herstellen
                self::$pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
            } catch (PDOException $e) {
                // Fehlerbehandlung, falls die Verbindung fehlschlägt
                die("Verbindung zur Datenbank fehlgeschlagen: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
