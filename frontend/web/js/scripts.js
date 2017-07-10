$( document ).ready(function() {
	try{
		$('.slider-block').slick({
			fade: true,
			autoplay: true,
			dots: true,
			arrows: false
		});
	} catch(e){}
	try {
		$('.list-products-slider').slick({
			dots: false,
			arrows: true,
			slidesToShow: 5,
			appendArrows: $('.list-products-slider-arrows')
		})
	} catch(e){}
});

