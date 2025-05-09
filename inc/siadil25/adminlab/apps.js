var app = new Vue({
	el: "#app",
	data: {
		info: {},
		nama: "",
		nama_ruang: "",
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
				.post("../Login/proses.php", { request: "check_session" }) // Menggunakan request untuk memeriksa data session
				.then((response) => {
					if (response.data.status === "success") {
						this.nama = response.data.nama; // Mendapatkan nama user dari session
						this.nama_ruang = response.data.folder; // Mendapatkan nama ruang dari session
					} else {
						window.location.href = "../Login/index.html"; // Redirect jika sesi tidak valid
					}
				})
				.catch((error) => console.log("Fetch error: ", error));
		},
		countSample() {
			axios
				.post("proses.php", { request: 1 })
				.then((response) => (this.info = response.data))
				.catch((error) => console.log(error));
		},
	},
	mounted() {
		this.tampildata();
		this.countSample();
	},
});
