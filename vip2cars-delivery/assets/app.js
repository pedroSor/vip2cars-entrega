document.addEventListener('DOMContentLoaded', function () {
  const btnTable = document.getElementById('btn-table');
  const btnCards = document.getElementById('btn-cards');
  const tableView = document.getElementById('table-view');
  const cardsView = document.getElementById('cards-view');
  const search = document.getElementById('search');

  function setView(view) {
    if (view === 'cards') {
      tableView.classList.add('d-none');
      cardsView.classList.remove('d-none');
      btnCards.classList.add('active');
      btnTable.classList.remove('active');
    } else {
      tableView.classList.remove('d-none');
      cardsView.classList.add('d-none');
      btnTable.classList.add('active');
      btnCards.classList.remove('active');
    }
  }

  btnTable.addEventListener('click', () => setView('table'));
  btnCards.addEventListener('click', () => setView('cards'));

  function normalize(s){ return (s||'').toString().toLowerCase(); }

  function filterAll(q){
    q = normalize(q);
    // filter table rows
    document.querySelectorAll('#table-view tbody tr').forEach(row=>{
      const text = normalize(row.textContent);
      row.style.display = text.includes(q) ? '' : 'none';
    });
    // filter cards
    document.querySelectorAll('.vehicle-card').forEach(card=>{
      const text = card.getAttribute('data-search') || '';
      card.style.display = text.includes(q) ? '' : 'none';
    });
  }

  let timeout = null;
  search.addEventListener('input', (e)=>{
    clearTimeout(timeout);
    timeout = setTimeout(()=> filterAll(e.target.value), 150);
  });

});
