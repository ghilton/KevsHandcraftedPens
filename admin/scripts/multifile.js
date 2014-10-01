/**
 * Convert a single file-input element into a 'multiple' input list
 *
 * Usage:
 *
 *   1. Create a file input element (no name)
 *      eg. <input type="file" id="first_file_element">
 *
 *   2. Create a DIV for the output to be written to
 *      eg. <div id="files_list"></div>
 *
 *   3. Instantiate a MultiSelector object, passing in the DIV and an (optional) maximum number of files
 *      eg. var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 3 );
 *
 *   4. Add the first element
 *      eg. multi_selector.addElement( document.getElementById( 'first_file_element' ) );
 *
 *   5. That's it.
 *
 *   You might (will) want to play around with the addListRow() method to make the output prettier.
 *
 *   You might also want to change the line 
 *       element.name = 'file_' + this.count;
 *   ...to a naming convention that makes more sense to you.
 * 
 * Licence:
 *   Use this however/wherever you like, just don't blame me if it breaks anything.
 *
 * Credit:
 *   If you're nice, you'll leave this bit:
 *  
 *   Class by Stickman -- http://www.the-stickman.com
 *      with thanks to:
 *      [for Safari fixes]
 *         Luis Torrefranca -- http://www.law.pitt.edu
 *         and
 *         Shawn Parker & John Pennypacker -- http://www.fuzzycoconut.com
 *      [for duplicate name bug]
 *         'neal'
 */
function MultiSelector( list_target, max ){

	// Where to write the list
	this.list_target = list_target;
	// How many elements?
	this.count = 0;
	// How many elements?
	this.id = 0;
	// Is there a maximum?
	if( max ){
		this.max = max;
	} else {
		this.max = -1;
	};
	
	
	/**
	 * Add a new file input element
	 */
	this.addElement = function( element ){

		// Make sure it's a file input element
		if( element.tagName == 'INPUT' && element.type == 'file'){

			// Element name -- what number am I?
			element.name = 'files[]';

			// Add reference to this object
			element.multi_selector = this;

			// What to do when a file is selected
			element.onchange = function(){

				// New file input
				var new_element = document.createElement( 'input' );
				new_element.type = 'file';

				// Add new element
				this.parentNode.insertBefore( new_element, this );

				// Apply 'update' to element
				this.multi_selector.addElement( new_element );
// My code
var exten = 'good';
/*
Supportted Extenssions list here
var file_name = element.value;
var file_extension = file_name.substring(file_name.lastIndexOf('.') + 1);
if(file_extension == "gif" || file_extension == "jpg" || file_extension == "png" || file_extension == "jpeg"|| file_extension == "GIF" || file_extension == "JPG" || file_extension == "PNG" || file_extension == "JPEG") {
	var exten = 'good';
} else {
	exten = "bad";
alert("Invalid File. File Format supported: JPG, PNG and GIF Only");
}
*/
// My code
				// Update list
				this.multi_selector.addListRow( this, exten );

				// Hide this: we can't use display:none because Safari doesn't like it
				this.style.position = 'absolute';
				this.style.left = '-1000px';
			};
			// If we've reached maximum number, disable input element
			if( this.max != -1 && this.count >= this.max ){
				element.disabled = true;
			};

			// File element counter
			this.count++;
			// Most recent element
			this.current_element = element;
			

		} else {
			// This can only be applied to file input elements!
			alert( 'Error: not a file input element' );
		};

	};

	/**
	 * Add a new row to the list of files
	 */
	this.addListRow = function( element, exten ){

		// Row div
		cont++;
		var new_row = document.createElement( 'tr' );
		new_row.setAttribute("id", "r"+cont);
		new_row.setAttribute("class", "rowf");

        var cell1 = document.createElement("TD");
		cell1.setAttribute("class", "tab1");
        var cell2 = document.createElement("TD");
		cell2.setAttribute("class", "tab2");
        var cell3 = document.createElement("TD");
		cell3.setAttribute("class", "tab3");
        var cell4 = document.createElement("TD");
		cell4.setAttribute("class", "tab4");

		var img1 = document.createElement("img");
		if(exten == "bad"){
			img1.setAttribute("src", "images/warning.jpg");
		}
		else{
			img1.setAttribute("src", "images/circle.png");
		}
		img1.setAttribute("height", "16");
		img1.setAttribute("width", "16");
		img1.setAttribute("alt", "");
		
		var newlink = document.createElement("a");
		newlink.setAttribute('href', '#files_list');
		newlink.setAttribute('alt', 'Remove this file');

		cell1.appendChild(img1);

		// Delete button
		var new_row_button = document.createElement( 'input' );
		new_row_button.type = 'image';
		new_row_button.value = 'Delete';
		new_row_button.src = 'images/cross_small.gif';
		new_row_button.id = cont;

		var new_name = document.createElement( 'input' );
		new_name.type = 'text';
		new_name.name = 'doc_name[]';

		// References
		cell2.element = element;
		cell3.element = element;
		cell4.element = element;

		// Delete function
		new_row_button.onclick= function(){

			// Remove element from form
			this.parentNode.element.parentNode.removeChild( this.parentNode.element );
			

			// Remove this row from the list
			this.parentNode.parentNode.removeChild( this.parentNode );
			var iid = this.id;
			var child = document.getElementById("r"+iid);
        	var parent = document.getElementById('files_list');
          	parent.removeChild(child);


			// Decrement counter
			this.parentNode.element.multi_selector.count--;

			// Re-enable input element (if it's disabled)
			this.parentNode.element.multi_selector.current_element.disabled = false;

			// Appease Safari
			//    without it Safari wants to reload the browser window
			//    which nixes your already queued uploads
			return false;
		};

		// Set row value
		cell2.innerHTML = element.value;

		// Add button
		cell3.appendChild( new_row_button );
		cell4.appendChild( new_name );
		new_row.appendChild(cell1);
		new_row.appendChild(cell2);
		new_row.appendChild(cell3);
		new_row.appendChild(cell4);

		// Add it to the list
		this.list_target.appendChild( new_row );
		
	};

};

