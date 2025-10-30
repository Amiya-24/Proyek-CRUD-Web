document.addEventListener("DOMContentLoaded", function() {
    
    const tombolHapus = document.querySelectorAll('.btn-hapus');
    
    tombolHapus.forEach(function(tombol) {
        tombol.addEventListener('click', function(event) {
            const konfirmasi = confirm('Apakah Anda yakin ingin menghapus data ini?');
            
            if (!konfirmasi) {
                event.preventDefault();
            }
        });
    });

});