document.addEventListener('DOMContentLoaded', ()=>{

  // Live search: listen on input
  const searchInput = document.getElementById('globalSearch');
  const resultsBox = document.getElementById('searchResultsBox');

  if (searchInput) {
    let timer = null;
    searchInput.addEventListener('input', (e)=>{
      clearTimeout(timer);
      const q = e.target.value.trim();
      if (q.length < 2) {
        resultsBox.innerHTML = '';
        resultsBox.style.display = 'none';
        return;
      }
      timer = setTimeout(()=> {
        fetch('search.php?q=' + encodeURIComponent(q))
          .then(r=>r.json())
          .then(data=>{
            resultsBox.innerHTML = '';
            if (data.length === 0) {
              resultsBox.innerHTML = '<div class="p-2 text-muted">No results</div>';
            } else {
              data.forEach(item=>{
                const div = document.createElement('div');
                div.className = 'search-item';
                div.innerHTML = `<a href="${item.url}">${item.type}: ${item.title}</a>
                                 <div class="small text-muted">${item.snippet || ''}</div>`;
                resultsBox.appendChild(div);
              });
            }
            resultsBox.style.display = 'block';
          }).catch(err=>{
            console.error(err);
            resultsBox.style.display='none';
          });
      }, 300);
    });

    document.addEventListener('click', (ev)=>{
      if (!searchInput.contains(ev.target)) {
        resultsBox.style.display = 'none';
      }
    });
  }

});
