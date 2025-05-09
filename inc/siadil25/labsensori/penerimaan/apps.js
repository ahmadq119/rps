var app = new Vue({
	el: "#app",
	components: {
		"auto-suggest": {
			props: ["value", "suggestions", "displayKey", "extraKey"],
			template: `
                <div>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           :value="value" 
                           @input="$emit('input', $event.target.value)" 
                           @focus="showSuggestions = true"
                           @blur="hideSuggestions"
                           @keydown.down="highlightNext"
                           @keydown.up="highlightPrev"
                           @keydown.enter="selectHighlighted">
                    <ul v-if="showSuggestions && filteredSuggestions.length > 0" class="list-group">
                        <li v-for="(suggestion, index) in filteredSuggestions" 
                            :key="index" 
                            :class="{'list-group-item': true, 'active': index === highlightedIndex}"
                            @mousedown.prevent="selectSuggestion(suggestion)"
                            @mouseover="highlightIndex(index)">
                            {{ suggestion[displayKey] }} - {{ suggestion[extraKey] }} 
                        </li>
                    </ul>
                </div>
            `,
			data() {
				return {
					showSuggestions: false,
					highlightedIndex: -1,
				};
			},
			computed: {
				filteredSuggestions() {
					if (!Array.isArray(this.suggestions)) {
						return [];
					}
					return this.suggestions.filter((s) =>
						s[this.displayKey].toLowerCase().includes(this.value.toLowerCase())
					);
				},
			},
			methods: {
				hideSuggestions() {
					setTimeout(() => {
						this.showSuggestions = false;
					}, 100);
				},
				highlightIndex(index) {
					this.highlightedIndex = index;
				},
				highlightNext() {
					if (this.highlightedIndex < this.filteredSuggestions.length - 1) {
						this.highlightedIndex++;
					}
				},
				highlightPrev() {
					if (this.highlightedIndex > 0) {
						this.highlightedIndex--;
					}
				},
				selectHighlighted() {
					if (
						this.highlightedIndex >= 0 &&
						this.highlightedIndex < this.filteredSuggestions.length
					) {
						this.selectSuggestion(
							this.filteredSuggestions[this.highlightedIndex]
						);
					}
				},
				selectSuggestion(suggestion) {
					this.$emit("input", suggestion[this.displayKey]);
					this.$emit("select", suggestion);
					this.showSuggestions = false;
				},
			},
		},
	},
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		currentData: {
			kd_sample: "",
			tgl_terima: "",
			tgl_uji: "",
			tgl_hasil: "",
			tgl_harus_uji: "",
			nama_sample: "",
			jumlah: "",
			satuan: "",
			panjang: "",
			berat: "",
			target_pengujian: "",
			acuan: "",
		},
	},
	methods: {
		logout() {
			axios
				.post("../Login/proses.php", {
					request: "logout",
				})
				.then((response) => {
					if (response.data.status === "success") {
						window.location.href = "../Login/index.html";
					}
				})
				.catch((error) => {
					console.log("Logout error: ", error);
				});
		},

		tampildata() {
			axios
				.post("proses.php", { request: "tampilawal" })
				.then((response) => {
					console.log("Data dari server:", response.data); // Debugging
					this.info = response.data;
				})
				.catch((error) => console.log("Error fetching data:", error));
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

		editData(index, data) {
			Object.keys(data).forEach((key) => {
				this.$set(this.currentData, key, data[key]);
			});

			// Menambahkan nilai "(Kualitatif)" ke acuan
			if (this.currentData.acuan) {
				this.currentData.acuan += " (Kualitatif)";
			}

			console.log("Data Setelah Diset: ", this.currentData);
			var editDataModal = new bootstrap.Modal(
				document.getElementById("editDataModal")
			);
			editDataModal.show();
		},

		updateTglTerima(event) {
			this.$set(this.currentData, "tgl_terima", event.target.value);
		},

		updateData() {
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
				})
				.then((response) => {
					console.log("Response dari server:", response.data); // Debugging

					if (response.data.success && response.data.updatedData) {
						let index = this.info.findIndex(
							(item) => item.kd_sample === this.currentData.kd_sample
						);
						if (index !== -1) {
							// Update data di array 'info'
							this.$set(this.info, index, response.data.updatedData);
						}
						alert("Data berhasil diupdate!");
					} else {
						console.error("Kesalahan: ", response.data.message); // Debugging
						alert("Terjadi kesalahan saat mengupdate data.");
					}

					// Tutup modal
					var editDataModal = bootstrap.Modal.getInstance(
						document.getElementById("editDataModal")
					);
					editDataModal.hide();
				})
				.catch((error) => {
					console.error("Kesalahan Axios: ", error); // Debugging
					alert("Terjadi kesalahan saat mengupdate data.");
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
			const fields = ["kd_sample"];
			for (const field of fields) {
				if (!data[field]) {
					console.log(`Field ${field} is empty`);
					return false;
				}
			}
			return true;
		},
	},

	mounted() {
		this.tampildata();
	},
});
