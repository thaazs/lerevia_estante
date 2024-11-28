document.addEventListener("DOMContentLoaded", () => {
    const salvarAlteracaoPerfilButton = document.getElementById("salvar-alteracao-perfil");

    salvarAlteracaoPerfilButton.addEventListener("click", async (event) => {
        event.preventDefault();
        let id = sessionStorage.getItem('id');
        let senha = document.getElementById("editar-perfil-senha").value;

        try {
            const response = await fetch('http://localhost/lerevia/database/alterar_senha.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    id: id,
                    senha: senha,
                }),
            });

            const data = await response.json();
            if (data.success) {
                alert(data.message)
                return true;
            } else {
                alert(data.message);
                return false;
            }
        } catch (error) {
            alert(data.message);
            return false;
        }
    });
});