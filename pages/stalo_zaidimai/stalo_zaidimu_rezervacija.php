<?php
include 'dbh.php';
//pateikti visą informaciją apie žaidimą ir leisti jį rezervuoti
if(isset($_GET['id'])) {
$sql = "SELECT * FROM Zaidimas WHERE id=" .$_GET['id'];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
}
?>

<form class="form-horizontal" method="post" enctype="multipart/form-data"> 
      <fieldset>
    <div class="col-md-6">
        <legend><?php echo $row["pavadinimas"];?></legend>
        <div class="form-group">
            <span style="font-weight: bold;">Žaidimo trukmė: <?php echo $row["zaidimo_trukme"];?></span>
        </div>
        <div class="form-group">
            <span>Žaidėjų skaičius: <?php echo $row["zaideju_skaicius"];?></span>
        </div>
        <div class="form-group">
            <span>Žaidėjų amžius: <?php echo $row["zaideju_amzius"];?></span>
        </div>
        <div class="form-group">
            <span>Kalba: <?php echo $row["kalba"];?></span>
        </div>
        <div class="form-group">
            <span>Išleidimo metai: <?php echo $row["isleidimo_metai"];?></span>
        </div>
        <div class="form-group">
            <span>Gamintojas: <?php echo $row["gamintojas"];?></span>
        </div>
        <div class="form-group">
            <span>Gamintojo šalis: <?php echo $row["gamintojo_salis"];?></span>
        </div>
        <?php 
        if($row["turi_papildymu"] == 1)
        {?>
        <div class="form-group">
            <p style="text-align:justify;"> Žaidimui yra sukurta papildymų!</p>
        </div>
        <?php 
        }
        if($row["mokomasis"] == 1)
        {
        ?>
        <div class="form-group">
            <p style="text-align:justify;"> Tai yra mokomasis žaidimas</p>
        </div>
        <?php 
        }
        if($row["turi_apdovanojimu"] == 1)
        {
        ?>
        <div class="form-group">
            <p style="text-align:justify;"> Stalo žaidimas iškovojo tarptautinių apdovanojimų!</p>
        </div>
        <?php 
        }
        ?>
        <div class="form-group">
            <p style="font-style: italic; text-align:justify;"> <?php echo $row["aprasymas"];?></p>
        </div>
        <br>
        <a href="#" class="btn btn-success">Rezervuoti</a>
        <!--
        <br>
        <input style="float: right;" class="btn btn-primary" type="submit" name="submit" value="Pateikti">  
        -->
    </div>
        <div class="col-md-6">
            <?php  echo '<img class="img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row['nuotrauka'] ).'"  alt="">';?>
        </div>
          </fieldset>
        </form>

