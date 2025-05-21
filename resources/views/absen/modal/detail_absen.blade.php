<!-- Detail Absen Modal -->
<div class="modal fade" id="detailAbsenModal" tabindex="-1" aria-labelledby="detailAbsenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailAbsenModalLabel">Detail Absen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Guru:</strong> <span id="detailGuruName"></span></p>
                <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
                <p><strong>Jam:</strong> <span id="detailJamMasuk"></span></p>
                <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                <span class="d-none" id="detailIdAbsen"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="btnDeleteAbsen">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('btnDeleteAbsen').addEventListener('click', function () {
    const absenId = document.getElementById('detailIdAbsen').textContent;

    if (!absenId) {
        alert("ID Absen tidak ditemukan!");
        return;
    }

    if (!confirm("Yakin ingin menghapus data absen ini?")) return;

    fetch(`/absen/${absenId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) throw new Error("Gagal menghapus data.");
        return response.json();
    })
    .then(data => {
        alert("Data berhasil dihapus.");

        // Tutup modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('yourModalId')); // Ganti dengan ID modal kamu
        modal.hide();

        // Refresh tabel atau hapus elemen dari DOM jika perlu
        // misalnya: document.getElementById(`row-${absenId}`).remove();
    })
    .catch(error => {
        console.error(error);
        alert("Terjadi kesalahan saat menghapus data.");
    });
});
</script>
