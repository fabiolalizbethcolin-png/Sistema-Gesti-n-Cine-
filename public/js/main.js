// js/main.js

function calculaTotal() {
    const precio = parseFloat(document.getElementById('precio_unit').value) || 0;
    const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
    const total = precio * cantidad;
    document.getElementById('total').value = total.toFixed(2);
}

window.addEventListener('load', calculaTotal);

// Botones + y -
document.getElementById('btnSumar').addEventListener('click', () => {
    let c = parseInt(document.getElementById('cantidad').value);
    const max = parseInt(document.getElementById('cantidad').max);

    if (c < max) {
        document.getElementById('cantidad').value = c + 1;
        calculaTotal();
    }
});

document.getElementById('btnRestar').addEventListener('click', () => {
    let c = parseInt(document.getElementById('cantidad').value);

    if (c > 1) {
        document.getElementById('cantidad').value = c - 1;
        calculaTotal();
    }
});
