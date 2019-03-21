$(function() {

$('.hamburger').click(function(){

	if ($('body').hasClass('scrolldisable')) {
		$('body, html').removeClass('scrolldisable');
		$('.mobile-menu').removeClass('open');
		$('.hamburger').removeClass('is-active');
	} else {
		$('body, html').addClass('scrolldisable');
		$('.mobile-menu').addClass('open');
		$('.hamburger').addClass('is-active');
	}
	
});

	$("input[name='car-view-radio']").change(function() {
		var articleName = $(this).val();
		$(".js-toggle-info-body article").removeClass("active");
		$(".js-toggle-info-body" + " ." + articleName).addClass("active");
    });

document.ontouchmove = function(event){
	if ($('body').hasClass('scrolldisable')) {
		event.preventDefault();
	} else {
		
	}
}

function hidePriceSection() {
	if (($(document).scrollTop() + $(window).height()) >= $('body').height() - 76) {
		$('#price-section').addClass('hide')
	} else {
		$('#price-section').removeClass('hide')
	}
}

hidePriceSection();

$(document).scroll(function(){
	hidePriceSection();
});

// $('*').tooltipster();

$('.check-other-job').click(function(){
	$(this).toggleClass('active');
});


var clipboard = new ClipboardJS('.js-copy-buffer');

clipboard.on('success', function (e) {
	var target = e.trigger;
	target.classList.add("success");
	setTimeout(function () {
		target.classList.remove("success");
	}, 1500);
});

clipboard.on('error', function (e) {
});


$('.additional-parameters-switch').click(function(){
	if ($(this)
            .find("input")
            .prop("checked")) {
        $(this)
            .next()
            .slideDown(300);
    } else {
        $(this)
            .next()
            .slideUp(300);
    }
});

// Подключение Slick Carousel
$('.index-banner-slider').slick({
  dots: true,
  arrows: false,
  fade: true,
  infinite: true,
  speed: 1500,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 4000,
 //  responsive: [
	// {
	// 	breakpoint: 1024,
	// 	settings: {
	// 		slidesToShow: 3,
	// 		slidesToScroll: 3,
	// 		infinite: true,
	// 		dots: true
	// 	}
	// },
	// {
	// 	breakpoint: 600,
	// 	settings: {
	// 		slidesToShow: 2,
	// 		slidesToScroll: 2
	// 	}
	// },
	// {
	// 	breakpoint: 480,
	// 	settings: {
	// 		slidesToShow: 1,
	// 		slidesToScroll: 1
	// 	}
	// }
 //  ]
});
$('.js-car-view-gallery').slick({
	dots: false,
	arrows: true,
	infinite: true,
	slidesToShow: 3,
	slidesToScroll: 1,
});

// 

// Подключение Magnific Gallery
$('.zoom-gallery').magnificPopup({
	delegate: 'a',
	type: 'image',
	closeOnContentClick: false,
	closeBtnInside: false,
	mainClass: 'mfp-with-zoom mfp-img-mobile',
	image: {
		verticalFit: true,
		titleSrc: function(item) {
			return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
		}
	},
	gallery: {
		enabled: true
	},
	zoom: {
		enabled: true,
		duration: 300, // don't foget to change the duration also in CSS
		opener: function(element) {
			return element.find('img');
		}
	}
});
// 

// Подключение Magnific Modal
$('.popup').magnificPopup({
	type: 'inline',

	fixedContentPos: false,
	fixedBgPos: true,

	overflowY: 'auto',

	closeBtnInside: true,
	preloader: false,
	
	midClick: true,
	removalDelay: 300,
	mainClass: 'my-mfp-zoom-in'
});
// 

// Подключение формы GoldCarrot
	$('.ajax-form').goldCarrotForm({
        url: 'mail/ajax.php'
    });
// 

});



$(document).on('click', '.brand', function () {
	var child = $(this).find('.checker');
	if (child.hasClass('active')) {
		child.removeClass('active');
	} else {
		child.addClass('active');
	}

	var array = '';
	$.each($('.checker.active'), function () {
		console.log($(this));
		array += $(this).data('mark-id')+' ';
    });
	console.log(array);
	$.ajax({
		url: '/site/catalog',
		data: {
			markArray: array,
        },
		dataType: 'json',
		method: 'post',
		success: function (data) {
            if (data.status == 'ok') {
                $('.finded-cars').html(data.content);
            }
        }
	});
});

$(document).on('submit', '.callback-form', function (event) {
	event.preventDefault();
	var _this = $(this);
	$.ajax({
		url: '/site/callback',
		dataType: 'json',
		method: 'post',
		data: _this.serializeArray(),
		success: function (data) {
			if (data.status == "ok") {
                yaCounter45911007.reachGoal('callback');
            }
			_this.find('.error-message').html(data.message);
			_this.trigger('reset');
        }
	});
});

$('.body_button').click(function(){
    var section_id = $(this).data('id');
    if (section_id < 3 ) {
        $('.block_body').hide();
    	$('.block_body').eq(section_id).fadeIn();
    	$('.body_button').removeClass('active');
    	$(this).addClass('active');
    }
});

$('.avia').click(function(){
    $('.form-groups-avto').hide();
    $('.switch-button').removeClass('active');
    $(this).addClass('active');
    $('.form-groups-avto').parent().addClass('avia');
	$('.form-groups-avia').show();
});

$('.avto').click(function(){
    $('.switch-button').removeClass('active');
    $(this).addClass('active');
    $('.form-groups-avia').hide();
    $('.form-groups-avto').parent().removeClass('avia');
	$('.form-groups-avto').show();
});





$('.faq-head').click(function(){
	if ($(this).parent().hasClass('open')) {
		$(this).parent().removeClass('open');
		$(this).next().slideUp(400);
	} else {
		$('.faq-head').not(this).parent().removeClass('open');
		$('.faq-head').not(this).next().slideUp(400);
		$(this).parent().addClass('open');
		$(this).next().slideDown(400);
	}
});

$(document).ready(function () {
    var im = new Inputmask('+79999999999');
    im.mask('.js-phone-mask');
});

$(document).ready(function () {
	if(device.mobile()) {
    	$('.js-brand-cars-title').text('Прокат авто в сургуте');
    	$('.js-brand-cars-title-description').remove();
	}
});