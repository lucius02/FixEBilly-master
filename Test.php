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
        $stmt = $this->pdo->query('SELECT onderwerp, rol, competentie, wat, why, how, plaatje, bronnen, niveau, studieduur, rating'
                . 'FROM sch_map.kenniskaart '
                . 'ORDER BY onderwerp');
        $kaart = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $kaart[] = [
                'onderwerp' => $row['onderwerp'],
                'rol' => $row['rol'],
                'competentie' => $row['competentie'],
                'wat' => $row['wat'],
                'why' => $row['why'],
                'how' => $row['how'],
                'plaatje' => $row['plaatje'],
                'bronnen' => $row['bronnen'],
                'niveau' => $row['niveau'],
                'studieduur' => $row['studieduur'],
                'rating' => $row['rating']
            ];
        }
        return $kaart;
    }
}

if (isset($_POST['onderwerp']) and $_POST['rol'] <> '' and $_POST['competentie'] <> '' and $_POST['wat'] <> '' and $_POST['why'] <> '' and $_POST['how'] <> '' and $_POST['plaatje'] <> '' and $_POST['bronnen'] <> '' and $_POST['niveau'] <> '' and $_POST['studieduur'] <> '' and $_POST['rating'] <> '') {

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

   $checkbox3=$_POST['competentie'];
    $onderwerp="";  
    foreach($checkbox3 as $competentie1)  
   {  
      $competentie .= $competentie1.",";  
   } 

   $name = $_FILES['file']['name'];
  $target_dir = "upload/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png","gif");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){
 
    // Convert to base64 
    $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
  }

try {
	$pdo = Connection::get()->connect();
    // 
    $sql_insert_naam = "INSERT INTO sch_map.kenniskaart(onderwerp, rol, competentie, wat, why, how, plaatje, bronnen, niveau, studieduur, rating) VALUES ('$_POST[onderwerp]', '$rol', '$competentie', '$_POST[wat]', '$_POST[why]', '$_POST[how]', '$image', '$_POST[bronnen]', '$chk', '$_POST[studieduur]', '$_POST[rating]')";
    $stmt = $pdo->query($sql_insert_naam);

 if($stmt === false){
	die("Error executing the query: $sql_get_depts");
    }
    }
catch (PDOException $e){
	echo $e->getMessage();
}
}

