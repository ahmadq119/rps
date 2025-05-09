var app = new Vue({
	el: "#app",
	data: {
		info: [],
		nilaiOrganTarget: [],
		selectedTargets: [],
		searchQuery: "",
		searchMessage: "",
		currentData: {
			id: "",
			kd_sample: "",
			tgl_terima: "",
		},
	},
	methods: {
		tampildata(kd_sample) {
			console.log("Mengirim kd_sample ke server:", kd_sample); // Debug log
			axios
				.post("proses.php", { request: "tampilawal", kd_sample })
				.then((response) => {
					console.log("Data yang diterima dari server:", response.data); // Debug log
					this.info = response.data;
				})
				.catch((error) => {
					console.error("Error saat mengambil data:", error);
				});
		},

		navigateToDaftarSample() {
			const url = `../daftar_sample/`;
			//const kd_sample = currentData.kd_sample;
			console.log("URL yang akan dibuka:", url); // Debug URL

			// Buka halaman baru
			//window.open(url, "_self"); // '_blank' membuka di tab baru
			window.location.href = `../daftar_sample/index.php`;
		},

		caridata() {
			axios
				.post("proses.php", {
					request: "caridata",
					searchQuery: this.searchQuery,
				})
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

		updateOrganTarget() {
			if (this.selectedTargets.length === 0) {
				alert("Silakan pilih setidaknya satu organ target.");
				return;
			}

			axios
				.post("proses.php", {
					request: "updateOrganTarget",
					currentData: this.currentData,
					organ_target: this.selectedTargets.join(", "),
				})
				.then((response) => {
					if (response.data.success) {
						alert("Data berhasil diperbarui!");
						this.tampildata(this.currentData.kd_sample); // Refresh data
						var ModalDisposisi = bootstrap.Modal.getInstance(
							document.getElementById("ModalDisposisi")
						);
						ModalDisposisi.hide();
					} else {
						alert("Gagal memperbarui data: " + response.data.message);
					}
				})
				.catch((error) => {
					alert("Terjadi kesalahan saat memperbarui data.");
					console.error("Error:", error);
				});
		},

		isiData(index, data) {
			Object.keys(data).forEach((key) => {
				this.$set(this.currentData, key, data[key]);
			});
			console.log("Data Setelah Diset: ", this.currentData);
			var ModalDisposisi = new bootstrap.Modal(
				document.getElementById("ModalDisposisi")
			);
			ModalDisposisi.show();
		},

		addData() {
			if (!this.validateForm(this.currentData)) {
				alert("Harap isi semua field yang diperlukan.");
				return;
			}
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
					nama_organ: this.selectedTargets,
				})
				.then((response) => {
					console.log(
						"Response dari server:",
						response.data,
						this.selectedTargets
					);
					if (response.data.success && response.data.updatedData) {
						let index = this.info.findIndex(
							(item) => item.id === this.currentData.id
						);
						if (index !== -1) {
							this.$set(this.info, index, response.data.updatedData);
						}
						alert("Data berhasil diupdate!");
					}
					var ModalDisposisi = bootstrap.Modal.getInstance(
						document.getElementById("ModalDisposisi")
					);
					ModalDisposisi.hide();
					//alert("Data berhasil diupdate!"); // Show success message
					//this.tampildata(); //Data dalam table direfresh
				})
				.catch((error) => {
					alert("Terjadi kesalahan saat mengupdate data. Silakan coba lagi.");
					console.log(error);
				});
		},

		formatDate(date) {
			const parsedDate = new Date(date);
			const year = parsedDate.getFullYear();
			const month = String(parsedDate.getMonth() + 1).padStart(2, "0");
			const day = String(parsedDate.getDate()).padStart(2, "0");
			const hours = String(parsedDate.getHours()).padStart(2, "0");
			const minutes = String(parsedDate.getMinutes()).padStart(2, "0");
			const seconds = String(parsedDate.getSeconds()).padStart(2, "0");
			return `${year}-${month}-${day}`;
			//return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
		},
		validateForm(data) {
			const fields = ["selectedTargets"];
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
				kd_sample: "",
				tgl_terima: "",
				tgl_uji: "",
				no_reg: "",
				nama_customer: "",
				nama_sample: "",
				jumlah: "",
				satuan: "",
				idpeg3: "",
			};
		},

		//Respon Target Pengujian
		getDataOrganTarget() {
			axios
				.post("proses.php", { request: "organTarget" })
				.then((response) => {
					if (response.data) {
						this.nilaiOrganTarget = response.data; // Simpan data dari server ke nilaiOrganTarget
						console.log("Data Organ Target:", this.nilaiOrganTarget);
					} else {
						console.log("Data kosong atau tidak tersedia.");
					}
				})
				.catch((error) => {
					console.log("Error saat mengambil data :", error);
				});
		},
		getTargetName(id) {
			const target = this.nilaiOrganTarget.find((t) => t.id === id);
			return target ? target.nama_organ : "Tidak ditemukan";
		},
		//End Response
		getCurrentTime() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, "0");
			const minutes = String(now.getMinutes()).padStart(2, "0");
			return `${hours}:${minutes}`;
		},
	},

	created() {
		this.currentData.tgl_uji = this.getCurrentTime(); // Initialize waktu with current time
	},
	mounted() {
		// Ambil kd_sample dari URL
		const params = new URLSearchParams(window.location.search);
		const kd_sample = params.get("kd_sample");

		if (kd_sample) {
			console.log("kd_sample ditemukan di URL:", kd_sample); // Debug log
			this.tampildata(kd_sample); // Panggil metode dengan kd_sample
		} else {
			console.error("kd_sample tidak ditemukan di URL");
		}
		//this.tampildata();
		this.getDataOrganTarget();
		this.getTargetName();
		var addDataModalElement = document.getElementById("addDataModal");
		//addDataModalElement.addEventListener("shown.bs.modal", this.getNewNomor);
	},
});
