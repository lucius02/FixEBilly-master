<!DOCTYPE html>
<?php
session_start(); 

//************************** Include scripts ********************************* 
include("inc/functie.inc");
include("inc/syssettings.inc");

if ($_SESSION['user_name'] <> "service" AND $_SESSION['user_name'] <> "catpoint" )
{
		redirect ("./login.php");
		echo "redirect naar login.php";
}

$this_url   = "leden.php";

if ( $_SESSION[$this_url.'_id']=='' OR isset($_POST['Search']) ) {$_SESSION[$this_url.'_pagno']=1;$id='';$_SESSION[$this_url.'_id']='';}
if (isset($_GET['id'])=='' ) {if ($_SESSION[$this_url.'_id']<>'') {$id=$_SESSION[$this_url.'_id'];} } else {$id = $_GET['id'];	}
if (substr($id,0,3)=='pag' and isset($_POST['Search'])== FALSE ) {$id='';$_SESSION[$this_url.'_pagno']=substr($_GET['id'],3);} 
$pagno=$_SESSION[$this_url.'_pagno'];
$rec_van=($pagno-1)*10;
if ($id==0) {$DISABLED='';} else {$DISABLED='DISABLED';}

//****************************************************************************
//************************** Search for records ******************************
//****************************************************************************
if(isset($_POST['Search']))
{
  //Deze variabelen mogelijk via een user_search-tabel waar alle laatste argumenten worden bewaard
  //Handig voor als je er weer opnieuw inkomt, dan weet ie nog waar je mee bezig was!
	$search_adres = $_POST['search_adres'];
	$_SESSION['search_adres'] = "$search_adres"; 
}
else
{
	$search_adres = $_SESSION['search_adres'];
}

include("inc/style_standard.inc");

?>

<html>
<head>
<title> Ledenlijst </title>
<link rel="stylesheet" type="text/css">
</head>
<body>
<A NAME="Top"></A>
<form id="form1" name="form1" method="post" action="">
  <table style='width:100%' border="0" cellspacing="0" cellpadding="0">
  	<tr style="background-image: url(images/menubalkdik.gif)">
  	<th style='width:10%'></th>
  	<th style='width:30%'></th>
  	<th style='width:50%;font-size:150%'>Ledenlijst</th>
  	<th style='width:10%'></th>
  	</tr>
    <tr>
      <td><BR></td>
    </tr>
    <tr>
      <td></td>
      <td>Zoek: </td>
      <td><input type="text" name="search_adres" value ="<?php echo $search_adres ?>" size="40"></td>
    </tr>
    <tr>
      <td><BR></td>
    </tr>
    <tr style="background-image: url(images/menubalkdik.gif)"> 
      <td></td>
      <td></td>
      <td>
  	    <input name="Search" type="submit" id="Search" value="<?php echo $SYS_SEARCH_BUTTON_TEXT ?>">
      </td>
      <td></td>
    </tr>
  </table>
<?php

if ($search_adres=='') {$search_adres='Nu mag je geen results teruggeven!!!';}

$reccount=$_SESSION[$this_url.'_reccount'];
if($reccount=='' OR isset($_POST['Search']))
{
	$sql = "SELECT count(*) as reccount
					FROM adres 
					WHERE (voornaam Like '%$search_adres%' 
					or achternaam Like '%$search_adres%' 
					or familie Like '%$search_adres%' 
					or tel1 Like '%$search_adres%' 
					or email Like '%$search_adres%' 
					or plaats Like '%$search_adres%' 
					or ligplaats Like '%$search_adres%' 
					or boot Like '%$search_adres%' 
					or factuurnr Like '%$search_adres%' 
					or '$search_adres'='*' )";
	$sql_result = sql_execute($sql,1) ;
	foreach ($sql_result as $row) { $reccount= $row[0]; }

	$_SESSION[$this_url.'_reccount']=$reccount;
	$id=$_SESSION[$this_url.'_id'];

}