$sql_get_kaart = "SELECT onderwerp, rol, competentie, wat, why, how, plaatje, bronnen, niveau, studieduur, rating FROM sch_map.kenniskaart ORDER BY onderwerp;";

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
            <form action="data_Frontend.php" method="post">
                <label class="label" for="onderwerp">Onderwerp:</label>
                <textarea class="invulveld" id="onderwerp" name="onderwerp" required></textarea>
                <label class="label"for = "wat">Wat:</label>
                <textarea class="invulveld" id="wat" name="wat" required></textarea>
                <label class="label"for = "why">Why:</label>
                <textarea class="invulveld" id="why" name="why" required></textarea>
                <label class="label" for = "how">How:</label>
                <textarea class="invulveld" id="how" name="how"></textarea>
                <label class="label"for = "plaatje">Plaatje:</label>
                <input class="invulveld" type='file' name='file' id="plaatje" enctype='multipart/form-data' required></input>
                <label class="label"for = "niveau">Niveau:</label><br>
                <div class="niveau_block" required>
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
                    <input class="invulbox2" type = "checkbox" id="rol6" name = "rol[]" value="UX Designer">
                    <label class="checkbox2"for ="niveau3">UX Designer</label><br>
                </div><br>
                <label class="label"for = "competentie">Competentie:</label><br>
                <div class="ow_block" required>
                    <input class="invulbox3" type = "checkbox" id="competentie1" name="competentie[]" value="Gebruikersinteractie Analyseren">
                    <label class="checkbox3" for ="competentie1">Gebruikersinteractie Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie2" name="competentie[]" value="Gebruikersinteractie Adviseren">
                    <label class="checkbox3" for ="competentie2">Gebruikersinteractie Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie3" name="competentie[]" value="Gebruikersinteractie Ontwerpen">
                    <label class="checkbox3" for ="competentie3">Gebruikersinteractie Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie4" name="competentie[]" value="Gebruikersinteractie Realiseren">
                    <label class="checkbox3" for ="competentie4">Gebruikersinteractie Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie5" name="competentie[]" value="Gebruikersinteractie Manage & control">
                    <label class="checkbox3" for ="competentie5">Gebruikersinteractie Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie" name="competentie[]" value="Organisatieprocessen Analyseren">
                    <label class="checkbox3" for ="competentie6">Organisatieprocessen Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie7" name="competentie[]" value="Organisatieprocessen Adviseren">
                    <label class="checkbox3" for ="competentie7">Organisatieprocessen Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie8" name="competentie[]" value="Organisatieprocessen Ontwerpen">
                    <label class="checkbox3" for ="competentie8">Organisatieprocessen Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie9" name="competentie[]" value="Organisatieprocessen Realiseren">
                    <label class="checkbox3" for ="competentie9">Organisatieprocessen Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie10" name="competentie[]" value="Organisatieprocessen Manage & control">
                    <label class="checkbox3" for ="competentie10">Organisatieprocessen Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie11" name="competentie[]" value="Infrastructuur Analyseren">
                    <label class="checkbox3" for ="competentie11">Infrastructuur Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie12" name="competentie[]" value="Infrastructuur Adviseren">
                    <label class="checkbox3" for ="competentie12">Infrastructuur Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie13" name="competentie[]" value="Infrastructuur Ontwerpen">
                    <label class="checkbox3" for ="competentie13">Infrastructuur Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie14" name="competentie[]" value="Infrastructuur Realiseren">
                    <label class="checkbox3" for ="competentie14">Infrastructuur Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie15" name="competentie[]" value="Infrastructuur Manage & control">
                    <label class="checkbox3" for ="competentie15">Infrastructuur Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie16" name="competentie[]" value="Software Analyseren">
                    <label class="checkbox3" for ="competentie16">Software Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie17" name="competentie[]" value="Software Adviseren">
                    <label class="checkbox3" for ="competentie17">Software Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie18" name="competentie[]" value="Software Ontwerpen">
                    <label class="checkbox3" for ="competentie18">Software Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie19" name="competentie[]" value="Software Realiseren">
                    <label class="checkbox3" for ="competentie19">Software Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie20" name="competentie[]" value="Software Manage & control">
                    <label class="checkbox3" for ="competentie20">Software Manage & control</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie21" name="competentie[]" value="Hardware interfacing Analyseren">
                    <label class="checkbox3" for ="competentie21">Hardware interfacing Analyseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie22" name="competentie[]" value="Hardware interfacing Adviseren">
                    <label class="checkbox3" for ="competentie22">Hardware interfacing Adviseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie23" name="competentie[]" value="Hardware interfacing Ontwerpen">
                    <label class="checkbox3" for ="competentie23">Hardware interfacing Ontwerpen</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie24" name="competentie[]" value="Hardware interfacing Realiseren">
                    <label class="checkbox3" for ="competentie24">Hardware interfacing Realiseren</label><br>
                    <input class="invulbox3" type = "checkbox" id="competentie25" name="competentie[]" value="Hardware interfacing Manage & control">
                    <label class="checkbox3" for ="competentie25">Hardware interfacing Manage & control</label><br>
                </div><br>
                <label class="label"for = "bronnen">Bronnen:</label>
                <textarea class="invulveld" id="bronnen" name="bronnen" required></textarea>
                <label class="label"for = "Studieduur">Studieduur:</label>
                <textarea class="invulveld" id="Studieduur" name="Studieduur" required></textarea>
                <label class="label"for = "Rating">Rating:</label>
                <textarea class="invulveld" id="Rating" name="Rating" required></textarea>
                <input class="button2" type = "submit" name="opslaan" onclick="alert('Kenniskaart is opgeslagen')"/>
            </form>
        </div>
    </body>
</html>