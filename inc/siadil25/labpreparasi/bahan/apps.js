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
		newData: {
			ruangid: "", // Akan diisi otomatis dari session
			tanggal: "",
			waktu: "",
			idpeg: "",
			items: [{ namaBahan: "", jumlahBahan: "", namaAlat: "", jumlahAlat: "" }],
		},
		currentData: {},
		petugasBahan: [],
		items: [{ namaBahan: "", jumlahBahan: "", namaAlat: "", jumlahAlat: "" }],
	},

	methods: {
		ambildataSession() {
			axios
				.post("../../Login/proses.php", { request: "check_session" }) // Menggunakan request untuk memeriksa data session
				.then((response) => {
					if (response.data.status === "success") {
						this.newData.ruangid = response.data.ruangid; // Simpan ke newData.ruangid
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
			//console.log("Data yang akan dikirim:", this.newData);
			//console.log("Items yang akan dikirim:", this.items);

			if (!this.newData.tanggal || !this.newData.waktu) {
				alert("Tanggal dan waktu harus diisi.");
				return;
			}

			axios
				.post("proses.php", {
					request: "create",
					ruangid: this.newData.ruangid,
					tanggal: this.newData.tanggal,
					waktu: this.newData.waktu,
					idpeg: this.newData.idpeg,
					items: this.items,
				})
				.then((response) => {
					if (response.data.status === "success") {
						this.info.push(...response.data.items); // Tambahkan semua item yang berhasil disimpan
						this.resetForm();
						var addDataModal = bootstrap.Modal.getInstance(
							document.getElementById("addDataModal")
						);
						addDataModal.hide();
						alert("Data berhasil disimpan!");
						this.tampildata();
					} else {
						alert(
							"Gagal menyimpan data: " +
								(response.data.message || "Terjadi kesalahan.")
						);
					}
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
			console.log("Data yang akan dikirim:", this.currentData);
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
					idbahan: this.currentData.idbahan,
					tanggal: this.currentData.tanggal,
					waktu: this.currentData.waktu,
					nama_bahan: this.currentData.nama_bahan,
					jumlah_bahan: this.currentData.jumlah_bahan,
					nama_alat: this.currentData.nama_alat,
					jumlah_alat: this.currentData.jumlah_alat,
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
					//this.tampildata(); //Data dalam table direfresh
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

		addItem() {
			this.items.push({
				namaBahan: "",
				jumlahBahan: "",
				namaAlat: "",
				jumlahAlat: "",
			});
		},
		removeItem(index) {
			this.items.splice(index, 1);
		},
		resetForm() {
			// Reset form ke nilai awal
			const now = new Date();
			this.newData.tanggal = now.toISOString().split("T")[0]; // Mengisi tanggal dengan format YYYY-MM-DD
			this.newData.waktu = now.toTimeString().split(" ")[0].slice(0, 5); // Mengisi waktu dengan format HH:MM
			this.petugasBahan = "";
			this.items = [
				{ namaBahan: "", jumlahBahan: "", namaAlat: "", jumlahAlat: "" },
			];
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

		selectPetugasBahan(p1) {
			this.newData.nama_pegawai = p1.nama_pegawai;
			this.newData.idpeg = p1.idpeg;
		},
		selectPetugasBahanNew(p2) {
			this.currentData.nama_pegawai = p2.nama_pegawai;
			this.currentData.idpeg = p2.idpeg;
		},
		getPetugasBahan() {
			axios
				.post("proses.php", { request: "ambildatapegawai" })
				.then((response) => {
					this.petugasBahan = response.data;
				})
				.catch((error) => console.log(error));
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
			100
		);
	},

	mounted() {
		this.ambildataSession();
		this.tampildata();
		this.getPetugasBahan();
		var addDataModalElement = document.getElementById("addDataModal");
		// Tambahkan event listener untuk mengisi tanggal dan waktu saat modal dibuka
		addDataModalElement.addEventListener("show.bs.modal", () => {
			this.resetForm(); // Panggil resetForm saat modal dibuka
		});
	},
});
