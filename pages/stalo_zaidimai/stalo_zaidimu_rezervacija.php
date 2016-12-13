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
        
        <div class="container">
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Rezervuoti</button>

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

                  <div class="modal-body">
                    <form>
                        Kada norite atsiimti žaidimą?<br>
                        <input type="date" name="from" min="<?php date("m-d-Y");  ?>"><br><br>
                        Kada norite grąžinti žaidimą?<br>
                        <input type="date" name="to" min="<?php date("m-d-Y");  ?>"><br><br>
                        <p style="text-align:justify;"> *Nuomos kaina - 1eu už dieną</p>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success">Patvirtinti</button>
                  </div>
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
                    <h4 class="modal-title">Užsiregistruokite</h4>
                  </div>

                  <div class="modal-body">
                    <form>
                        <p style="text-align:justify;"> Reikalinga registracija</p>
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
  
</div>
        
    </div>
        <div class="col-md-6">
            <?php  echo '<img class="img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row['nuotrauka'] ).'"  alt="">';?>
        </div>
          </fieldset>
        </form>

