<?php
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
        $params = parse_ini_file('.\ini\database_2.ini');
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
        $stmt = $this->pdo->query('SELECT titel, datum, wat, wie, hoe, waarom, niveau, rol, onderwerp, bronnen'
                . 'FROM sch_kennis.kenniskaart '
                . 'ORDER BY titel');
        $kaart = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $kaart[] = [
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

if (isset($_POST['titel']) and $_POST['datum'] <> '' and $_POST['wat'] <> '' and $_POST['auteur'] <> '' and $_POST['hoe'] <> '' and $_POST['waarom'] <> '' and $_POST['niveau'] <> '' and $_POST['rol'] <> '' and $_POST['onderwerp'] <> '' and $_POST['bronnen'] <> '') {

    $checkbox1=$_POST['niveau'];
    $chk="";  
    foreach($checkbox1 as $chk1)  
   {  
      $chk .= $chk1."";  
   } 

   $checkbox2=$_POST['rol'];
    $rol="";  
    foreach($checkbox2 as $rol1)  
   {  
      $rol .= $rol1.",";  
   } 

   $checkbox3=$_POST['onderwerp'];
    $onderwerp="";  
    foreach($checkbox3 as $onderwerp1)  
   {  
      $onderwerp .= $onderwerp1.",";  
   } 

try {
	$pdo = Connection::get()->connect();
    // 
    $sql_insert_naam = "INSERT INTO sch_kennis.kenniskaart(titel, datum, wat, auteur, hoe, waarom, niveau, rol, onderwerp, bronnen) VALUES ('$_POST[titel]', '$_POST[datum]', '$_POST[wat]', '$_POST[auteur]', '$_POST[hoe]', '$_POST[waarom]', '$chk', '$rol', '$onderwerp', '$_POST[bronnen]')";
    
    echo $sql_insert_naam;
    
    $stmt = $pdo->query($sql_insert_naam);



 if($stmt === false){
	die("Error executing the query: $sql_get_depts");
    }
    }
catch (PDOException $e){
	echo $e->getMessage();
}
}

$sql_get_kaart = "SELECT titel, datum, wat, auteur, hoe, waarom, niveau, rol, onderwerp, bronnen FROM sch_kennis.kenniskaart ORDER BY titel;";

try {
	$pdo = Connection::get()->connect();
    #echo 'A connection to the PostgreSQL database sever has been established successfully.';
    // 
 $stmt = $pdo->query($sql_get_kaart);
 
 if($stmt === false){
	die("Error executing the query: $sql_get_depts");
 }
 
}catch (PDOException $e){
	echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Billy</title>
        <link href="styles.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    </head>
    <body>
        <h1 class="title1">Kenniskaart Aanmaken</h1><br>
        <div class="template_blok">
            <form action="test2.php" method="post">
                <label class="label" for="titel">Titel:</label>
                <textarea class="invulveld" id="titel" name="titel" required></textarea>
                <label class="label" for="datum">Datum:</label>
                <input class="invulveld" id="datum" type="date" name="datum" required></input>
                <label class="label"for = "wat">Wat:</label>
                <textarea class="invulveld" id="wat" name="wat" required></textarea>
                <label class="label"for = "auteur">Auteur:</label>
                <textarea class="invulveld" id="auteur" name="auteur" required></textarea>
                <label class="label" for = "hoe">Hoe:</label>
                <textarea class="invulveld" id="hoe" name="hoe" required></textarea>
                <label class="label"for = "waarom">Waarom:</label>
                <textarea class="invulveld" id="waarom" name="waarom" required></textarea>
                <label class="label"for = "niveau">Niveau:</label><br>
                <div class="check_block" required>
                    <input class="invulbox" type = "checkbox" id="niveau1" name = "niveau[]" value="beginner">
                    <label class="checkbox"for ="niveau1">Beginner</label><br>
                    <input class="invulbox" type = "checkbox" id="niveau2" name = "niveau[]" value="Gevorderde">
                    <label class="checkbox"for ="niveau2">Gevorderde</label><br>
                    <input class="invulbox" type = "checkbox" id="niveau3" name = "niveau[]" value="Expert">
                    <label class="checkbox"for ="niveau3">Expert</label><br>
                    <script type="text/javascript">
                        $('.invulbox').on('change', function() {
                            $('.invulbox').not(this).prop('checked', false);  
                        });
                    </script>
                </div><br>
                <label class="label"for = "rol">Rol:</label><br>
                <div class="check_block" required>
                    <input class="invulbox2" type = "checkbox" id="rol1" name = "rol[]" value="FE">
                    <label class="checkbox2"for ="niveau1">FE</label><br>
                    <input class="invulbox2" type = "checkbox" id="rol2" name = "rol[]" value="BE">
                    <label class="checkbox2"for ="niveau2">BE</label><br>
                    <input class="invulbox2" type = "checkbox" id="rol3" name = "rol[]" value="AI">
                    <label class="checkbox2"for ="niveau3">AI</label><br>
                    <input class="invulbox2" type = "checkbox" id="rol4" name = "rol[]" value="PO">
                    <label class="checkbox2"for ="niveau1">PO</label><br>
                    <input class="invulbox2" type = "checkbox" id="rol5" name = "rol[]" value="CSC">
                    <label class="checkbox2"for ="niveau2">CSC</label><br>
                </div><br>
                <label class="label"for = "onderwerp">Onderwerp:</label><br>
                <div class="ow_block" required>
                    <input class="invulbox3" type = "checkbox" id="onderwerp1" name="onderwerp[]" value="Gebruikersinteractie Analyseren">
                    <label class="checkbox3" for ="onderwerp1">Gebruikersinteractie Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp2" name="onderwerp[]" value="Gebruikersinteractie Adviseren">
                    <label class="checkbox3" for ="onderwerp2">Gebruikersinteractie Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp3" name="onderwerp[]" value="Gebruikersinteractie Ontwerpen">
                    <label class="checkbox3" for ="onderwerp3">Gebruikersinteractie Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp4" name="onderwerp[]" value="Gebruikersinteractie Realiseren">
                    <label class="checkbox3" for ="onderwerp4">Gebruikersinteractie Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp5" name="onderwerp[]" value="Gebruikersinteractie Manage & control">
                    <label class="checkbox3" for ="onderwerp5">Gebruikersinteractie Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp6" name="onderwerp[]" value="Organisatieprocessen Analyseren">
                    <label class="checkbox3" for ="onderwerp6">Organisatieprocessen Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp7" name="onderwerp[]" value="Organisatieprocessen Adviseren">
                    <label class="checkbox3" for ="onderwerp7">Organisatieprocessen Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp8" name="onderwerp[]" value="Organisatieprocessen Ontwerpen">
                    <label class="checkbox3" for ="onderwerp8">Organisatieprocessen Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp9" name="onderwerp[]" value="Organisatieprocessen Realiseren">
                    <label class="checkbox3" for ="onderwerp9">Organisatieprocessen Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp10" name="onderwerp[]" value="Organisatieprocessen Manage & control">
                    <label class="checkbox3" for ="onderwerp10">Organisatieprocessen Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp11" name="onderwerp[]" value="Infrastructuur Analyseren">
                    <label class="checkbox3" for ="onderwerp11">Infrastructuur Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp12" name="onderwerp[]" value="Infrastructuur Adviseren">
                    <label class="checkbox3" for ="onderwerp12">Infrastructuur Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp13" name="onderwerp[]" value="Infrastructuur Ontwerpen">
                    <label class="checkbox3" for ="onderwerp13">Infrastructuur Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp14" name="onderwerp[]" value="Infrastructuur Realiseren">
                    <label class="checkbox3" for ="onderwerp14">Infrastructuur Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp15" name="onderwerp[]" value="Infrastructuur Manage & control">
                    <label class="checkbox3" for ="onderwerp15">Infrastructuur Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp16" name="onderwerp[]" value="Software Analyseren">
                    <label class="checkbox3" for ="onderwerp16">Software Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp17" name="onderwerp[]" value="Software Adviseren">
                    <label class="checkbox3" for ="onderwerp17">Software Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp18" name="onderwerp[]" value="Software Ontwerpen">
                    <label class="checkbox3" for ="onderwerp18">Software Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp19" name="onderwerp[]" value="Software Realiseren">
                    <label class="checkbox3" for ="onderwerp19">Software Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp20" name="onderwerp[]" value="Software Manage & control">
                    <label class="checkbox3" for ="onderwerp20">Software Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp21" name="onderwerp[]" value="Hardware interfacing Analyseren">
                    <label class="checkbox3" for ="onderwerp21">Hardware interfacing Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp22" name="onderwerp[]" value="Hardware interfacing Adviseren">
                    <label class="checkbox3" for ="onderwerp22">Hardware interfacing Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp23" name="onderwerp[]" value="Hardware interfacing Ontwerpen">
                    <label class="checkbox3" for ="onderwerp23">Hardware interfacing Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp24" name="onderwerp[]" value="Hardware interfacing Realiseren">
                    <label class="checkbox3" for ="onderwerp24">Hardware interfacing Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="onderwerp25" name="onderwerp[]" value="Hardware interfacing Manage & control">
                    <label class="checkbox3" for ="onderwerp25">Hardware interfacing Manage & control</label><br>
                </div><br>
                <label class="label"for = "bronnen">Bronnen:</label>
                <textarea class="invulveld" id="bronnen" name="bronnen" required></textarea>
                <input class="button2" type = "submit" name="opslaan" onclick="alert('Kenniskaart is opgeslagen')"/>
            </form>
        </div>
    </body>
</html>