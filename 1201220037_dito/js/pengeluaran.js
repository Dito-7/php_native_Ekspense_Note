document.addEventListener("DOMContentLoaded", (event) => {
    let form = document.querySelector("form");
    let historyList = document.querySelector(".history_list");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // Mengambil nilai dari input
        let pengeluaran_ = document.getElementById("pengeluaran_").value;
        let kategori = document.getElementById("kategori").value;
        let Keterangan = document.getElementById("Keterangan").value;

        // Menambahkan input ke daftar histori
        addDaftarPengeluaran(pengeluaran_, kategori, Keterangan);

        // Mengosongkan formulir setelah input ditambahkan
        form.reset();
    });

    // Fungsi untuk menambahkan input ke daftar histori
    function addDaftarPengeluaran(pengeluaran_, kategori, Keterangan) {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${pengeluaran_}</td>
            <td>${getKategoriName(kategori)}</td>
            <td>${Keterangan}</td>
            <td></td>
        `;
        historyList.appendChild(row);
    }

    // Fungsi untuk mendapatkan nama kategori berdasarkan nilai kategori
    function getKategoriName(kategori) {
        switch (kategori) {
            case "1":
                return "Makanan";
            case "2":
                return "Transportasi";
            case "3":
                return "Hiburan";
            case "4":
                return "Lainnya";
            default:
                return "Tidak Diketahui";
        }
    }
});
