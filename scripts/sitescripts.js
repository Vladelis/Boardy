		
		
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
		
		function showOfferDeleteConfirm(module, removeOfferId) {
			var r = confirm("Ar tikrai norite pašalinti?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&removeOffer=" + removeOfferId);
			}
		}
		
		function showOfferActivateConfirm(module, activateOfferId) {
			var r = confirm("Ar tikrai norite aktyvuoti šią akciją?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&activateOffer=" + activateOfferId);
			}
		}
		
		function showOfferDeactivateConfirm(module, Id) {
			var r = confirm("Ar tikrai norite išjungti šią akciją?");
			if (r === true) {
				window.location.replace("index.php?module=" + module + "&deactivateOffer=" + Id);
			}
		}
		
		