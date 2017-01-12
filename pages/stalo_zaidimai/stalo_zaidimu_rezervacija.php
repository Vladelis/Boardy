<?php
include 'dbh.php';
$bendra_kaina = 0;
//pateikti visą informaciją apie žaidimą ir leisti jį rezervuoti
if(isset($_GET['id'])) {
    $sql = "SELECT * FROM Zaidimas WHERE id=" .$_GET['id'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
}

if(isset($_POST['patvirtinti']))
{
    $today = date("Y-m-d");  
    $from = ($_POST["from"]);
    $to = ($_POST["to"]);
    
    $datetime1 = strtotime($from);
    $datetime2 = strtotime($to);
    
    if($datetime1> $datetime2)
    {
        $message = "Neteisingai  įvestos datos!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else
    {
        $secs = $datetime2 - $datetime1;// == <seconds between the two times>
        $days = $secs / 86400;


        $sqlIns = "INSERT INTO Zaidimo_rezervacija (sukurimo_data, rezervavimo_data, rezervavimo_trukme, rezervavimo_kaina, zaidimo_id) VALUES(CAST('".$today."' AS DATE), CAST('".$from."' AS DATE), '".$days."', '".$days."', '".$_GET['id']."')";
        $resultIns = mysqli_query($conn, $sqlIns);

        //i sesija irasyti rezervacijos id     
        $rez_id = mysqli_insert_id($conn);
        if(!isset($_SESSION['rez_ids']))
        {
            $_SESSION['rez_ids'] = array();
        }
        array_push($_SESSION['rez_ids'],$rez_id);
        $message = "Jūsų stalo žaidimas užrezervuotas sistemoje!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if(isset($_POST['uzs']))
{
    $read = mysqli_query($conn, "SELECT redagavimu_kiekis FROM Uzsakymo_busena WHERE id = '1'");
    $row1 = mysqli_fetch_array($read);
    $kiek = $row1["redagavimu_kiekis"];
    // updatinti lentele
    $todayU = date("Y-m-d"); 
    $sqlBus = "UPDATE Uzsakymo_busena SET redagavimo_data=CAST('". $todayU."' AS DATE), redagavimu_kiekis=".++$kiek." WHERE id = '1'";
    $resultBus= mysqli_query($conn, $sqlBus);
    //tikrinti ar prisijunges kaip darbuotojas ar kaip klientas
    $busenos_id = 1;
    
    //is sesijos pasiimu bendra kaina
    $bendraK = $_SESSION["bendra_kaina"];
        
    if($_SESSION['user']['fk_role_id']==2 || $_SESSION['user']['fk_role_id']==3)
    {
        $darbuotojas_id = $_SESSION['user']['id'];
        //kazkaip ideti darbuotojo_id
        $sqlUzs = "INSERT INTO Uzsakymas(bendra_kaina, data, busenos_id, klientas_id, darbuotojas_id) VALUES(".$bendraK.",CAST('".$todayU."' AS DATE),".$busenos_id.",'',".$darbuotojas_id.")";
        $resultUzs = mysqli_query($conn, $sqlUzs);
        $uzs_id = mysqli_insert_id($conn);
        //ideti i uzsakymo rezervacija tiek kartu kiek buvo rezervaciju
        $a = count($_SESSION['rez_ids']);
        
        for ($x = 0; $x < $a; $x++) {
            $id = $_SESSION['rez_ids'][$x];
            $sql = "INSERT INTO Uzsakymo_rezervacija(uzsakymas_id, zaidimo_rezervacija_id) VALUES(".$uzs_id.",".$id.")";
            $u = mysqli_query($conn, $sql);
        } 
        
        
    }
    else if($_SESSION['user']['fk_role_id']==1){
        $klientas_id = $_SESSION['user']['id'];
        //kazkaip ideti kliento_id
        $sqlUzs = "INSERT INTO Uzsakymas(bendra_kaina, data, busenos_id, klientas_id, darbuotojas_id) VALUES(".$bendraK.",CAST('".$todayU."' AS DATE),".$busenos_id.",".$klientas_id.",'')";
        $resultUzs = mysqli_query($conn, $sqlUzs);
        $uzs_id = mysqli_insert_id($conn);
        //ideti i uzsakymo rezervacija tiek kartu kiek buvo rezervaciju
        $a = count($_SESSION['rez_ids']);
        for ($x = 0; $x < $a; $x++) {
            $id = $_SESSION['rez_ids'][$x];
            $sql = "INSERT INTO Uzsakymo_rezervacija(uzsakymas_id, zaidimo_rezervacija_id) VALUES(".$uzs_id.",".$id.")";
            $u = mysqli_query($conn, $sql);
        } 
    } 
         
    $message = "Jūsų užsakymas priimtas!";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

?>

<!--<form class="form-horizontal" method="post" enctype="multipart/form-data">-->
      <fieldset>
    <div class="col-md-6">
        <legend style="font-weight: bold;"><?php echo $row["pavadinimas"];?></legend>
        <div class="form-group">
            <span>Žaidimo trukmė: <?php echo $row["zaidimo_trukme"];?></span>
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
        
        <div class="container">
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Rezervuoti</button>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myTodal">Užsakyti visus rezervuotus žaidimus</button>
        
        <?php 
        if(!empty($_SESSION['user']))
        {
            echo'
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Žaidimo rezervavimas</h4>
                  </div>
                    <form method="post">
                  <div class="modal-body">
                        Kada norite atsiimti žaidimą?<br>
                        <input required type="date" name="from" min="<? date("Y-m-d");  ?><br><br>
                        Kada norite grąžinti žaidimą?<br>
                        <input required type="date" name="to" min="<? date("Y-m-d");  ?><br><br>
                        <p style="text-align:justify;"> *Nuomos kaina - 1eu už dieną</p>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-success" name="patvirtinti" value="Patvirtinti"></input>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            '; 
        } else{
            echo'
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Informacija</h4>
                  </div>

                  <div class="modal-body">
                    <form>
                        <p style="text-align:justify;"> Reikalinga registracija!</p>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="index.php?module=kliento_profilio_kurimas" type="button" class="btn btn-success">Registruotis</a>
                  </div>
                </div>

              </div>
            </div>
            ';
        }
        ?>
        
        <?php 
        if(!empty($_SESSION['rez_ids']))
        {
        ?>
            <!-- Todal -->
            <div class="modal fade" id="myTodal" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Žaidimų užsakymas</h4>
                  </div>
                    <form method="post">
                  <div class="modal-body">
                        <table class="table table-striped table-hover ">
                            <thead>
                              <tr>
                                <th>Žaidimo pavadinimas</th>
                                <th>Užsakymo laikotarpis</th>
                                <th>Kaina</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = count($_SESSION['rez_ids']);
                            for ($x = 0; $x < $a; $x++) {
                            $id = $_SESSION['rez_ids'][$x];
                            $sqlRez = "SELECT * FROM Zaidimo_rezervacija WHERE id=".$id;
                            $resultRez = mysqli_query($conn, $sqlRez);
                            $rowRez = mysqli_fetch_array($resultRez);
                            $sqlPav = "SELECT pavadinimas FROM Zaidimas WHERE id=".$rowRez['zaidimo_id'];
                            $resultPav = mysqli_query($conn, $sqlPav);
                            $rowPav = mysqli_fetch_array($resultPav);
                            $bendra_kaina = $bendra_kaina+$rowRez['rezervavimo_kaina'];
                            ?>
                              <tr class="success">
                                <td> <?php echo $rowPav['pavadinimas'] ?></td>
                                <td> <?php echo $rowRez['rezervavimo_trukme']." dienos" ?></td>
                                <td><?php echo $rowRez['rezervavimo_kaina']." eur" ?></td>
                              </tr>
                            <?php
                            } 
                            ?>
                            </tbody>
                        </table> 
                        <?php  $_SESSION["bendra_kaina"] = $bendra_kaina;         //irasau bendra kaina i sesija ?>
                        <p style="text-align:justify;"> Bendra kaina: <?php echo $bendra_kaina ?> eur</p> 
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-success" name="uzs" value="Užsakyti">
                  </div>
                  </form>
                </div>
              </div>
            </div>
        <?php 
        } else{
            echo'
            <!-- Todal -->
            <div class="modal fade" id="myTodal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Informacija</h4>
                  </div>
                    <form>
                  <div class="modal-body">
                        <p style="text-align:justify;"> Pirmiau rezervuokite žaidimus!</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Gerai</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            ';
        }
        ?>
        
  
</div>
        
    </div>
        <div class="col-md-6">
            <?php  echo '<img class="img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row['nuotrauka'] ).'"  alt="">';?>
        </div>
          </fieldset>
        <!--</form>-->

