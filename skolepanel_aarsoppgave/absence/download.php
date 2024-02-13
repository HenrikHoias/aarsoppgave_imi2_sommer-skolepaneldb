<?php
// download.php

// Inkluder filen for databaseforbindelse
include "../db_conn.php";

// Viderekobler til påloggingssiden hvis brukeren ikke er pålogget
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Henter brukerens tilgangsnivå fra databasen
$usernameOrMail = $_SESSION['username'];
$sqlUserAccess = "SELECT access FROM users WHERE username = '$usernameOrMail' OR mail = '$usernameOrMail'";
$resultUserAccess = mysqli_query($conn, $sqlUserAccess);

// Håndterer feil hvis brukerens tilgangsnivå ikke kan hentes
if (!$resultUserAccess) {
    die("Feil ved henting av brukerens tilgangsnivå: " . mysqli_error($conn));
}

// Henter brukerdata
$userData = mysqli_fetch_assoc($resultUserAccess);

// Håndterer feil hvis ingen brukerdata er funnet for brukernavnet eller e-postadressen
if (!$userData) {
    die("Ingen brukerdata funnet for brukernavnet eller e-postadressen: " . $usernameOrMail);
}

// Deler tilgangsnivåene og lager et array med klasse-navn
$accessLevels = explode("-", $userData['access']);
$classNames = array();

// Henter klassenavn basert på tilgangsnivået og legger dem til i arrayet
foreach ($accessLevels as $level) {
    if ($level === '*') {
        $sqlClassName = "SELECT class_name FROM classes";
    } else {
        $sqlClassName = "SELECT class_name FROM classes WHERE id = $level";
    }
    $resultClassName = mysqli_query($conn, $sqlClassName);

    // Håndterer feil hvis klassenavnet ikke kan hentes
    if (!$resultClassName) {
        die("Feil ved henting av klasse: " . mysqli_error($conn));
    }

    while ($dataClassName = mysqli_fetch_assoc($resultClassName)) {
        array_push($classNames, $dataClassName['class_name']);
    }
}

// Konverterer klassenavnene til en kommaseparert streng
$classNamesString = implode("', '", $classNames);

// Sett header for filtype
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=fravaer_data_' . date('m-d-Y') . '.xls'); // Legg til datoen i filnavnet

// Åpne output buffer
ob_start();

// Output CSV- eller XLS-data
echo "ID\tFornavn\tEtternavn\tKlasse\tFravær\tKommentar\n"; // Tabellhode

// Hent data fra databasen basert på de gitte klassene
$sqlStudents = "SELECT * FROM students WHERE class IN ('$classNamesString')";
$resultStudents = mysqli_query($conn, $sqlStudents);

// Hent data fra databasen og legg til i output
while ($row = mysqli_fetch_assoc($resultStudents)) {
    echo $row['id'] . "\t" . $row['first_name'] . "\t" . $row['last_name'] . "\t" . $row['class'] . "\t" . $row['absence'] . "\t" . $row['comment'] . "\n";
}

// Lukk output buffer og send fil til brukeren
ob_end_flush();
?>
