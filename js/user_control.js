
document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login-button");
    const createAccountButton = document.getElementById("criar-conta-button");

    loginButton.addEventListener("click", async (event) => {
        event.preventDefault();

        const email = document.getElementById("email-login").value;
        const password = document.getElementById("senha-login").value;

        if (!email || !password) {
            alert("Por favor, preencha todos os campos!");
            return;
        }

        if (!email.match(/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/)) {
            alert("O e-mail deve ser válido");
            return;
        }

        var result = await login(email, password);
        if (result == false) {
            return
        }
        window.location.href = "/index.html";
    });


    createAccountButton.addEventListener("click", async (event) => {
        event.preventDefault()

        const nome = document.getElementById("nome-criar-conta").value;
        const email = document.getElementById("email-criar-conta").value;
        const password = document.getElementById("senha-criar-conta").value;

        if (!email || !password || !nome) {
            alert("Por favor, preencha todos os campos!");
            return;
        }

        if (password.length <= 7) {
            alert("Senha deve ser valida");
            return;
        }

        if (!email.match(/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/)) {
            alert("O e-mail deve ser válido");
            return;
        }

        var result = createUser(nome, email, password);
        if (!result) {
            return
        }

        alert("Conta criada com sucesso");
        window.location.href = "login.html";
    });


});

async function login(email, password) {
    try {
        const response = await fetch('http://localhost/lerevia/database/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                email: email,
                senha: password,
            }),
        });

        const data = await response.json();
        if (data.success) {
            return true;
        } else {
            alert(data.message);
            return false;
        }
    } catch (error) {
        alert(data.message);
        return false;
    }
}


async function login(email, password) {
    try {
        const response = await fetch('http://localhost/lerevia/database/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                email: email,
                senha: password,
            }),
        });

        const data = await response.json();
        if (data.success) {
            sessionStorage.setItem('nome', data.nome);
            sessionStorage.setItem('id', data.id);
            sessionStorage.setItem('email', data.email);
            return true;
        } else {
            alert(data.message);
            return false;
        }
    } catch (error) {
        alert(data.message);
        return false;
    }
}

async function createUser(nome, email, password) {
    try {
        const response = await fetch('http://localhost/lerevia/database/create_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                nome: nome,
                email: email,
                senha: password,
            }),
        });

        const data = await response.json();
        if (data.success) {
            return true;
        } else {
            alert(data.message);
            return false;
        }
    } catch (error) {
        alert(data.message);
        return false;
    }
}

function GerenciarRotaLogin() {
    const nomeUsuario = sessionStorage.getItem('nome');
    if (nomeUsuario) {
        window.location.href = "perfil.html";
    } else {
        window.location.href = "login.html";
    }
}
