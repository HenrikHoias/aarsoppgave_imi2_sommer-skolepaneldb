<?php
session_start();

include "../db_conn.php";

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['username'])) {
    // Hvis ikke, redirect til login-siden
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

// Hent lærerdata fra databasen
$queryTeachers = "SELECT id, username, access FROM users";
$resultTeachers = mysqli_query($conn, $queryTeachers);

// Hent klassedata fra databasen
$queryClasses = "SELECT id, class_name FROM classes";
$resultClasses = mysqli_query($conn, $queryClasses);

// Lagre lærerdata i en array
$teachers = [];
while ($rowTeacher = mysqli_fetch_assoc($resultTeachers)) {
    $teachers[] = $rowTeacher;
}

// Lagre klassedata i en array
$classes = [];
while ($rowClass = mysqli_fetch_assoc($resultClasses)) {
    $classes[] = $rowClass;
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css"/>

    <title>Brukeradministrasjon</title>
<style>
.table {
    border-collapse: collapse;
}

.table th,
.table td {
    border: none;
}

.table thead td {
    border-bottom: none;
}

.table tbody td {
    border-top: none;
}
table.table tr:nth-child(odd) {
    background-color: #FFFFFF;
    border: none;
}

table.table tr:nth-child(even) {
    background-color: #FFFFFF;
    border: none;
}

@media (max-width: 768px) {
    /* Stiler som bare gjelder for skjermbredder mindre enn eller lik 768px */
    .table th:nth-child(2),
    .table td:nth-child(2) {
        display: none; /* Skjul Klassetilgang på små skjermer */
    }
}

@media (min-width: 769px) {
    /* Stiler som bare gjelder for skjermbredder større enn eller lik 769px */
    .table th:nth-child(2),
    .table td:nth-child(2) {
        display: table-cell; /* Vis Klassetilgang på store skjermer */
    }
}

</style>

</head>

<body>
<nav class="fs-6 mb-5 text-dark custom-navlinks">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="../index.php">
            <div>
                <img id="logo" src="../images/eleva_alt_text_logo.svg" alt="Eleva" class="px-2"></img>
            </div>
        </a>
        <div class="d-flex d-lg-flex fs-6">
            <a href="../index.php" class="nav-link" style="display: inline-block; margin-right: 20px;">Forside</a>
            <a href="../absence/absence.php" class="nav-link" style="display: inline-block; margin-right: 20px;">Fravær</a>
            <a href="../annotation/annotation.php" class="nav-link" style="display: inline-block; margin-right: 20px;">Anmerkninger</a>
            <a href="../faq/faq.php" class="nav-link" style="display: inline-block;">FAQ</a>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown fs-5">
                <a class="nav-link dropdown-toggle-no-caret" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 20px;">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../index.php">Forside</a>
                    <a class="dropdown-item" href="../absence/absence.php">Fravær</a>
                    <a class="dropdown-item" href="../annotation/annotation.php">Anmerkninger</a>
                    <a class="dropdown-item" href="../faq/faq.php">FAQ</a>
                </div>
            </div>

            <div class="dropdown fs-5">
                <a class="nav-link dropdown-toggle-no-caret" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 20px;">
                    <i class="fas fa-circle-question"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="files/sluttbruker_eleva.pdf">Opplæringsmateriell</a>
                    <a class="dropdown-item" href="#kontakt">Kontakt oss</a>
                </div>
            </div>

            <div class="dropdown fs-5">
                <a class="nav-link dropdown-toggle-no-caret" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"><b><?php echo $_SESSION['username'] ?></b></a>
                    <a class="dropdown-item" href="../logout.php">Logg ut</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container bg-white p-4 rounded-5 mb-5">
    <div class="container">
        <h3 class="my-2">Brukeradministrasjon</h3>
        <div class="d-flex justify-content-between align-items-center">
            <p>Tilgangsnivå: <span class="bg-warning rounded p-1 px-2 text-center">Administrator</span></p>
        </div>
    </div>
</div>

<div class="container">
    <?php
    // Sjekker om det er satt en "msg"-parameter i URL-en
    if (isset($_GET["msg"])) {
        // Henter meldingen fra "msg"-parameteren
        $msg = $_GET["msg"];

        // Viser en grønn Bootstrap-varsling for suksess, med en lukkeknapp
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
</div>

<div class="container bg-white p-4 rounded-5 mb-5">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Lærernavn</th>
            <th>Klassetilgang</th>
            <th class="text-end">Handlinger</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($teachers as $teacher) : ?>

        <?php
        $accessLevels = explode('-', $teacher['access']);
                
        // Skip the row if the access level is "*"
        if (in_array('*', $accessLevels)) {
            continue;
        }
        ?>
        <tr>
            <td style="border-radius: 10px;"><?php echo $teacher['username']; ?></td>
            <td style="border-radius: 10px;">
                <?php
                $classNames = [];
                foreach ($accessLevels as $key => $accessLevel) {
                    foreach ($classes as $class) {
                        if ($accessLevel == $class['id']) {
                            $classNames[] = '<span class="p-2 rounded-2" style="background-color: #E5E5E5;">' . $class['class_name'] . '</span>';

                            // Add a class separator for multiple classes
                            if ($key < count($accessLevels) - 1) {
                                $classNames[] = '<span class="p-1"></span>';
                            }
                        }
                    }
                }
                echo implode('', $classNames);
                ?>
            </td>
            <td class="text-end">
                <div class="btn-group">
                    <a href="edit_user.php?id=<?php echo $teacher['id']; ?>" class="btn rounded-end" style="background-color: #FBECC7;margin-right: 20px;">Endre bruker</a>
                    <form method="post" action="delete_user.php?id=<?php echo $teacher['id']; ?>">
                        <button type="submit" class="btn" style="background-color:#FBD2C7;">Fjern bruker</button>
                    </form>
                </div>
            </td>
        </tr>

    <?php endforeach; ?>
    
</tbody>
    </table>
    <tr>
        <td>
            <a href="add_user.php">
                <button type="submit" class="btn" style="background-color: #DCFBC7;">Legg til lærer</button>
            </a>
        </td>
        <td>
            <a href="add_class.php">
                <button type="submit" class="btn" style="background-color: #C7E1FB;">Tilpass klasser</button>
            </a>
        </td>
    </tr>
  </div>
  </div>
</div>
</div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script>
        var commentTextarea = document.getElementById("melding");
        var chartCount = document.getElementById("chartCount");

        commentTextarea.addEventListener("input", function () {
        var currentLength = commentTextarea.value.length;
        chartCount.textContent = currentLength + " / 200";
        });
    </script>

    <script>
    function updateLogo() {
        var logo = document.getElementById("logo");
        if (window.innerWidth < 365) {
            logo.src = "../images/eleva_alt_logo.svg";
        } else {
            logo.src = "../images/eleva_alt_text_logo.svg";
        }
    }

    window.onload = updateLogo;
    window.onresize = updateLogo;
    </script>

    <script>
        
    </script>

</body>

</html>
