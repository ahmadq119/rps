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
			ket_file: "",
		},
		currentData: {
			kd_sample: "",
			tgl_uji: "",
			tgl_hasil: "",
			nama_sample: "",
			target_pengujian: "",
			idpeg_analis: "",
			analis: "",
			file: null,
			ket_file: "",
			nama_file: "",
		},
		petugasAnalis: [],
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
			console.log("Data Setelah Diset: ", this.currentData);
			var editDataModal = new bootstrap.Modal(
				document.getElementById("editDataModal")
			);
			editDataModal.show();
		},

		uploadFoto(index, data) {
			Object.keys(data).forEach((key) => {
				this.$set(this.currentData, key, data[key]);
			});
			console.log("Data Setelah Diset: ", this.currentData);
			var editDataModalUpload = new bootstrap.Modal(
				document.getElementById("editDataModalUpload")
			);
			editDataModalUpload.show();
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

		handleFileUpload(event) {
			const file = event.target.files[0];
			if (!file) return;

			if (!file.type.startsWith("image/")) {
				alert("Hanya file gambar yang diperbolehkan!");
				return;
			}

			if (file.size > 5 * 1024 * 1024) {
				alert("Ukuran file maksimal 5MB!");
				return;
			}

			this.currentData.file = file;
			console.log("File dipilih:", this.currentData.file);
		},

		updateFileUpload() {
			if (!this.currentData.file) {
				alert("Pilih file terlebih dahulu!");
				return;
			}

			let formData = new FormData();
			formData.append("request", "updateFileUpload");
			formData.append("kd_sample", this.currentData.kd_sample);
			formData.append("ket_file", this.newData.ket_file);
			formData.append("file", this.currentData.file);

			axios
				.post("proses_upload.php", formData, {
					headers: {
						"Content-Type": "multipart/form-data",
					},
				})
				.then((response) => {
					console.log("Response dari server:", response.data); // Debugging

					if (response.data && response.data.success) {
						alert(response.data.message || "File berhasil diunggah!");
						this.tampildata(); // Refresh data
						let modal = bootstrap.Modal.getInstance(
							document.getElementById("editDataModalUpload")
						);
						modal.hide();
					}
				})
				.catch((error) => {
					console.error("Upload error:", error);
					alert("Terjadi kesalahan saat mengunggah file.");
				});
		},

		hapusLampiran(index) {
			this.info.splice(index, 1);
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
			const fields = ["kd_sample", "hasil_pengujian"];
			for (const field of fields) {
				if (!data[field]) {
					console.log(`Field ${field} is empty`);
					return false;
				}
			}
			return true;
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

		searchAnalis(query) {
			if (query.length < 2) {
				this.petugasAnalis = [];
				return;
			}
			axios
				.post("proses.php", { request: "ambildatapegawai", query: query })
				.then((response) => {
					this.petugasAnalis = response.data;
				})
				.catch((error) => console.log(error));
		},
		selectAnalis(p1) {
			this.currentData.analis = p1.nama_pegawai;
			this.currentData.idpeg_analis = p1.idpeg;
		},

		getCurrentTime() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, "0");
			const minutes = String(now.getMinutes()).padStart(2, "0");
			return `${hours}:${minutes}`;
		},

		simpanData() {
			alert("Data berhasil disimpan!");
		},

		initTinyMCE() {
			tinymce.init({
				selector: "#keterangan",
				height: 100,
				menubar: false,
				toolbar:
					"undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | superscript subscript",
				setup: (editor) => {
					editor.on("init", () => {
						let x = this.currentData.kd_sample;
						let defaultContent = `
						<p>Sample uji ${x}</p>
					<p><strong>NEGATIF FORMALIN</strong></p>
					<ul>
					  <li>Sensitifitas metode uji (LOD) adalah 0,1 mg/l atau 2 mg/kg</li>
					</ul>
				  `;
						editor.setContent(defaultContent);
						this.newData.ket_file = defaultContent; // Simpan nilai awal ke data Vue
					});

					editor.on("change", () => {
						this.newData.ket_file = editor.getContent();
					});
				},
			});
		},

		printLhp(data) {
			// Extract kd_sample from the record object
			const kd_sample = data.kd_sample;

			// Construct the URL for the PHP script
			const url = `print_lhp.php?kd_sample=${kd_sample}`;

			// Open the URL in a new tab
			window.open(url, "_blank");
		},
	},

	created() {
		this.debouncedSearchAnalis = this.debounce(this.searchAnalis, 200);
	},
	mounted() {
		this.tampildata();
		this.initTinyMCE();

		var editDataModalElement = document.getElementById("editDataModal");
		var editDataModalUploadElement = document.getElementById(
			"editDataModalUpload"
		);
		//editDataModalElement.addEventListener("shown.bs.modal", this.getAnalis);
	},
});
