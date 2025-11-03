

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
// Dessa värden matchar vad du har i din podman-compose.yml
$host = 'mariadb_db'; // Måste matcha containerns namn i docker-compose
$db   = 'myapp_db';
$user = 'root';
$pass = 'myrootpassword'; // Måste matcha lösenordet i docker-compose

// backend/config.php (eller var du nu ansluter)


$dsn = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8mb4';




if (isset($_GET['action'])) {
     $action = $_GET['action'];

     if ($action === 'getTodos') {

          $sql = "SELECT * FROM tasks";
          $conn = new PDO('mysql:host=' .$host .';dbname=' .$db, $user, $pass);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "CONNECT db";

          $sql = "SELECT * FROM tasks";
          echo "r=";
     } 
     elseif ($action === 'addTodo') {

          // Kalla på funktionen som uppdaterar databasen
          //$title = trim($data['Måste Sova']);
          $title = "dax att sova";

          // 2. Förbered SQL-satsen med platshållare (mycket viktigt!)
          //$sql = "INSERT INTO tasks (title) VALUES (:title)";

          //$sql = "INSERT INTO todos (title, completed) VALUES ('Gå o sova', 0)";
          $sql = "INSERT INTO tasks (title, completed) VALUES (:title, 0)";
          //echo $sql;
          try {
               // 3. Förbered satsen med PDO
               $pdo = new PDO($dsn, $user, $pass);
               $stmt = $pdo->prepare($sql);

               // 4. Bind platshållaren till den faktiska datan
               // PDO kommer att sanera datan automatiskt innan den skickas till databasen
               $stmt->bindParam(':title', $title, PDO::PARAM_STR);

               // 5. Utför satsen
               $stmt->execute();

               // VALFRITT: Hämta ID för den nyligen skapade posten
               //$newId = $pdo->lastInsertId();

               // 6. Skicka tillbaka en framgångsrespons till React
               // http_response_code(201); // Created
               // echo json_encode([
               //      "message" => "Uppgift skapad!",
               //      "id" => $newId,
               //      "title" => $title,
               //      "completed" => 0 // Skicka tillbaka datan så att React kan uppdatera listan snabbt
               // ]);
          } catch (PDOException $e) {
               //      // Logga felet (bör inte exponeras för användaren i prod)
                     error_log("Database error: " . $e->getMessage());
                     echo $e->getMessage();
                     //http_response_code(500); // Internal Server Error
                     //echo json_encode(["message" => "Kunde inte lägga till uppgiften på grund av ett serverfel."]);
          }
     } elseif ($action === 'remTodo') {

          echo "remTodos";

          // Hämta ID:t
          //$taskId = $_GET['id'];
          // Kalla på funktionen som uppdaterar databasen
          //markTaskAsCompleted($taskId);
     }
}


//try {
// Skapa PDO-objektet
//   $pdo = new PDO($dsn, $user, $pass);

// Ställ in error mode till exception för bättre felhantering
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
// Avsluta och skriv ut ett felmeddelande om anslutningen misslyckas
//  exit('Database connection failed: ' . $e->getMessage());
//}

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




function getTodos($dsn, $user, $pass, $options){
     $pdo = new PDO($dsn, $user, $pass, $options);
       
     // SQL-fråga för att hämta alla uppgifter
     $sql = "SELECT * FROM tasks ORDER BY id DESC";

     // Kör frågan
     $stmt = $pdo->query($sql);

     // Hämta alla resultat som en associativ array
     $tasks = $stmt->fetchAll();

     // Returnera uppgifterna som ett JSON-svar
     echo json_encode(['success' => true, 'data' => $tasks]);
     exit();
}