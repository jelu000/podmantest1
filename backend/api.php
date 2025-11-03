<?php
// PHP-fil för att hämta data (GET) från MariaDB

// 1. Tillåt åtkomst från din React-domän
header('Access-Control-Allow-Origin: http://localhost:3000');

// 2. Tillåt de HTTP-metoder som din app använder
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');

// 3. Tillåt de headers som React och Axios skickar
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// 4. Hantera OPTION-förfrågningar (Pre-flight request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
     http_response_code(200);
     exit();
}

// Ställ in att svaret ska vara JSON
header('Content-Type: application/json');

// --- Databaskonfiguration ---
// Dessa värden matchar vad du har i din podman-compose.yml
$host = 'mariadb_db'; // Måste matcha containerns namn i docker-compose
$db   = 'myapp_db';
$user = 'root';
$pass = 'myrootpassword'; // Måste matcha lösenordet i docker-compose
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Kastar undantag vid fel
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Standardformat för data blir associativ array
     PDO::ATTR_EMULATE_PREPARES   => false,                  // Använd riktiga prepared statements
];



try {
     // Upprätta databasanslutningen
     $pdo = new PDO($dsn, $user, $pass, $options);

     // Kontrollera den begärda åtgärden (action)
     if (isset($_GET['action'])) {
          $action = $_GET['action'];

          if ($action === 'getTodos') {
               getTodos($dsn, $user, $pass, $options);
          } 
          
     } 

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
          // Läs in JSON-datan från kroppen
           if (isset($_GET['action'])){
               $data = json_decode(file_get_contents("php://input"), true);
               $title = $data['todotext'];
          
               echo $title;
           }      
     } 
     
     if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){ // && isset($_GET['action']) && $_GET['action'] === 'deleteTodo') {
         if (isset($_GET['id'])){
          $t_id = $_GET['id'];
          echo $t_id;
         }         
     } 
     
     
     // Om ingen giltig åtgärd angavs
     echo json_encode(['success' => false, 'message' => 'Ogiltig eller saknad åtgärd.']);
     
} catch (\PDOException $e) {
     // Hantera fel vid databasanslutning eller SQL-fråga
     http_response_code(500); // Internal Server Error
     echo json_encode([
          'success' => false,
          'message' => 'Ett databasfel inträffade.',
          // Ta bort 'error_details' i en skarp produktionsmiljö
          'error_details' => $e->getMessage()
     ]);
} catch (\Exception $e) {
     // Hantera andra oväntade fel
     http_response_code(500);
     echo json_encode([
          'success' => false,
          'message' => 'Ett oväntat fel inträffade.'
     ]);
}

function getTodos($dsn, $user, $pass, $options)
{
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

function delTodo($dsn, $user, $pass, $options, $t_id)
{
     $pdo = new PDO($dsn, $user, $pass, $options);
     $sql = "DELETE FROM todos WHERE id = :id";

     try {
        $stmt = $pdo->prepare($sql);
        
        // 3. Bind ID:t som en integer
        $stmt->bindParam(':id', $t_id, PDO::PARAM_INT);
        
        // 4. Utför satsen
        $stmt->execute();

        // 5. Skicka tillbaka en framgångsrespons (200 OK)
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Uppgift raderad framgångsrikt."]);

    } catch (PDOException $e) {
        error_log("Database error vid radering: " . $e->getMessage());
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Kunde inte radera uppgiften på grund av ett serverfel."]);
    }
    exit;
}

function addTodo($dsn, $user, $pass, $options, $t_todo)
{
     $pdo = new PDO($dsn, $user, $pass, $options);
     $sql = "INSERT INTO tasks (title, completed) VALUES (:description, 0)";
     $stmt = $pdo->prepare($sql);
     $stmt->execute(['description' => $t_todo]);

     // Returnera det nya ID:t och framgång
     $newId = $pdo->lastInsertId();
     echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Uppgift tillagd.']);
}
