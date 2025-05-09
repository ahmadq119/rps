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
		nilaiTargetPengujian: [], // Data target pengujian dari database
		selectedTargets: [],
		searchQuery: "",
		searchMessage: "",
		newData: {
			kd_sample: "",
			nomor:"",
			no_reg: "",
			no_bap: "",
			tgl_terima: "",
			tgl_uji: "",
			idcustomer: "",
			idsample: "",
			jumlah: "",
			idkondisi: "",
			idpeg1: "",
			idpeg2: "",
			idpeg3: "",
			idasal: "",
		},
		currentData: {
			kd_sample: "",
			tgl_terima: "",
			tgl_uji: "",
			idcustomer: "",
			idsample: "",
			jumlah: "",
			idkondisi: "",
			idpeg1: "",
			idpeg2: "",
			idpeg3: "",
			nomor: "",
			no_reg: "",
			no_bap: "",
			idasal: "",
		},
		customers: [],
		namaSample: [],
		kondisiSample: [],
		asalSample: [],
		petugasPelayanan: [],
		petugasPengambilSample: [],
		manajerTeknis: [],
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
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
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
		tambahData() {
			if (!this.validateForm(this.newData)) {
				alert("Harap isi semua field yang diperlukan.");
				return;
			}

			console.log(
				"Data yang akan dikirim:",
				this.newData,
				this.selectedTargets
			);

			axios
				.post("proses.php", {
					request: "tambahdata",
					kd_sample: this.newData.kd_sample,
					nomor: this.newData.nomor,
					no_reg: this.newData.no_reg,
					no_bap: this.newData.no_bap,
					tgl_terima: this.newData.tgl_terima,
					tgl_uji: this.newData.tgl_uji,
					idcustomer: this.newData.idcustomer,
					idsample: this.newData.idsample,
					jumlah: this.newData.jumlah,
					idkondisi: this.newData.idkondisi,
					idpeg1: this.newData.idpeg1,
					idpeg2: this.newData.idpeg2,
					idpeg3: this.newData.idpeg3,
					idasal: this.newData.idasal,
					target_pengujian: this.selectedTargets,
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
					console.error("Error saat mengirim data:", error);
					alert("Terjadi kesalahan saat menambahkan data.");
				});
		},

		editData(index, data) {
			Object.keys(data).forEach((key) => {
				this.$set(this.currentData, key, data[key]);
			});
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
			if (!this.validateForm(this.currentData)) {
				alert("Harap isi semua field yang diperlukan.");
				return;
			}
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
					target_pengujian: this.selectedTargets,
				})
				.then((response) => {
					console.log(
						"Response dari server:",
						response.data,
						this.selectedTargets
					);
					if (response.data.success && response.data.updatedData) {
						let index = this.info.findIndex(
							(item) => item.kd_sample === this.currentData.kd_sample
						);
						if (index !== -1) {
							this.$set(this.info, index, response.data.updatedData);
						}
						alert("Data berhasil diupdate!");
					}
					var editDataModal = bootstrap.Modal.getInstance(
						document.getElementById("editDataModal")
					);
					editDataModal.hide();
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
		getNewNomor() {
			axios
				.post("proses.php", { request: "ambilnomor" })
				.then((response) => {
					this.newData.nomor = response.data.nomor_baru;
				})
				.catch((error) => console.log(error));
		},
		validateForm(data) {
			const fields = [
				"kd_sample",
				"nomor",
				"no_reg",
				"no_bap",
				"tgl_terima",
				"nama_sample",
				"jumlah",
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
				kd_sample: "",
				nomor: "",
				tgl_terima: "",
				tgl_uji: "",
				no_reg: "",
				no_bap: "",
				nama_customer: "",
				idcustomer: "",
				idsample: "",
				nama_sample: "",
				jumlah: "",
				satuan: "",
				idpeg1: "",
				idpeg2: "",
				idpeg3: "",
				idasal: "",
			};
		},
		generateKdSample() {
			if (this.newData.nomor && this.newData.tgl_terima) {
				const date = new Date(this.newData.tgl_terima);
				const tahun = date.getFullYear();
				this.newData.kd_sample = `NR/${tahun}/${this.newData.nomor}/01`;
			}
		},

		generateNoBAP() {
			if (this.newData.nomor && this.newData.tgl_terima) {
				const date = new Date(this.newData.tgl_terima);
				const bulanRomawi = this.getBulanRomawi(date.getMonth() + 1);
				const tahun = date.getFullYear();
				this.newData.no_bap = `BA.${this.newData.nomor}/LAB.MRK/TU.220/${bulanRomawi}/${tahun}`;
			}
		},

		generateNoReg() {
			if (this.newData.nomor && this.newData.tgl_terima) {
				const date = new Date(this.newData.tgl_terima);
				const yearMonthDay = `${date.getFullYear()}${(
					"0" +
					(date.getMonth() + 1)
				).slice(-2)}${("0" + date.getDate()).slice(-2)}`;
				this.newData.no_reg = `NR/${yearMonthDay}/${this.newData.nomor}`;
			}
		},

		generateKdSampleEdit() {
			if (this.currentData.nomor && this.currentData.tgl_terima) {
				const date = new Date(this.currentData.tgl_terima);
				const tahun = date.getFullYear();
				this.$set(
					this.currentData,
					"kd_sample",
					`NR/${tahun}/${this.currentData.nomor}/01`
				);
			}
		},
		generateNoBAPEdit() {
			if (this.currentData.nomor && this.currentData.tgl_terima) {
				const date = new Date(this.currentData.tgl_terima);
				const bulanRomawi = this.getBulanRomawi(date.getMonth() + 1);
				const tahun = date.getFullYear();
				this.$set(
					this.currentData,
					"no_bap",
					`BA.${this.currentData.nomor}/LAB.MRK/TU.220/${bulanRomawi}/${tahun}`
				);
			}
		},
		generateNoRegEdit() {
			if (this.currentData.nomor && this.currentData.tgl_terima) {
				const date = new Date(this.currentData.tgl_terima);
				const yearMonthDay = `${date.getFullYear()}${(
					"0" +
					(date.getMonth() + 1)
				).slice(-2)}${("0" + date.getDate()).slice(-2)}`;
				this.$set(
					this.currentData,
					"no_reg",
					`NR/${yearMonthDay}/${this.currentData.nomor}`
				);
			}
		},

		getBulanRomawi(bulan) {
			const bulanRomawi = [
				"I",
				"II",
				"III",
				"IV",
				"V",
				"VI",
				"VII",
				"VIII",
				"IX",
				"X",
				"XI",
				"XII",
			];
			return bulanRomawi[bulan - 1];
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
		searchCustomers(query) {
			if (query.length < 2) {
				this.customers = [];
				return;
			}
			axios
				.post("proses.php", { request: "cari_customer", query: query })
				.then((response) => {
					this.customers = response.data;
				})
				.catch((error) => console.log(error));
		},
		selectCustomer(customer) {
			this.newData.nama_customer = customer.nama_customer;
			this.newData.idcustomer = customer.idcustomer;
			this.newData.alamat_customer = customer.alamat_customer;
		},
		selectCustomer2(customer) {
			this.currentData.nama_customer = customer.nama_customer;
			this.currentData.idcustomer = customer.idcustomer;
			this.currentData.alamat_customer = customer.alamat_customer;
		},

		getAsalSamples() {
			axios
				.post("proses.php", { request: "asalsample" })
				.then((response) => {
					console.log("Data asal sample:", response.data); // Debug log
					this.asalSample = response.data; // Simpan data dari server
				})
				.catch((error) =>
					console.log("Error saat mengambil data kondisi sample:", error)
				);
		},
		//Respon Target Pengujian
		getDataTargetPengujian() {
			axios
				.post("proses.php", { request: "ambiltargetpengujian" })
				.then((response) => {
					if (response.data) {
						this.nilaiTargetPengujian = response.data; // Simpan data dari server ke nilaiTargetPengujian
						console.log("Data Target Pengujian:", this.nilaiTargetPengujian);
					} else {
						console.log("Data kosong atau tidak tersedia.");
					}
				})
				.catch((error) => {
					console.log("Error saat mengambil data target pengujian:", error);
				});
		},
		getTargetName(id) {
			const target = this.nilaiTargetPengujian.find((t) => t.idtarget === id);
			return target ? target.target_pengujian : "Tidak ditemukan";
		},
		//End Response

		updateIdSample(event) {
			const selectedSample = this.namaSample.find(
				(ns) => ns.nama_sample === event.target.value
			);
			if (selectedSample) {
				this.newData.idsample = selectedSample.idsample;
				this.newData.satuan = selectedSample.satuan;
			} else {
				this.newData.idsample = "";
				this.newData.satuan = "";
			}
		},
		searchSamples(query) {
			if (query.length < 2) {
				this.namaSample = [];
				return;
			}
			axios
				.post("proses.php", { request: "cari_jenis_sample", query: query })
				.then((response) => {
					this.namaSample = response.data;
				})
				.catch((error) => console.log(error));
		},
		selectSample(sample) {
			this.newData.nama_sample = sample.nama_sample;
			this.newData.idsample = sample.idsample;
			this.newData.satuan = sample.satuan;
		},
		selectSample2(sample) {
			this.currentData.nama_sample = sample.nama_sample;
			this.currentData.idsample = sample.idsample;
			this.currentData.satuan = sample.satuan;
		},
		getNamaSample() {
			axios
				.post("proses.php", { request: "AmbilNamaSample" })
				.then((response) => {
					this.namaSample = response.data;
				})
				.catch((error) => console.log(error));
		},

		getKondisiSample() {
			axios
				.post("proses.php", { request: "ambildatakondisisample" })
				.then((response) => {
					console.log("Data kondisi sample:", response.data); // Debug log
					this.kondisiSample = response.data; // Simpan data dari server
				})
				.catch((error) =>
					console.log("Error saat mengambil data kondisi sample:", error)
				);
		},

		searchPetugasPelayanan(query) {
			if (query.length < 2) {
				this.petugasPelayanan = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.petugasPelayanan = response.data;
				})
				.catch((error) => console.log(error));
		},
		selectPetugasPelayanan(p1) {
			this.newData.nama_pegawai = p1.nama_pegawai;
			this.newData.idpeg1 = p1.idpeg;
		},
		selectPetugasPelayanan2(p1) {
			this.currentData.nama_pegawai = p1.nama_pegawai;
			this.currentData.idpeg1 = p1.idpeg;
		},
		getPetugasPelayanan() {
			axios
				.post("proses.php", { request: "ambildatapegawai" })
				.then((response) => {
					this.petugasPelayanan = response.data;
				})
				.catch((error) => console.log(error));
		},
		//Petugas Pengambil Sample
		searchPetugasPengambilSample(query) {
			if (query.length < 2) {
				this.petugasPengambilSample = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.petugasPengambilSample = response.data;
				})
				.catch((error) => console.log(error));
		},
		selectPetugasPengambilSample(p2) {
			this.newData.nama_pegawai = p2.nama_pegawai;
			this.newData.idpeg2 = p2.idpeg;
		},
		selectPetugasPengambilSample2(p2) {
			this.currentData.nama_pegawai = p2.nama_pegawai;
			this.currentData.idpeg2 = p2.idpeg;
		},
		getPetugasPengambilSample() {
			axios
				.post("proses.php", { request: "ambildatapegawai" })
				.then((response) => {
					this.petugasPengambilSample = response.data;
				})
				.catch((error) => console.log(error));
		},
		//Manajer Teknis
		searchManajerTeknis(query) {
			if (query.length < 2) {
				this.manajerTeknis = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.manajerTeknis = response.data;
				})
				.catch((error) => console.log(error));
		},
		selectManajerTeknis(p3) {
			this.newData.manajerTeknis = p3.nama_pegawai;
			this.newData.idpeg3 = p3.idpeg;
			console.log(p3.nama_pegawai);
		},
		selectManajerTeknis2(p3) {
			this.currentData.manajerTeknis = p3.nama_pegawai;
			this.currentData.idpeg3 = p3.idpeg;
			console.log(p3.nama_pegawai);
		},
		getManajerTeknis() {
			axios
				.post("proses.php", { request: "ambildatapegawai" })
				.then((response) => {
					this.manajerTeknis = response.data;
				})
				.catch((error) => console.log(error));
		},
		getCurrentTime() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, "0");
			const minutes = String(now.getMinutes()).padStart(2, "0");
			return `${hours}:${minutes}`;
		},

		printKajiUlang(data) {
			// Extract kd_sample from the record object
			const kd_sample = data.kd_sample;

			// Construct the URL for the PHP script
			const url = `print_kaji_ulang.php?kd_sample=${kd_sample}`;

			// Open the URL in a new tab
			window.open(url, "_blank");
		},

		printBap(data) {
			// Extract kd_sample from the record object
			const kd_sample = data.kd_sample;

			// Construct the URL for the PHP script
			const url = `print_bap.php?kd_sample=${kd_sample}`;

			// Open the URL in a new tab
			window.open(url, "_blank");
		},
	},

	watch: {
		"newData.tgl_terima": function (newVal) {
			if (newVal) {
				this.generateKdSample();
				this.generateNoBAP();
				this.generateNoReg();
			}
		},
		"currentData.tgl_terima": function (newVal) {
			if (newVal) {
				this.generateKdSampleEdit();
				this.generateNoBAPEdit();
				this.generateNoRegEdit();
			}
		},
	},

	created() {
		this.debouncedSearch = this.debounce(this.searchCustomers, 100);
		this.debouncedSearchSample = this.debounce(this.searchSamples, 100);
		this.debouncedSearchPetugasPelayanan = this.debounce(
			this.searchPetugasPelayanan,
			100
		);
		this.debouncedSearchPetugasPengambilSample = this.debounce(
			this.searchPetugasPengambilSample,
			100
		);
		this.debouncedSearchmanajerTeknis = this.debounce(
			this.searchManajerTeknis,
			100
		);
		this.newData.tgl_terima = this.getCurrentTime(); // Initialize waktu with current time
	},
	mounted() {
		this.tampildata();
		this.getNewNomor();
		this.getAsalSamples();
		this.getDataTargetPengujian();
		this.getTargetName();
		this.getNamaSample();
		this.getKondisiSample();
		this.getPetugasPelayanan();
		this.getPetugasPengambilSample();
		this.getManajerTeknis();
		var addDataModalElement = document.getElementById("addDataModal");
		addDataModalElement.addEventListener("shown.bs.modal", this.getNewNomor);
	},
});
