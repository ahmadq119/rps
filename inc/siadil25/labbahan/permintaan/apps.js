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
		currentData: {},
		petugasBahan: [],
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
		tampil_seluruh_data() {
			axios
				.post("proses.php", { request: "tampil_seluruh_data" })
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
		},
		caridata() {
			// Cek apakah input pencarian kosong
			if (!this.searchQuery.trim()) {
				this.searchMessage = "Kata kunci belum dimasukkan!.";

				// Hapus pesan setelah 3 detik
				setTimeout(() => {
					this.searchMessage = "";
				}, 3000);

				return; // Hentikan eksekusi fungsi agar tidak melakukan request ke server
			}

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

		editData(index, data) {
			this.currentData = Object.assign({}, data);
			var editDataModal = new bootstrap.Modal(
				document.getElementById("editDataModal")
			);
			editDataModal.show();
		},
		updateData() {
			console.log("Data yang akan dikirim:", this.currentData);
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
					idpeg: this.currentData.idpeg,
				})
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.idbahan === this.currentData.idbahan
					);
					if (index !== -1) {
						this.info.splice(index, 1, response.data);
					}
					var editDataModal = bootstrap.Modal.getInstance(
						document.getElementById("editDataModal")
					);
					editDataModal.hide();
					alert("Data berhasil diupdate!"); // Show success message
					this.tampildata(); //Data dalam table direfresh
				})
				.catch((error) => {
					alert("Terjadi kesalahan saat mengupdate data. Silakan coba lagi.");
					console.log(error);
				});
		},

		//Format Tanggal
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

		searchPetugasBahan(query) {
			if (query.length < 2) {
				this.petugasBahan = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.petugasBahan = response.data;
				})
				.catch((error) => console.log(error));
		},

		selectPetugasBahan(p2) {
			this.currentData.nama_p_bahan = p2.nama_pegawai;
			this.currentData.idpeg_bahan = p2.idpeg;
		},

		debounce(fn, delay) {
			let timeoutID;
			return function (...args) {
				if (timeoutID) clearTimeout(timeoutID);
				timeoutID = setTimeout(() => {
					fn.apply(this, args);
				}, delay);
			};
		},
	},

	created() {
		this.debouncedSearchPetugasBahan = this.debounce(
			this.searchPetugasBahan,
			200
		);
	},

	mounted() {
		this.sesi();
		this.tampildata();
	},
});
