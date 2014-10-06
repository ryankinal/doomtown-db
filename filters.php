<?php
$types = array(
	'actions',
	'deeds',
	'dudes',
	'events',
	'goods',
	'hexes',
	'improvements',
	'miracles',
	'outfits',
	'specials',
	'spirits');

$values = array(
	'A',
	'2',
	'3',
	'4',
	'5',
	'6',
	'7',
	'8',
	'9',
	'10',
	'J',
	'Q',
	'K');
	
$sets = array(
	'1&2',
	'3',
	'4',
	'5',
	'6',
	'7',
	'8',
	'9',
	'Ash',
	'E4E',
	'MoH',
	'PB',
	'PRO',
	'Rev',
	'RoS');

$suits = array(
	'clubs',
	'diamonds',
	'hearts',
	'spades');
	
$rarities = array(
	'C',
	'U',
	'R');
	
$outfits = array(
	'blackjacks',
	'collegium',
	'drifter',
	'law dogs',
	'lost angels',
	'maze rats',
	'sioux union',
	'sweetrock',
	'texas rangers',
	'texas rangers',
	'the agency',
	'the flock',
	'whateleys');

$dbcols = array(
	'card_title' => 'Title',
	'card_type' => 'Type',
	'card_set' => 'Set',
	'card_rarity' => 'Rarity',
	'card_value' => 'Value',
	'card_suit' => 'Suit',
	'card_cost' => 'Cost',
	'card_upkeep' => 'Upkeep',
	'card_control' => 'Control',
	'card_influence' => 'Influence',
	'card_bullet' => 'Bullet Value',
	'card_stud' => 'Bullet Rating',
	'card_starting_ghost_rock' => 'Starting Ghost Rock',
	'card_outfit' => 'Outfit',
	'card_text' => 'Text');

function makeOperator($p_type, $p_selected)
{
	switch ($p_type)
	{
		case 'card_type':
		case 'card_set':
		case 'card_rarity':
		case 'card_suit':
		case 'card_stud':
		case 'card_outfit':
		case 'card_value':
			echo '<td><input type="hidden" name="operators[]" value="="></td>';
			break;
		case 'card_title':
		case 'card_text':
			echo '<td><input type="hidden" name="operators[]" value="LIKE"></td>';
			break;
		default:
			echo '<td><select name="operators[]">';
			echo '<option value="="';
			if ($p_selected == '=')
				echo ' selected="selected"';
			echo '>=</option>';
			
			echo '<option value=">"';
			if ($p_selected == '>')
				echo ' selected="selected"';
			echo '>></option>';
			
			echo '<option value="<"';
			if ($p_selected == '<')
				echo ' selected="selected"';
			echo '><</option>';
			
			echo '<option value="<>"';
			if ($p_selected == '<>')
				echo ' selected="selected"';
			echo '><></option>';
			echo '</select></td>';
	}
}

function makeSearch($p_type, $p_selected)
{
	$arr = array();
	switch ($p_type)
	{
		case 'card_type':
			global $types;
			$arr = $types;
			break;
		case 'card_set':
			global $sets;
			$arr = $sets;
			break;
		case 'card_rarity':
			global $rarities;
			$arr = $rarities;
			break;
		case 'card_value':
			global $values;
			$arr = $values;
			break;
		case 'card_suit':
			global $suits;
			$arr = $suits;
			break;
		case 'card_stud':
			echo '<select name="searches[]">';
			echo '<option value="yes">Stud</option>';
			echo '<option value="no">Draw</option>';
			echo '</select>';
			return;
			break;
		case 'card_outfit':
			global $outfits;
			$arr = $outfits;
			break;
		case 'card_title':
		case 'card_text':
			echo '<input type="text" name="searches[]" value="'.$p_selected.'">';
			return;
		default:
			echo '<input type="text" name="searches[]" size="3" value="'.$p_selected.'">';
			return;
	}
	
	echo '<select name="searches[]">';
	
	foreach ($arr as $item)
	{
		echo '<option value="'.$item.'"';
		
		if ($item == $p_selected)
		{
			echo ' selected="selected"';
		}
		
		echo '>'.$item.'</option>';
	}
	
	echo '</select>';
}

function makeInitialFilter($p_column, $p_operator, $p_search)
{
	global $dbcols;
	echo '<tr class="filter">';
	echo '<td><select name="columns[]">';
	
	foreach ($dbcols as $column => $label)
	{
		echo '<option value="'.$column.'"';
		
		if ($p_column == $column)
		{
			echo ' selected="selected"';
		}
		
		echo '>'.$label.'</option>';
	}
	
	echo '</select></td>';
	
	makeOperator($p_column, $p_operator);
	echo '<td>';
	makeSearch($p_column, $p_search);
	echo '</td><td>';
	echo '<a href="javascript:void(0)" name="initialRemove">remove</a>';
	echo '</td>';
	
	echo '</tr>';
}

if ($columns && sizeof($columns) > 0)
{
	foreach ($columns as $key => $column)
	{
		makeInitialFilter($column, $operators[$key], $searches[$key]);
	}
}
?>
