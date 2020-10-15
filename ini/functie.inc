<?php
function  redirect ($url) 
{ 
	  if( ! headers_sent() ) 
    { 

        Header("Location: $url" ); 
//        exit; 

    } 
    else 
    { 
		echo '<script type="text/javascript">window.location = "'.$url.'"</script>';
			
		/* oud script..
			  printf("\n<script language=\"JavaScript\">\n<!--"); 
				 printf("\nlocation.href = \"$url\";"); 
				 printf("\n\\-->\n</script>"); 
		//        exit; 
		*/
    } 
}

function refreshmenu($url) 
{ 
	printf("\n<script language=\"JavaScript\">\n<!--");
	printf("\n parent.inhoud.location.href = \"$url\";"); 
	printf("\n//-->\n</script>"); 
}

//  combobox ('search_car_usr_id','usr_id','usr_name',"select usr_id,usr_name from user where usr_parent_id='$user_parent' order by usr_name ",$old_usr_id,1,$_EDITMODE) ;
function  combobox ($object_name,$key_id,$key_name,$sql_select,$select_item,$zero_value,$_LEDITMODE) 
{ 
		$db_data = mysql_query($sql_select);
    $combo_output= "<SELECT NAME='$object_name' $_LEDITMODE >"; 
		if (trim($zero_value)<>"" and $zero_value<>0) 
		{
			$combo_output=$combo_output."<option value='0'>-</option>";
		}
    while ($row = mysql_fetch_object($db_data))  
          {  
							if ($row->$key_id == $select_item)
               {
									$combo_output=$combo_output."<option value=".$row->$key_id." selected>".getstr($row->$key_name)."</option>"; 
               }
            Else
               {
            	   $combo_output=$combo_output."<option value=".$row->$key_id."> ".getstr($row->$key_name)." </option>";
               }
           }
    $combo_output=$combo_output."</SELECT>"; 
    echo $combo_output;
}

function date2mysql( $date_str )	{ return date_conv( "DMY","YMD", $date_str );	}
function date2html( $date_str )	{ return date_conv( "YMD","DMY", $date_str );	}
function putstr( $put_str )
	{ 
		$put_str = str_replace("\'", "#single-quote#", $put_str);
		$put_str = str_replace("'", "#single-quote#", $put_str);
		return $put_str ;
	}
function getstr( $get_str )	
	{ 
		$get_str = str_replace("#single-quote#", "'", $get_str);
		return $get_str ;
	}

function date_conv( $date_format_in,$date_format_out, $date_str )
{
	if (strlen($date_str)>0)
	{
	//Bepaal separator (:/-)
	if (ctype_digit(substr($date_str,2,1))=== TRUE AND ctype_digit(substr($date_str,4,1))=== TRUE ) {$separator='-';}
	if (ctype_digit(substr($date_str,2,1))=== FALSE ) {$separator=substr($date_str,2,1);}
	if (ctype_digit(substr($date_str,4,1))=== FALSE ) {$separator=substr($date_str,4,1);}
	//Strip de separator
	$date_str = preg_replace('/'.$separator.'/',"",$date_str);
	//Bepaal Jaar-notatie (YY/YYYY)
	if (strlen($date_str)==6 ) {$y=2;} else {$y=4;}
	//Ontleed de dag, maand en jaar
	if (strtoupper($date_format_in)=="DMY")	{$Day = substr($date_str,0,2);$Month = substr($date_str,2,2);$Year = substr($date_str,4,$y);}
	if (strtoupper($date_format_in)=="MDY")	{$Day = substr($date_str,2,2);$Month = substr($date_str,0,2);$Year = substr($date_str,4,$y);}
	if (strtoupper($date_format_in)=="YMD")	{$Day = substr($date_str,$y+2,2);$Month = substr($date_str,$y,2);$Year = substr($date_str,0,$y);}
	//Opbouwen DatumString
	if (strtoupper($date_format_out)=="DMY")	{	$date_str = $Day.$separator.$Month.$separator.$Year;	}
	if (strtoupper($date_format_out)=="MDY")	{	$date_str = $Month.$separator.$Day.$separator.$Year;	}
	if (strtoupper($date_format_out)=="YMD")	{	$date_str = $Year.$separator.$Month.$separator.$Day;	}
	}   
	return $date_str;
}

function display_amount( $amount ) {	return number_format($amount, 2, ',', '.') ;	}

//function fdate( )	{ return '2007-08-01'; }
function fdate( )	{ return getdate(); }

function build_textblock ( $pagename )
{
	$sql="select blk_id,blk_title,blk_text from blok where blk_pag='$pagename' and blk_tonen=1 order by blk_order desc ,blk_id desc" ;
	$sql_result = sql_execute($sql,1) ;
	foreach ($sql_result as $row) 
	{ 
		$id=$row['blk_id'];
		$title=getstr($row['blk_title']);
		$text=getstr($row['blk_text']);
		$imagename="pics/image_".$id.".jpg";
		if (file_exists($imagename))
			{$imagename="<IMG SRC='pics/image_".$id.".jpg' BORDER=0 width=400>";}
		else
			{$imagename="";}
				
		echo "
		<TABLE style='width=100%; font-size:100%'>
			<TR>
				<TD BGCOLOR='RGB(59,89,152)' style='width=10%'></TD>
				<TD BGCOLOR='RGB(59,89,152)'>
					<FONT color=White><B>".$title."</B><FONT><BR>
				</TD>
			</TR>
		</TABLE>
		<TABLE style='width=100%'>
			<TR>
				<TD style='width=5%'></TD>
				<TD>
					<BR>".$text."<BR><BR>
				</TD>
				<TD style='width=5%'></TD>
			</TR>
			<TR>
				<TD></TD>
				<TD>
					$imagename
				</TD>
			</TR>
		</TABLE>
		";
	} 

}

function escape($html) 
{
	return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}


function sql_execute($sql,$n) 
{
require("databaseconnect.inc");
try {
		$connection = new PDO($dsn, $username, $password, $options);
		$statement = $connection->prepare($sql);
		$statement->execute();
		if ($n==1) {return $statement->fetchAll();}
		else {return $connection->lastInsertId();}
	} 
catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}

?>