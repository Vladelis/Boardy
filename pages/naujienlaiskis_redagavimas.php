
	<?php
		include 'classes/naujienlaiskis.class.php';
		$newslettersObj = new newsletters();
		
		if (empty($_SESSION['user']) || $_SESSION['user']['fk_role_id']==1 )
		{
				header("Location: index.php?module=noaccess");
				die();
		}
		
		$newsletter = $newslettersObj -> getNewsletterById($id);
		
		
		
		if(isset($_POST['submitCreateNewsletter'])) {
			$snippet = $_POST['comment'];
			if (strlen($snippet) > 35 )
				$snippet = substr($snippet,0,35) . "...";
			
			$data = array (
				'subject' => $_POST['subject'],
				'description' => $_POST['description'],
				'comment' => $_POST['comment'],
				'date' => date("Y-m-d"),
				'content' => serialize(json_decode($_REQUEST['contents'])),
				'user' => $_SESSION['user']['id'],
				'snippet' => $snippet
			);
			$newslettersObj -> createNewsletter($data);
			header("Location: index.php?module=naujienlaiskiai_sarasas");
			die();
		}
		if(isset($_POST['submitUpdateNewsletter'])) {
			$snippet = $_POST['comment'];
			if (strlen($snippet) > 35 )
				$snippet = substr($snippet,0,35) . "...";
			
			$data = array (
				'subject' => $_POST['subject'],
				'description' => $_POST['description'],
				'comment' => $_POST['comment'],
				'content' => serialize(json_decode($_REQUEST['contents'])),
				'snippet' => $snippet,
				'id' => $newsletter['id']
			);
			$newslettersObj -> updateNewsletter($data);
			header("Location: index.php?module=naujienlaiskiai_sarasas");
			die();
		}
		
		
	?>

		<script src="//cdn.quilljs.com/1.1.7/quill.js"></script>
		<link href="//cdn.quilljs.com/1.1.7/quill.snow.css" rel="stylesheet">
		<link href="//cdn.quilljs.com/1.1.7/quill.bubble.css" rel="stylesheet">
		<div class="col-md-12">
			<legend style="padding-top:20px">Naujienlaiškio kūrimas</legend>
			<form action="" method="post">
				<input name="contents" id="Contents"  type="hidden"/>
				<div class="form-group">
					<label>Antraštė</label>
					<input class="form-control" placeholder="Antraštė" name="subject" value="<?php echo $newsletter['antraste'] ?>" required />
				</div>
				<div class="form-group">
					<label>Apibūdinimas</label>
					<input class="form-control" placeholder="Apibūdinimas" name="description" value="<?php echo $newsletter['apibudinimas'] ?>"/>
				</div>
				<div class="form-group">
					<label>Komentaras</label>
					<textarea class="form-control" rows="3" placeholder="Komentaras" name="comment" style="resize:none"><?php echo $newsletter['komentaras'] ?></textarea>
				</div>
				<div class="col-sm-12" id="editor" style="height:350px; margin-bottom:15px;">
				</div>
				<a href="index.php?module=naujienlaiskiai_sarasas" class="btn btn-default"> Grįžti </a>
				<?php 
					if (!empty($newsletter['id']))
						echo "<input class='btn btn-primary' type='submit' name='submitUpdateNewsletter' value='Atnaujinti' onclick='addData()'/>";
					else
						echo "<input class='btn btn-primary' type='submit' name='submitCreateNewsletter' value='Sukurti' onclick='addData()'/>";
				?>
				
			</form>
			
		</div>
	
		<script>
			var toolbarOptions = [
			  [{ 'size': ['small', false, 'large', 'huge'] }], 
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
			var data = <?php echo json_encode(unserialize($newsletter["turinys"]))?>;
			console.log(data);
			quill.setContents(data);
			
			
		</script>
