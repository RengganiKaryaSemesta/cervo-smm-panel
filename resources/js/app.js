import '../css/app.css'
import Quagga from 'quagga';

window.Quagga = Quagga

document.addEventListener('livewire:navigating', () => {
    const htmlElement = document.querySelector('html');
    if (htmlElement.classList.contains('sidenav-enable')) {
        htmlElement.classList.remove('sidenav-enable');
    }
})
document.addEventListener('livewire:navigated', () => {
    const selectInput = document.querySelectorAll('.selectize-input');
    selectInput.forEach(data => {
        const inputElement = data.querySelector('input');
        if (inputElement) { // Pastikan elemen input ditemukan
            inputElement.style.width = 'auto';
        }
    })
})
Alpine.store('utilities', {
    formatRupiah(num) {
        if (!isNaN(num))
            return num.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
    },
    formatFloat(num) {
        return parseFloat(num.replace(/\./g, '').replace(',', '.'))
    }
})
  