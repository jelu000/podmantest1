<?php
phpinfo();
// PHP-fil för att testa databasanslutningen

//$host = 'mariadb_db'; // Måste matcha containerns namn i docker-compose
//$db   = 'myapp_db';
//$user = 'root';
//$pass = 'myrootpassword'; // Måste matcha lösenordet i docker-compose

//$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
/**$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];*/

/**try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "<h1>PHP är igång och ansluten till databasen!</h1>";
     // Här kan du lägga till logik för att hämta data till din React-app
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}*/

?>