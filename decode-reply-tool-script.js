[].forEach.call( document.querySelectorAll(".replytrigger"), function(element) {
	element.addEventListener('click', function(event) {
		
		if ( document.querySelector('.triggered') ) {
			document.querySelector('.triggered').classList.remove('triggered');
		}
		
		element.parentElement.classList.add('triggered');
						
	}, false);
});