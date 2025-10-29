// public/js/script.js

document.addEventListener("DOMContentLoaded", function() {
    
    // Ambil semua tombol hapus
    const tombolHapus = document.querySelectorAll('.btn-hapus');
    
    // Tambahkan event listener untuk setiap tombol
    tombolHapus.forEach(function(tombol) {
        tombol.addEventListener('click', function(event) {
            // Tampilkan pesan konfirmasi
            const konfirmasi = confirm('Apakah Anda yakin ingin menghapus data ini?');
            
            // Jika pengguna membatalkan (klik "Cancel")
            if (!konfirmasi) {
                // Hentikan aksi default (pindah halaman)
                event.preventDefault();
            }
        });
    });

});