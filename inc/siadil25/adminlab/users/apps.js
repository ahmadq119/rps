var app = new Vue({
	el: "#app",
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		newData: {
			userid: "",
			nama: "",
			username: "",
			password: "",
			email: "",
			no_contact: "",
			ruangid: "",
			nama_ruang: "",
		},
		currentData: {},
		namaRuang: [],
	},
	methods: {
		sesi() {
			axios
				.post("../../Login/proses.php", { request: "check_session" }) // Menggunakan request untuk memeriksa data session
				.then((response) => {
					if (response.data.status === "success") {
						this.userid = response.data.userid; // Mendapatkan userid dari session
					} else {
						window.location.href = "../../Login/index.html"; // Redirect jika sesi tidak valid
					}
				})
				.catch((error) => console.log("Fetch error: ", error));
		},
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
			if (!this.newData.ruangid) {
				alert("Harap pilih Ruang/Bagian yang valid.");
				return;
			}
			console.log("Data yang akan dikirim:", this.newData); // Menampilkan data yang akan dikirim
			axios
				.post("proses.php", {
					request: "create",
					nama: this.newData.nama,
					username: this.newData.username,
					password: this.newData.password,
					email: this.newData.email,
					no_contact: this.newData.no_contact,
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
					nama: this.currentData.nama,
					username: this.currentData.username,
					password: this.currentData.password,
					email: this.currentData.email,
					no_contact: this.currentData.no_contact,
					ruangid: this.currentData.ruangid,
				})
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.userid === this.currentData.userid
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
			const fields = ["username", "password"];
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
				nama: "",
				username: "",
				password: "",
				email: "",
				no_contact: "",
				ruangid: "",
				nama_ruang: "",
			};
		},

		// merubah nilai dari nama_ruang ke ruangid
		updateRuangid(event) {
			const selectedRuang = this.namaRuang.find(
				(nr) => nr.nama_ruang === event.target.value
			);
			if (selectedRuang) {
				this.newData.ruangid = selectedRuang.ruangid;
				console.log("Ruang ID:", this.newData.ruangid); // Log untuk memastikan ruangid diisi dengan benar
			} else {
				this.newData.ruangid = "";
				console.log("Ruang ID kosong"); // Log jika tidak ada ruangan yang cocok
			}
		},

		//mengambil data Nama Ruang
		getNamaRuang() {
			axios
				.post("proses.php", { request: "ambildataruang" })
				.then((response) => {
					this.namaRuang = response.data;
					console.log("Nama Ruang:", this.namaRuang); // Menampilkan daftar nama ruang di konsol
				})
				.catch((error) => console.log(error));
		},
	},

	mounted() {
		this.sesi();
		this.tampildata();
		this.getNamaRuang();
		var addDataModalElement = document.getElementById("addDataModal");
	},
});
