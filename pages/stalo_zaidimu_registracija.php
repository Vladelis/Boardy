<?php
include 'dbh.php';

// Patikrina ar kas prisijunges, jei ne kill
if(empty($_SESSION['user'])) {
    header("Location: index.php");
    die();
}
// Tik darbuotojas(id = 2) ir vadybininkas(id = 3)
if($_SESSION['user']['fk_role_id']!=2 && $_SESSION['user']['fk_role_id']!=3) {
    header("Location: index.php");
    die();
}
// Patikrinti ar prisijunges kaip darbuotojas/vadybininkas
//matoma tik darbuotojams/vadybininkams
?>
<html>
    <body> 
<?php
    $gameTitleErr =  $gameLengthErr = $playersErr = $playersAgeErr = $descriptionErr = $photoErr= $categoryErr = $languageErr = $yearsErr = $producerErr = $countryErr ="";
    $gameTitle = $gameLength = $players = $playersAge = $description = $years = $producer = $photo = "";
    $language = $country = $category = "Pasirinkite";
    $pap = $apd = $mok = 0;
    if(isset($_POST['submit']))
    {
        $uzpildyta = true;
        //tikrinti visus laukus
        if (empty($_POST["gameTitle"])) {
            $gameTitleErr = "*Neįvestas pavadinimas!";
            $uzpildyta = false;
        } else {
            $gameTitle = test_input($_POST["gameTitle"]);
        }
        if (empty($_POST["gameLength"])) {
            $gameLengthErr = "*Neįvesta trukmė!";
            $uzpildyta = false;
        } else {
            $gameLength = test_input($_POST["gameLength"]);
        }
        if (empty($_POST["players"])) {
            $playersErr = "*Neįvestas žaidėjų skaičius!";
            $uzpildyta = false;
        } else {
            $players = test_input($_POST["players"]);
        }
        if (empty($_POST["playersAge"])) {
            $playersAgeErr = "*Neįvestas žaidėjų amžius!";
            $uzpildyta = false;
        } else {
            $playersAge = test_input($_POST["playersAge"]);
        }
        if (empty($_POST["description"])) {
            $descriptionErr = "*Neįvestas aprašymas!";
            $uzpildyta = false;
        } else {
            $description = test_input($_POST["description"]);
        }
        if (($_POST["category"])=="Pasirinkite") {
            $categoryErr = "*Neparinkta kategorija!";
            $uzpildyta = false;
        } else {
            $category = test_input($_POST["category"]);
        }
        if (($_POST["language"])=="Pasirinkite") {
            $languageErr = "*Neparinkta kalba!";
            $uzpildyta = false;
        } else {
            $language = test_input($_POST["language"]);
        }
        if (empty($_POST["years"])) {
            $yearsErr = "*Neįvesti metai!";
            $uzpildyta = false;
        } else {
            $years = test_input($_POST["years"]);
        }
        if (empty($_POST["producer"])) {
            $producerErr = "*Neįvestas gamintojas!";
            $uzpildyta = false;
        } else {
            $producer = test_input($_POST["producer"]);
        }
        if (($_POST["country"])=="Pasirinkite") {
            $countryErr = "*Neparinkta šalis!";
            $uzpildyta = false;
        } else {
            $country = test_input($_POST["country"]);
        }
        if (!is_uploaded_file($_FILES['img']['tmp_name']))
        {
            $photoErr = "*Neįkelta nuotrauka!";
            $uzpildyta = false;
            echo "<script type='text/javascript'>alert('foto');</script>";
        } else{
            $photo = addslashes (file_get_contents($_FILES['img']['tmp_name']));
        }
        
        if(isset($_POST['pap']))
        {
            $pap = 1;
        }
        if(isset($_POST['mok']))
        {
            $mok = 1;
        }
        if(isset($_POST['apd']))
        {
            $apd = 1;
        }
        if($uzpildyta == true)
        {
            $sql = "INSERT INTO Zaidimas (pavadinimas, zaidimo_trukme, zaideju_skaicius, aprasymas, nuotrauka, kalba,
                gamintojas, zaideju_amzius, turi_papildymu, gamintojo_salis, mokomasis, isleidimo_metai, turi_apdovanojimu, kategorijos_id) 
                    VALUES ('$gameTitle', '$gameLength', '$players', '$description', '$photo', '$language', '$producer',"
                    . "'$playersAge', '$pap', '$country', '$mok', '$years', '$apd', '$category')";
            $result = mysqli_query($conn, $sql);
            $message = "Sukurtas naujas stalo žaidimas!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
?>
    <form class="form-horizontal" method="post" enctype="multipart/form-data"> 
      <fieldset>
    <div class="col-md-7">
        <legend>Naujas stalo žaidimas</legend>
        <div class="form-group">
          <label for="gameTitle" class="col-lg-2 control-label">Pavadinimas</label>
          <div class="col-lg-10">
            <input type="text" name="gameTitle"  class="form-control" id="gameTitle" placeholder="Pavadinimas" value="<?php echo $gameTitle;?>">
            <span class="error"><?php echo $gameTitleErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="gamelength" class="col-lg-2 control-label">Žaidimo trukmė</label>
          <div class="col-lg-10">
            <input  type="text" name="gameLength" class="form-control" id="gamelength" placeholder="Žaidimo trukmė" value="<?php echo $gameLength;?>">
            <span class="error"><?php echo $gameLengthErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="players" class="col-lg-2 control-label">Žaidėjų skaičius</label>
          <div class="col-lg-10">
            <input type="text" name="players"  class="form-control" id="players" placeholder="Žaidėjų skaičius" value="<?php echo $players;?>">
            <span class="error"><?php echo $playersErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="playersAge" class="col-lg-2 control-label">Žaidėjų amžius</label>
          <div class="col-lg-10">
            <input type="text" name="playersAge"  class="form-control" id="playersAge" placeholder="Žaidėjų amžius" value="<?php echo $playersAge;?>">
            <span class="error"><?php echo $playersAgeErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-lg-2 control-label">Aprašymas</label>
          <div class="col-lg-10">
            <textarea class="form-control" name="description" rows="3" id="description"><?php echo $description;?></textarea>
            <span class="error"><?php echo $descriptionErr;?></span>
          </div>
        </div>
        <div class="form-group">
            <label for="photo" class="col-lg-2 control-label">Žaidimo nuotrauka</label>
            <div class="col-lg-10">
                <input type="file" id="photo" name="img">
                <span class="error"><?php echo $photoErr;?></span>
            </div>
        </div>
    </div>
    <div class="col-md-5">
          <br>
          <br>
          <br>  
        <div class="form-group">
          <label for="category" class="col-lg-3 control-label">Kategorija</label>
          <div class="col-lg-8">
              <?php
                $sqlI = "SELECT id, pavadinimas FROM Zaidimo_kategorija"; 
                $resultI = mysqli_query($conn, $sqlI);
              ?>
            <select class="form-control" id="category" name="category">
              <option selected><?php echo $category;?></option>
              <?php
                while($row = mysqli_fetch_array($resultI)) {
                    echo'<option value='.$row[id].'>'.$row[pavadinimas].'</option>';
                }
              ?> 
            </select>
              <span class="error"><?php echo $languageErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="language" class="col-lg-3 control-label">Kalba</label>
          <div class="col-lg-8">
            <select class="form-control" id="language" name="language">
              <option selected><?php echo $language;?></option>
              <option>Lietuvių</option>
              <option>Anglų</option>
              <option>Rusų</option>
              <option>Vokiečių</option>
            </select>
              <span class="error"><?php echo $languageErr;?></span>
          </div>
        </div>
         <div class="form-group">
          <label for="years" class="col-lg-3 control-label">Išleidimo metai</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="years" name="years" placeholder="Išleidimo metai" value="<?php echo $years;?>">
            <span class="error"><?php echo $yearsErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="producer" class="col-lg-3 control-label">Gamintojas</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="producer" name="producer" placeholder="Gamintojas" value="<?php echo $producer;?>">
            <span class="error"><?php echo $producerErr;?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="country" class="col-lg-3 control-label">Gamintojo šalis</label>
          <div class="col-lg-8">
            <select class="form-control" id="country" name="country">
              <option selected><?php echo $country;?></option>
              <option>Lietuva</option>
              <option>JAV</option>
              <option>Kinija</option>
              <option>Vokietija</option>
            </select>
            <span class="error"><?php echo $countryErr;?></span>
          </div>
        </div>
        <div class="checkbox">
              <label>
                <input type="checkbox" name="pap" <?php if (isset($pap) && ($pap!=0)) {echo "checked";}?>> Turi papildymų
              </label>
        </div>
        <div class="checkbox">
              <label>
                <input type="checkbox" name="apd" <?php if (isset($apd) && ($apd!=0)) {echo "checked";}?>> Turi apdovanojimų
              </label>
        </div>
        <div class="checkbox">
              <label>
                <input type="checkbox" name="mok" <?php if (isset($mok) && ($mok!=0)) {echo "checked";}?>> Mokomasis žaidimas
              </label>
        </div>
        <br>
        <input style="float: right;" class="btn btn-primary" type="submit" name="submit" value="Pateikti">  
    </div>
          </fieldset>
        </form>
        </body> 
</html>
<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
