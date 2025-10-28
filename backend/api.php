<?
// 1. Tillåt åtkomst från din React-domän (http://localhost:3000)
header('Access-Control-Allow-Origin: http://localhost:3000');

// 2. Tillåt de HTTP-metoder som din app använder (GET, POST, DELETE)
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');

// 3. Tillåt de headers som React och Axios skickar (t.ex. Content-Type)
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// 4. Hantera OPTION-förfrågningar (Pre-flight request)
// Webbläsaren skickar först en OPTIONS-förfrågan för POST/DELETE
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// PHP-fil för att testa databasanslutningen

$host = 'mariadb_db'; // Måste matcha containerns namn i docker-compose
$db   = 'myapp_db';
$user = 'root';
$pass = 'myrootpassword'; // Måste matcha lösenordet i docker-compose

echo "Hej";

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

     //function connect(){
         
        // try {
        //     $conn = new PDO('mysql:host=' .$host .';dbname=' .$db, $user, $pass);
        //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     echo "CONNECT db";

        //     return $conn;
        // }
        // catch (Exception $e){
        //     echo "Database error: " . $e->getMessage() ; 
        // }
        // catch (PDOException $e){
        //     echo "Database PDO error: " . $e->getMessage() ; 
        // }
     
 //}

?>