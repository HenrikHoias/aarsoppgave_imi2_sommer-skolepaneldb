<?php
session_start();
include "../db_conn.php";

// Viderekobler til påloggingssiden hvis brukeren ikke er pålogget
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Legg til sikkerhetstiltak, for eksempel validering av $id og beskyttelse mot SQL-injeksjon

    // Hent tilgangsnivået for user fra sesjonen
    $usernameOrMail = $_SESSION['username'];
    $sqlUserAccess = "SELECT access FROM users WHERE username = '$usernameOrMail' OR mail = '$usernameOrMail'";
    $resultUserAccess = mysqli_query($conn, $sqlUserAccess);

    if ($resultUserAccess) {
        $UserAccess = mysqli_fetch_assoc($resultUserAccess)['access'];
    }

    // Sjekk om user har tilgangsnivået "*"
    if (strpos($UserAccess, '*') !== false) {
        // Brukeren har tilgangsnivået "*", derfor slett brukeren med den gitte ID-en
        $query = "DELETE FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $query);

        // Legg til sjekk for vellykket sletting og send brukeren tilbake til administrasjonssiden
        if ($result) {
            header("Location: user_management.php?msg=Brukeren ble fjernet vellykket");
            exit();
        } else {
            header("Location: user_management.php?msg=Feil ved fjerning av bruker");
            exit();
        }
    } else {
        // Hvis user ikke har tilgangsnivået "*", send brukeren tilbake til administrasjonssiden med en feilmelding
        header("Location: user_management.php?msg=Du har ikke tilgang til å gjøre dette");
        exit();
    }
} else {
    // Hvis ingen ID ble sendt, send brukeren tilbake til administrasjonssiden med en feilmelding
    header("Location: user_management.php?msg=Manglende bruker-ID");
    exit();
}
?>
