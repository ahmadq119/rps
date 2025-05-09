var app = new Vue({
	el: "#app_logout",
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
	},
});
