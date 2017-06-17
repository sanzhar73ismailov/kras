function add_natinality() {
	var placeForInput = document.getElementById("pole_for_add_nationality");
	// placeForInput.style.color = 'blue';
	var inputTextNew = document.createElement("input");
	inputTextNew.setAttribute("type", "text");
	inputTextNew.setAttribute("size", "20");
	inputTextNew.setAttribute("id", "nationalityNew");
	inputTextNew.setAttribute("name", "nationalityNew");

	var btnAdd = document.createElement("button");
	btnAdd.innerHTML = "Добавить";
	// inputTextNew.setAttribute("size", "20");
	btnAdd.setAttribute("id", "btnAdd");
	btnAdd.setAttribute("name", "btnAdd");
	btnAdd.setAttribute("onclick",
			"return add_natinality_btn('nationalityNew');");

	placeForInput.appendChild(inputTextNew);
	placeForInput.appendChild(btnAdd);

	// placeForInput.innerHTML = "test";

	// alert(1111);

}

function add_natinality_btn(elementId) {

	console.log(777);
	var valueNew = document.getElementById(elementId).value;
	console.log(valueNew);

	$.getJSON("ajax_add_row.php", // The server URL
	{
		pole : valueNew
	}, // Data you want to pass to the server.
	show // The function to call on completion.
	);

	return false;

}

function show(json) {
	console.log("sss:" + json);

	if (json.id == 0) {
		alert(json.id + " " + json.value);
		return;
	}

	var select = document.getElementById("nationality_id");
	var optionElement = document.createElement("option");
	optionElement.setAttribute("value", json.id);
/*
	for (loop = select.childNodes.length - 1; loop >= 0; loop--) {
		if (select.options[loop].selected) {
			select.options[loop].selected = false;
		}
	}
*/
	if ( select.selectedIndex != -1)
	{
	  //Если есть выбранный элемент, отобразить его значение (свойство value)
	  
	 // select.options[select.selectedIndex].selected=false;
	  select.options[select.selectedIndex].removeAttribute("selected");
	}

	optionElement.setAttribute("selected", "selected");
	optionElement.appendChild(document.createTextNode(json.value));
	select.appendChild(optionElement);

}
/*
 * // This just displays the first parameter passed to it // in an alert.
 * function show(json) { alert(json); }
 * 
 * function run() { $.getJSON("test.php", // The server URL { id : 567, pole:
 * "Пример" }, // Data you want to pass to the server. show // The function to
 * call on completion. ); } // We'll run the AJAX query when the page loads.
 * window.onload = run;
 */