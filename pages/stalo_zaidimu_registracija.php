<div class="col-md-7">
	<form class="form-horizontal">
  <fieldset>
    <legend>Naujas stalo žaidimas</legend>
    <div class="form-group">
      <label for="gameTitle" class="col-lg-2 control-label">Pavadinimas</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="gameTitle" placeholder="Pavadinimas">
      </div>
    </div>
    <div class="form-group">
      <label for="gamelength" class="col-lg-2 control-label">Žaidimo trukmė</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="gamelength" placeholder="Žaidimo trukmė">
      </div>
    </div>
    <div class="form-group">
      <label for="players" class="col-lg-2 control-label">Žaidėjų skaičius</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="players" placeholder="Žaidėjų skaičius">
      </div>
    </div>
    <div class="form-group">
      <label for="playersAge" class="col-lg-2 control-label">Žaidėjų amžius</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="playersAge" placeholder="Žaidėjų amžius">
      </div>
    </div>
    <div class="form-group">
      <label for="description" class="col-lg-2 control-label">Aprašymas</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="description"></textarea>
      </div>
    </div>
    <div class="form-group">
        <label for="photo" class="col-lg-2 control-label">Žaidimo nuotrauka</label>
        <div class="col-lg-10">
            <input type="file" id="photo">
        </div>
    </div>
   </fieldset>
    </form>
</div>
<div class="col-md-5">
    <form class="form-horizontal">
  <fieldset>
      <br>
      <br>
      <br>
    <div class="form-group">
      <label for="language" class="col-lg-3 control-label">Kalba</label>
      <div class="col-lg-8">
        <select class="form-control" id="language">
          <option>Lietuvių</option>
          <option>Anglų</option>
          <option>Rusų</option>
          <option>Vokiečių</option>
        </select>
      </div>
    </div>
     <div class="form-group">
      <label for="years" class="col-lg-3 control-label">Išleidimo metai</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="years" placeholder="Išleidimo metai">
      </div>
    </div>
    <div class="form-group">
      <label for="producer" class="col-lg-3 control-label">Gamintojas</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="producer" placeholder="Gamintojas">
      </div>
    </div>
    <div class="form-group">
      <label for="country" class="col-lg-3 control-label">Gamintojo šalis</label>
      <div class="col-lg-8">
        <select class="form-control" id="country">
          <option>Lietuva</option>
          <option>JAV</option>
          <option>Kinija</option>
          <option>Vokietija</option>
        </select>
      </div>
    </div>
    <div class="checkbox">
          <label>
            <input type="checkbox" value="pap"> Turi papildymų
          </label>
    </div>
    <div class="checkbox">
          <label>
            <input type="checkbox" value="apd"> Turi apdovanojimų
          </label>
    </div>
    <div class="checkbox">
          <label>
            <input type="checkbox" value="mok"> Mokomasis žaidimas
          </label>
    </div>
    <br>
    <a href="#" class="btn btn-primary" style="float: right;">Pateikti</a>
  </fieldset>
    </form>
</div>



