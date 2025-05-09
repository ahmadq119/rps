var app = new Vue({
	el: "#app",
	components: {
		"auto-suggest": {
			props: ["value", "suggestions", "displayKey", "extraKey"],
			template: `
                <div>
                    <input type="text" 
                           class="form-control form-control" 
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
		newData: {
			laporan: "",
			tahun: "",
			bulan: "",
			manajerTeknis: "",
		},
		dataTahun: [],
		dataBulan: [],
		manajerTeknis: [],
	},
	methods: {
		getDataBulan() {
			axios
				.post("proses.php", { request: "ambildatabulan" })
				.then((response) => {
					this.dataBulan = response.data; // Simpan data dari server
				})
				.catch((error) =>
					console.log("Error saat mengambil data bulan:", error)
				);
		},
		getDataTahun() {
			axios
				.post("proses.php", { request: "ambildatatahun" })
				.then((response) => {
					this.dataTahun = response.data; // Simpan data dari server
				})
				.catch((error) =>
					console.log("Error saat mengambil data tahun:", error)
				);
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
			this.newData.idpeg = p3.idpeg;
			this.newData.nip_pegawai = p3.nip_pegawai;
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

		printData() {
			const laporan = this.newData.laporan;
			const bulan = this.newData.bulan;
			const tahun = this.newData.tahun;
			const nm_mt = this.newData.manajerTeknis;
			const nip_mt = this.newData.nip_pegawai;

			let url = "";

			// Validasi input
			if (!laporan) {
				alert("Anda belum memilih jenis laporan!");
				return;
			}
			if (!bulan) {
				alert("Anda belum memilih bulan!");
				return;
			}
			if (!tahun) {
				alert("Anda belum memilih tahun!");
				return;
			}

			// Cek nilai laporan untuk menentukan URL
			if (laporan == 1) {
				url = `print_preparasi.php?bulan=${bulan}&tahun=${tahun}`;
			} else if (laporan == 2) {
				url = `print_persiapan.php?bulan=${bulan}&tahun=${tahun}&nm_mt=${nm_mt}&nip_mt=${nip_mt}`;
			} else if (laporan == 3) {
				url = `print_rek_rh_temp.php?bulan=${bulan}&tahun=${tahun}&nm_mt=${nm_mt}&nip_mt=${nip_mt}`;
			} else if (laporan == 4) {
				url = `print_rek_uv_ruangan.php?bulan=${bulan}&tahun=${tahun}&nm_mt=${nm_mt}&nip_mt=${nip_mt}`;
			} else if (laporan == 5) {
				url = `print_pengelolaan_sample_pra_pengujian.php?bulan=${bulan}&tahun=${tahun}&nm_mt=${nm_mt}&nip_mt=${nip_mt}`;
			} else {
				alert("Jenis laporan tidak valid!");
				return;
			}

			// Buka URL di tab baru
			window.open(url, "_blank");
		},
	},
	mounted() {
		this.getDataBulan();
		this.getDataTahun();
		this.getManajerTeknis();
	},
});
