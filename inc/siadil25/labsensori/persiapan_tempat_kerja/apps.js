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
			nama_kegiatan: "Persiapan organoleptik",
			s_uv: 1,
			s_ol: 1,
			s_bh: 1,
			s_al: 1,
			p_ss: 1,
			p_ol: 1,
			p_sk: 1,
			p_al: 1,
		},
		currentData: {},
		Analis: [],
	},
	methods: {
		tampildata() {
			axios
				.post("proses.php", { request: "tampil" })
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
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
		editData(index, data) {
			this.currentData = Object.assign({}, data);
			var editDataModal = new bootstrap.Modal(
				document.getElementById("editDataModal")
			);
			editDataModal.show();
		},
		tambahData() {
			if (!this.validateForm(this.currentData)) {
				alert("Harap isi semua field yang diperlukan.");
				return;
			}
			axios
				.post("proses.php", {
					request: "tambahData",
					currentData: this.currentData,
					nama_kegiatan: this.newData.nama_kegiatan,
					s_uv: this.newData.s_uv,
					s_ol: this.newData.s_ol,
					s_bh: this.newData.s_bh,
					s_al: this.newData.s_al,
					p_ss: this.newData.p_ss,
					p_ol: this.newData.p_ol,
					p_sk: this.newData.p_sk,
					p_al: this.newData.p_al,
				})
				.then((response) => {
					let index = this.info.findIndex(
						(item) => item.kd_sample === this.currentData.kd_sample
					);
					if (index !== -1) {
						this.info.splice(index, 1, response.data);
					}
					var editDataModal = bootstrap.Modal.getInstance(
						document.getElementById("editDataModal")
					);
					editDataModal.hide();
					alert("Input Data Persiapan Tempat Kerja Berhasil...!"); // Show success message
					this.tampildata();
				})
				.catch((error) => {
					alert("Terjadi kesalahan saat mengupdate data. Silakan coba lagi.");
					console.log(error);
				});
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

		searchAnalis(query) {
			if (query.length < 2) {
				this.Analis = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.Analis = response.data;
				})
				.catch((error) => console.log(error));
		},

		selectAnalis(p1) {
			this.currentData.nama_pegawai = p1.nama_pegawai;
			this.currentData.idpeg = p1.idpeg;
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
		this.debouncedSearchAnalis = this.debounce(this.searchAnalis, 200);
	},

	mounted() {
		this.tampildata();
		var addDataModalElement = document.getElementById("addDataModal");
	},
});
