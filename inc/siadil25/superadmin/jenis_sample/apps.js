var app = new Vue({
	el: "#app",
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		newData: {
			nama_sample: "",
			idsatuan: "",
			idkelompok: "",
			satuan: "",
			kelompok: "",
		},
		currentData: {},
		nilaiSatuan: [],
		nilaiKelompok: [],
	},
	methods: {
		tampildata() {
			axios
				.post("proses.php", { request: "tampil" })
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
		},
		caridata() {
			axios
				.post("proses.php", { request: "read", searchQuery: this.searchQuery })
				.then((response) => {
					this.info = response.data;
					if (this.info.length === 0) {
						this.searchMessage = "Pencarian tidak ditemukan.";
					} else {
						this.searchMessage = "";
					}
					// Set timeout to clear the message after 3 seconds
					setTimeout(() => {
						this.searchMessage = "";
					}, 3000);
				})
				.catch((error) => {
					console.log(error);
					this.searchMessage = "Terjadi kesalahan saat melakukan pencarian.";
					// Set timeout to clear the message after 3 seconds
					setTimeout(() => {
						this.searchMessage = "";
					}, 3000);
				});
		},
		tambahData() {
			if (!this.validateForm(this.newData)) {
				alert("Harap isi semua field yang diperlukan.");
				return;
			}

			if (!this.newData.satuan) {
				alert("Harap pilih Satuan yang valid.");
				return;
			}

			console.log("Data yang akan dikirim:", this.newData); // Menampilkan data yang akan dikirim
			axios
				.post("proses.php", {
					request: "create",
					nama_sample: this.newData.nama_sample,
					idsatuan: this.newData.satuan,
					idkelompok: this.newData.kelompok,
				})
				.then((response) => {
					this.info.push(response.data);
					this.resetForm();
					var addDataModal = bootstrap.Modal.getInstance(
						document.getElementById("addDataModal")
					);
					addDataModal.hide();
					alert("Data berhasil disimpan!"); // Show success message
					this.tampildata(); // Data dalam table direfresh
				})
				.catch((error) => {
					alert("Terjadi kesalahan saat menambahkan data. Silakan coba lagi.");
					console.log(error);
				});
		},

		editData(index, data) {
			this.currentData = Object.assign({}, data);
			var editDataModal = new bootstrap.Modal(
				document.getElementById("editDataModal")
			);
			editDataModal.show();
		},
		updateData() {
			if (!this.validateForm(this.currentData)) {
				alert("Harap isi semua field yang diperlukan.");
				return;
			}
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
					nama_sample: this.currentData.nama_sample,
					idsatuan: this.currentData.idsatuan,
					idkelompok: this.currentData.idkelompok,
				})
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.idsample === this.currentData.idsample
					);
					if (index !== -1) {
						this.info.splice(index, 1, response.data);
					}
					var editDataModal = bootstrap.Modal.getInstance(
						document.getElementById("editDataModal")
					);
					editDataModal.hide();
					alert("Data berhasil diupdate!"); // Show success message
					//this.tampildata(); //Data dalam table direfresh
				})
				.catch((error) => {
					alert("Terjadi kesalahan saat mengupdate data. Silakan coba lagi.");
					console.log(error);
				});
		},

		validateForm(data) {
			const fields = ["nama_sample"];
			for (const field of fields) {
				if (!data[field]) {
					console.log(`Field ${field} is empty`);
					return false;
				}
			}
			return true;
		},
		resetForm() {
			this.newData = {
				nama_sample: "",
				idkelompok: "",
				idsatuan: "",
				kelompok: "",
				satuan: "",
			};
		},

		//mengambil data Satuan
		getDataSatuan() {
			axios
				.post("proses.php", { request: "ambildatasatuan" })
				.then((response) => {
					this.nilaiSatuan = response.data;
					console.log("Nilai Satuan:", this.nilaiSatuan); // Menampilkan daftar nama ruang di konsol
				})
				.catch((error) => console.log(error));
		},

		//mengambil data Kelompok
		getDataKelompok() {
			axios
				.post("proses.php", { request: "ambildatakelompok" })
				.then((response) => {
					this.nilaiKelompok = response.data;
					console.log("Nilai Kelompok:", this.nilaiKelompok); // Menampilkan daftar nama ruang di konsol
				})
				.catch((error) => console.log(error));
		},
	},

	mounted() {
		this.tampildata();
		this.getDataSatuan();
		this.getDataKelompok();
		var addDataModalElement = document.getElementById("addDataModal");
	},
});
