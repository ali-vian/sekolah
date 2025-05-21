// modal absen
function showModal(tanggal) {
    // Isi modal dengan data dinamis
    document.getElementById("modal-tanggal").innerHTML =
        "Anda mengklik tanggal: " + tanggal;
    var dayModal = new bootstrap.Modal(document.getElementById("dayModal"));
    dayModal.show();
}

// detail absen
// document.addEventListener("DOMContentLoaded", function () {
//     var detailAbsenModal = document.getElementById("detailAbsenModal");
//     detailAbsenModal.addEventListener("show.bs.modal", function (event) {
//         var button = event.relatedTarget;
//         var guruName = button.getAttribute("data-guru-name");
//         var tanggal = button.getAttribute("data-tanggal");
//         var jamMasuk = button.getAttribute("data-jam-masuk");
//         var status = button.getAttribute("data-status");
//         var idAbsen = button.getAttribute("data-id-absen");

//         document.getElementById("detailGuruName").textContent = guruName;
//         document.getElementById("detailTanggal").textContent = tanggal;
//         document.getElementById("detailJamMasuk").textContent = jamMasuk;
//         document.getElementById("detailStatus").textContent = status;
//         document.getElementById("detailIdAbsen").textContent = idAbsen;
//     });
// });

// Fungsi untuk menampilkan dropdown bulan jika opsi "Per Bulan" dipilih
function showMonthComboBox(select) {
    const id = select.id.split("_").pop();
    const monthCombo = document.getElementById("month_combo_" + id);
    monthCombo.style.display = select.value === "bulan" ? "block" : "none";
}

// Fungsi untuk menampilkan tabel rekap absen
function generateRekapTable(id) {
    const rekapType = document.getElementById("rekap_per_" + id).value;
    const selectedMonthElement = document.getElementById("bulan_" + id);
    const selectedMonth = selectedMonthElement
        ? selectedMonthElement.value
        : "";

    const semesterTable = document.getElementById("rekap_semester_table_" + id);
    const bulanTable = document.getElementById("rekap_bulan_table_" + id);

    // Sembunyikan tabel di awal
    semesterTable.style.display = "none";
    bulanTable.style.display = "none";

    // Tampilkan tabel sesuai pilihan pengguna
    if (rekapType === "semester") {
        semesterTable.style.display = "block";
    } else if (rekapType === "bulan") {
        if (selectedMonth) {
            bulanTable.style.display = "block";
        } else {
            alert("Pilih bulan terlebih dahulu.");
        }
    } else {
        alert("Pilih tipe rekap yang valid.");
    }
}

if (document.getElementById("tanggal")) {
    document.addEventListener("DOMContentLoaded", function () {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // sesuaikan timezone

        const formatted = now.toISOString().slice(0, 16); // ambil YYYY-MM-DDTHH:MM
        document.getElementById("tanggal").value = formatted;
    });
}

let semuaHadir = false;

function toggleHadir() {
    semuaHadir = !semuaHadir;

    document
        .querySelectorAll('.status-radio[value="Hadir"]')
        .forEach((radio) => {
            radio.checked = semuaHadir;
        });

    const btn = document.getElementById("btnHadir");

    if (semuaHadir) {
        btn.innerText = "Batalkan Semua Hadir";
        btn.classList.remove("btn-success");
        btn.classList.add("btn-danger");
    } else {
        btn.innerText = "Tandai Semua Hadir";
        btn.classList.remove("btn-danger");
        btn.classList.add("btn-success");
    }
}
