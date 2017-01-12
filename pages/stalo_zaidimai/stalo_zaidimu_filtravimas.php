<?php
include 'dbh.php';
$adresas = "/Boardy/index.php?module=stalo_zaidimu_perziura";
if(isset($_POST['filtravimas']))
{
    if (($_POST["age"])!="-") {
        $adresas = $adresas.''."&amzius=".''.$_POST["age"];
    }
    if (($_POST["amount"])!="-") {
        $adresas = $adresas.''."&kiekis=".''.$_POST["amount"];
    }
    if (($_POST["genre"])!="-") {
        $adresas = $adresas.''."&zanras=".''.$_POST["genre"];
    }
    if (($_POST["length"])!="-") {
        $adresas = $adresas.''."&trukme=".''.$_POST["length"];
    }
    ('Location: '. $adresas);
}
?>
<form class="form-horizontal" method="post" enctype="multipart/form-data"> 
    <fieldset>
        <div class="col-md-5">
            <div class="form-group">
                <label for="age" class="col-lg-7 control-label">Žaidėjų amžius</label>
                    <div class="col-lg-4">
                        <select class="form-control" id="age" name="age">
                          <option selected>-</option>
                          <option>3+</option>
                          <option>7+</option>
                          <option>10+</option>
                          <option>12+</option>
                          <option>18+</option>
                        </select>
                    </div>
                <label for="amount" class="col-lg-7 control-label">Žaidėjų kiekis</label>
                    <div class="col-lg-4">
                        <select class="form-control" id="amount" name="amount">
                          <option selected>-</option>
                          <option>2+</option>
                          <option>3+</option>
                          <option>4+</option>
                        </select>
                    </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="form-group">
                <label for="genre" class="col-lg-7 control-label">Žanras</label>
                    <div class="col-lg-4">
                        <?php
                            $sqlI = "SELECT id, pavadinimas FROM Zaidimo_kategorija"; 
                            $resultI = mysqli_query($conn, $sqlI);
                          ?>
                        <select class="form-control" id="genre" name="genre">
                          <option selected>-</option>
                          <?php
                            while($row = mysqli_fetch_array($resultI)) {
                                echo'<option value='.$row[id].'>'.$row[pavadinimas].'</option>';
                            }
                          ?> 
                        </select>
                    </div>
                <label for="length" class="col-lg-7 control-label">Žaidimo trukmė</label>
                    <div class="col-lg-4">
                        <select class="form-control" id="length" name="length">
                          <option selected>-</option>
                          <option><=30min</option>
                          <option>>30min</option>
                        </select>
                    </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input name="filtravimas" type="submit" class="btn btn-primary" value="Filtruoti">  
            </div>
        </div>
        
    </fieldset>
</form>