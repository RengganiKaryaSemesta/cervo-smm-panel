import '../css/app.css'
import Quagga from 'quagga';

window.Quagga = Quagga

document.addEventListener('livewire:navigating', () => {
    const htmlElement = document.querySelector('html');
    if (htmlElement.classList.contains('sidenav-enable')) {
        htmlElement.classList.remove('sidenav-enable');
    }
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
// Simulasi respons dari API
const apiResponse = {
    candidates: [
      {
        content: {
          parts: [
            {
              text: "```json\n[\n  {\n    \"comment\": \"MasyaAllah, Nagita selalu tampil memukau! 😍 Makanannya pun terlihat sangat menggiurkan.\"\n  },\n  {\n    \"comment\": \"Duh, Nagita bikin ngiler banget! 🤤 Resepnya apa, Kak Gigi? Pengen coba bikin sendiri.\"\n  },\n  {\n    \"comment\": \"Aduh, lapar banget liat postingan ini! 😋 Makanan kesukaan aku semua. Nagita emang selalu bisa bikin suasana jadi menyenangkan.\"\n  },\n  {\n    \"comment\": \"Wow, platingnya cantik banget! Selain itu makanannya juga keliatan super enak. Nagita selalu berhasil bikin aku terpesona.\"\n  },\n  {\n    \"comment\": \"Cakepnyaaa Nagita, makanannya juga menggoda banget! 🤩 Semoga sehat selalu ya, Kak Gigi dan keluarga.\"\n  }\n]\n```"
            }
          ]
        }
      }
    ]
  };
  
  // 1. Ekstrak teks mentah dari respons
  const rawText = apiResponse.candidates[0].content.parts[0].text;
  
  // 2. Bersihkan teks dari wrapping markdown
  const cleanedText = rawText
    .trim() // Hapus spasi atau baris kosong di awal/akhir
    .replace(/^```json\n/, '') // Hapus ` ```json\n ` di awal
    .replace(/```$/, ''); // Hapus ` ``` ` di akhir
  
  console.log('Cleaned Text:', cleanedText);
  
  // 3. Parse teks menjadi JSON valid
  try {
    const parsedResults = JSON.parse(cleanedText);
    console.log('Parsed JSON:', parsedResults);
  
    // 4. Akses komentar
    parsedResults.forEach(item => {
      console.log(item.comment);
    });
  } catch (error) {
    console.error('JSON Parsing Error:', error);
  }
  