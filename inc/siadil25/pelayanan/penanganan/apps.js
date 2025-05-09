var app = new Vue({
	el: "#app",
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		pegawaiList: [],
		currentData: {},
	},
	methods: {
		tampildata() {
			axios
				.post("proses.php", { request: "tampil" })
				.then((response) => {
					this.info = response.data;
				})
				.catch((error) => console.log(error));
		},
		caridata() {
			axios
				.post("proses.php", { request: "cari", searchQuery: this.searchQuery })
				.then((response) => {
					this.info = response.data;
					this.searchMessage =
						this.info.length === 0 ? "Pencarian tidak ditemukan." : "";
				})
				.catch((error) => {
					this.searchMessage = "Terjadi kesalahan saat melakukan pencarian.";
					console.error("Error during search:", error);
				});
		},
		editData(index, data) {
			console.log("Original data received:", data);
			this.currentData = { ...data };

			// Set default values if empty
			this.currentData.kemasan = this.currentData.kemasan?.trim() || "Plastik";
			this.currentData.kondisi_kemasan =
				this.currentData.kondisi_kemasan?.trim() || "Baik dan Utuh";

			console.log(
				"Modified currentData after setting defaults:",
				this.currentData
			);

			let modalElement = document.getElementById("editDataModal");
			if (modalElement) {
				let editDataModal = new bootstrap.Modal(modalElement);
				editDataModal.show();
			} else {
				console.error("Modal element not found.");
			}
		},
		updateData() {
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
				})
				.then((response) => {
					console.log("Response from server:", response.data);
					if (response.data.success) {
						let index = this.info.findIndex(
							(item) => item.kd_sample === this.currentData.kd_sample
						);
						if (index !== -1) {
							// Update the specific item directly in the array
							Vue.set(
								this.info,
								index,
								response.data.updatedData || this.currentData
							);
						}
						// Close modal
						let modalElement = document.getElementById("editDataModal");
						if (modalElement) {
							let editDataModal = bootstrap.Modal.getInstance(modalElement);
							editDataModal.hide();
						}
						//alert("Data berhasil diupdate!");
					} else {
						alert(response.data.message || "Gagal mengupdate data.");
					}
				})
				.catch((error) => {
					console.error("Error updating data:", error);
					alert("Terjadi kesalahan saat mengupdate data.");
				});
		},

		getPegawaiList() {
			axios
				.post("proses.php", { request: "pegawai" })
				.then((response) => {
					this.pegawaiList = response.data;
				})
				.catch((error) => console.error("Error fetching pegawai list:", error));
		},
	},
	mounted() {
		this.tampildata();
		this.getPegawaiList();
	},
});
