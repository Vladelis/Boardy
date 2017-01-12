		
		
		<?php
		include 'classes/naujienlaiskis.class.php';
		$newslettersObj = new newsletters();
		
		$newsletter = $newslettersObj -> getNewsletterById($id);
		
		
		
		if(isset($_POST['submitCreateNewsletter'])) {
			$snippet = $_POST['comment'];
			
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
			<legend style="padding-top:20px"><?php echo $newsletter['antraste'] ?></legend>
				<div class="col-sm-12" id="editor">
				</div>
				<a href="index.php?module=naujienos" class="btn btn-default"> Grįžti </a>
		</div>
		
		<style>
			#editor {
				
				margin-bottom:15px; 
				border:none;
			}
			
			.ql-editor {
				cursor:default !important;
			}
		</style>
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
				toolbar: false
			  },
			  theme: 'snow'
			});
			function addData() {
				var x= JSON.stringify(quill.getContents());
				$("#Contents").val(x);
			}
			quill.enable(false);
			var data = <?php echo json_encode(unserialize($newsletter["turinys"]))?>;
			console.log(data);
			quill.setContents(data);
			
		</script>