<?php
include 'dbh.php';
include 'stalo_zaidimai/stalo_zaidimu_filtravimas.php';
$age = $amount= $genre= $parinkta = $kazkas =0;
$length = "";
if(isset($_GET['amzius'])) {
    $age = $_GET['amzius']; $parinkta++;
    //$age = substr($age, 0, -1); // numetu +
}
if(isset($_GET['kiekis'])) {
    $amount = $_GET['kiekis']; $parinkta++;
    //$amount = substr($amount, 0, -1); // numetu +
}
if(isset($_GET['zanras'])) {
    $genre = $_GET['zanras']; $parinkta++;
}
if(isset($_GET['trukme'])) {
    $length = $_GET['trukme']; $parinkta++;
    //$length = substr($length, 0, -3); // numetu min
}
$sql = "SELECT * FROM Zaidimas WHERE 0=0"; 
if($age!=0)
{
    $sql = $sql." AND zaideju_amzius >= ".$age;
}
if($amount!=0)
{
    $sql = $sql." AND zaideju_skaicius >= ".$amount;
}
if($genre!=0)
{
    $sql = $sql." AND kategorijos_id= ".$genre;
}
if($length!="")
{
    $min = substr($length, -5);
    $simbolis = substr($length, 0, 1);
    if($simbolis == ">")
    {
        $sql = $sql." AND zaidimo_trukme > '".$min."'";
    }
    else {
        $sql = $sql." AND zaidimo_trukme <= '".$min."'";
    }
    echo "<script type='text/javascript'>alert('$sql');</script>";
}
$result = mysqli_query($conn, $sql);
?>
<html>
    <body> 
        <?php
            while($row = mysqli_fetch_array($result)) {
                $sql2 = "SELECT * FROM Zaidimas WHERE id=" . $row["id"];
                
                $result2 = mysqli_query($conn, $sql2); //or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error());
                $row2 = mysqli_fetch_array($result2);
                //https://miketricking.github.io/dist/
        ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="hovereffect" style="height: 350px;">
                    <?php 
                        echo '<img object-fit= "contain" class="img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row2['nuotrauka'] ).'"  alt="">';?>
                        <div class="overlay">
                           <h2><?php echo $row["pavadinimas"]; ?></h2>
                           <a class="info" href="/Boardy/index.php?module=stalo_zaidimai/stalo_zaidimu_rezervacija&id=<?php echo $row["id"];?>">Peržiūrėti</a>
                        </div>       
                </div>
            </div>
            <?php		
            }
            ?>
    </body>
</html>

