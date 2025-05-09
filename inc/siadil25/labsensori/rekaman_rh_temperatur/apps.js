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
		newData: {
			ruangid: "",
			tgl_kegiatan: "",
			nil_rh: "",
			nil_temp: "",
			nil_lx: "",
			idpeg: "",
		},
		currentData: {},
		petugas: [],
		inputNilai: "",
	},

	methods: {
		ambildataSession() {
			axios
				.post("../../Login/proses.php", { request: "check_session" }) // Menggunakan request untuk memeriksa data session
				.then((response) => {
					if (response.data.status === "success") {
						this.newData.ruangid = response.data.ruangid; // Simpan ke newData.ruangid
						this.nama_ruang = response.data.folder;
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

		tampildata365() {
			//event.preventDefault(); // Meskipun @submit.prevent sudah melakukan ini
			console.log("Input Nilai:", this.inputNilai);
			axios
				.post("proses.php", {
					request: "tampil365",
					jumlah: parseInt(this.inputNilai),
				})
				.then((response) => {
					console.log("Data yang diterima:", response.data); // Cek data yang diterima dari server
					this.info = response.data; // Simpan data ke Vue
					//inputRecordModal.hide();
					this.tutupModal(); // Tutup modal setelah submit
				})
				.catch((error) => console.log(error));
		},

		tutupModal() {
			var modalEl = document.getElementById("inputRecordModal");
			var modalInstance = bootstrap.Modal.getInstance(modalEl);
			if (modalInstance) {
				modalInstance.hide();
			}
		},

		tambahData() {
			console.log("Data yang akan dikirim:", this.newData);

			if (
				!this.newData.tgl_kegiatan ||
				!this.newData.nil_rh ||
				!this.newData.nil_temp ||
				!this.newData.nil_lx
			) {
				alert("Tanggal, RH, Temperatur dan Lux harus diisi.");
				return;
			}

			axios
				.post("proses.php", {
					request: "create",
					ruangid: this.newData.ruangid,
					tgl_kegiatan: this.newData.tgl_kegiatan,
					nil_rh: this.newData.nil_rh,
					nil_temp: this.newData.nil_temp,
					nil_lx: this.newData.nil_lx,
					idpeg: this.newData.idpeg,
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
					alert(
						"Terjadi kesalahan saat menambahkan data. Data sudah ada sebelumnya. Silakan coba lagi."
					);
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
					id: this.currentData.id,
					tgl_kegiatan: this.currentData.tgl_kegiatan,
					nil_rh: this.currentData.nil_rh,
					nil_temp: this.currentData.nil_temp,
					nil_lx: this.currentData.nil_lx,
					idpeg: this.currentData.idpeg,
					ruangid: this.currentData.ruangid,
				})
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.id === this.currentData.id
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

		resetForm() {
			const now = new Date();
			this.newData.tgl_kegiatan = now.toISOString().split("T")[0];
			this.newData.nil_rh = "";
			this.newData.nil_temp = "";
			this.newData.nil_lx = "";
			this.newData.nama_pegawai = "";
			this.newData.idpeg = "";
			this.inputNilai = "";
		},

		searchPetugas(query) {
			if (query.length < 2) {
				this.petugas = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.petugas = response.data;
					console.log("Data petugas:", this.petugas);
				})
				.catch((error) => console.log(error));
		},

		selectPetugas(p1) {
			this.newData.nama_pegawai = p1.nama_pegawai;
			this.newData.idpeg = p1.idpeg;
		},

		selectPetugasNew(p2) {
			this.currentData.nama_pegawai = p2.nama_pegawai;
			this.currentData.idpeg = p2.idpeg;
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

		getKesimpulan(rh, temp, lux) {
			// Standar yang harus dipenuhi
			const rhMin = 45,
				rhMax = 65;
			const tempMin = 17,
				tempMax = 23; // Karena 20 ± 3°C
			const luxMin = 300,
				luxMax = 500;

			// Periksa apakah semua kondisi terpenuhi
			if (
				rh >= rhMin &&
				rh <= rhMax &&
				temp >= tempMin &&
				temp <= tempMax &&
				lux >= luxMin &&
				lux <= luxMax
			) {
				return "Memenuhi";
			} else {
				return "Tidak Memenuhi";
			}
		},
		getKesimpulanClass(rh, temp, lux) {
			return this.getKesimpulan(rh, temp, lux) === "Memenuhi"
				? "text-success fw-bold"
				: "text-danger fw-bold";
		},
	},
	created() {
		this.debouncedSearchPetugas = this.debounce(this.searchPetugas, 200);
	},

	mounted() {
		this.ambildataSession();
		this.tampildata();
		//this.getKesimpulan();
		var addDataModalElement = document.getElementById("addDataModal");
		// Tambahkan event listener untuk mengisi tanggal saat modal dibuka
		addDataModalElement.addEventListener("show.bs.modal", () => {
			this.resetForm(); // Panggil resetForm saat modal dibuka
		});
	},
});
