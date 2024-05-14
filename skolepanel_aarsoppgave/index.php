<?php
session_start();

include "db_conn.php";

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['username'])) {
    // Hvis ikke, redirect til login-siden
    header("Location: login.php");
    exit();
}

// Hent brukerens tilgangsnivå fra databasen
$username = $_SESSION['username'];
$queryUserAccess = "SELECT access FROM users WHERE username='$username'";
$resultUserAccess = mysqli_query($conn, $queryUserAccess);
$accessLevels = mysqli_fetch_assoc($resultUserAccess)['access'];

// Konverter strengen til et array for enkel sjekk
$accessLevels = explode('-', $accessLevels);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon Eleva -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon"/>

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
    <link rel="stylesheet" href="style.css"/>

    <title>Forside</title>
</head>

<body>
<nav class="fs-6 mb-5 text-dark custom-navlinks">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="index.php">
            <div>
                <img id="logo" src="images/eleva_alt_text_logo.svg" alt="Eleva" class="px-2"></img>
            </div>
        </a>
        <div class="d-flex d-lg-flex fs-6">
            <a href="index.php" class="nav-link" style="display: inline-block; margin-right: 20px;">Forside</a>
            <a href="absence/absence.php" class="nav-link" style="display: inline-block; margin-right: 20px;">Fravær</a>
            <a href="annotation/annotation.php" class="nav-link" style="display: inline-block; margin-right: 20px;">Anmerkninger</a>
            <a href="faq/faq.php" class="nav-link" style="display: inline-block;">FAQ</a>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown fs-5">
                <a class="nav-link dropdown-toggle-no-caret" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 20px;">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="index.php">Forside</a>
                    <a class="dropdown-item" href="absence/absence.php">Fravær</a>
                    <a class="dropdown-item" href="annotation/annotation.php">Anmerkninger</a>
                    <a class="dropdown-item" href="faq/faq.php">FAQ</a>
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
                    <?php if (in_array('*', $accessLevels)): ?>
                        <a class="dropdown-item" href="user_management/user_management.php">Administrer</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="logout.php">Logg ut</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <?php
    // Sjekker om det er satt en "msg"-parameter i URL-en
    if (isset($_GET["msg"])) {
        // Henter meldingen fra "msg"-parameteren
        $msg = $_GET["msg"];

        // Viser en grønn Bootstrap-varsling for suksess, med en lukkeknapp
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

    <h2 class="my-4">Om oss</h2>
    <hr>
    <p class="mb-5">Velkommen til Eleva, ditt dedikerte system for skoleadministrasjon. Vårt intuitive online-verktøy er utformet for å imøtekomme behovene til lærere og skoleansatte ved å samle viktige oppgaver på ett sted. Med Eleva kan fravær, notater, timeplaner og annen viktig elevinformasjon administreres med enkelhet og effektivitet. Vårt oppdrag er å lette administrativt arbeid, slik at lærere kan konsentrere seg om det som virkelig teller: å fremme elevens læring og vekst. <u><a href="#oversikt">Er du klar for en enklere skolehverdag?<a></u></p>
    
    <h2 id="oversikt" class="mb-3 text-center">Oversikt</h2>
    <div class="d-flex justify-content-center">
        <div class="row mx-auto">
            <div class="col-md-4">
                <div class="card d-flex flex-fill mb-5">
                    <div class="card-body">
                        <h2 class="card-title text-center p_oversikt_ele rodtone">Fravær</h2>
                        <p class="card-text">Les, sett og endre elevfravær samt elever på en enkel og intuitiv måte i vårt skolepanel.</p>
                        <a href="absence/absence.php" class="btn btn-primary mt-3">Gå til fravær</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card d-flex flex-fill mb-5">
                    <div class="card-body">
                    <h2 class="card-title text-center p_oversikt_ele grontone">Anmerkninger</h2>
                        <p class="card-text">Få oversikten over elevenes orden og atferd og ivareta skolereglene på en strukturert måte.</p>
                        <a href="annotation/annotation.php" class="btn btn-primary">Gå til anmerkninger</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card d-flex flex-fill mb-5">
                    <div class="card-body">
                        <h2 class="card-title text-center p_oversikt_ele gultone">FAQ</h2>
                        <p class="card-text">Utforsk våre FAQ-seksjon for svar på vanlige spørsmål som du kanskje lurer på.</p>
                        <a href="faq/faq.php" class="btn btn-primary">Gå til FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder innhold -->
    <h2 class="my-4">Informasjon</h2>
    <hr>
    <p class="mb-5">In vel neque imperdiet, posuere augue consectetur, porttitor nulla. Ut rutrum, augue sit amet pharetra varius, risus magna mattis orci, sit amet sagittis tortor eros quis velit. Vivamus ornare ultrices libero in consequat. Curabitur ut lacus ligula. Nunc cursus turpis augue, nec hendrerit ligula facilisis convallis. Etiam blandit consectetur massa non egestas. Sed turpis risus, scelerisque porta metus ut, molestie porta leo. Fusce hendrerit et enim eu mollis. Maecenas vel ligula accumsan, elementum dolor quis, volutpat libero. Sed fringilla nunc non sapien tempus, id fringilla risus tincidunt. Morbi ac velit eget augue facilisis pulvinar vel at arcu. Mauris dapibus viverra tincidunt.</p>

    <h2 class="my-4" id="kontakt">Kontakt oss</h2>
    <hr>
    <p>Vi er tilgjengelige på epost, telefon og har kontor i Professor Kohts vei 5. E-post: eleva@skolessy.no og telefon: +47 223 33 233.</p>
    <!-- Kontaktskjema -->
    <div class="mt-3 mb-5">
        <form action="contact_form.php" method="post">
            <div class="mb-3">
                <label for="melding" class="form-label">Hvordan kan vi forbedre oss? Jo mer du forteller oss, desto bedre kan vi hjelpe deg.</label>
                <textarea class="form-control" id="melding" name="melding" rows="5" maxlength="200" required></textarea>
                <div id="chartCount" class="mt-2">0 / 200</div>
            </div>
            <div class="container d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Send tilbakemelding</button>
            </div>
        </form>
    </div>

</div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous">
    </script>

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
            logo.src = "images/eleva_alt_logo.svg";
        } else {
            logo.src = "images/eleva_alt_text_logo.svg";
        }
    }

    window.onload = updateLogo;
    window.onresize = updateLogo;
    </script>

    <script>
        
    </script>

</body>

</html>
