<?php
$submitted = isset($_REQUEST['upload']) ? true : false;
if ($submitted)
{
	$connect = mysql_connect('localhost', 'username', 'password');
	mysql_select_db('database');
	$filename = $_FILES['cardlist']['tmp_name'];
	$fp = fopen($filename, 'r');
	if (!$fp)
		echo "Couldn't open ".$filename;
		
	// Skip the fist line
	$line = fgetcsv($fp, 24000,"\t");

	$query = 'INSERT INTO card (card_title, card_type, card_set, card_rarity, card_value, card_suit, card_cost, card_upkeep, card_control, card_influence, card_bullet, card_stud, card_starting_ghost_rock, card_outfit, card_text) VALUES ';
	while ($line = fgetcsv($fp, 24000, "\t"))
	{
		$query .= '(';
		foreach ($line as $item)
		{
			if (is_string($item))
			{
				$query .= '\''.mysql_real_escape_string($item).'\',';
			}
			else
			{
				$query .= $item.',';
			}
		}
		
		$query = rtrim($query, ',');
		
		$query .= '),';
	}
	
	$query = rtrim($query, ',');
	
	echo $query.'<br>';
	
	mysql_query($query) or die(mysql_error());;
	
	echo "Success!";
}
?>
<html>
<head>
	<title>Doomtown Cards List Upload</title>
	<style type="text/css">
	td
	{
		border: solid black 1px;
	}
	</style>
</head>
<body>
<form enctype="multipart/form-data" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
	<input type="file" name="cardlist" />
	<input type="submit" name="upload" />
</form>
<?php
if ($submitted)
{
	echo '<table>';
	while ($line = fgetcsv($fp, 12000, "\t"))
	{
		echo '<tr>';
		foreach ($line as $item)
		{
			echo '<td>'.$item.'</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
?>
</body>
</html>
