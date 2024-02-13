<?php
session_start();

include "../db_conn.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Hent brukerens tilgangsnivå fra databasen
$username = $_SESSION['username'];
$queryUserAccess = "SELECT access FROM users WHERE username='$username'";
$resultUserAccess = mysqli_query($conn, $queryUserAccess);
$accessLevels = mysqli_fetch_assoc($resultUserAccess)['access'];

// Konverter strengen til et array for enkel sjekk
$accessLevels = explode('-', $accessLevels);

// Sjekk om tilgangsnivået ikke er *
if (!in_array('*', $accessLevels)) {
    // Redirect til ønsket side hvis tilgangsnivået ikke er *
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']); // Legg til e-postfeltet
    $newPassword = hash('sha256', $_POST['password']); // Krypter passordet med SHA-256
    $selectedClasses = isset($_POST['classes']) ? $_POST['classes'] : [];

    $insertQuery = "INSERT INTO users (username, mail, password) VALUES ('$newUsername', '$newEmail', '$newPassword')"; // Oppdater spørringen for å inkludere 'mail' -kolonnen
    $resultInsert = mysqli_query($conn, $insertQuery);

    if ($resultInsert) {
        $newUserId = mysqli_insert_id($conn);

        // Legg til brukerens tilgang til klasser
        foreach ($selectedClasses as $classId) {
            $insertAccessQuery = "INSERT INTO user_classes (user_id, class_id) VALUES ('$newUserId', '$classId')";
            mysqli_query($conn, $insertAccessQuery);
        }

        header("Location: user_management.php?msg=Ny bruker lagt til!");
        exit();
    } else {
        echo "Feil ved oppretting av ny bruker.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legg til Bruker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        .class-button {
            padding: 5px;
            margin: 2px;
            cursor: pointer;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            color: #212529;
            border-radius: .25rem;
            transition: background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .selected {
            background-color: #DCFBC7;
            border: 1px solid #DCFBC7;
            color: #000;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-4 mb-5 custom-navlinks text-white">
        Legg til lærer
    </nav>

    <div class="container bg-white p-5 rounded-5 mb-5">
        <form method="post" action="add_user.php">
            <div class="mb-3 row">
                <div class="col">
                    <label for="username" class="form-label">Brukernavn:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="col">
                    <label for="email" class="form-label">E-post:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label for="password" class="form-label">Passord:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-success">Opprett</button>
                <a href="user_management.php" class="btn btn-danger">Avbryt</a>
            </div>

        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <!-- Font Awesome JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
        integrity="sha512-gem4up8i+yTYb3FbFyt4Lr+fpFTlqjb+Thcv3A9+It9J7hIh8udboNXPkvxY1yF7CQDZf3s+lPhTZrS3Zjz4Vg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const classButtons = document.querySelectorAll('.class-button');

            classButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    button.classList.toggle('selected');
                });
            });
        });
    </script>
</body>

</html>
