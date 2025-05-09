var app = new Vue({
	el: "#app",
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		newData: {
			target_pengujian: "",
			metode_pengujian: "",
			ruangid: "",
			nama_ruang: "",
		},
		currentData: {},
		nilaiRuang: [],
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

			axios
				.post("proses.php", {
					request: "create",
					target_pengujian: this.newData.target_pengujian,
					metode_pengujian: this.newData.metode_pengujian,
					ruangid: this.newData.ruangid,
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
					//target_pengujian: this.currentData.target_pengujian,
					//metode_pengujian: this.currentData.metode_pengujian,
					//ruangid: this.currentData.ruangid,
				})
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.idtarget === this.currentData.idtarget
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
			const fields = ["target_pengujian"];
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
				target_pengujian: "",
				metode_pengujian: "",
			};
		},
		//mengambil data Ruang
		getDataRuang() {
			axios
				.post("proses.php", { request: "ambildataruang" })
				.then((response) => {
					this.nilaiRuang = response.data;
					console.log("Nilai Ruang:", this.nilaiRuang); // Menampilkan daftar nama ruang di konsol
				})
				.catch((error) => console.log(error));
		},
	},

	mounted() {
		this.tampildata();
		this.getDataRuang();
		var addDataModalElement = document.getElementById("addDataModal");
	},
});
