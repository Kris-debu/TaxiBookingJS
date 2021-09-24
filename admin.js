function getPickup(dataSource, divID){
    if(xhr){
        var obj = document.getElementById(divID);
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                if(xhr.responseText.includes("Error")){
                    alert(xhr.responseText);
                }
                else if(xhr.responseText == ""){
                    alert("No booking at the moment");
                }
                else{
                    createTable(xhr.responseText);
                }
            }
        }
        xhr.send();
    }
}

function checkTaxi(dataSource, divID, input){
    if(xhr){
        var object = document/getElementById(divID);
        var requestBody = "input=" + encodeURIComponent(input);
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                object.innerHTML = xhr.responseText; 
            }
        }
        xhr.send(requestBody)
    }

}

function addNewCell(name) {
	
	c1 = document.createElement("td");
	v1 = document.createTextNode(name);
	c1.appendChild(v1);
	newRow.appendChild(c1);
	
}


function extractData(body,requests){
	
	
	while(requests.includes("$")){ 
		record = requests.substring(0,requests.indexOf("$")+1);
		newRow = document.createElement("tr");
		while(record.includes("#")){
			addNewCell(record.substring(0,record.indexOf("#")));
			record = record.substring(record.indexOf("#")+1,record.length);
		}
		requests = requests.substring(requests.indexOf("$")+1,requests.length);
		body.appendChild(newRow);
	}
}

function createTable(dataString) {
	var table = document.getElementById("tbl");
	if (table.firstChild != null){
		var currentTable = table.childNodes[0];  
		table.removeChild(currentTable);
	}
	var table = document.getElementById("tbl");
	var tBody = document.createElement("TBODY");
	table.appendChild(tBody);
	newRow = document.createElement("tr");
	addNewCell("Ref no.");
	addNewCell("Booking time");
	addNewCell("Name");
	addNewCell("Phone");
	addNewCell("Suburb");
	addNewCell("Street name");
	addNewCell("Street number");
	addNewCell("Unit number");
	addNewCell("Pick-up date"); 
	addNewCell("Pick-up time");
	addNewCell("Destination street");
	addNewCell("Destination number");
	addNewCell("Booking date");
	tBody.appendChild(newRow);
	extractData(tBody,dataString);
	
}