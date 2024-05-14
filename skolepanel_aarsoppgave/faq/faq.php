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

    <title>FAQ-Seksjon</title>
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
            <a href="" class="nav-link" style="display: inline-block;">FAQ</a>
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
                    <a class="dropdown-item" href="">FAQ</a>
                </div>
            </div>

            <div class="dropdown fs-5">
                <a class="nav-link dropdown-toggle-no-caret" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 20px;">
                    <i class="fas fa-circle-question"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../files/sluttbruker_eleva.pdf">Opplæringsmateriell</a>
                    <a class="dropdown-item" href="../#kontakt">Kontakt oss</a>
                </div>
            </div>

            <div class="dropdown fs-5">
                <a class="nav-link dropdown-toggle-no-caret" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"><b><?php echo $_SESSION['username'] ?></b></a>
                    <?php if (in_array('*', $accessLevels)): ?>
                        <a class="dropdown-item" href="../user_management/user_management.php">Administrer</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="../logout.php">Logg ut</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container mb-5">

    <h2 class="my-4 text-center">Ofte stilte spørsmål (FAQ)</h2>
    <hr>    
    <div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            Hvordan legger jeg til fravær for en elev?
        </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            For å registrere fravær på en enkel og nøyaktig måte, kan du følge disse trinnene: Klikk først på redigeringsikonet under "Handling". Deretter vil du se en liste over tilgjengelige alternativer, hvor du skal velge "Fravær". Under denne kategorien kan du velge den spesifikke typen fravær som er mest hensiktsmessig for eleven du registrerer fraværet for.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Hvordan registrerer jeg en ny elev i systemet?
        </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Å inkludere en ny elev i systemet er enkelt. Naviger nedover på siden og se etter knappen merket "Legg til elev". Ved å klikke på denne knappen, blir du veiledet gjennom prosessen med å legge til den nye eleven i systemet, slik at deres informasjon blir raskt og effektivt lagt til i elevdatabasen.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Kan jeg legge til anmerkninger for oppførsel eller faglig fremgang?
        </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            For å registrere fravær for en spesifikk elev, følg disse trinnene: Finn først den aktuelle eleven ved å se gjennom listen over elever. Deretter, ved siden av elevens navn, vil du se et plussikon. Klikk på dette ikonet, og du vil få muligheten til å velge en dato, det relevante faget og legge til eventuelle kommentarer som er nødvendige for å registrere fraværet nøyaktig.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
            Hvordan endrer jeg en elevs klasse eller informasjon?
        </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Å oppdatere elevens informasjon er en enkel prosess. Finn først elevens navn i systemet og klikk deretter på redigeringsikonet ved siden av det. Dette vil åpne et vindu der du kan gjøre nødvendige endringer i elevens informasjon, for eksempel kontaktinformasjon eller personlige opplysninger.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingFive">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
            Hvor finner jeg elevens timeplan?
        </button>
        </h2>
        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Utviklingen av Timeplan-funksjonen er en pågående prosess hos Eleva. Vi jobber kontinuerlig med å implementere denne funksjonaliteten, og den vil være tilgjengelig så snart den er klar for bruk.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingSix">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
            Hvordan kan jeg generere rapporter om elevens fravær eller akademisk ytelse?
        </button>
        </h2>
        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            For å laste ned fraværsdata for en hel klasse, kan du enkelt bruke nedlastingsalternativet som tilbys på plattformen. Se etter knappen merket "Last ned som XLS" og klikk på den. Dette vil generere en nedlastbar fil med fraværsdataene for den valgte klassen, slik at du kan analysere dem eller lagre dem for fremtidig referanse.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingSeven">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
            Hvilke rettigheter har ulike brukerroller i systemet?
        </button>
        </h2>
        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Brukerrollene på plattformen tilpasses individuelle behov og krav av administratorer. Administratoren har full kontroll over brukerrollene og kan tilpasse dem ved å legge til nye klasser, redigere brukerrettigheter og administrere tilgangen til ulike funksjoner og verktøy etter behov.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingEight">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
            Hvordan kan jeg kontakte systemstøtte hvis jeg opplever problemer med Eleva?
        </button>
        </h2>
        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Vi tilbyr flere måter å kontakte supportteamet vårt på for å få hjelp og assistanse. På forsiden av plattformen finner du et "Kontakt oss" -skjema som du kan fylle ut med dine spørsmål eller bekymringer. Alternativt kan du også nå oss direkte via e-post eller telefon på de oppgitte kontaktene. I tillegg tilbyr vi et spørsmålsikon i navigasjonsmenyen som gir tilgang til en omfattende "Opplæringsmateriell"-seksjon for teknisk support og veiledning.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingNine">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
            Er det mulig å synkronisere Eleva med andre skoleadministrative systemer?
        </button>
        </h2>
        <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Ved å laste ned elevdata som en XLS-fil, gir vi deg muligheten til å enkelt overføre historiske data til et annet system eller sikkerhetskopiere data for fremtidig bruk. Vi tilbyr imidlertid ikke direkte synkronisering med eksterne tjenester. Vår plattform er utstyrt med verktøy som dekker behovene for dataadministrasjon og sikkerhet internt.
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTen">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
            Kan elever eller foresatte få tilgang til sine egne data i systemet, for eksempel fraværsinformasjon eller karakterer?
        </button>
        </h2>
        <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            Den kommende funksjonaliteten er under aktiv utvikling, og vi forventer å lansere den så snart den er klar for bruk. Vi jobber kontinuerlig med å forbedre og utvide funksjonaliteten til plattformen vår for å møte behovene og forventningene til våre brukere.
        </div>
        </div>
    </div>
</div>


</div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous">
    </script>

    <script>
        // Vent til dokumentet er ferdig lastet
        document.addEventListener('DOMContentLoaded', function () {
            // Finn alle akkordionknappene
            var accordionButtons = document.querySelectorAll('.accordion-button');
                    accordions.forEach(function(accordion) {
                new bootstrap.Collapse(accordion, {
                    toggle: false // Slik at vi ikke lukker alle panelene samtidig
                });
            });

            // Gå gjennom hver akkordionknapp og legg til en hendelselytter
            accordionButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Finn målet for knappen basert på data-bs-target-attributtet
                    var target = document.querySelector(button.getAttribute('data-bs-target'));

                    // Sjekk om målet er skjult eller synlig
                    if (!target.classList.contains('show')) {
                        // Hvis skjult, vis målet og marker knappen som åpen
                        target.classList.add('show');
                        button.setAttribute('aria-expanded', 'true');
                    } else {
                        // Hvis synlig, skjul målet og marker knappen som lukket
                        target.classList.remove('show');
                        button.setAttribute('aria-expanded', 'false');
                    }
                });
            });
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
</body>
</html>