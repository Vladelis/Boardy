
<?php
	// Jei bando pasiekti ne vadybininkas ismesti
	if(!empty($_SESSION['user'])) {
		if($_SESSION['user']['fk_role_id']!=3) {
			header("Location: index.php?module=error");
			die();
		}
	}
        else{header("Location: index.php?module=error");}
            
?>

<?php 

	if(isset($_POST['submitreg']))
    {	
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
		
		$db->insertNewBiuras($el_pastas, $tel_nr, $darbo_laikas, $faksas, $isteigimo_data, $pavadinimas, $banko_saskaita, $gatve, 
		$miestas, $rajonas, $salis, $komentaras, $aukstas_pastate, $kabineto_nr);
		
	}
?>

<div class="col-md-12">
		<legend style="padding-top:20px">Naujo biuro registracija</legend>
		<form class="form-horizontal col-md-8" method="post" action="">
			<div class="form-group">
				<label for="el_pastas" class="col-lg-4 control-label">Elektroninis paštas</label>
				<div class="col-lg-8">
					<input type="email" class="form-control" name="el_pastas" placeholder="pastas@pastas.lt" value="<?php if (isset($_POST['el_pastas'])) {echo $_POST['el_pastas'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tel_nr" class="col-lg-4 control-label">Telefono numeris</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="tel_nr" placeholder="Pavyzdžiui: 86*******" value="<?php if (isset($_POST['tel_nr'])) {echo $_POST['tel_nr'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="pavadinimas" class="col-lg-4 control-label">Biuro pavadinimas</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="pavadinimas" placeholder="" value="<?php if (isset($_POST['pavadinimas'])) {echo $_POST['pavadinimas'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="darbo_laikas" class="col-lg-4 control-label">Darbo laikas</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="darbo_laikas" placeholder="" value="<?php if (isset($_POST['darbo_laikas'])) {echo $_POST['darbo_laikas'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="faksas" class="col-lg-4 control-label">Faksas</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="faksas" placeholder="" value="<?php if (isset($_POST['faksas'])) {echo $_POST['faksas'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="banko_saskaita" class="col-lg-4 control-label">Banko sąskaita</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="banko_saskaita" placeholder="LT***********" value="<?php if (isset($_POST['banko_saskaita'])) {echo $_POST['banko_saskaita'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="isteigimo_data" class="col-lg-4 control-label">Įsteigimo data</label>
				<div class="col-lg-8">
					<input type="date" class="form-control" name="isteigimo_data" placeholder="" value="<?php if (isset($_POST['isteigimo_data'])) {echo $_POST['isteigimo_data'];} ?>" required>
				</div>
			</div>
			
			<!--Adreso dalis-->
			<div class="form-group">
				<label for="gatve" class="col-lg-4 control-label">Gatvė</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="gatve" placeholder="" value="<?php if (isset($_POST['gatve'])) {echo $_POST['gatve'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="miestas" class="col-lg-4 control-label">Miestas</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="miestas" placeholder="" value="<?php if (isset($_POST['miestas'])) {echo $_POST['miestas'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="rajonas" class="col-lg-4 control-label">Rajonas</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="rajonas" placeholder="" value="<?php if (isset($_POST['rajonas'])) {echo $_POST['rajonas'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="salis" class="col-lg-4 control-label">Šalis</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="salis" placeholder="" value="<?php if (isset($_POST['salis'])) {echo $_POST['salis'];} ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="komentaras" class="col-lg-4 control-label">Komentaras</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="komentaras" placeholder="" value="<?php if (isset($_POST['komentaras'])) {echo $_POST['komentaras'];} ?>" >
				</div>
			</div>
			<div class="form-group">
				<label for="aukstas_pastate" class="col-lg-4 control-label">Aukštas pastate</label>
				<div class="col-lg-8">
					<input type="number" class="form-control" name="aukstas_pastate" placeholder="" value="<?php if (isset($_POST['aukstas_pastate'])) {echo $_POST['aukstas_pastate'];} ?>" >
				</div>
			</div>
			<div class="form-group">
				<label for="kabineto_nr" class="col-lg-4 control-label">Kabineto numeris</label>
				<div class="col-lg-8">
					<input type="number" class="form-control" name="kabineto_nr" placeholder="" value="<?php if (isset($_POST['kabineto_nr'])) {echo $_POST['kabineto_nr'];} ?>" >
				</div>
			</div>
			
			
			
			<div class="form-group">
				<input type="submit" name="submitreg" value="Registruotis" class="btn btn-primary" />
			</div>
		</form>
	</div>