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
		manajerTeknis: [],
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

		navigateToLHUS() {
			const url = `../lhus/`;
			//const kd_sample = currentData.kd_sample;
			console.log("URL yang akan dibuka:", url); // Debug URL

			// Buka halaman baru
			//window.open(url, "_self"); // '_blank' membuka di tab baru
			window.location.href = `../lhus/index.php`;
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

		isiData(index, data) {
			Object.keys(data).forEach((key) => {
				this.$set(this.currentData, key, data[key]);
			});

			console.log("Data Setelah Diset: ", this.currentData);

			// **Pastikan TinyMCE diupdate dengan data terbaru**
			this.$nextTick(() => {
				if (tinymce.get("editor1")) {
					tinymce.get("editor1").setContent(this.currentData.hasil || "");
				}
				if (tinymce.get("editor2")) {
					tinymce
						.get("editor2")
						.setContent(this.currentData.persyaratan_mutu || "");
				}
				if (tinymce.get("editor3")) {
					tinymce.get("editor3").setContent(this.currentData.keterangan || "");
				}
			});

			var ModalLhp = new bootstrap.Modal(document.getElementById("ModalLhp"));
			ModalLhp.show();
		},

		updateData() {
			// **Ambil nilai terbaru dari TinyMCE**
			this.currentData.hasil = tinymce.get("editor1").getContent();
			this.currentData.persyaratan_mutu = tinymce.get("editor2").getContent();

			console.log("Data yang akan dikirim:", this.currentData);
			axios
				.post("proses.php", {
					request: "update",
					currentData: this.currentData,
					kd_sample: this.currentData.kd_sample,
					no_lhu: "Tes Nomor",
					bidang_pengujian: this.currentData.bidang_pengujian,
					parameter: this.currentData.parameter,
					hasil: this.currentData.hasil,
					persyaratan_mutu: this.currentData.persyaratan_mutu,
					metode_acuan: this.currentData.metode_acuan,
					keterangan: this.currentData.keterangan,
					tgl_lhu: this.currentData.tgl_terima,
					idpeg: this.currentData.idpeg,
				})
				.then((response) => {
					if (response.data.success && response.data.updatedData) {
						let index = this.info.findIndex(
							(item) => item.id === this.currentData.id
						);
						if (index !== -1) {
							this.$set(this.info, index, response.data.updatedData);
						}
						alert("Data berhasil diupdate!");
					}
					var ModalLhp = bootstrap.Modal.getInstance(
						document.getElementById("ModalLhp")
					);
					ModalLhp.hide();
					//alert("Data berhasil diupdate!"); // Show success message
					//this.tampildata(); //Data dalam table direfresh
					this.tampildata(this.currentData.kd_sample);
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

		resetForm() {
			this.currentData = {
				hasil: currentData.metode_pengujian,
			};
		},

		//End Response
		getCurrentTime() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, "0");
			const minutes = String(now.getMinutes()).padStart(2, "0");
			return `${hours}:${minutes}`;
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
		selectManajerTeknis(p1) {
			this.currentData.manajerTeknis = p1.nama_pegawai;
			this.currentData.idpeg = p1.idpeg;
		},

		initTinyMCE_editor1() {
			tinymce.init({
				selector: "#editor1",
				height: 150,
				menubar: false,
				/*plugins:
					"advlist autolink lists link charmap preview superscript subscript",*/
				toolbar:
					"formatselect | bold italic | bullist numlist | removeformat | superscript subscript",
				setup: (editor) => {
					editor.on("change", () => {
						this.currentData.hasil = editor.getContent();
					});
				},
			});
		},

		initTinyMCE_editor2() {
			tinymce.init({
				selector: "#editor2",
				height: 150,
				menubar: false,
				/*plugins:
					"advlist autolink lists link charmap preview superscript subscript",*/
				toolbar:
					"formatselect | bold italic | bullist numlist | removeformat | superscript subscript",
				setup: (editor) => {
					editor.on("change", () => {
						this.currentData.persyaratan_mutu = editor.getContent();
					});
				},
			});
		},

		initTinyMCE_editor3() {
			tinymce.init({
				selector: "#editor3",
				height: 150,
				menubar: false,
				/*plugins:
					"advlist autolink lists link charmap preview superscript subscript",*/
				toolbar:
					"formatselect | bold italic | bullist numlist | removeformat | superscript subscript",
				setup: (editor) => {
					editor.on("change", () => {
						this.currentData.keterangan = editor.getContent();
					});
				},
			});
		},
	},

	created() {
		this.debouncedSearchManajerTeknis = this.debounce(
			this.searchManajerTeknis,
			200
		);
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

		var addDataModalElement = document.getElementById("addDataModal");
		this.initTinyMCE_editor1();
		this.initTinyMCE_editor2();
		this.initTinyMCE_editor3();
		//addDataModalElement.addEventListener("shown.bs.modal", this.getNewNomor);
	},
});
