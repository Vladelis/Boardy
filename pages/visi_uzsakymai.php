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
                      <th>Biuras</th>
                      <th>Užsakymo data</th>
                      <th>Bendra kaina</th>
                      <th>Žaidimai</th>
                      <th>Atsiėmimo datos</th>
                      <th>Trukmė</th>
					  <th>Nuolaida</th>
					  <th></th>
                    </tr>
              </thead>
              <tbody>
              <?php
              //kol kas visi
                $sql = "SELECT * FROM Uzsakymas WHERE 0=0 ORDER BY id DESC"; 
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    $sql12 = "SELECT z.pavadinimas AS pav, r.rezervavimo_data AS data, r.rezervavimo_trukme AS trukme, z.spec_pasiulymas AS pasiulymas
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
					$nuolaida = array();
                    while($row2 = mysqli_fetch_array($result22)) {
                        $pav[$kiek] = $row2['pav'];
                        $data[$kiek] = $row2['data'];
                        $trukme[$kiek] = $row2['trukme'];
						if ($row2['pasiulymas'] != null) {
							$sql99 = "SELECT nuolaidos_dydis, ar_galioja FROM Specialus_pasiulymas WHERE id=".$row2['pasiulymas']; 
							$rez12 = mysqli_query($conn, $sql99);
							$rez123 = mysqli_fetch_array($rez12);
							if ($rez123['ar_galioja'] == 0)
								$nuolaida[$kiek] = 'Nėra';
							else 
								$nuolaida[$kiek] = $rez123['nuolaidos_dydis'] . '%';
						}
						else 
							$nuolaida[$kiek] = 'Nėra';
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
                        <td><?php 
                            $sqlp = "SELECT pavadinimas FROM Biuras WHERE id =".$row['biuras_id'];
                            $resultp = mysqli_query($conn, $sqlp);
                            $a = mysqli_fetch_array($resultp);
                            echo $a["pavadinimas"];
                            ?>
                        </td>
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
						<td>
                            <table>
                                <?php
                                $iiii = 0;
                                while($iiii<$kiek) {
                                    if(!empty($trukme[$iiii]))
                                    {
                                        echo "<tr>"; 
                                            echo "<td>$nuolaida[$iiii]</td>";
                                        echo "</tr>";
                                    }
                                    $iiii++;
                                }
                                ?>
                            </table>
                        </td>
                    <?php
					echo"<td>";
					if ($row['klientas_id'] > 0 && $row['ar_yra_byla'] == 0)
						echo "<a class='btn btn-danger btn-xs' href='#' onclick='showOpenCaseConfirm(\"bylos_sarasas\", \"{$row['id']}\");'>+ Byla</a></td>";
					else 
						echo "</td></tr>";
                }						
            ?>
              </tbody>
            </table> 
    </div>



