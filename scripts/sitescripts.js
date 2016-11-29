		
		
		function showConfirmDialog(module, removeId) {
			var r = confirm("Ar tikrai norite pašalinti?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&remove=" + removeId);
			}
		}
		
		function showJobConfirmation(module, takeId) {
			var r = confirm("Ar tikrai apsiimti šį remontą?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&take=" + takeId);
			}
		}
		
		function showSucceedConfirmation(module, succeedId) {
			var r = confirm("Ar tikrai atlikote taisymo darbus?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&succeed=" + succeedId);
			}
		}
		
		function showFailConfirmation(module, failId) {
			var r = confirm("Ar tikrai nepavyks įtaiso pataisyti?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&fail=" + failId);
			}
		}
		
		function giveBackConfirm(module, giveId) {
			var r = confirm("Ar tikrai grąžinate įtaisą?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&give=" + giveId);
			}
		}