$sql = "SELECT adres_id,voornaam,achternaam,familie,mob,email,boot 
					FROM adres 
					WHERE (voornaam Like '%$search_adres%' 
					or achternaam Like '%$search_adres%' 
					or familie Like '%$search_adres%' 
					or tel1 Like '%$search_adres%' 
					or email Like '%$search_adres%' 
					or plaats Like '%$search_adres%' 
					or ligplaats Like '%$search_adres%' 
					or boot Like '%$search_adres%' 
					or factuurnr Like '%$search_adres%' 
					or '$search_adres'='*' )
					ORDER BY achternaam,voornaam  
					LIMIT $rec_van,10"; 
$sql_result = sql_execute($sql,1) ;

$returntable='<table width="100%" border="0" cellspacing="0" cellpadding="0">'.
'<tr style="background-image: url(images/menubalkdik.gif)">' .
'<td width="16%">Voornaam</td>'.
'<td width="22%">Achternaam</td>'. 
'<td width="32%">Familie</td>'.
'<td width="15%">mobiel</td>'.
'<td width="15%">email</td>'.
'<td width="15%">boot</td>'.
'</tr>';

foreach ($sql_result as $row) 
{
	$array_recpoint[] = $row['adres_id'];
	if ($id=='') {$id=$row['adres_id'];}
 	if ($row['adres_id']==$id)
      	{$TR= "<tr style='background-color: RGB(200,200,200)'>"; }
     else
      	{$TR= "<tr>"; }

	$returntable=$returntable.$TR.'<td><a href="'.$this_url.'?id='.$row["adres_id"].'">'.escape($row["voornaam"]).
	'</a></td><td><a href="'.$this_url.'?id='.$row["adres_id"].'">'.escape($row["achternaam"]).
	'</a></td><td><a href="'.$this_url.'?id='.$row["adres_id"].'">'.escape($row["familie"]).
	'</a></td><td><a href="'.$this_url.'?id='.$row["adres_id"].'">'.escape($row["mob"]).
	'</a></td><td><a href="'.$this_url.'?id='.$row["adres_id"].'">'.escape($row["email"]).
	'</a></td><td><a href="'.$this_url.'?id='.$row["adres_id"].'">'.escape($row["boot"]).
	'</a><BR></td></tr>';
}
$returntable=$returntable.'</table>';
echo $returntable;

//***************************************************************************************************
// Let op. Hier zitten ook de zogenaamde edit-buttons in zonder verwijderen
// Er zit ook een niet zo mooie "</Table>" in, maar hopen dat dat niet in de weg zit in de toekomst
//***************************************************************************************************

//************************** tot 10 lege regels uitvullen naar beneden ********************
if ($reccount>0) 
	{
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">'; 
		$last_pos = count($array_recpoint);
		for ($rowcounter = $last_pos; $rowcounter < 5; $rowcounter++) 
		{
			echo '<tr><td><BR></td></tr>';
		}
		echo "</table>"; 
	}    

//************************** go to previous record ******************************
if(isset($_POST['Up']))
	{
		$current_pos = array_search($id, $array_recpoint);
		if ($current_pos>0)
			{$id=$array_recpoint[$current_pos-1];}
		redirect ("$this_url?id=$id");
	}

//************************** go to next record ******************************
if(isset($_POST['Down']))
	{
		$current_pos = array_search($id, $array_recpoint);
		if ($current_pos<count($array_recpoint)-1)
			{$id=$array_recpoint[($current_pos+1)];}
		redirect ("$this_url?id=$id");
	}
