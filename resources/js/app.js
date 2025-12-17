import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

// Test Vite: Convertir euros en francs
const convertBtn = document.querySelector("#convertir");
if (convertBtn) {
    convertBtn.addEventListener("click", calculer, false);
}

function calculer() {
    let euros = document.querySelector("#euros");
    let valeur = euros.value;
    if (Number.isNaN(Number(valeur)) || valeur === '') {
        alert("Le montant en euros n'est pas un nombre !");
        euros.focus();
    }
    else {
        let francs = document.querySelector("#francs");
        francs.innerHTML = (valeur * 6.55957).toFixed(2);
    }
}
