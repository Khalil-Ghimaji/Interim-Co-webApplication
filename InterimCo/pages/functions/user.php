<script>
    function enable_fields(){
        const inputs = document.querySelectorAll('#user_info input');
        inputs.forEach(input => {
            input.removeAttribute('disabled');
            input.required=true;
        });
    }
    function add_password_field(field_name){
        let formFieldsContainer = document.getElementById('formFields');
        let inputGroup = document.createElement('div');
        inputGroup.classList.add('mb-3');
        let label = document.createElement('label');
        label.setAttribute('for', field_name);
        label.classList.add('form-label');
        label.textContent = field_name.replace(/_/g,' ').replace(/pwd/g,'mot de passe').replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });


        let pwd = document.createElement('input');
        pwd.type = 'password';
        pwd.id = field_name;
        pwd.name = field_name;
        pwd.placeholder = 'Entrez votre ' + field_name.split('_')[0] + ' mot de passe';
        pwd.classList.add('form-control');

        let pwd_error = document.createElement('div');
        pwd_error.id = field_name + '_error';
        pwd_error.classList.add('invalid-feedback');
        if (form_errors[field_name]) {
            pwd_error.textContent = form_errors[field_name];
            pwd.classList.add('is-invalid');
        }

        inputGroup.appendChild(label);
        inputGroup.appendChild(pwd);
        inputGroup.appendChild(pwd_error)
        formFieldsContainer.appendChild(inputGroup);
    }
    function add_username_error(){
        let username = document.getElementById('nom_utilisateur');
        let username_error=document.createElement('div');
        username_error.id = 'nom_utilisateur_error';
        username_error.classList.add('invalid-feedback');
        if (form_errors['nom_utilisateur']) {
            username_error.textContent = form_errors['nom_utilisateur'];
            username.classList.add('is-invalid');
        }
        username.parentElement.appendChild(username_error);
    }
    function add_submit_button(textcontent){
        let saveButton = document.createElement('button');
        saveButton.textContent = textcontent;
        saveButton.type = "submit";
        saveButton.classList.add('btn');
        saveButton.classList.add('btn-primary');
        let user_info_form = document.getElementById('user_info');
        user_info_form.appendChild(saveButton);
    }
    function enable_profile_modif() {
        enable_fields();
        document.getElementById('changeProfileBtn').style.display = 'none';
        pwds = ['ancien_pwd', 'nouveau_pwd']
        pwds.forEach((pwd_field) => {
            add_password_field(pwd_field);
        })
        add_username_error();
        add_submit_button('Enregistrer');
    }
</script>