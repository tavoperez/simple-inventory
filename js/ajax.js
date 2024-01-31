const form_ajax = document.querySelectorAll('.form');

function send_ajax(e){
    e.preventDefault();

    let sent = confirm('Quiere enviar el formulario')
    
    if(sent==true){
        let data= new FormData(this);
        let method=this.getAttribute("method");
        let action=this.getAttribute("action");

        let headers = new Headers();

        let config={
            method: method,
            headers: headers,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        }

        fetch(action, config)
        .then(response => response.text())
        .then(response => {
            let container=document.querySelector('.form-rest')
            container.innerHTML = response
        })
    };
}

form_ajax.forEach(forms => {
    forms.addEventListener('submit', send_ajax)
})