if ($reccount>0) 
	{ 

?> 
  <table style='width:100%' border="0" cellspacing="0" cellpadding="0">
  	<tr style="background-image: url(images/menubalkdik.gif)">
  	<th style='width:10%'>	<A NAME="Bottom"></A><STRONG><A HREF="#Bottom">Omlaag</A><STRONG></th>
  	<th style='width:80%'><CENTER>
  		<input name="Up" type="submit" id="Up" value="<?php echo $SYS_UP_BUTTON_TEXT ?>">
  		<input name="Down" type="submit" id="Down" value="<?php echo $SYS_DOWN_BUTTON_TEXT ?>">
<?php
		if ($reccount>10) 
		{
		echo 'Pag.';
		for ($pagcounter = 1; $pagcounter <= (int)($reccount/10)+1; $pagcounter++) 
			{
			echo '&nbsp';
			if ($pagno==$pagcounter)
				{echo '<STRONG><a style="text-decoration: underline" href="'.$this_url.'?id=pag'.$pagcounter.'" >'.$pagcounter.'</a></STRONG>';}
			else
				{echo '<SMALL><a href="'.$this_url.'?id=pag'.$pagcounter.'" >'.$pagcounter.'</a></SMALL>';}
			}
		}
?>
<?php
		if ($_SESSION['user_name'] == "service" )
		{
			If ($id>0 or $id==''){$DISABLED='DISABLED';}Else{$DISABLED='';}
			If(isset($_POST['Edit'])){$DISABLED='';}
			if($DISABLED=='DISABLED')
			{
				echo '<input name="Edit" type="submit" id="Edit" value="'.$SYS_EDIT_BUTTON_TEXT.'">';
				echo '<input name="New" type="submit" id="New" value="'.$SYS_NEW_BUTTON_TEXT.'">';
			}
			Else
			{
				echo '<input name="Save" type="submit" id="Save" value="'.$SYS_SAVE_BUTTON_TEXT.'">';
				echo '<input name="Cancel" type="submit" id="Cancel" value="'.$SYS_CANCEL_BUTTON_TEXT.'">';
			}
		}

?>
  		</CENTER>
  	</th>
  	<th style='width:10%'></th>
  	</tr>
  </table>

  <?php
}
$_SESSION[$this_url.'_id']=$id;
////
//******************************************************************************************************
//******************************************************************************************************
//*************** Hier verder met de detail informatie tbv bewerken gegevens ***************************
//******************************************************************************************************
//******************************************************************************************************

