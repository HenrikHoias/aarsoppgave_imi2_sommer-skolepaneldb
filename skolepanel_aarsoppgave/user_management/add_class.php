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

// Håndterer legge til ny klasse
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_class'])) {
    $className = mysqli_real_escape_string($conn, $_POST['class_name']);

    $insertQuery = "INSERT INTO classes (class_name) VALUES ('$className')";
    $resultInsert = mysqli_query($conn, $insertQuery);

    if ($resultInsert) {
        header("Location: add_class.php?msg=Klasse lagt til!");
        exit();
    } else {
        echo "Feil ved oppretting av ny klasse.";
        exit();
    }
}

// Håndterer endre klassenavn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_class'])) {
    $classId = $_POST['class_id'];
    $newClassName = mysqli_real_escape_string($conn, $_POST['new_class_name']);

    // Hent det gamle klassenavnet
    $getClassQuery = "SELECT class_name FROM classes WHERE id='$classId'";
    $resultClass = mysqli_query($conn, $getClassQuery);
    $oldClassName = mysqli_fetch_assoc($resultClass)['class_name'];

    // Oppdater klassenavnet i "classes" tabellen
    $updateQuery = "UPDATE classes SET class_name='$newClassName' WHERE id='$classId'";
    $resultUpdate = mysqli_query($conn, $updateQuery);

    // Oppdater klassenavnet i "students" tabellen
    $updateStudentsQuery = "UPDATE students SET class='$newClassName' WHERE class='$oldClassName'";
    $resultUpdateStudents = mysqli_query($conn, $updateStudentsQuery);

    if ($resultUpdate && $resultUpdateStudents) {
        header("Location: add_class.php?msg=Klassenavn oppdatert!");
        exit();
    } else {
        echo "Feil ved oppdatering av klassenavn.";
        exit();
    }
}

// Håndterer slette klasse
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_class'])) {
    $classId = $_POST['class_id'];

    $deleteQuery = "DELETE FROM classes WHERE id='$classId'";
    $resultDelete = mysqli_query($conn, $deleteQuery);

    if ($resultDelete) {
        header("Location: add_class.php?msg=Klasse slettet!");
        exit();
    } else {
        echo "Feil ved sletting av klasse.";
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

    <title>Tilpass klasser</title>
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
</head>

<body>
    <nav class="navbar navbar-light justify-content-between fs-4 mb-5 custom-navlinks text-white">
        <a href="user_management.php" class="btn btn-outline-light"><i class="fas fa-arrow-left hover:text-black"></i> Tilbake</a>
    </nav>
    
    <div class="container bg-white p-5 rounded-5 mb-5">
        <?php if (isset($_GET['msg'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_GET['msg']; ?>
            </div>
        <?php endif; ?>

        <!-- Legg til ny klasse -->
        <form method="post" action="add_class.php">
            <div class="mb-3">
                <label for="class_name" class="form-label">Ny klasse:</label>
                <input type="text" class="form-control" id="class_name" name="class_name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_class">Legg til</button>
        </form>

        <hr>

        <!-- Liste over eksisterende klasser med mulighet for å endre eller slette -->
        <ul class="list-group mt-3">
            <?php
            $queryClasses = "SELECT * FROM classes";
            $resultClasses = mysqli_query($conn, $queryClasses);

            if (mysqli_num_rows($resultClasses) > 0) {
                while ($row = mysqli_fetch_assoc($resultClasses)) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                    echo $row['class_name'];
                    echo "<div class='btn-group'>";
                    echo "<button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal{$row['id']}'><i class='fas fa-edit'></i></button>";
                    echo "<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal{$row['id']}'><i class='fas fa-trash'></i></button>";
                    echo "</div>";
                    echo "</li>";

                    // Modal for endring av klassenavn
                    echo "<div class='modal fade' id='editModal{$row['id']}' tabindex='-1'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title'>Endre klassenavn</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<form method='post' action='add_class.php'>";
                    echo "<div class='modal-body'>";
                    echo "<input type='hidden' name='class_id' value='{$row['id']}'>";
                    echo "<input type='text' class='form-control' name='new_class_name' value='{$row['class_name']}' required>";
                    echo "</div>";
                    echo "<div class='modal-footer'>";
                    echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Avbryt</button>";
                    echo "<button type='submit' class='btn btn-primary' name='edit_class'>Lagre endringer</button>";
                    echo "</div>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    // Modal for sletting av klasse
                    echo "<div class='modal fade' id='deleteModal{$row['id']}' tabindex='-1'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title'>Slett klasse</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                    echo "Er du sikker på at du vil slette denne klassen?";
                    echo "</div>";
                    echo "<div class='modal-footer'>";
                    echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Avbryt</button>";
                    echo "<form method='post' action='add_class.php'>";
                    echo "<input type='hidden' name='class_id' value='{$row['id']}'>";
                    echo "<button type='submit' class='btn btn-danger' name='delete_class'>Slett</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<li class='list-group-item'>Ingen klasser tilgjengelig.</li>";
            }
            ?>
        </ul>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <!-- Font Awesome JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
        integrity="sha512-gem4up8i+yTYb3FbFyt4Lr+fpFTlqjb+Thcv3A9+It9J7hIh8udboNXPkvxY1yF7CQDZf3s+lPhTZrS3Zjz4Vg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
