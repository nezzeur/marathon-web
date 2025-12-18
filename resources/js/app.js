import './bootstrap';
import 'alpinejs/dist/cdn.min.js';

import.meta.glob([
    '../images/**',
    '../fonts/**',
    '../sounds/**',
]);

const hoverSoundPath =  '/sounds/hover.mp3';
const insertSoundPath = '/sounds/insert.mp3';


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
document.addEventListener('DOMContentLoaded', () => {
    // Préchargement des sons pour éviter la latence
    const soundHover = new Audio(hoverSoundPath);
    const soundInsert = new Audio(insertSoundPath);

    // Réglage du volume
    soundHover.volume = 0.2;
    soundInsert.volume = 0.5;

    // Fonction utilitaire pour jouer un son sans erreur
    const playSound = (audioObj) => {
        // On clone le noeud pour permettre de jouer le son plusieurs fois très vite
        // (Sinon si on survole vite, le son se coupe)
        const sound = audioObj.cloneNode();
        sound.volume = audioObj.volume;

        sound.play().catch(e => {
            // Si le navigateur bloque l'autoplay (avant le 1er clic), on ne fait rien.
            // C'est normal et invisible pour l'utilisateur.
            console.log("Audio bloqué (en attente d'interaction utilisateur)");
        });
    };

    const cartridges = document.querySelectorAll('.js-cartridge');

    cartridges.forEach(el => {
        // --- HOVER ---
        el.addEventListener('mouseenter', () => {
            playSound(soundHover);
        });

        // --- CLICK ---
        el.addEventListener('click', (e) => {
            e.preventDefault();
            const url = el.getAttribute('href');

            // 1. Jouer le son d'insertion
            playSound(soundInsert);

            // 2. Animation CSS JS (Enfoncement)
            // On désactive les transitions de hover pour figer l'état
            el.classList.remove('hover:-translate-y-2', 'hover:scale-[1.01]');
            // On ajoute l'état "enfoncé"
            el.classList.add('translate-y-4', 'scale-95', 'brightness-90', 'duration-100');

            // 3. Navigation retardée
            setTimeout(() => {
                window.location.href = url;
            }, 500); // 500ms pour laisser le son se jouer
        });
    });
});