If(isset($_POST['Upload-Uitslagen-f18'])) {redirect ("uploaduitslagenf18.php");}
If(isset($_POST['Upload-Uitslagen'])) {redirect ("uploaduitslagen.php");}
// geen idee waarom deze roundtrip gemaakt moet worden. Het zal aan de redirect-functie liggen......
//If(isset($_POST['Exportleden'])) {echo '<br><br><br><center><B><a href="exportleden.php">Druk hier voor de export.</a></B></center><br><br><br>';}
If(isset($_POST['Exportleden'])) {redirect ("exportleden.php");}
If(isset($_POST['Factuur'])) {redirect ("e-mailing_factuur.php");}
If(isset($_POST['Importknwv'])) {redirect ("importknwv.php");}
If(isset($_POST['Exportknwv'])) {redirect ("exportknwv.php");}
If(isset($_POST['CMS'])) {redirect ("cms.php");}
If(isset($_POST['Actiecode'])) 
{
	//Mutatiestatus veranderen.		
	$sql = "Update adres set actiecode='' where actiecode<>'' ";
	$sql_result = sql_execute($sql,0) ;

//!	mysql_query($query) or die('Actiecode bijwerken gaat fout');
}
// Even de variabelen zetten
$adres_id=$id;
If(isset($_POST['Cancel']) or isset($_POST['Search']) or $id=='') {$DISABLED='DISABLED';}
If(isset($_POST['New'])){redirect("$this_url?id=0");}
If(isset($_POST['Edit'])){$DISABLED='';}
If(isset($_POST['Save']))
{

// FORMFIELDS GET
	$adres_id=$_POST['adres_id'];
	$voornaam= $_POST['voornaam'];       
	$geslacht=strtoupper($_POST['geslacht']);
	$voorletter=putstr($_POST['voorletter']);
	$tussenvoegsel=putstr($_POST['tussenvoegsel']);
	$achternaam= $_POST['achternaam'];       
	$familie= $_POST['familie'];       
	$adres= putstr($_POST['adres']);       
	$huisnr=$_POST['huisnr'];
	$huisnrt=$_POST['huisnrt'];
	$postcode= $_POST['postcode'];       
	$plaats= $_POST['plaats'];       
	$landcode=strtoupper($_POST['landcode']);
	$tel1= $_POST['tel1'];       
	$tel2= $_POST['tel2'];       
	$tel3= $_POST['tel3'];       
	$mob= $_POST['mob'];       
	$email= $_POST['email'];
	$ligplaats= $_POST['ligplaats'];     
	$boot= $_POST['boot'];
	$zeilnr=strtoupper($_POST['zeilnr']);
	$bank= $_POST['bank'];
	$verzekering= $_POST['verzekering'];
	$polisnr= $_POST['polisnr'];
	$ingeschreven= $_POST['ingeschreven'];
	$uitgeschreven= $_POST['uitgeschreven'];
	$knwv = $_POST['knwv'];
	$knwvlidnr = $_POST['knwvlidnr'];
	$factuurdatum = $_POST['factuurdatum'];
	$factuurnr= $_POST['factuurnr'];
	$factuuromschrijving= $_POST['factuuromschrijving'];
	$factuurbedrag= $_POST['factuurbedrag'];
	$liggeld= $_POST['liggeld'];
	$lidgeld= $_POST['lidgeld'];
	$contributie= $_POST['contributie'];
	$opmerking= $_POST['opmerking'];
	$geboortedd= $_POST['geboortedd'];
	$actiecode = strtoupper($_POST['actiecode']);
	$soortlid = strtoupper($_POST['soortlid']);
	$status = strtoupper($_POST['status']);
	$betaald = ($_POST['betaald'])?1:0;
	$uitstel = ($_POST['uitstel'])?1:0;
	$categorie = strtoupper($_POST['categorie']);
	$jeugdzeilen = ($_POST['jeugdzeilen'])?1:0;
	$wedstrijdzeilen = ($_POST['wedstrijdzeilen'])?1:0;
 
	if ($landcode=='NED' or $landcode== '') {$land='';}
	if ($landcode=='BEL') {$land='Belgie'; }
	if ($landcode=='GER') {$land='Germany';}
	if ($landcode=='GBR') {$land='Great Brittain';}
	if ($landcode=='FR' ) {$land='France'; }

	if($id>0)
	{
// UPDATE-SQL
	$sql = "UPDATE adres SET 
						voornaam = '$voornaam',
						geslacht = '$geslacht',
						voorletter = '$voorletter',
						tussenvoegsel ='$tussenvoegsel',
						achternaam = '$achternaam',
						familie = '$familie',
						adres = '$adres',
						huisnr = '$huisnr',
						huisnrt = '$huisnrt',
						postcode = '$postcode',
						plaats = '$plaats',
						landcode = '$landcode',
						land = '$land',
						tel1 = '$tel1',
						tel2 = '$tel2',
						tel3 = '$tel3',
						mob = '$mob',
						email = '$email',
						ligplaats = '$ligplaats',
						boot = '$boot',
						zeilnr = '$zeilnr',
						bank = '$bank',
						verzekering = '$verzekering',
						polisnr = '$polisnr',
						ingeschreven = '$ingeschreven',
						uitgeschreven= '$uitgeschreven',
						knwv = '$knwv',
						knwvlidnr = '$knwvlidnr',
						factuurdatum = '$factuurdatum',
						factuurnr = '$factuurnr',
						factuuromschrijving = '$factuuromschrijving',
						factuurbedrag = '$factuurbedrag',
						liggeld = '$liggeld',
						lidgeld = '$lidgeld',
						contributie = '$contributie',
						opmerking = '$opmerking',
						geboortedd = '$geboortedd',
						actiecode = '$actiecode',
						soortlid = '$soortlid',
						categorie = '$categorie',
						status = '$status',
						betaald = '$betaald',
						uitstel = '$uitstel',
						jeugdzeilen = '$jeugdzeilen',
						wedstrijdzeilen = '$wedstrijdzeilen' 
					where adres_id='$id'";
	$sql_result = sql_execute($sql,0) ;
//!	mysql_query($query) or die('Update gaat fout'); 
	}
	Else
	{
// INSERT-SQL
	$sql = "INSERT into adres ( voornaam,geslacht,voorletter,tussenvoegsel,achternaam,familie,adres,huisnr,huisnrt,postcode,plaats,landcode,land,
						tel1,tel2,tel3,mob,email,ligplaats,boot,zeilnr,bank,verzekering,polisnr,ingeschreven,uitgeschreven ,knwv ,knwvlidnr, factuurdatum,factuurnr ,factuuromschrijving ,factuurbedrag ,liggeld ,lidgeld ,contributie ,opmerking,geboortedd,actiecode,soortlid,status,betaald,uitstel,categorie,jeugdzeilen,wedstrijdzeilen  ) 
						VALUES ('$voornaam','$geslacht','$voorletter','$tussenvoegsel','$achternaam','$familie','$adres','$huisnr','$huisnrt','$postcode','$plaats','$landcode','$land',
						'$tel1','$tel2','$tel3','$mob','$email','$ligplaats','$boot','$zeilnr','$bank','$verzekering','$polisnr','$ingeschreven','$uitgeschreven','$knwv','$knwvlidnr','$factuurdatum','$factuurnr','$factuuromschrijving','$factuurbedrag','$liggeld','$lidgeld','$contributie','$opmerking','$geboortedd','$actiecode','$soortlid','$status','$betaald','$uitstel','$categorie','$jeugdzeilen','$wedstrijdzeilen' ) ";
	$new_id = sql_execute($sql,0) ;

	//!	mysql_query($query) or die('Insert gaat fout'); 

//	$new_id = mysql_insert_id();

	redirect ("$this_url?id=$new_id");
	}
}

