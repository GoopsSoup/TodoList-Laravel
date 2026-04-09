import './bootstrap';

// Username check
document.getElementById('username').addEventListener('keyup', function() {

let username = this.value;

fetch('/check-username?username=' + username)
    .then(response => response.json())
    .then(data => {

        let status = document.getElementById('username-status');

        if(username.length === 0){
            status.textContent = "";
        }
        else if(username.length > 0 && username.length < 6) {
            status.textContent = "- Username atleast 6 character"
            status.style.color = "red"
        }
        else if (data.available) {
            status.textContent = "- Username available";
            status.style.color = "green";
        } 
        else {
            status.textContent = "- Username not available";
            status.style.color = "red";
        }

    });

});


// Email check
document.getElementById('email').addEventListener('input', function() {

    let email = this.value;
    let status = document.getElementById('email-status');

    if(email.length === 0){
        status.textContent = "";
        return;
    }

    fetch('/check-email?email=' + email)
    .then(response => response.json())
    .then(data => {

        if(!data.valid){
            status.textContent = "- Invalid email format";
            status.style.color = "orange";
        }
        else if(data.available){
            status.textContent = "- Email available";
            status.style.color = "green";
        }
        else{
            status.textContent = "- Email already used";
            status.style.color = "red";
        }

    });

});

// Password check
document.getElementById('password').addEventListener('input', function(){

    let password = this.value;
    let status = document.getElementById('password-status');

    if(password.length === 0){
        status.textContent = "";
    }
    else if(password.length < 8){
        status.textContent = "- Password must be at least 8 characters";
        status.style.color = "red";
    }
    else{
        status.textContent = "- Strong enough";
        status.style.color = "green";
    }

});

window.showLogin = function showLogin(e) {
    e.preventDefault();
    document.getElementById('slide-container').classList.add('login-mode');
}

window.showRegister = function showRegister(e) {
    e.preventDefault();
    document.getElementById('slide-container').classList.remove('login-mode');
}