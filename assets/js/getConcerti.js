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

    array.forEach(concerto => {
        const row = document.createElement("div");
        const text = document.createElement("span");
        const button = document.createElement("button");

        // button.textContent = "edit";
        
        let ans = "";

        const keys = Object.keys(concerto).filter(key => key !== "id");
        keys.forEach(key => {
            console.log(key)
            ans += concerto[key] + " ";
        });

        text.textContent = ans;

        row.append(text, button);
        wrapper.appendChild(row);
    });
}

// events
document.addEventListener("DOMContentLoaded", getConcerti);