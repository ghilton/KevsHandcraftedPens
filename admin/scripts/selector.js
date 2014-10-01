// Kill Form submit on ENTER KEY
function killEnter(e){
e = e? e : window.event;
var k = e.keyCode? e.keyCode : e.which? e.which : null;
if (k == 13){
if (e.preventDefault)
e.preventDefault();
return false;
};
return true;
};
if(typeof document.addEventListener!='undefined')
document.addEventListener('keydown', killEnter, false);
else if(typeof document.attachEvent!='undefined')
document.attachEvent('onkeydown', killEnter);
else{
if(document.onkeydown!=null){
var oldOnkeydown=document.onkeydown;
document.onkeydown=function(e){
oldOnkeydown(e);
killEnter(e);
};}
else
document.onkeydown=killEnter;
}

// Real Script Starts here -->
$(document).ready(function() {
	//Moving selected item(s) to right select box provided
	$('#moveright').click(function() { 
		//If none of the items are selected, inform the user using an alert
		if(!isSelected("#fromSelectBox")){return;} 
		//If atleast one of the item is selected, initially the selected option would be 'removed' and then it is appended to 'toSelectBox' (select box)
		$('#fromSelectBox option:selected').remove().appendTo('#toSelectBox'); 
		return false;
	});
	
	//Moving selected item(s) to left select box provided
	$('#moveleft').click(function() {
		//If no items are present in 'toSelectBox' (or) if none of the items are selected inform the user using an alert
		if(!noOptions("#toSelectBox") || !isSelected("#toSelectBox")){return;} 
		//If atleast one of the item is selected, initially the selected option would be 'removed' and then it is appended to 'fromSelectBox' (select box)
		$('#toSelectBox option:selected').remove().appendTo('#fromSelectBox');
		return false;
	});
	
	
	$('#bottommost').click(function(){
		//If no items are present in 'toSelectBox' (or) if none of the items are selected inform the user using an alert	
		if(!noOptions("#toSelectBox") || !isSelected("#toSelectBox")){return;}
		//If the selected item(s) index is less than last item (option) index then move that item to the last position
		if($('#toSelectBox option:selected').attr('index') < $('#toSelectBox option:last').attr('index')){
			$('#toSelectBox option:selected').insertAfter($('#toSelectBox option:last'));
		}
		return false;
	});
});

//Below function is to validate the select box, if none of the item(s) is selected then it alerts saying 'Please select atleast one option' if user selects an item then it returns true
function isSelected(thisObj){
	if (!$(thisObj+" option:selected").length){
		alert("Please select atleast one option");
		return false;
	}
	return 1;
}

//Below function is to validate the select box, if none of the item(s) where present in the select box provided then it alerts saying 'There are no options to select/move' if select box has more than one item it returns true
function noOptions(thisObj){
	if(!$(thisObj+" option").length){
		alert("There are no options to select/move");
		return false;
	}
	return 1;
}