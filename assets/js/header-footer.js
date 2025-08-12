function loadHTML(id, file) {
    fetch(file)
        .then(response => {
            if (!response.ok) throw new Error("HTTP error " + response.status);
            return response.text();
        })
        .then(data => {
            document.getElementById(id).innerHTML = data;
        })
        .catch(err => {
            console.error('Error loading ' + file + ':', err);
        });
}