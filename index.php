<?php
$submitted = isset($_REQUEST['search']) ? true : false;
$columns = isset($_REQUEST['columns']) ? $_REQUEST['columns'] : array('card_title');
$operators = isset($_REQUEST['operators']) ? $_REQUEST['operators'] : array('LIKE');
$searches = isset($_REQUEST['searches']) ? $_REQUEST['searches'] : array('');

if ($submitted)
{
	$connect = mysql_connect('localhost', 'username', 'password');
	mysql_select_db('database');

	$query = 'SELECT * FROM card';

	if ($columns && sizeof($columns) > 0)
	{
		$query .= ' WHERE';
		foreach ($columns as $key => $column)
		{
			$operator = $operators[$key];
			$search = $searches[$key];
			
			if ($operator == 'LIKE')
			{
				$search = '%'.$search.'%';
			}
			
			$query .= ' '.$column.' '.$operator.' \''.$search.'\' AND';
		}
		
		$query = rtrim($query, ' AND');
	}

	$query .= ' ORDER BY card_title ASC';

	$result = mysql_query($query) or die(mysql_error());
}
?>
<html>
<head>
	<title>Doomtown Cards Search</title>
	<link rel="stylesheet" href="./css/overall.css" />
	<style type="text/css">
	dl
	{
		width: 400px;
		margin: -2px 0 0 30px;
		padding: 5px;
		display: none;
		position: absolute;
		background-color: white;
		border: solid black 1px;
	}
	
	#results
	{
		background: url('./images/bgbottom.jpg') bottom center no-repeat;
		padding-bottom: 65px;
		text-align: left;
	}

	td
	{
		padding: 5px 10px;
		text-align:center;
	}

	td:first-child
	{
		text-align: left;
	}
	
	table
	{
		margin: 0 auto;
	}
	
	#controls
	{
		margin: 15px 0;
	}
	
	#filters
	{
		background: url('./images/bgtop.jpg') no-repeat;
		padding-top: 30px;
	}
	
	#filters td
	{
		text-align: left;
	}
	
	#filters img
	{
		margin-bottom: 30px;
	}
	</style>
	<script type="text/javascript" src="./js/Utility.js"></script>
	<script type="text/javascript" src="./js/filters.js"></script>
</head>
<body>
<div id="container">
<form method="post">
	
	<div id="filters">
	<img src='./images/doomtown_logo.gif'>
	<table id="filtersTable">
	<?php
	include('./filters.php');
	?>
	</table>
	<div id="controls">
		<input type="button" id="addFilterLink" value="Add a Filter" />
		<input type="submit" name="search" value="Search!" class="submit" />
	</div>
</form>
</div>
<div id="results">
<table>
<?php
if (isset($result))
{
?>
<tr>
	<td colspan="6">
<?php
	echo mysql_num_rows($result).' cards';
?>
	</td>
</tr>
<tr class="tableHead">
	<td>Title</td>
	<td>Type</td>
	<td>Value</td>
	<td>Cost</td>
	<td>Upkeep</td>
	<td>Set</td>
</tr>
<?php
	while ($row = mysql_fetch_assoc($result))
	{
		echo '<tr>';
		echo '<td><a href="card.php?card_id='.$row['card_id'].'" name="cardTitle">'.$row['card_title'].'</a>';
		echo '<dl name="details" class="details">';
			echo '<dd class="firstItem">&nbsp;</dd>';
			
			if ($row['card_outfit'] != '')
			{
				echo '<dt>Outfit</dt>';
				echo '<dd>'.$row['card_outfit'].'</dd>';
			}
			
			echo '<dt>Rarity</dt>';
			echo '<dd>'.$row['card_rarity'].'</dd>';
			
			if ($row['card_type'] == 'deeds')
			{
				echo '<dt>Control</dt>';
				echo '<dd>'.$row['card_control'].'</dd>';
			}
			
			if ($row['card_type'] == 'dudes' ||
				$row['card_type'] == 'goods')
			{
				echo '<dt>Influence</dt>';
				echo '<dd>'.$row['card_influence'].'</dd>';
			}
			
			if ($row['card_type'] == 'dudes' ||
				$row['card_type'] == 'goods')
			{
				echo '<dt>Bullet</dt>';
				echo '<dd>'.$row['card_bullet'];
				
				if ($row['card_stud'] == 'yes')
				{
					echo ' stud';
				}
				else
				{
					echo ' draw';
				}
				
				echo '</dd>';
			}
			
			if ($row['card_type'] == 'outfits')
			{
				echo '<dt>Starting Rock</dt>';
				echo '<dd>'.$row['card_starting_ghost_rock'].'</dd>';
			}
			
			echo '<dt>Text</dt>';
			echo '<dd class="text">'.$row['card_text'].'<dd>';
			
			echo '<dd class="lastItem">&nbsp;</dd>';
		echo '</dl>';
		echo '</td>';
		echo '<td>'.$row['card_type'].'</td>';
		echo '<td>';
		if (trim($row['card_value']) != '' &&
			trim($row['card_suit']) != '')
		{
			echo $row['card_value'].' of '.$row['card_suit'];
		}
		echo '</td>';
		echo '<td>'.$row['card_cost'].'</td>';
		echo '<td>'.$row['card_upkeep'].'</td>';
		echo '<td>'.$row['card_set'].'</td>';
		echo '</tr>';
	}
}
?>
</table>
</div>
</div>
</body>
</html>
