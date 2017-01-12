<?php
    include 'dbh.php';
    if (empty($_SESSION['user']))
    {
                    header("Location: index.php?module=noaccess");
                    die();
    }
?>
    <div class="col-md-12">
            <legend style="padding-top:20px">Visi užsakymai</legend>

            <table class="table table-striped table-hover ">

              <thead>
                    <tr class="danger">
                      <th>Kliento paštas/darbuotojo kodas</th>
                      <th>Užsakymo data</th>
                      <th>Bendra kaina</th>
                      <th>Žaidimai</th>
                      <th>Atsiėmimo datos</th>
                      <th>Trukmė</th>
					  <th></th>
                    </tr>
              </thead>
              <tbody>
              <?php
              //kol kas visi
                $sql = "SELECT * FROM Uzsakymas WHERE 0=0"; 
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    $sql12 = "SELECT z.pavadinimas AS pav, r.rezervavimo_data AS data, r.rezervavimo_trukme AS trukme
                        FROM Zaidimas z
                        INNER JOIN Zaidimo_rezervacija r ON z.id = r.zaidimo_id
                        INNER JOIN Uzsakymo_rezervacija ur ON ur.zaidimo_rezervacija_id = r.id
                        AND ur.uzsakymas_id =".$row['id'];
                    $result22 = mysqli_query($conn, $sql12);
                    
                    //kliento pastas arba darbuotojo kodas
                    if($row["klientas_id"] == 0)
                    {
                        $sql = "SELECT kodas FROM Darbuotojas WHERE id=".$row['darbuotojas_id']; 
                        $rez = mysqli_query($conn, $sql);
                        $ro = mysqli_fetch_array($rez);
                    }
                    else
                    {
                        $sql = "SELECT email FROM Klientas WHERE id=".$row['klientas_id']; 
                        $rez = mysqli_query($conn, $sql);
                        $ro = mysqli_fetch_array($rez);
                    }
                    
                    $kiek = 0;
                    $pav = array();
                    $data = array();
                    $trukme = array();
                    while($row2 = mysqli_fetch_array($result22)) {
                        $pav[$kiek] = $row2['pav'];
                        $data[$kiek] = $row2['data'];
                        $trukme[$kiek] = $row2['trukme'];
                        $kiek++;
                    }
                    ?>
                        <td><?php
                        if($row["klientas_id"] == 0){
                            echo $ro["kodas"];
                        }
                        else {  
                            echo $ro["email"];
                        }
                        ?></td>
                        <td><?php echo $row["data"]?></td>
                        <td><?php echo $row["bendra_kaina"].'eu' ?></td>
                        <td>
                            <table>
                                <?php
                                $i = 0;
                                while($i<$kiek) {
                                    if(!empty($pav[$i]))
                                    {
                                        echo "<tr>"; 
                                            echo "<td>$pav[$i]</td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }
                                ?>
                            </table>
                        </td>
                        <td>
                            <table>
                                <?php
                                $ii = 0;
                                while($ii<$kiek) {
                                    if(!empty($data[$ii]))
                                    {
                                        echo "<tr>"; 
                                            echo "<td>$data[$ii]</td>";
                                        echo "</tr>";
                                    }
                                    $ii++;
                                }
                                ?>
                            </table>
                        </td>
                        <td>
                            <table>
                                <?php
                                $iii = 0;
                                while($iii<$kiek) {
                                    if(!empty($trukme[$iii]))
                                    {
                                        echo "<tr>"; 
                                            echo "<td>$trukme[$iii]</td>";
                                        echo "</tr>";
                                    }
                                    $iii++;
                                }
                                ?>
                            </table>
                        </td>
                    <?php
                    echo "<td>dasdasd</td></tr>
					";
                }						
            ?>
              </tbody>
            </table> 
    </div>



