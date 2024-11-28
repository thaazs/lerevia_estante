// Abrir e fechar o modal ao clicar em "Adicionar à estante"
const addShelfBtn = document.getElementById('addShelfBtn');
const modal = document.getElementById('modal');
const closeModalBtn = document.getElementById('closeModalBtn');

addShelfBtn.addEventListener('click', () => {
  modal.style.display = 'flex';
});

// Fechar o modal ao clicar no botão de fechar
closeModalBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

// Fechar o modal ao clicar em qualquer botão
const modalButtons = modal.querySelectorAll('button');
modalButtons.forEach(button => {
  button.addEventListener('click', () => {
    modal.style.display = 'none';
  });
});