var app = new Vue({
	el: "#app",
	data: {
		newData: {
			laporan: "",
			tahun: "",
			bulan: "",
		},
		dataTahun: [],
		dataBulan: [],
	},
	methods: {
		getDataBulan() {
			axios
				.post("proses.php", { request: "ambildatabulan" })
				.then((response) => {
					this.dataBulan = response.data; // Simpan data dari server
				})
				.catch((error) =>
					console.log("Error saat mengambil data bulan:", error)
				);
		},
		getDataTahun() {
			axios
				.post("proses.php", { request: "ambildatatahun" })
				.then((response) => {
					this.dataTahun = response.data; // Simpan data dari server
				})
				.catch((error) =>
					console.log("Error saat mengambil data tahun:", error)
				);
		},

		printData() {
			const laporan = this.newData.laporan;
			const bulan = this.newData.bulan;
			const tahun = this.newData.tahun;

			let url = "";

			// Validasi input
			if (!laporan) {
				alert("Anda belum memilih jenis laporan!");
				return;
			}
			if (!bulan) {
				alert("Anda belum memilih bulan!");
				return;
			}
			if (!tahun) {
				alert("Anda belum memilih tahun!");
				return;
			}

			// Cek nilai laporan untuk menentukan URL
			if (laporan == 1) {
				url = `print_penerimaan.php?bulan=${bulan}&tahun=${tahun}`;
			} else if (laporan == 2) {
				url = `print_penanganan.php?bulan=${bulan}&tahun=${tahun}`;
			} else {
				alert("Jenis laporan tidak valid!");
				return;
			}

			// Buka URL di tab baru
			window.open(url, "_blank");
		},
	},
	mounted() {
		this.getDataBulan();
		this.getDataTahun();
	},
});
