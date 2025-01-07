// js/scripts.js

// Contoh: Konfirmasi sebelum menghapus surat
document.addEventListener('DOMContentLoaded', () => {
    const deleteLinks = document.querySelectorAll('a[href*="delete_surat.php"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            if (!confirm('Apakah Anda yakin ingin menghapus surat ini?')) {
                e.preventDefault();
            }
        });
    });
});
