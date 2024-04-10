<form class="col-md-8 mx-auto border p-4" id="user_info" method="post">
    <div id="formFields">

    </div>
</form>

<script>
    // Sample data for form fields (can be replaced with actual user data)
    const userProfileFields = {'Nom':'text', 'Locale':'text', 'Email':'email', 'Numero Telephone':'number', "Nom utilisateur":'text'};
    // Function to initialize form fields for viewing user profile
    function initializeFormFieldsForProfile(fields, user_data) {
        let formFieldsContainer = document.getElementById('formFields');
        Object.keys(fields).forEach(field => {
            const champ=field.toLowerCase().replace(/ /g, '_');
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('mb-3');
            const label = document.createElement('label');
            label.setAttribute('for', champ);
            label.classList.add('form-label');
            label.textContent = field;

            const input = document.createElement('input');
            input.classList.add('form-control');
            input.setAttribute('id', champ);
            input.setAttribute('name',champ);
            input.setAttribute('type', userProfileFields[field]);
            input.setAttribute('placeholder', 'Entrez ' + field);
            input.setAttribute('disabled', 'true');
            if (user_data[champ]) {
                input.value = user_data[champ];
            }

            inputGroup.appendChild(label);
            inputGroup.appendChild(input);
            formFieldsContainer.appendChild(inputGroup);
        });
        document.getElementById('numero_telephone').min=10000000;
        document.getElementById('numero_telephone').max=99999999;
    }
    // Initialize form fields for viewing user profile
    initializeFormFieldsForProfile(userProfileFields, user_data);

</script>
