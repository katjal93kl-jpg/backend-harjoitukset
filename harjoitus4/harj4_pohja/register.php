<?php 
  require "includes/header.php"; 
  require "config.php";

  if(isset($_SESSION['sposti'])) #estetään käyttäjältä kirjautumisen jälkeen suora pääsy login.php ja register.php tiedostoihin, eli tarkistetaan sessionit! 
    {
      header("location: index.php");
    }

  if(isset($_POST['submit']))
    {
        if($_POST['email'] == '' OR $_POST['username'] == '' OR $_POST['password'] == '')#katsotaan onko email lähetetty
          {
            echo "Täytä kaikki kentät";
          }
        else
          {
            $sposti = $_POST['email'];#ottaa spostin vastaan
            $tunnus = $_POST['username'];
            $salasana = $_POST['password'];

            $lisays = "INSERT INTO kayttajat (sposti, tunnus, salasana) VALUES (:sposti, :tunnus, :salasana)";
            $lisaa = $yhteys->prepare($lisays);
            $lisaa->execute([ #suorittaa edellisen lauseen
              ':sposti' => $sposti,
              ':tunnus' => $tunnus,
              ':salasana' => password_hash($salasana, PASSWORD_DEFAULT), #salasanan suojaus suoritetaan samalla
            ]);
          }
    }

?>

<main class="form-signin w-50 m-auto">
  <form method="POST" action="register.php">
   
    <h1 class="h3 mt-5 fw-normal text-center">Ole hyvä ja rekisteröidy</h1>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Sähköpostiosoite</label>
    </div>

    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username">
      <label for="floatingInput">Käyttäjätunnus</label>
    </div>

    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Salasana</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">rekisteröidy</button>
    <h6 class="mt-3">Jos sinulla on jo käyttäjätunnus?  <a href="login.php">Kirjaudu</a></h6>

  </form>
</main>
<?php require "includes/footer.php"; ?>