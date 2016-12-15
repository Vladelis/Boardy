<?php
	// Jei bando pasiekti ne vadybininkas ismesti
	if(!empty($_SESSION['user'])) {
		if($_SESSION['user']['fk_role_id']!=3) {
			header("Location: index.php?module=error");
			die();
		}
	}
    $db = new Mysql();
?>

<?php
    //Biuro istrynimas
    if(isset($_POST['trinti']))
    {
        $data = $db -> getBiuras($_POST['trynimo_id']);
        $adresas_id = $data[0]['adresas_id'];
        
        $result = $db -> trintiBiura($_POST['trynimo_id'], $adresas_id);
        
        if($result)
            echo '
                <div class="alert alert-dismissible alert-success">
                    <strong>Biuras sėkmingai ištrintas</strong>
                </div>
            ';
       
    }
?>

<legend style="padding-top:20px">Biurų trynimas</legend>
<form class="form-horizontal" method="post" action="">
    <div class="form-group">
        <div class="col-lg-4">
            <label class="control-label" for="trynimo_id">Įveskite norimo ištrinti biuro ID:</label>
            <input class="form-control" name="trynimo_id" type="number" value="">
            <input style="margin-top:10px" type="submit" name="trinti" value="Trinti" class="btn btn-primary" />
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
    
    <?php
    $data = $db -> getBiurai();
    for($i = 0; $i < sizeof($data); $i++)
    {
        echo '
        <tr>
            <td>'.$data[$i]['id'].'</td>
            <td>'.$data[$i]['pavadinimas'].'</td>
            <td>'.$data[$i]['gatve'].'</td>
            <td>'.$data[$i]['miestas'].'</td>
            <td>'.$data[$i]['banko_saskaita'].'</td>
            <td>'.$data[$i]['isteigimo_data'].'</td>
        </tr>
        ';
    }
    ?>
    </tbody>
</table>