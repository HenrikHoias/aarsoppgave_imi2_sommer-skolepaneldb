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

// Sjekk om en gyldig bruker-ID er gitt i URL-en
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];

    // Hent eksisterende brukerinformasjon fra databasen basert på bruker-ID
    $queryUser = "SELECT * FROM users WHERE id='$userId'";
    $resultUser = mysqli_query($conn, $queryUser);

    if ($resultUser) {
        $user = mysqli_fetch_assoc($resultUser);
        $existingEmail = isset($user['mail']) ? $user['mail'] : ''; // Nytt: Sjekk om e-postadressen eksisterer
        $existingPassword = $user['password']; // Lagre eksisterende passord
    } else {
        echo "Feil ved henting av brukerinformasjon.";
        exit();
    }
} else {
    echo "Ugyldig bruker-ID.";
    exit();
}

// Hent eksisterende brukerens tilgangsnivåer fra databasen
$queryAccess = "SELECT access FROM users WHERE id='$userId'";
$resultAccess = mysqli_query($conn, $queryAccess);

if ($resultAccess) {
    $userAccess = mysqli_fetch_assoc($resultAccess);
    $existingAccess = $userAccess['access'];
    $accessLevels = explode('-', $existingAccess);
} else {
    echo "Feil ved henting av brukerens tilgangsnivåer.";
    exit();
}

// Hent klassedata fra databasen
$queryClasses = "SELECT id, class_name FROM classes";
$resultClasses = mysqli_query($conn, $queryClasses);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    
    // Sjekk om passordfeltet er tomt
    if (!empty($_POST['password'])) {
        $newPassword = hash('sha256', $_POST['password']); // Krypter passordet med SHA-256
    } else {
        // Hvis passordfeltet er tomt, behold det eksisterende passordet
        $newPassword = $existingPassword;
    }

    $newEmail = mysqli_real_escape_string($conn, $_POST['email']); // Nytt: Hent ny e-postadresse
    $newAccess = isset($_POST['access']) ? implode('-', $_POST['access']) : '';

    // Legg til denne sjekken før du oppdaterer databasen
    if (empty($newAccess)) {
        $newAccess = $existingAccess;
    }

    $updateQuery = "UPDATE users SET username='$newUsername', password='$newPassword', mail='$newEmail', access='$newAccess' WHERE id='$userId'";
    $resultUpdate = mysqli_query($conn, $updateQuery);

    if ($resultUpdate) {
        header("Location: user_management.php?msg=Endringer lagret!");
        exit();
    } else {
        echo "Feil ved oppdatering av brukerinformasjon.";
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
    
    <!-- Favicon Eleva -->
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>

    <title>Rediger Bruker</title>
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
        }

        .selected {
            /* background-color: #E5E5E5; */
            background-color: #DCFBC7;
            color: #000;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-light justify-content-center fs-4 mb-5 custom-navlinks text-white">
        Endre bruker
</nav>

<div class="container bg-white p-4 rounded-5 mb-5">
    <form method="post" action="edit_user.php?id=<?php echo $userId; ?>">
        <div class="mb-3 row">
            <div class="col">
                <label for="username" class="form-label">Brukernavn:</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?php echo $user['username']; ?>" required>
            </div>
            <div class="col">
                <label for="password" class="form-label">Oppdater passord:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" value="">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="email" class="form-label">E-postadresse:</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo $existingEmail; ?>" required>
            </div>
        </div>

        <div class="mb-5">
            <label for="access" class="form-label">Klassetilgang: (Grønn kloss gir tilgang, blank kloss betyr ingen tilgang)</label><br>
            <?php
            $classNames = [];
            // Sjekk om $resultClasses ikke er null før du bruker det i løkken
            if ($resultClasses) {
                while ($class = mysqli_fetch_assoc($resultClasses)) {
                    $classId = $class['id'];
                    $className = $class['class_name'];
                    $selected = in_array($classId, $accessLevels) ? 'selected' : '';

                    echo '<button type="button" class="btn px-2 btn btn-outline-secondary class-button ' . $selected . '" data-class-id="' . $classId . '">' . $className . '</button>';
                }
            }
            ?>
            <input type="hidden" name="access[]" id="hiddenAccessInput" value="">
        </div>

        <button type="submit" class="btn btn-success" onclick="updateAccess()">Oppdater</button>
        <a href="user_management.php" class="btn btn-danger">Avbryt</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const classButtons = document.querySelectorAll('.class-button');

        classButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                button.classList.toggle('selected');
                updateHiddenInput();
            });
        });

        function updateHiddenInput() {
            const selectedButtons = document.querySelectorAll('.class-button.selected');
            const accessArray = Array.from(selectedButtons).map(button => button.getAttribute('data-class-id'));
            document.getElementById('hiddenAccessInput').value = accessArray.join('-');
        }
    });

    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
</script>
</body>

</html>