If(isset($_POST['Delete']))
{
// DELETE-SQL
	// waarborg data-integriteit
	if ($id>0)
	{
		$deleterecord=1;
		if ($deleterecord>0)
		{
		// We gaan nu echt deleten!
		$sql = "DELETE from adres where adres_id='$id'";
		$sql_result = sql_execute($sql,0) ;
//!		mysql_query($query) or die('Delete gaat fout'); 
		$_SESSION[$this_url.'_id']='';
		redirect($this_url);
		}
	}
}

// SELECT-SQL
$sql = "SELECT adres_id,voornaam,achternaam,familie,adres,postcode,plaats,land,tel1,tel2,tel3,mob,email,ligplaats,boot,bank,
					verzekering,polisnr,ingeschreven,uitgeschreven ,knwv,factuurnr ,factuuromschrijving ,factuurbedrag ,liggeld ,lidgeld ,contributie, 
					opmerking, geboortedd,geslacht,voorletter,tussenvoegsel,landcode,knwvlidnr,soortlid,actiecode,zeilnr,huisnr,huisnrt,status,betaald,uitstel,factuurdatum,categorie,jeugdzeilen,wedstrijdzeilen 
					FROM adres WHERE adres_id = '$id'" ; 
$sql_result = sql_execute($sql,1) ;
foreach ($sql_result as $row) { 
//!$sql_result = mysql_query($query) or die(mysql_error($query)); 
//!$row = mysql_fetch_row($sql_result); 
// FORMFIELDS SET
$adres_id= $row[0];
$voornaam= $row[1];
$achternaam= $row[2];
$familie= $row[3];
$adres= getstr($row[4]);
$postcode= $row[5];
$plaats= $row[6];
$land= $row[7];
$tel1= $row[8];
$tel2= $row[9];
$tel3= $row[10];
$mob= $row[11];
$email= $row[12];
$ligplaats= $row[13];
$boot= $row[14];
$bank= $row[15];
$verzekering= $row[16];
$polisnr= $row[17];
$ingeschreven= $row[18];
$uitgeschreven= $row[19];
$knwv= $row[20];
$factuurnr= $row[21];
$factuuromschrijving= $row[22];
$factuurbedrag= $row[23];
$liggeld= $row[24];
$lidgeld= $row[25];
$contributie = $row[26];
$opmerking= $row[27];
$geboortedd = $row[28];
$geslacht = $row[29];
$voorletter = getstr($row[30]);
$tussenvoegsel =getstr($row[31]);
$landcode = $row[32];
$knwvlidnr = $row[33];
$soortlid = $row[34];
$actiecode = $row[35];
$zeilnr = $row[36];
$huisnr = $row[37];
$huisnrt = $row[38];
$status = $row[39];
$betaald = $row[40];
$uitstel = $row[41];
$factuurdatum = $row[42];
$categorie = $row[43];
$jeugdzeilen = $row[44];
$wedstrijdzeilen = $row[45];
}

