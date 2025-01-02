// Inputmask js

(function () {
	// credit card

	var cardMaskElem = document.getElementById('card-mask');

	if (cardMaskElem) {
		var creditCardMask = new IMask(cardMaskElem, {
			mask: '0000-0000-0000-0000',
		});
	}

	// digital mask
	var digitMaskElem = document.getElementById('digit-mask');
	if (digitMaskElem) {
		var digitPinMask = new IMask(digitMaskElem, {
			mask: '000',
		});
	}
})();
