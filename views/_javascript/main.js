jQuery(document).ready(function(){
	startSplide();

});

function startSplide(){
	new Splide( '.slider1', {
		type:					'loop',
		perPage:			1,
		autoplay:			true,
		pauseOnHover: true,
		arrows:				true,
		pagination:		true,
		interval:			5000,
	}).mount();

	new Splide( '.slider2', {
		type:					'loop',
		perPage:			5,
		perMove:			1,
		autoplay:			true,
		pauseOnHover: true,
		autoWidth: true,
		cover: true,
		arrows:				true,
		pagination:		true,
		interval:			7000,
	}).mount();

	new Splide( '.slider3', {
		type:					'loop',
		perPage:			5,
		perMove:			1,
		autoplay:			true,
		pauseOnHover: true,
		autoWidth: true,
		cover: true,
		arrows:				true,
		pagination:		true,
		interval:			9000,
	}).mount();

	new Splide( '.slider4', {
		type:					'loop',
		perPage:			5,
		perMove:			1,
		autoplay:			true,
		pauseOnHover: true,
		autoWidth: true,
		cover: true,
		arrows:				true,
		pagination:		true,
		interval:			11000,
	}).mount();
}