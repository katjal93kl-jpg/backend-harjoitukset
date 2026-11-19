<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php
  if(isset($_SESSION['sposti'])) #estetään käyttäjältä kirjautumisen jälkeen suora pääsy login.php ja register.php tiedostoihin, eli tarkistetaan sessionit! 
    {
      header("location: index.php");
    }

  if(isset($_POST['submit']))
    {
        if($_POST['email'] == '' OR $_POST['password'] == '')#katsotaan onko nämä kaikki tiedot lähetetty
          {
            echo "Täytä kaikki kentät";
          }
        else
          {
            $sposti = $_POST['email'];#ottaa spostin vastaan
            $salasana = $_POST['password'];
          }

      $komento = "SELECT * FROM kayttajat WHERE sposti = '$sposti'"; #tarkistetaan onko sposti oikein
      $kirjaudu = $yhteys->query($komento); #ottaa komentolauseesta sql lauseen
      $kirjaudu->execute(); #ajaa kirjautumisen

      $data = $kirjaudu->fetch(PDO::FETCH_ASSOC); #fetch_associlla ajetaan tiedot data-nimiseen muuttujaan
      if($kirjaudu->rowCount() > 0) #tarkistaa onko tietokannassa sähköpostia esim.
        {
          if(password_verify($salasana, $data['salasana']))
            {
              #echo "Olet kirjautunut.";
              $_SESSION['sposti'] = $data['sposti'];

              header("location: index.php");
            } #kun salasana on tarkistettu ja on oikein, niin käyttäjä ohjataan kirjautumisesta index.php sivulle!
          else
            {
              echo "Sähköposti tai salasana on väärin.";
            }

        }
        else
          {
            echo "Sähköposti on väärin.";
          }
    }
?>

<main class="form-signin w-50 m-auto">
  <form method="POST" action="login.php">
    <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="h3 mt-5 fw-normal text-center">Ole hyvä ja kirjaudu</h1>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Sähköpostiosoite</label>
    </div>
    <!-- <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="user.name">
      <label for="floatingInput">Käyttäjätunnus</label>
    </div> -->
    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Salasana</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Kirjaudu</button>
    <h6 class="mt-3">Jos sinulla ei ole käyttäjätunnusta  <a href="register.php">Luo tunnus</a></h6>
  </form>
</main>
<?php require "includes/footer.php"; ?>