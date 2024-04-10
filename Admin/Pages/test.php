<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Option to Select</title>
</head>
<body>

<select id="mySelect" onchange="checkOption()">
    <option value="">Select an option or type a new one</option>
    <option value="option1">Option 1</option>
    <option value="option2">Option 2</option>
    <option value="option3">Option 3</option>
</select>
<input type="text" id="newOptionInput" style="display: none;">
<div id="suggestionList" style="display: none;"></div>
<button onclick="addNewOption()">Add Option</button>

<script>
    document.querySelector(".competences").addEventListener('change',checkOption);

    function checkOption(event) {
        var select = event.target;
        var newCompetenceInput = select.nextSibling;
        console.log(newCompetenceInput);
        console.log(select);

        if (select.value === "") {
            newCompetenceInput.style.display = "inline";
        } else {
            newCompetenceInput.style.display = "none";
        }
    }

    function addNewOption() {
        var select = document.getElementById("mySelect");
        var newOptionInput = document.getElementById("newOptionInput");
        var newOption = newOptionInput.value.trim();

        if (newOption !== "") {
            // Check if the option already exists
            var optionExists = Array.from(select.options).some(option => option.text.toLowerCase() === newOption.toLowerCase());
            if (!optionExists) {
                var option = document.createElement("option");
                option.text = newOption;
                option.value = newOption.toLowerCase().replace(/\s+/g, '-'); // Use a format for the value if needed
                select.add(option);
                newOptionInput.value = "";
                newOptionInput.style.display = "none";
                select.value = option.value; // Select the newly added option
            } else {
                alert("Option already exists!");
            }
        } else {
            alert("Please enter a valid option!");
        }
    }

    document.addEventListener("click", function(event) {
        var suggestionList = document.getElementById("suggestionList");
        var newOptionInput = document.getElementById("newOptionInput");
        if (event.target !== newOptionInput && event.target !== suggestionList) {
            suggestionList.style.display = "none";
        }
    });
</script>

</body>
</html>