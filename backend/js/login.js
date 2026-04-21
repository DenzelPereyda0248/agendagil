
const params = new URLSearchParams(window.location.search);
const success = params.get("success");

if(success){
    const msg = document.getElementById("successMessage");
    msg.style.display = "block";
    msg.innerText = success.replaceAll("_", " ");

    setTimeout(() => {
        msg.style.opacity = "0";
    }, 3500);

    setTimeout(() => {
        msg.style.display = "none";
    }, 4000);
}

const error = params.get("error");



if(error){
    const msg = document.getElementById("errorMessage");

    if(msg){
        msg.style.display = "block";
        msg.innerText = error.replaceAll("_", " ");

        setTimeout(() => {
            msg.style.opacity = "0";
        }, 3500);

        setTimeout(() => {
            msg.style.display = "none";
        }, 4000);
    }
}





const registerForm = document.querySelector('.register form');
const registerError = document.getElementById('registerError');
let passwordInput = null;
let emailInput = null;

function showRegisterError(message) {
    if (!registerError) return;
    registerError.textContent = message;
    registerError.style.display = 'block';
}

function clearRegisterError() {
    if (!registerError) return;
    registerError.textContent = '';
    registerError.style.display = 'none';
}

if (registerForm) {
    passwordInput = registerForm.querySelector('input[name="password"]');
    emailInput = registerForm.querySelector('input[name="email"]');

    passwordInput.addEventListener("input", () => {
        const value = passwordInput.value;

        const hasUpper = /[A-Z]/.test(value);
        const hasNumber = /[0-9]/.test(value);
        const hasLength = value.length >= 6;

        if(value.length === 0) {
            clearRegisterError();
            return;
        }

        if(!hasLength){
            showRegisterError("Mínimo 6 caracteres");
        } else if(!hasUpper){
            showRegisterError("Agrega una mayúscula");
        } else if(!hasNumber){
            showRegisterError("Agrega un número");
        } else {
            clearRegisterError();
        }
    });

    //  VALIDACIÓN FINAL 
    registerForm.addEventListener("submit", function(e){

        const password = passwordInput.value;
        const email = emailInput.value;

    const hasUpper = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSymbol = /[\W]/.test(password);

    //  validar correo
    if(!email.includes("@")){
        e.preventDefault();
        showRegisterError("Correo inválido");
        return;
    }

    //  validar contraseña completa
    if(password.length < 6){
        e.preventDefault();
        showRegisterError("La contraseña debe tener mínimo 6 caracteres");
        return;
    }

    if(!hasUpper){
        e.preventDefault();
        showRegisterError("Debe incluir una mayúscula");
        return;
    }

    if(!hasNumber){
        e.preventDefault();
        showRegisterError("Debe incluir un número");
        return;
    }

    });
}

const container = document.getElementById("container");

if (container) {
    const btnRegister = document.getElementById("btnRegister");
    const btnLogin = document.getElementById("btnLogin");
    const btnRecover = document.getElementById("btnRecover");
    const showRecover = document.getElementById("showRecover");

    if (btnRegister) {
        btnRegister.onclick = () => {
            container.classList.add("show-register");
            container.classList.remove("show-recover");
        };
    }

    if (btnLogin) {
        btnLogin.onclick = () => {
            container.classList.remove("show-register");
            container.classList.remove("show-recover");
        };
    }

    if (btnRecover) {
        btnRecover.onclick = () => {
            container.classList.add("show-recover");
            container.classList.remove("show-register");
        };
    }

    if (showRecover) {
        showRecover.onclick = () => {
            container.classList.add("show-recover");
        };
    }
}

document.querySelectorAll(".password-container").forEach(container => {

    const input = container.querySelector("input");
    const icon = container.querySelector(".toggle-password");

    icon.addEventListener("click", () => {

        if(input.type === "password"){
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }else{
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }

    });

});
