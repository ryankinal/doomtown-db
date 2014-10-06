/*****
    File Name: domFunctions.js
    Author: Ryan Kinal
	Date: 05/19/06
	Description:  General-use functions, mostly for event handling
	Updated By:
	Updated Date: 6/16/06
	Last Change: Added a find to the Array prototype
*****/


/*****
	Cross-browser event handling for IE5+, NS6+, and Mozilla/Gecko
		By Scott Andrews
*****/
function addEvent(p_elm, p_evType, p_fn, p_useCapture)
{
	if (p_elm.addEventListener)
	{
		p_elm.addEventListener(p_evType, p_fn, p_useCapture);
		return true;
	}
	else if (p_elm.attachEvent)
	{
		return p_elm.attachEvent("on" + p_evType, p_fn);
	}
	else
	{
		//TODO We may want to create a new function each time and keep adding fn to it. If we do though, we can't remove them easily. If we don't, every add removes the previous add.
		p_elm["on" + p_evType] = p_fn;
		return true;
	}
}

/***
	Cross-browser event removal
***/
function removeEvent(p_elm, p_evType, p_fn, p_useCapture)
{
	if (p_elm.removeEventListener)
	{
		p_elm.removeEventListener(p_evType, p_fn, p_useCapture);
		return true;
	}
	else if (p_elm.detachEvent)
	{
		return p_elm.detachEvent("on" + p_evType, p_fn);
	}
	else
	{
		//TODO If we do add multiple event handlers with DOM 1, how do we remove them?
		p_elm["on" + p_evType] = null;
		return true;
	}
}

/*****
	Checks for double click on element p_elem, and calls function p_function if a double click happens
*****/
function makeDoubleClick(p_elem, p_func, p_bubble)
{
	var DOUBLE_CLICK_SPEED = 500;

	var remove = function()
	{
		removeEvent(p_elem, "click", p_func, p_bubble);
	}

	var dbl = function(p_e)
	{
		addEvent(p_elem, "click", p_func, p_bubble);
		var timeOut = setTimeout(remove, DOUBLE_CLICK_SPEED);
	}

	addEvent(p_elem, "click", dbl, p_bubble);
}

/*****
	Returns mouse position from event p_e.  This should only be called
	from an event handler, as Internet Explorer will not have an event
	to pass to this function, and instead relies on window.event.  This
	will return the mouse position as an object.  obj.x is the mouse's
	x position, obj.y is the mouse's y position.

	Author:  Ryan Kinal
*****/
function mousePos(p_e)
{
	posx = 0;
	posy = 0;

	if (!p_e)
		var e = window.event;
	else
		var e = p_e;

	if (e.pageX || e.pageY)
	{
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY)
	{
		posx = e.clientX + document.body.scrollLeft;
		posy = e.clientY + document.body.scrollTop;
	}

	returnObj = new Object();
	returnObj.x = posx;
	returnObj.y = posy;
	return returnObj;
}

function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}

/*
	Cookie functions:  From QuirksMode - http://www.quirksmode.org/js/cookies.html
*/
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

/***
	A very simple find, added to the array prototype.
	Simply call with myArray.find(element)

	Author: Ryan Kinal
***/
Array.prototype.find = function(p_elem)
{
	for (var i = 0; i < this.length; i++)
	{
		if (this[i] == p_elem)
		{
			return i;
		}
	}

	return false;
}

Array.prototype.remove = function(p_elem)
{
	var index = this.find(p_elem);
	var before = this.slice(0, index);
	var after = this.slice(index + 1);
	before = before.concat(after);
	return before;
}

function createXHR()
{
	var xhr;
	if (window.ActiveXObject)
	{
		try
		{
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			alert(e.message);
			xhr = null;
		}
	}
	else
	{
		xhr = new XMLHttpRequest();
	}

	return xhr;
}


String.prototype.trim = function()
{
	return this.replace(/^\s+|\s+$/, '');
}

function addSlashes(p_str)
{
	var str = p_str.replace(/\\/g, "\\\\");
	str = str.replace(/\'/g, "\\'");
	str = str.replace(/\"/g, '\\"');
	return str;
}

function stripSlashes(p_str)
{
	var str = p_str.replace(/\\"/g, '\"');
	str = str.replace(/\\'/g, "\'");
	str = str.replace(/\\\\/g, "\\");
	return str;
}

/***
  Acutally makes it so javascript (IE) recognizes a checkbox as checked
***/
function actuallyCheckCheckbox(p_e)
{
	var target = (p_e.target) ? p_e.target : p_e.srcElement;
	
	if (typeof target.defaultChecked != 'undefined')
	{
		target.defaultChecked = target.checked;
	}
}