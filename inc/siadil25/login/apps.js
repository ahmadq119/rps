var app = new Vue({
	el: "#app",
	data: {
		loginData: {
			username: "",
			password: "",
		},
		errorMessage: "",
	},
	methods: {
		login() {
			axios
				.post("proses.php", {
					request: "login",
					username: this.loginData.username,
					password: this.loginData.password,
				})
				.then((response) => {
					if (response.data.status === "success") {
						window.location.href = "../" + response.data.folder + "/index.php";
					} else {
						this.errorMessage =
							"Login failed. Please check your username and password.";
					}
				})
				.catch((error) => {
					console.log(error);
					this.errorMessage = "An error occurred during login.";
				});
		},
	},
});
