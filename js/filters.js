var g_types = [
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
	'spirits'];

var g_values = [
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
	'K'];
	
var g_sets = [
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
	'RoS'];

var g_suits = [
	'clubs',
	'diamonds',
	'hearts',
	'spades'];
	
var g_rarities = [
	'C',
	'U',
	'R'];
	
var g_outfits = [
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
	'whateleys'];

var g_columns = [
	'card_title',
	'card_type',
	'card_set',
	'card_rarity',
	'card_value',
	'card_suit',
	'card_cost',
	'card_upkeep',
	'card_control',
	'card_influence',
	'card_bullet',
	'card_stud',
	'card_starting_ghost_rock',
	'card_outfit',
	'card_text'];
	
var g_labels = [
	'Title',
	'Type',
	'Set',
	'Rarity',
	'Value',
	'Suit',
	'Cost',
	'Upkeep',
	'Control',
	'Influence',
	'Bullet Value',
	'Bullet Rating',
	'Starting Ghost Rock',
	'Outfit',
	'Text'];

function makeDisplayDetails(p_details)
{
	return function()
	{
		p_details.style.display = 'block';
	}
}

function makeHideDetails(p_details)
{
	return function()
	{
		p_details.style.display = 'none';
	}
}

function addFilter()
{
	var filters = document.getElementById('filtersTable');
	var container = document.createElement('tr');
		container.className = 'filter';
	var select = document.createElement('select');
		select.name = 'columns[]';
	
	var i;
	for (i = 0; i < g_columns.length; i++)
	{
		var option = document.createElement('option');
			option.value = g_columns[i];
		option.appendChild(document.createTextNode(g_labels[i]));
		select.appendChild(option);
	}
	
	var cell = document.createElement('td');
		cell.appendChild(select)
	container.appendChild(cell);
	
	cell = document.createElement('td');
		cell.appendChild(createTextOperator());
	container.appendChild(cell);
	
	var text = document.createElement('input');
		text.type = 'text';
		text.name = 'searches[]';
	
	cell = document.createElement('td');
		cell.appendChild(text);
	
	container.appendChild(cell);
	
	
	var rLink = document.createElement('a');
		rLink.href = 'javascript:void(0)';
		rLink.appendChild(document.createTextNode('remove'));
		
	cell = document.createElement('td');
		cell.appendChild(rLink);
	
	container.appendChild(cell);
	addEvent(rLink, 'click', makeRemoveFilter(container));
	addEvent(select, 'change', makeFullFilter(select, container), false);
	filters.appendChild(container);
}

function makeRemoveFilter(p_filter)
{
	return function(e)
	{
		p_filter.parentNode.removeChild(p_filter);
	}
}

function makeFullFilter(p_select, p_container)
{
	return function()
	{
		var children = p_container.childNodes;
		var thisSelect = p_select;
		
		while (p_container.childNodes.length > 1)
		{
			p_container.removeChild(p_container.lastChild);
		}
		
		var cell;
		switch (p_select.value)
		{
			case 'card_type':
			case 'card_set':
			case 'card_rarity':
			case 'card_suit':
			case 'card_stud':
			case 'card_outfit':
			case 'card_value':
				cell = document.createElement('td');
				cell.appendChild(createExactOperator());
				p_container.appendChild(cell);
				break;
			case 'card_title':
			case 'card_text':
				cell = document.createElement('td');
				cell.appendChild(createTextOperator());
				p_container.appendChild(cell);
				break;
			default:
				cell = document.createElement('td');
				cell.appendChild(createNumberOperator());
				p_container.appendChild(cell);
		}
		
		cell = document.createElement('td');
		cell.appendChild(createSearchSelect(p_select.value));
		p_container.appendChild(cell);
		
		var rlink = document.createElement('a');
			rlink.href = 'javascript:void(0)';
		rlink.appendChild(document.createTextNode('remove'));
		
		cell = document.createElement('td');
		cell.appendChild(rlink);
		
		addEvent(rlink, 'click', makeRemoveFilter(p_container), false);
		
		p_container.appendChild(cell);
	}
}