// DROPDOWN set defaults or old values
//if ($rel_sex_id>0) {$old_sex_id = $rel_sex_id;} Else {$old_sex_id = 1;}
?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php
			if ($_SESSION['user_name'] == "service" )
			{
echo '    <tr style="background-image: url(images/menubalkdik.gif)"> ';
echo '    	<td width="3%"></td>';
echo '      <td></td><td>';
				If ($id>0 or $id==''){$DISABLED='DISABLED';}Else{$DISABLED='';}
				If(isset($_POST['Edit'])){$DISABLED='';}
				if($DISABLED=='DISABLED')
				{
				echo '<input name="Exportleden" type="submit" id="Exportleden" value="Export Ledenlijst">';
				echo '<input name="Factuur" type="submit" id="Factuur" value="Factuur">';
				echo '<input name="Importknwv" type="submit" id="Importknwv" value="Import Knwv">';
				echo '<input name="Exportknwv" type="submit" id="Exportknwv" value="Export Knwv">';
				echo '<input name="Actiecode" type="submit" id="Actiecode" value="Actiecode leegmaken">';
				echo '<input name="CMS" type="submit" id="CMS" value="CMS">';
				echo '<BR><input name="Upload-Uitslagen-f18" type="submit" id="Upload-Uitslagen-f18" value="Upload Diverse Uitslagen">';
				echo '<input name="Upload-Uitslagen" type="submit" id="Upload-Uitslagen" value="Upload Club Uitslagen">';				
	    	}
	    	Else
	    	{
//				echo '<input name="Exportleden" type="submit" id="Exportleden" value="Export Ledenlijst" DISABLED>';
//				echo '<input name="Factuur" type="submit" id="Factuur" value="Factuur" DISABLED >';
    		}
echo '    	</td>';
echo '    </tr>';

			}
			?>
    <tr> 
    	<td width="3%"></td>
      <td></td>
    	<td><BR></td>
    </tr>
    <tr> 
    	<td width="3%"></td>
      <td>Id.</td>
      <td><input type="text" name="adres_id" value ="<?php echo $adres_id ?>" size="10" DISABLED/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Voornaam</td>
      <td><input type="text" name="voornaam" value ="<?php echo $voornaam ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
		<tr>
			<td></td>
			<td>Geslacht (M/V)</td>
			<td><input type="text" name="geslacht" value ="<?php echo $geslacht; ?>" size="1" <?php echo $DISABLED ?> ></td>
		</tr>
		<tr>
			<td></td>
			<td>Voorletters</td>
			<td><input type="text" name="voorletter" value ="<?php echo $voorletter; ?>" size="5" <?php echo $DISABLED ?> ></td>
		</tr>
		<tr>
			<td></td>
			<td>Tussenvoegsel (van der)</td>
			<td><input type="text" name="tussenvoegsel" value ="<?php echo $tussenvoegsel; ?>" size="10" <?php echo $DISABLED ?> >*</td>
		</tr>
    <tr> 
    	<td></td>
      <td>Achternaam</td>
      <td><input type="text" name="achternaam" value ="<?php echo $achternaam ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Familie</td>
      <td><input type="text" name="familie" value ="<?php echo $familie ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Adres</td>
      <td><input type="text" name="adres" value ="<?php echo $adres ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
		<tr>
			<td></td>
			<td>Huisnr.</td>
			<td><input type="text" name="huisnr" value ="<?php echo $huisnr; ?>" size="5" <?php echo $DISABLED ?> ></td>
		</tr>
		<tr>
			<td></td>
			<td>Huisnr. toevoeging (A,bis,C 1ste verd.)</td>
			<td><input type="text" name="huisnrt" value ="<?php echo $huisnrt; ?>" size="10" <?php echo $DISABLED ?> >*</td>
		</tr>
    <tr> 
    	<td></td>
      <td>Postcode</td>
      <td><input type="text" name="postcode" value ="<?php echo $postcode ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Plaats</td>
      <td><input type="text" name="plaats" value ="<?php echo $plaats ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
		<tr>
			<td></td>
			<td>Landcode (NED/BEL/GER/GBR)</td>
			<td>
				<input type="text" name="landcode" value ="<?php echo $landcode; ?>" size="5" <?php echo $DISABLED ?> >
				<input type="text" name="land" value ="<?php echo $land; ?>" size="15" DISABLED >
			</td>
		</tr>
    <tr> 
    	<td></td>
      <td>Geboortedatum</td>
      <td><input type="text" name="geboortedd" value ="<?php echo $geboortedd ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Telefoon</td>
      <td><input type="text" name="tel1" value ="<?php echo $tel1 ?>" size="30" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Tel2</td>
      <td><input type="text" name="tel2" value ="<?php echo $tel2 ?>" size="30" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Tel3</td>
      <td><input type="text" name="tel3" value ="<?php echo $tel3 ?>" size="30" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Mobiel</td>
      <td><input type="text" name="mob" value ="<?php echo $mob ?>" size="30" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Email</td>
      <td><input type="text" name="email" value ="<?php echo $email ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Ligplaats</td>
      <td><input type="text" name="ligplaats" value ="<?php echo $ligplaats ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Boot</td>
      <td><input type="text" name="boot" value ="<?php echo $boot ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
		<tr>
			<td></td>
			<td>Zeilnr.</td>
			<td><input type="text" name="zeilnr" value ="<?php echo $zeilnr; ?>" size="10" <?php echo $DISABLED ?> ></td>
		</tr>
