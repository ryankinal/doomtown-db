<?php
$card_id = isset($_REQUEST['card_id']) ? $_REQUEST['card_id'] : null;

if ($card_id)
{
	$connect = mysql_connect('localhost', 'username', 'password');
	mysql_select_db('database');
	
	$query = 'SELECT * FROM card WHERE card_id = '.$card_id;
	$result = mysql_query($query) or die(mysql_error());;
	$card = mysql_fetch_assoc($result);
}
?>
<html>
<head>
	<title>Doomtown Card: <?php echo $card['card_title']; ?></title>
	<link rel="stylesheet" type="text/css" href="./css/overall.css" />
	<style type="text/css">
	#stats
	{
		width: 400px;
		margin: 0 auto;
	}
	
	h3
	{
		margin-top: 15px;
	}
	</style>
</head>
<body>
<div id="container">

	<div id="header">
	<img src="./images/doomtown_logo.gif">
	<h3><?php if ($card_id && $card) echo $card['card_title']; ?></h3>
	</div>
	<?php if ($card_id && $card) { ?>
	<div id="stats">
	<dl>
	<?php
		echo '<dt>Type</dt>';
			echo '<dd>'.$card['card_type'].'</dd>';
			
			echo '<dt>Set</dt>';
			echo '<dd>'.$card['card_set'].'</dd>';
			
			if ($card['card_outfit'] != '')
			{
				echo '<dt>Outfit</dt>';
				echo '<dd>'.$card['card_outfit'].'</dd>';
			}
			
			echo '<dt>Value</dt>';
			echo '<dd>'.$card['card_value'].' of '.$card['card_suit'].'</dd>';
			
			if ($card_type != 'events')
			{
				echo '<dt>Cost</dt>';
				echo '<dd>'.$card['card_cost'].'</dd>';
			}
			
			if ($card['card_type'] == 'dudes' ||
				$card['card_type'] == 'deeds' ||
				$card['card_type'] == 'outfits')
			{
				echo '<dt>Upkeep</dt>';
				echo '<dd>'.$card['card_upkeep'].'</dd>';
			}
			
			if ($card['card_type'] == 'deeds')
			{
				echo '<dt>Control</dt>';
				echo '<dd>'.$card['card_control'].'</dd>';
			}
			
			if ($card['card_type'] == 'dudes')
			{
				echo '<dt>Influence</dt>';
				echo '<dd>'.$card['card_influence'].'</dd>';
			}
			
			if ($card['card_type'] == 'dudes' ||
				$card['card_type'] == 'goods')
			{
				echo '<dt>Bullet</dt>';
				echo '<dd>'.$card['card_bullet'];
				
				if ($card['card_stud'] == 'yes')
				{
					echo ' stud';
				}
				else
				{
					echo ' draw';
				}
				
				echo '</dd>';
			}
			
			if ($card['card_type'] == 'outfits')
			{
				echo '<dt>Starting Ghost Rock</dt>';
				echo '<dt>'.$card['card_starting_ghost_rock'].'</dt>';
			}
			
			echo '<dt>Text</dt>';
			echo '<dd class="text">'.$card['card_text'].'<dd>';
		?>
	</dl> 
	<? 
	}
	else
	{
		'There was a problem, please go back to your search and try again';
	}?>
	</div>
	<div id="footer">
	</div>
</div>
</body>
</html>
