<?php
include("ini/functie.inc");
class Connection {
 
    /**
     * Connection
     * @var type 
     */
    private static $conn;
 
    /**
     * Connect to the database and return an instance of \PDO object
     * @return \PDO
     * @throws \Exception
     */
    public function connect() {
 
        // read parameters in the ini configuration file
        $params = parse_ini_file('.\database_2.ini');
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }
        // connect to the postgresql database
        $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
                $params['host'], 
                $params['port'], 
                $params['database'], 
                $params['user'], 
                $params['password']);
 
        $pdo = new \PDO($conStr);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
        return $pdo;
    }
 
    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }
 
        return static::$conn;
    }

    /**
     * Return all rows in the naam table
     * @return array
     */
    public function all_naam() {
        $stmt = $this->pdo->query('SELECT kenniskaart_id, titel, datum, wat, wie, hoe, waarom, niveau, rol, onderwerp, bronnen'
                . 'FROM sch_kennis.kenniskaart '
                . 'ORDER BY kenniskaart_id');

        $kaart = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $kaart[] = [
                'kenniskaart_id' => $row['kenniskaart_id'],
                'titel' => $row['titel'],
                'datum' => $row['datum'],
                'wat' => $row['wat'],
                'auteur' => $row['auteur'],
                'hoe' => $row['hoe'],
                'waarom' => $row['waarom'],
                'niveau' => $row['niveau'],
                'rol' => $row['rol'],
                'onderwerp' => $row['onderwerp'],
                'bronnen' => $row['bronnen']
            ];
        }
        return $kaart;
    }
}

# legt een connectie neer en export data van de database
if (isset($_POST['titel']) and $_POST['kenniskaart_id'] and $_POST['datum'] and $_POST['wat'] and $_POST['auteur'] and $_POST['hoe'] and $_POST['waarom'] and $_POST['niveau'] and $_POST['rol'] and $_POST['onderwerp'] and $_POST['bronnen']) {

    $kenniskaart_id = $_POST['kenniskaart_id'];
    $titel = $_POST['titel'];
    $datum = $_POST['datum'];
    $wat = $_POST['wat'];
    $auteur = $_POST['auteur'];
    $hoe = $_POST['hoe'];
    $waarom = $_post['waarom'];
    $niveau = $_post['niveau'];
    $rol = $_post['rol'];
    $onderwerp = $_post['onderwerp'];
    $bronnen = $_post['bronnen'];
}

$sql = "SELECT kenniskaart_id, titel, datum, wat, auteur, hoe, waarom, niveau, rol, onderwerp, bronnen FROM sch_kennis.kenniskaart where kenniskaart_id = 1" ; 
$sql_result = sql_execute($sql,1) ;
foreach ($sql_result as $row) { 
    // FORMFIELDS SET
    $kenniskaart_id= $row[0];
    $titel= $row[1];
    $datum= $row[2];
    $wat= $row[3];
    $auteur= $row[4];
    $hoe= ($row[5]);
    $waarom= $row[6];
    $niveau= $row[7];
    $rol= $row[8];
    $onderwerp= $row[9];
    $bronnen= $row[10];
    }

?>