function getConcerti() {
    fetch("/Es11_PHP/api/get/concerti.php")
        .then(res => res.json())
        .then(data => {
            buildConcertiTable(data);
        });
}

function buildConcertiTable(array) {
    const wrapper = document.getElementById("concertiWrapper");
    wrapper.innerHTML = "";

    if(array.length > 0) {
        const headerRow = document.createElement("tr");
        const headers = Object.keys(array[0]).filter(key => key !== "id");
        headers.forEach(key => {
            const header = document.createElement("th");
            header.textContent = key;
            headerRow.appendChild(header);
        });
        wrapper.appendChild(headerRow);
    }

    array.forEach(concerto => {
        const row = document.createElement("tr");

        const keys = Object.keys(concerto).filter(key => key !== "id");
        keys.forEach(key => {
            const cell = document.createElement("td");
            cell.textContent = concerto[key];

            row.appendChild(cell);
        });
    
        wrapper.appendChild(row);
    });
}

// events
document.addEventListener("DOMContentLoaded", getConcerti);