var app = new Vue({
	el: "#app",
	data: {
		info: [],
		searchQuery: "",
		searchMessage: "",
		currentData: {
			kd_sample: "",
			tgl_terima: "",
			tgl_uji: "",
			jumlah: "",
			idpeg3: "",
			no_reg: "",
			mt: "",
		},
	},
	methods: {
		tampildata() {
			axios
				.post("proses.php", { request: "tampilawal" })
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
		},

		navigateToLhp(kd_sample) {
			console.log("Navigasi ke Disposisi dengan kd_sample:", kd_sample); // Debug
			if (!kd_sample) {
				console.error("kd_sample tidak tersedia");
				return;
			}
			// Buat URL ke halaman disposisi
			const url = `../lhp/index.php`;
			//const kd_sample = currentData.kd_sample;
			console.log("URL yang akan dibuka:", url); // Debug URL

			// Buka halaman baru
			//window.open(url, "_self"); // '_blank' membuka di tab baru
			window.location.href = `../lhp/index.php?kd_sample=${kd_sample}`;
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

		//End Response
		getCurrentTime() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, "0");
			const minutes = String(now.getMinutes()).padStart(2, "0");
			return `${hours}:${minutes}`;
		},

		printLhu(data) {
			// Extract kd_sample from the record object
			const kd_sample = data.kd_sample;

			// Construct the URL for the PHP script
			const url = `print_lhu.php?kd_sample=${kd_sample}`;

			// Open the URL in a new tab
			window.open(url, "_blank");
		},
	},

	created() {
		this.currentData.tgl_uji = this.getCurrentTime(); // Initialize waktu with current time
	},
	mounted() {
		this.tampildata();
		//var addDataModalElement = document.getElementById("addDataModal");
		//addDataModalElement.addEventListener("shown.bs.modal", this.getNewNomor);
	},
});
