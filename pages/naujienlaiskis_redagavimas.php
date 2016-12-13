
	<?php
		include 'classes/naujienlaiskis.class.php';
		$newslettersObj = new newsletters();
		
		if(isset($_POST['submitCreateNewsletter'])) {
			
			$data = array (
				'subject' => $_POST['subject'],
				'description' => $_POST['description'],
				'comment' => $_POST['comment'],
				'date' => date("Y-m-d"),
				'content' => htmlspecialchars($_REQUEST['contents'])
			);
			
			

			$query = "  INSERT INTO `Naujienlaiskis`
									(
										sukurimo_data,
										laisko_turinys,
										antraste,
										ar_issiustas,
										komentaras,
										kurejoId,
										laisko_trumpinys,
										apibudinimas
									)
									VALUES
									(
										'{$data['date']}',
										'{$data['content']}',
										'{$data['subject']}',
										'0',
										'{$data['comment']}',
										'0',
										'asd',
										'{$data['description']}'
										
									)";
			mysql::query($query);
			header("Location: index.php?module=item1");
			die();
		}
	?>

		<script src="//cdn.quilljs.com/1.1.7/quill.js"></script>
		<link href="//cdn.quilljs.com/1.1.7/quill.snow.css" rel="stylesheet">
		<link href="//cdn.quilljs.com/1.1.7/quill.bubble.css" rel="stylesheet">
		
		<div class="col-md-12">
			<legend style="padding-top:20px">Naujienlaiškio kūrimas</legend>
			<form action="" method="post">
				<input name="contents" id="Contents"  type="hidden" value="0"/>
				<div class="form-group">
					<label>Antraštė</label>
					<input class="form-control" placeholder="Antraštė" name="subject" required />
				</div>
				<div class="form-group">
					<label>Apibūdinimas</label>
					<input class="form-control" placeholder="Apibūdinimas" name="description"/>
				</div>
				<div class="form-group">
					<label>Komentaras</label>
					<textarea class="form-control" rows="3" placeholder="Komentaras" name="comment" style="resize:none"></textarea>
				</div>
				<div class="col-sm-12" id="editor" style="height:350px; margin-bottom:15px;">
				</div>
				<input class="btn btn-primary" type="submit" name="submitCreateNewsletter" value="Sukurti" onclick="addData()"/>
			</form>
			
		</div>
	
		<script>
			var toolbarOptions = [
			  ['bold', 'italic', 'underline', 'strike'],   
			  ['link', 'image', 'video'],		  

			  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
			  [{ 'direction': 'rtl' }],                         // text direction


			  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
			  [{ 'font': [] }],
			  [{ 'align': [] }],

			  ['clean']                                         // remove formatting button
			];

			var quill = new Quill('#editor', {
			  modules: {
				toolbar: toolbarOptions
			  },
			  theme: 'snow'
			});
			function addData() {
				var x= JSON.stringify(quill.getContents());
				$("#Contents").val(x);
			}
		</script>
