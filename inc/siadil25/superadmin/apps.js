var app = new Vue({
	el: "#app",
	data: {
		info: {},
		nama: "",
		nama_ruang: "",
		infoPivot: [], // Data pivot untuk tabel dinamis
		menuLinks: [
			{ text: "Pegawai", url: "../superadmin/pegawai/" },
			{ text: "Customer", url: "../superadmin/customer/" },
			{ text: "Kondisi Sample", url: "../superadmin/kondisi_sample/" },
			{ text: "Target Pengujian", url: "../superadmin/target_pengujian/" },
			{ text: "Satuan Sample", url: "../superadmin/satuan/" },
			{ text: "Kelompok Sample", url: "../superadmin/kelompok/" },
			{ text: "Jenis Sample", url: "../superadmin/jenis_sample/" },
			{ text: "Organ Target", url: "../superadmin/organ_target/" },
			{ text: "Users", url: "../superadmin/users/" },
		],
	},

	methods: {
		// Fungsi Logout
		async logout() {
			try {
				const response = await axios.post(
					window.location.origin + "/siadil25/login/proses.php",
					{
						request: "logout",
					}
				);

				// Pastikan respons memiliki `data.status`
				if (response.data && response.data.status === "success") {
					window.location.href =
						window.location.origin + "/siadil25/login/index.html";
				} else {
					console.error("Logout failed: ", response.data);
				}
			} catch (error) {
				console.error("Logout error: ", error);
			}
		},

		// Mengecek session pengguna
		async tampildata() {
			try {
				const response = await axios.post(
					window.location.origin + "/siadil25/login/proses.php",
					{
						request: "check_session",
					}
				);

				if (response.data && response.data.status === "success") {
					this.nama = response.data.nama;
					this.nama_ruang = response.data.folder;
				} else {
					window.location.href = window.location.origin + "//login/index.html";
				}
			} catch (error) {
				console.error("Fetch error: ", error);
			}
		},

		async fetchData() {
			axios
				.post("proses.php", { request: 1 })
				.then((response) => {
					if (response.data.error) {
						console.error("Error: ", response.data.error);
					} else {
						this.infoPivot = response.data;
					}
				})
				.catch((error) => {
					console.error("Axios error: ", error);
				});
		},
	},

	// Memanggil data saat halaman dimuat
	mounted() {
		console.log("Vue.js is running");
		console.log("menuLinks:", this.menuLinks);
		this.fetchData();
		this.tampildata();
	},
});
