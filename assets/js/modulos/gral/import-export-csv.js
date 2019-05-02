	function csvToArray(csvString)
	{
		// The array we're going to build
		var csvArray   = [];
		// Break it into rows to start
		var csvRows    = csvString.split(/\n/);
		// Take off the first line to get the headers, then split that into an array
		var csvHeaders = csvRows.shift().split(';');
		
		// Loop through remaining rows
		for(var rowIndex = 0; rowIndex < csvRows.length; ++rowIndex)
		{
			var rowArray  = csvRows[rowIndex].split(';');
			
			// Create a new row object to store our data.
			var rowObject = csvArray[rowIndex] = {};
				
			// Then iterate through the remaining properties and use the headers as keys
			for(var propIndex = 0; propIndex < rowArray.length; ++propIndex)
			{
				// Grab the value from the row array we're looping through...
				var propValue =   rowArray[propIndex].replace(/^"|"$/g,'');
				// ...also grab the relevant header (the RegExp in both of these removes quotes)
				var propLabel = csvHeaders[propIndex].replace(/^"|"$/g,'');

				rowObject[propLabel] = propValue;
								
			}
		}

		return csvArray;
	}

	function CSVToArray(strData, strDelimiter) {
		// Check to see if the delimiter is defined. If not,
		// then default to comma.
		strDelimiter = (strDelimiter || ",");
		// Create a regular expression to parse the CSV values.
		var objPattern = new RegExp((
			// Delimiters.
		"(\\" + strDelimiter + "|\\r?\\n|\\r|^)" +
			// Quoted fields.
		"(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
			// Standard fields.
		"([^\"\\" + strDelimiter + "\\r\\n]*))"), "gi");
		// Create an array to hold our data. Give the array
		// a default empty first row.
		var arrData = [[]];
		// Create an array to hold our individual pattern
		// matching groups.
		var arrMatches = null;
		// Keep looping over the regular expression matches
		// until we can no longer find a match.
		while (arrMatches = objPattern.exec(strData)) {
			// Get the delimiter that was found.
			var strMatchedDelimiter = arrMatches[1];
			// Check to see if the given delimiter has a length
			// (is not the start of string) and if it matches
			// field delimiter. If id does not, then we know
			// that this delimiter is a row delimiter.
			if (strMatchedDelimiter.length && (strMatchedDelimiter != strDelimiter)) {
				// Since we have reached a new row of data,
				// add an empty row to our data array.
				arrData.push([]);
			}
			// Now that we have our delimiter out of the way,
			// let's check to see which kind of value we
			// captured (quoted or unquoted).
			if (arrMatches[2]) {
				// We found a quoted value. When we capture
				// this value, unescape any double quotes.
				var strMatchedValue = arrMatches[2].replace(
						new RegExp("\"\"", "g"), "\"");
			} else {
				// We found a non-quoted value.
				var strMatchedValue = arrMatches[3];
			}
			// Now that we have our value string, let's add
			// it to the data array.
			arrData[arrData.length - 1].push(strMatchedValue);
		}
		// Return the parsed data.
		return (arrData);
	}

	function CSV2JSON(csv) {
		var array = CSVToArray(csv,';');
		var objArray = [];
		for (var i = 1; i < array.length; i++) {
			objArray[i - 1] = {};
			for (var k = 0; k < array[0].length && k < array[i].length; k++) {
				var key = array[0][k];
				objArray[i - 1][key] = array[i][k]
			}
		}

		var json = JSON.stringify(objArray);
		var str = json.replace(/},/g, "},\r\n");

		return str;
	}

	function CSV2Object(csv) {
		var array = CSVToArray(csv,';');
		var objArray = [];
		for (var i = 1; i < array.length; i++) {
			objArray[i - 1] = {};
			for (var k = 0; k < array[0].length && k < array[i].length; k++) {
				var key = array[0][k];
				objArray[i - 1][key] = array[i][k]
			}
		}

		return objArray;
	}

	function UploadDataCSV(content, fileName, mimeType) 
	{
		var a = document.createElement('a');
		mimeType = mimeType || 'application/octet-stream';

		if (navigator.msSaveBlob) 
		{ // IE10
			//console.log("IE10")
			navigator.msSaveBlob(new Blob([content], { type: mimeType}), fileName);
		} 
		else if (URL && 'download' in a) 
		{ //html5 A[download]
			//console.log("html5")
			a.href = URL.createObjectURL(new Blob([content], { type: mimeType }));
			a.setAttribute('download', fileName);
			document.body.appendChild(a);
			a.click();
			document.body.removeChild(a);
		} 
		else 
		{
			location.href = 'data:application/octet-stream,' + encodeURIComponent(content); // only this mime type is supported
		}
	}

