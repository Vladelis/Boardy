<?php
	// Jei bando pasiekti ne vadybininkas ismesti
	if(!empty($_SESSION['user'])) {
		if($_SESSION['user']['fk_role_id']!=3) {
			header("Location: index.php?module=error");
			die();
		}
	}
?>


<?php
    //Duomenu atnaujinimas
    if(isset($_POST['submitUpdate']))
    {
        $irasoId = $_POST['redagavimo_id'];
        
        $db = new mysql();
		$el_pastas = $_POST['el_pastas'];
		$tel_nr = $_POST['tel_nr'];
		$darbo_laikas = $_POST['darbo_laikas'];
		$faksas = $_POST['faksas'];
		$isteigimo_data = $_POST['isteigimo_data'];
		$pavadinimas = $_POST['pavadinimas'];
		$banko_saskaita = $_POST['banko_saskaita'];
		$gatve  = $_POST['gatve'];
		$miestas = $_POST['miestas'];
		$rajonas = $_POST['rajonas'];
		$salis = $_POST['salis'];
		$komentaras = $_POST['komentaras'];
		$aukstas_pastate = $_POST['aukstas_pastate'];
		$kabineto_nr = $_POST['kabineto_nr'];
        $adresas_id = $_POST['adresas_id'];
		
		$result = $db->updateBiuras($el_pastas, $tel_nr, $darbo_laikas, $faksas, $isteigimo_data, $pavadinimas, $banko_saskaita, $gatve, 
		$miestas, $rajonas, $salis, $komentaras, $aukstas_pastate, $kabineto_nr, $adresas_id, $irasoId);
        
        if($result)
            echo '
                <div class="alert alert-dismissible alert-success">
                    <strong>Biuras sėkmingai atnaujintas</strong>
                </div>
            ';
        
    }    
?>

<legend style="padding-top:20px">Biurų redagavimas</legend>
<?php
    $db = new mysql();
    if(isset($_POST['redaguoti']))
    {
        $data = $db -> getBiuras($_POST['redagavimo_id']);
        
        echo'
            <form class="form-horizontal col-md-8" method="post" action="">
                <div class="form-group">
                    <label for="el_pastas" class="col-lg-4 control-label">Elektroninis paštas</label>
                    <div class="col-lg-8">
                        <input type="email" class="form-control" name="el_pastas" placeholder="pastas@pastas.lt" value="'.$data[0]['el_pastas'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel_nr" class="col-lg-4 control-label">Telefono numeris</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="tel_nr" placeholder="Pavyzdžiui: 86*******" value="'.$data[0]['tel_nr'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pavadinimas" class="col-lg-4 control-label">Biuro pavadinimas</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="pavadinimas" placeholder="" value="'.$data[0]['pavadinimas'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="darbo_laikas" class="col-lg-4 control-label">Darbo laikas</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="darbo_laikas" placeholder="" value="'.$data[0]['darbo_laikas'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="faksas" class="col-lg-4 control-label">Faksas</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="faksas" placeholder="" value="'.$data[0]['faksas'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="banko_saskaita" class="col-lg-4 control-label">Banko sąskaita</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="banko_saskaita" placeholder="LT***********" value="'.$data[0]['banko_saskaita'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="isteigimo_data" class="col-lg-4 control-label">Įsteigimo data</label>
                    <div class="col-lg-8">
                        <input type="date" class="form-control" name="isteigimo_data" placeholder="" value="'.$data[0]['isteigimo_data'].'" required>
                    </div>
                </div>
                
                <!--Adreso dalis-->
                <div class="form-group">
                    <label for="gatve" class="col-lg-4 control-label">Gatvė</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="gatve" placeholder="" value="'.$data[0]['gatve'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="miestas" class="col-lg-4 control-label">Miestas</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="miestas" placeholder="" value="'.$data[0]['miestas'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rajonas" class="col-lg-4 control-label">Rajonas</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="rajonas" placeholder="" value="'.$data[0]['rajonas'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="salis" class="col-lg-4 control-label">Šalis</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="salis" placeholder="" value="'.$data[0]['salis'].'" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="komentaras" class="col-lg-4 control-label">Komentaras</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="komentaras" placeholder="" value="'.$data[0]['komentaras'].'" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="aukstas_pastate" class="col-lg-4 control-label">Aukštas pastate</label>
                    <div class="col-lg-8">
                        <input type="number" class="form-control" name="aukstas_pastate" placeholder="" value="'.$data[0]['aukstas_pastate'].'" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="kabineto_nr" class="col-lg-4 control-label">Kabineto numeris</label>
                    <div class="col-lg-8">
                        <input type="number" class="form-control" name="kabineto_nr" placeholder="" value="'.$data[0]['kabineto_nr'].'" >
                    </div>
                </div>
                <input type="hidden" name="redagavimo_id" value="'.$_POST['redagavimo_id'].'">
                <input type="hidden" name="adresas_id" value="'.$data[0]['adresas_id'].'">
                
                
                
                <div class="form-group">
                    <input type="submit" name="submitUpdate" value="Atnaujinti" class="btn btn-primary" />
                </div>
            </form>
        ';
        
    }
    //Uzkrauti visu biuru duomenis ir forma redagavimo pasirinkimui
    else 
    {
        $data = $db -> getBiurai();
        echo '
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-lg-4">
                    <label class="control-label" for="redagavimo_id">Įveskite norimo redaguoti biuro ID:</label>
                    <input class="form-control" name="redagavimo_id" type="number" value="">
                    <input style="margin-top:10px" type="submit" name="redaguoti" value="Redaguoti" class="btn btn-primary" />
                </div>
            </div>
        </form>

        <legend style="padding-top:20px">Biurų sąrašas</legend>
        <table class="table table-striped table-hover ">
            <thead>
                <tr class="danger"><a href="#">
                <th>ID</th>
                <th>Pavadinimas</th>
                <th>Gatvė</th>
                <th>Miestas</th>
                <th>Banko sąskaita</th>
                <th>Įsteigimo data</th>
                </a></tr>
            </thead>
            <tbody>
            ';
            
            for($j = 0; $j < sizeof($data); $j++)
            {
                echo '
                <tr>
                    <td>'.$data[$j]['id'].'</td>
                    <td>'.$data[$j]['pavadinimas'].'</td>
                    <td>'.$data[$j]['gatve'].'</td>
                    <td>'.$data[$j]['miestas'].'</td>
                    <td>'.$data[$j]['banko_saskaita'].'</td>
                    <td>'.$data[$j]['isteigimo_data'].'</td>
                </tr>
                ';
            }
            echo'</tbody>
        </table>
        ';
    }
?>