<?php
			if ($_SESSION['user_name'] == "service" )
			{
?>
    <tr> 
    	<td></td>
      <td>Bank</td>
      <td><input type="text" name="bank" value ="<?php echo $bank ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Verzekering</td>
      <td><input type="text" name="verzekering" value ="<?php echo $verzekering ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Polisnr</td>
      <td><input type="text" name="polisnr" value ="<?php echo $polisnr ?>" size="60" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Email Jeugdzeilen</td>
      <td><input type="checkbox" name="jeugdzeilen" value =1 <?php if($jeugdzeilen==1) {echo 'checked="yes"';} ?> <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Email Wedstrijdzeilen</td>
      <td><input type="checkbox" name="wedstrijdzeilen" value =1 <?php if($wedstrijdzeilen==1) {echo 'checked="yes"';} ?> <?php echo $DISABLED ?>/></td>
    </tr>
		<tr>
			<td></td>
			<td>Soortlid Catpoint (BOL)</td>
			<td><input type="text" name="soortlid" value ="<?php echo $soortlid ?>" size="1" <?php echo $DISABLED ?> >(B=Buitenlid,O=Ondersteunend,L=Ligplaats)</td>
		</tr>
		<tr>
			<td></td>
			<td>Status lidmaatschap Catpoint </td>
			<td><input type="text" name="status" value ="<?php echo $status ?>" size="10" <?php echo $DISABLED ?> >(STOPPED)</td>
		</tr>
    <tr> 
    	<td></td>
      <td>Ingeschreven</td>
      <td><input type="text" name="ingeschreven" value ="<?php echo $ingeschreven ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Uitgeschreven</td>
      <td><input type="text" name="uitgeschreven" value ="<?php echo $uitgeschreven ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>KNWV (<B>S</B>enior/<B>J</B>unior)</td>
      <td><input type="text" name="knwv" value ="<?php echo $knwv ?>" size="1" <?php echo $DISABLED ?>/></td>
    </tr>
		<tr>
			<td></td>
			<td>Watersportverbond lidmaatschaps-nr.</td>
			<td><input type="text" name="knwvlidnr" value ="<?php echo $knwvlidnr ?>" size="10" <?php echo $DISABLED ?> ></td>
		</tr>
		<tr>
			<td></td>
			<td>Watersportverbond actiecode (T/V/M/D)</td>
			<td><input type="text" name="actiecode" value ="<?php echo $actiecode ?>" size="10" <?php echo $DISABLED ?> ></td>
		</tr>
		<tr>
			<td></td>
			<td>Watersportverbond categorie (Z/S)</td>
			<td><input type="text" name="categorie" value ="<?php echo $categorie ?>" size="10" <?php echo $DISABLED ?> ></td>
		</tr>
    <tr> 
    	<td></td>
      <td>Factuur-datum</td>
      <td><input type="text" name="factuurdatum" value ="<?php echo $factuurdatum ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Factuur-nr. (bijvoorbeeld 2009-Z12)</td>
      <td><input type="text" name="factuurnr" value ="<?php echo $factuurnr ?>" size="20" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Factuur-omschrijving (Bijv. Inschrijfgelden)</td>
      <td><TEXTAREA name="factuuromschrijving" cols="50" rows="5" WRAP="soft" <?php echo $DISABLED ?> ><?php echo $factuuromschrijving ?></TEXTAREA></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Factuurbedrag (afwijkend van normaal)</td>
      <td><input type="text" name="factuurbedrag" value ="<?php echo $factuurbedrag ?>" size="20" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Liggeld (normaal 160)</td>
      <td><input type="text" name="liggeld" value ="<?php echo $liggeld ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Lidmaatschap (normaal 2x30=60)</td>
      <td><input type="text" name="lidgeld" value ="<?php echo $lidgeld ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Contributie (normaal 260, maar dan liggeld en lidmaatschap leeg laten)</td>
      <td><input type="text" name="contributie" value ="<?php echo $contributie ?>" size="10" <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Betaald</td>
      <td><input type="checkbox" name="betaald" value =1 <?php if($betaald==1) {echo 'checked="yes"';} ?> <?php echo $DISABLED ?>/></td>
    </tr>
    <tr> 
    	<td></td>
      <td>Uitstel v betaling</td>
      <td><input type="checkbox" name="uitstel" value =1 <?php if($uitstel==1) {echo 'checked="yes"';} ?> <?php echo $DISABLED ?>/></td>
    </tr>
    <tr>
    	<td></td>
    	<td>Opmerkingen</td>
      <td><TEXTAREA name="opmerking" cols="50" rows="5" WRAP="soft" <?php echo $DISABLED ?> ><?php echo $opmerking ?></TEXTAREA></td>
    </tr>
<?php
	}
