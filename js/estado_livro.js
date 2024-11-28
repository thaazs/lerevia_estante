
async function AtualizarStatus(id, status) {

    const idUsuario = sessionStorage.getItem('id');

    if (!idUsuario) {
        window.location.href = "../../../login.html";
    }

    try {
        const response = await fetch('http://localhost/lerevia/database/estado_livro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                id_usuario: idUsuario,
                id_livro: id,
                id_status: status,
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
}