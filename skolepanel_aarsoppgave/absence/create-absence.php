<?php
session_start(); // Starter økten for å spore brukerens påloggingsstatus

include "../db_conn.php"; // Inkluderer filen for databaseforbindelse

// Viderekobler til påloggingssiden hvis brukeren ikke er pålogget
if (!isset($_SESSION['username'])) {
    // Hvis brukernavnet ikke er lagret som en sesjon, viderekoble til login-siden
    header("Location: ../login.php");
    exit();
}

// Henter brukerens tilgang til klasser fra databasen
$user_username = $_SESSION['username']; // Antar at brukerens brukernavn er lagret i sesjonen
$sql = "SELECT access FROM users WHERE username = '$user_username'";
$result = mysqli_query($conn, $sql);

// Opprett en array for å lagre klassene brukeren har tilgang til
$user_classes = array();
if ($row = mysqli_fetch_assoc($result)) {
    // Sjekk om brukeren har tilgang til alle klassene
    if ($row['access'] === "*") {
        // Hvis brukeren har tilgang til alle klassene, henter vi alle klassenavnene
        $sql_all_classes = "SELECT class_name FROM classes";
        $result_all_classes = mysqli_query($conn, $sql_all_classes);
        while ($row_all_classes = mysqli_fetch_assoc($result_all_classes)) {
            $user_classes[] = $row_all_classes['class_name'];
        }
    } else {
        // Hvis ikke, splitter vi strengen basert på skilletegnet "-"
        $access = explode("-", $row['access']);
        // Går gjennom hver ID og henter klassenavnet fra classes-tabellen
        foreach ($access as $class_id) {
            $class_id = intval($class_id); // Konverterer til heltall
            // Henter klassenavnet fra classes-tabellen
            $sql = "SELECT class_name FROM classes WHERE id = $class_id";
            $class_result = mysqli_query($conn, $sql);
            if ($class_row = mysqli_fetch_assoc($class_result)) {
                $user_classes[] = $class_row['class_name'];
            }
        }
    }
}

// Håndterer POST-forespørsler når skjemaet sendes inn
if (isset($_POST["submit"])) {
    // Henter verdier fra skjemaet
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $class = $_POST['class'];

    // SQL-setning for å legge til en ny elev i databasen
    $sql = "INSERT INTO `students`(`id`, `first_name`, `last_name`, `class`, `absence`) VALUES (NULL,'$first_name','$last_name','$class','Ingen')";

    // Utfører SQL-setningen
    $result = mysqli_query($conn, $sql);

    // Håndterer resultatet av SQL-setningen
    if ($result) {
        // Viderekobler til fraværssiden med melding om vellykket registrering
        header("Location: absence.php?msg=En ny elev er registrert");
    } else {
        // Skriver ut feilmelding hvis SQL-setningen mislykkes
        echo "Failed: " . mysqli_error($conn);
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

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <!-- Custom CSS -->
   <link rel="stylesheet" href="../style.css"/>
   <title>Fraværsoversikt</title>
</head>

<body>
<nav class="navbar navbar-light justify-content-center fs-4 mb-5 custom-navlinks text-white">
        Fraværsoversikt
</nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Legg til ny elev</h3>
         <p class="text-muted">Fyll ut skjemaet nedenfor for å legge til en ny elev</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Fornavn:</label>
                  <input type="text" class="form-control" name="first_name" placeholder="Fornavn">
               </div>

               <div class="col">
                  <label class="form-label">Etternavn:</label>
                  <input type="text" class="form-control" name="last_name" placeholder="Etternavn">
               </div>
            </div>

            <div class="mb-3">
               <label class="form-label">Klasse</label>
               <select class="form-select" name="class">
                  <?php foreach ($user_classes as $class_name): ?>
                     <option value="<?php echo $class_name; ?>"><?php echo $class_name; ?></option>
                  <?php endforeach; ?>
               </select>
            </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit">Opprett</button>
               <a href="absence.php" class="btn btn-danger">Avbryt</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
