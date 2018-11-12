$(function() {

    $('.popup').magnificPopup({
        type: 'ajax',

        fixedContentPos: false,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,

        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
    });

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

document.ontouchmove = function(event){
	if ($('body').hasClass('scrolldisable')) {
		event.preventDefault();
	}
};

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

$('*').tooltipster();

$('.check-other-job').click(function(){
	$(this).toggleClass('active');
});

// Подключение Slick Carousel
$('.index-banner-slider').slick({
  dots: false,
  arrows: false,
  infinite: true,
  speed: 2000,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 5000,
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
//
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
$('.name_organization').click(function(){
    var section_id = $(this).data('id');
	$('.history_table').hide();
	$('.history_table').eq(section_id).fadeIn();
	$('.name_organization').removeClass('active');
	$(this).addClass('active');
});

$(document).ready(function () {
    var im = new Inputmask('+79999999999');
    im.mask('.js-phone-mask');
});

$(document).on('submit', '#password-changer', function (event) {
	event.preventDefault();
	var _this = $(this);
	$.ajax({
		url: '/user/change-password',
		method: 'post',
		data: _this.serializeArray(),
		dataType: 'json',
		success: function (data) {
            $('.password-block').html(data.content);
			if (data.status == 'ok') {
                $('.error-summary-message').html(data.message);
			}
        }
	})
});

$(document).on('change', '.datepicker', function () {
	var target = $($(this).data('target'));
	var array = $(this).val().split('-');
	var normalDate = array[1] + '-' + array[0] + '-' + array[2];
    target.val(new Date(normalDate).getTime()/1000);
});

$(document).on('click', '.js-sberbank-payment', function (event) {
	event.preventDefault();
	$.ajax({
		url: $(this).attr('href'),
		method: 'post',
		success: function (data) {
			if (data.status == 'success') {
				window.location.href = data.sberbankLink;
			}
        }
	})
});
$('.a-head').click(function(){
	if ($(this).parent().hasClass('open')) {
		$(this).parent().removeClass('open');
		$(this).next().slideUp(600);
	} else {
		$('.a-head').not(this).parent().removeClass('open');
		$('.a-head').not(this).next().slideUp(600);
		$(this).parent().addClass('open');
		$(this).next().slideDown(600);
	}
});

$('.mobile-substitute-table-wrap .block__head').click(function(){
	if ($(this).hasClass('open')) {
		$(this).removeClass('open');
		$(this).next().slideUp(300);
	} else {
		$('.mobile-substitute-table-wrap .block__head').not(this).removeClass('open');
		$('.mobile-substitute-table-wrap .block__head').not(this).next().slideUp(300);
		$(this).addClass('open');
		$(this).next().slideDown(300);
	}
});

$(document).on('keyup', '.js-bonuses-field', function () {
	var _this = $(this);
	$.ajax({
		method: 'post',
		url: _this.data('url'),
		data: {
			bonuses: _this.val()
		},
		dataType: 'json',
		success: function (data) {
			if (data.status == 'success') {
				$('.js-price').html(data.price);
				$('.js-bonuses-balance').html(data.bonusesBalance);
                $('.error-summary').html('');
			} else {
				$('.error-summary').html(data.message);
			}
        }
	});
});