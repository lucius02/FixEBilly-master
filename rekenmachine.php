<form name="rekenmachine" action="" method="post">

    <input type="text" name="getal1" value="">
    <br>
    <select name="type">
          <option value ="plus">+</option>
          <option value ="min">-</option>
          <option value ="delen">:</option>
          <option value ="maal">x</option>
    </select>
    <br>
    <input type="text" name="getal2" value="">
    <br>
    <input type="submit" name="reken_uit" value="Reken uit">
</form>

<?php
$getal1 = $_POST["getal1"];
$getal2 = $_POST["getal2"];

if ($_POST["type"] == "plus") {
    $uitkomst = $getal1 + $getal2;
} else if ($_POST["type"] == "min") {
    $uitkomst = $getal1 - $getal2;
} else if ($_POST["type"] == "delen") {
    $uitkomst = $getal1 / $getal2;
} else if ($_POST["type"] == "maal") {
    $uitkomst = $getal1 * $getal2;
}

print ($uitkomst);
?>