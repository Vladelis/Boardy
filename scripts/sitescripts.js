		
		
		function showNewsletterDeleteConfirm(module, removeNewsletterId) {
			var r = confirm("Ar tikrai norite pašalinti?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&removeNewsletter=" + removeNewsletterId);
			}
		}
		
		function showNewsletterSendConfirm(module, sendNewsletterId) {
			var r = confirm("Ar tikrai norite išsiūsti šį laišką?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&sendNewsletter=" + sendNewsletterId);
			}
		}