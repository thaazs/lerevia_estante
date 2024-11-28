document.addEventListener("DOMContentLoaded", async () => {

    const lidoDiv = "#tab-lidos > div";
    const lendoDiv = "#tab-lendo > div";
    const favoritoDiv = "#tab-favoritos > div";
    const queroLerDiv = "#tab-queroLer > div";

    
    const idUsuario = sessionStorage.getItem('id');
    const status_lido = 1;
    const status_lendo = 2;
    const status_quero_ler = 3;
    const status_favorito = 4;
    
    await PopularLido();
    await PopularLendo();
    await PopularQueroLer();
    await PopularFavorito();

    async function PopularLido() {
        const livros = await CarregarLivros(idUsuario, status_lido);
        if (livros) {

            livros.forEach(livro => {
                PopularEstante(livro.capa_url, livro.titulo, livro.pagina_url, lidoDiv);
            });
        }
    }

    async function PopularLendo() {
        const livros = await CarregarLivros(idUsuario, status_lendo);

        if (livros) {

            livros.forEach(livro => {
                PopularEstante(livro.capa_url, livro.titulo, livro.pagina_url, lendoDiv);
            });
        }
    }


    async function PopularQueroLer() {

        const livros = await CarregarLivros(idUsuario, status_quero_ler);

        if (livros) {

            livros.forEach(livro => {
                PopularEstante(livro.capa_url, livro.titulo, livro.pagina_url, queroLerDiv);
            });
        }
    }

    async function PopularFavorito() {

        const livros = await CarregarLivros(idUsuario, status_favorito);

        if (livros) {

            livros.forEach(livro => {
                PopularEstante(livro.capa_url, livro.titulo, livro.pagina_url, favoritoDiv);
            });
        }
    }

    function PopularEstante(imagemPath, Titulo, PaginaLivro, containerId) {
        const container = document.querySelector(containerId);

        if (container) {
            const wrapper = document.createElement('div');
            wrapper.style.textAlign = 'center';
            wrapper.style.marginBottom = '16px';
            wrapper.style.display = 'inline-block';
            wrapper.style.margin = '8px';

            const link = document.createElement('a');
            link.href = PaginaLivro;

            const newImage = document.createElement('img');
            newImage.src = imagemPath;

            link.appendChild(newImage);

            const text = document.createElement('span');
            text.textContent = Titulo;
            text.style.display = 'block';
            text.style.marginTop = '8px';

            wrapper.appendChild(link);
            // wrapper.appendChild(text);

            container.appendChild(wrapper);
        }
    }


    async function CarregarLivros(id_usuario, id_status) {
        try {
            const response = await fetch('http://localhost/lerevia/database/carregar_estante.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },

                body: new URLSearchParams({
                    id_usuario: id_usuario,
                    id_status: id_status,
                }),
            });

            const data = await response.json();

            if (data.success) {
                return data.livros;
            } else {
                return false;
            }
        } catch (error) {
            alert("Erro: " + error.message);
            return false;
        }
    }

});
