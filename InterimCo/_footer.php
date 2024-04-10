<script>

    let input_items = document.querySelectorAll('input');
    input_items.forEach((input_item)=>{
        input_item.classList.add('form-control');
    })
    selects = document.querySelectorAll('select');
    selects.forEach((select_item)=>{
        select_item.classList.add('form-select');
    })
    let labels = document.querySelectorAll('label');
    labels.forEach((label_item)=>{
        label_item.classList.add('form-label');
    })
    let buttons = document.querySelectorAll('button');
    buttons.forEach((button_item)=>{
        button_item.classList.add('btn');
    })
    let look_alike_buttons=document.querySelectorAll('.btn');
    look_alike_buttons.forEach((look_alike_button)=>{
        look_alike_button.classList.add('mt-3');
        if(look_alike_button.textContent.includes('Modifier')){
            look_alike_button.classList.add('btn-secondary');
        }
        else if(look_alike_button.textContent.includes('Supprimer')){
            look_alike_button.classList.add('btn-danger');
        }
        else{
            look_alike_button.classList.add('btn-primary')
        }
    })
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>
</body>
</html>
