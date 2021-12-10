
// function check() {
//     let elem = document.getElementById("resultRecherche");
//     if (typeof elem !== 'undefined' && elem !== null) {
//         document.getElementById("resultRecherche").style.display="none";
//     }
// }

function recherche() {
    let elem = document.getElementById("resultRecherche");
    if (elem.style.display === "none") {
        elem.style.display="block";
    }
}