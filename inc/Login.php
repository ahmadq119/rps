
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" type="image/png" href="logo.jpg" ">  
    <style>
        body {
            background-color: darkgray;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .kontainer {
            flex-direction: column;
            background-color: lightgrey;
            border-radius: 8px;
            width: 30%;
            margin-top: 150px;
            padding: 20px;
            margin-left: auto;
            margin-right: auto;
            height: auto;
        }

        .in label {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .in input, .in select {
            width: 95%;
            border-radius: 5px;
            outline: none;
            padding: 10px;
            border: none;
            background-color: darkgray;
            color: white;
        }

        .in select {
            width: 99%;
        }

        .gas button {
            width: 99%;
            padding: 7px;
            top: 20px;
            margin-top: 11px;
            border-radius: 5px;
            border: none;
            background-color: darkgray;
            cursor: pointer;
            color: white;
        }

        .gas button:hover {
            background-color: grey;
        }

        h2 {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="kontainer">
        <h2>Login</h2>
        <form method="POST" action="cek-login.php">
            <div class="in">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>

            <div class="in">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div class="in">
                <label>Level:</label>
                <select name="level" required>
                    <option value="admin">Admin</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <div class="gas">
                <button type="submit">Login</button>
            </div>
        </form>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($error)): ?>
            <p style="color:red; text-align:center;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>
