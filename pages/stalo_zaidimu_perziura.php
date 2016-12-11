<?php
include 'dbh.php';
include 'stalo_zaidimai/stalo_zaidimu_filtravimas.php';
$sql = "SELECT id, pavadinimas FROM Zaidimas"; 
$result = mysqli_query($conn, $sql);
?>
<html>
    <body> 
        <?php
            while($row = mysqli_fetch_array($result)) {
                $sql2 = "SELECT nuotrauka FROM Zaidimas WHERE id=" . $row["id"];
                $result2 = mysqli_query($conn, $sql2) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error());
                $row2 = mysqli_fetch_array($result2);
                //https://miketricking.github.io/dist/
        ?>
        
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="hovereffect">
                <?php  echo '<img class="img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row2['nuotrauka'] ).'"  alt="">';?>
                <div class="overlay">
                   <h2><?php echo $row["pavadinimas"]; ?></h2>
                   <a class="info" href="/Boardy/index.php?module=stalo_zaidimai/stalo_zaidimu_rezervacija&id=<?php echo $row["id"];?>">Peržiūrėti</a>
                  <!-- <a class="info" href="/pages/stalo_zaidimai/stalo_zaidimu_rezervacija.php?id=<?php echo $row["id"];?>">Rezervuoti</a>
                -->
                  </div>
            </div>
        </div>
        <?php		
            }
        ?>
    </body>
</html>

