function GerenciarRotaLogin(path) {
    const nomeUsuario = sessionStorage.getItem('nome');
    if (nomeUsuario) {
        window.location.href = path + "perfil.html";
    } else {
        window.location.href = path + "login.html";
    }
}