?>  
    <tr>
    	<td></td>
    	<td><BR></td>
    	<td></td>
    </tr>
    <tr style="background-image: url(images/menubalkdik.gif)">
     	<td><STRONG><A HREF="#Top">Omhoog</A></STRONG></td>
      <td></td>
      <td>
			<?php 
			if ($_SESSION['user_name'] == "service" )
			{
				if($DISABLED=='DISABLED')
				{
					if ($id==0) {$NORECCORD='DISABLED';} else {$NORECCORD='';}
				?>
	      <input name="Edit" type="submit" id="Edit" value="<?php echo $SYS_EDIT_BUTTON_TEXT ?>" <?php echo $NORECCORD ?> >
	      <input name="New" type="submit" id="New" value="<?php echo $SYS_NEW_BUTTON_TEXT ?>">
	      <input name="Delete" type="submit" id="Delete" value="<?php echo $SYS_DELETE_BUTTON_TEXT ?>" <?php echo $NORECCORD ?> >
	    	<?php
	    	}
	    	Else
	    	{
	    	?>
	    	<input name="Save" type="submit" id="Save" value="<?php echo $SYS_SAVE_BUTTON_TEXT ?>">
	      <input name="Cancel" type="submit" id="Cancel" value="<?php echo $SYS_CANCEL_BUTTON_TEXT ?>">
				<?php
	    	}
    	}
			?>
			</td>
    </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
   	<td style="text-align:right">
				<?php
					if ($_SESSION['user_name'] == "service" )
					{ echo '<a  href="logout.php" ><Font size="1">Uitloggen</Font></a>';}
					else
					{ echo '<a  href="login.php" ><Font size="1">Inloggen</Font></a>'; }
				?>
   	</td>
  </tr>
</table>
</form>
</body>
</html>

