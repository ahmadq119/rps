var app = new Vue({
	el: "#app",
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		newData: {
			nama_customer: "",
			instansi_perusahaan: "",
			alamat_customer: "",
			no_contact: "",
			email: "",
		},
		currentData: {},
	},
	methods: {
		tampildata() {
			axios
				.post("proses.php", { request: "tampil" })
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
		},
		hapus(index, idcustomer) {
			axios
				.post("proses.php", { request: "delete", idcustomer: idcustomer })
				.then(() => this.info.splice(index, 1))
				.catch((error) => console.log(error));
		},
		confirmHapus(index, idcustomer) {
			if (confirm("Apakah record ini akan dihapus?")) {
				this.hapus(index, idcustomer);
			}
		},
		caridata() {
			axios
				.post("proses.php", { request: "cari", searchQuery: this.searchQuery })
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
					nama_customer: this.newData.nama_customer,
					instansi_perusahaan: this.newData.instansi_perusahaan,
					alamat_customer: this.newData.alamat_customer,
					no_contact: this.newData.no_contact,
					email: this.newData.email,
				})
				.then((response) => {
					this.info.push(response.data);
					this.resetForm();
					var addDataModal = bootstrap.Modal.getInstance(
						document.getElementById("addDataModal")
					);
					addDataModal.hide();
					alert("Data berhasil disimpan!"); // Show success message
					this.tampildata(); //Data dalam table direfresh
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
				.post("proses.php", { request: "edit", currentData: this.currentData })
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.idcustomer === this.currentData.idcustomer
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
			const fields = [
				"nama_customer",
				"alamat_customer",
				"no_contact",
				"email",
			];
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
				nama_customer: "",
				instansi_perusahaan: "",
				alamat_customer: "",
				no_contact: "",
				email: "",
			};
		},
	},

	mounted() {
		this.tampildata();
		var addDataModalElement = document.getElementById("addDataModal");
	},
});