function createSearchSelect(p_type)
{
	var arr = [];
	switch (p_type)
	{
		case 'card_type':
			arr = g_types;
			break;
		case 'card_set':
			arr = g_sets;
			break;
		case 'card_rarity':
			arr = g_rarities;
			break;
		case 'card_value':
			arr = g_values;
			break;
		case 'card_suit':
			arr = g_suits;
			break;
		case 'card_stud':
			var select = document.createElement('select');
				select.name = 'searches[]';
			
			var stud = document.createElement('option');
				stud.value = 'yes';
				stud.appendChild(document.createTextNode('Stud'));
			var draw = document.createElement('option');
				draw.value = 'no';
				draw.appendChild(document.createTextNode('Draw'));
			select.appendChild(stud);
			select.appendChild(draw);
			
			return select;
		case 'card_outfit':
			arr = g_outfits;
			break;
		case 'card_title':
		case 'card_text':
			var t = document.createElement('input');
				t.type = 'text';
				t.name = 'searches[]';
			return t;
		default:
			var t = document.createElement('input');
				t.type = 'text';
				t.name = 'searches[]';
				t.size = '3';
			return t;
	}
	
	var s = document.createElement('select');
		s.name = 'searches[]';
	var i;
	for (i = 0; i < arr.length; i++)
	{
		var o = document.createElement('option');
			o.value = arr[i];
		o.appendChild(document.createTextNode(arr[i]));
		s.appendChild(o);
	}
	
	return s;
}

function createNumberOperator()
{
	var s = document.createElement('select');
		s.name = 'operators[]';
	var eq = document.createElement('option');
		eq.value = '=';
		eq.appendChild(document.createTextNode('='));
	var gt = document.createElement('option');
		gt.value = '>';
		gt.appendChild(document.createTextNode('>'));
	var lt = document.createElement('option');
		lt.value = '<';
		lt.appendChild(document.createTextNode('<'));
	var ne = document.createElement('option');
		ne.value = '<>';
		ne.appendChild(document.createTextNode('<>'));
		
	s.appendChild(eq);
	s.appendChild(gt);
	s.appendChild(lt);
	s.appendChild(ne);
	
	return s;
}

function createExactOperator()
{
	var s = document.createElement('input');
		s.type = 'hidden';
		s.value = '=';
		s.name = 'operators[]';
		
	return s;
}

function createTextOperator()
{
	var s = document.createElement('input');
		s.type = 'hidden';
		s.value = 'LIKE';
		s.name = 'operators[]';
		
	return s;
}

function setup()
{

	var currentFilters = document.getElementsByName('columns[]');
	
	if (currentFilters.length > 0)
	{
		var i;
		for (i = 0; i < currentFilters.length; i++)
		{
			addEvent(currentFilters[i], 'change', makeFullFilter(currentFilters[i], currentFilters[i].parentNode.parentNode), false);
		}
	}
	
	var rLinks = document.getElementsByName('initialRemove');
	
	if (rLinks.length > 0)
	{
		var i;
		for (i = 0; i < rLinks.length; i++)
		{
			addEvent(rLinks[i], 'click', makeRemoveFilter(rLinks[i].parentNode.parentNode), false);
		}
	}
	
	var details = document.getElementsByTagName('dl');
	var cardTitles = document.getElementsByName('cardTitle');
	
	if (details.length > 0)
	{
		var i;
		for (i = 0; i < details.length; i++)
		{
			addEvent(cardTitles[i], 'mouseover', makeDisplayDetails(details[i]), false);
			addEvent(cardTitles[i], 'mouseout', makeHideDetails(details[i]), false);
		}
	}

	var addLink = document.getElementById('addFilterLink');
	addEvent(addLink, 'click', addFilter, false);
}

addEvent(window, 'load', setup, false);