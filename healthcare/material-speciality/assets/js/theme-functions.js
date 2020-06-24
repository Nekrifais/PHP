jQuery(document).ready(function() {

	
	
	function format(icon) {
    var originalOption = icon.element;
	if ($(originalOption).data('color') == null){
var $selection = $("<span> " + icon.text + "</span>");
} else {
    var $selection = $("<span><span class='i-metro' style='background-color:#" + $(originalOption).data('color') + "'></span> " + icon.text + "</span>");
}
    return $selection;
}

function formatdefault(icon) {
    var originalOption = icon.element;
    var $selection = $("<span>" + icon.text + "</span>");
    return $selection;
}
	
	
$('.select-home-speciality').select2({
    width: "100%",
	placeholder: "Выберите специальность",
	templateSelection: formatdefault,
});

$('.select-home-place').select2({
    width: "100%",
	placeholder: "Метро, район",
	templateSelection: formatdefault,
    templateResult: format
});	




$('.select-uslugi-place').select2({
    width: "100%",
	placeholder: "Метро, район",
	templateSelection: formatdefault,
    templateResult: format
});	

$('.select-uslugi-speciality').select2({
    width: "100%",
	placeholder: "Услуга",
	templateSelection: formatdefault,
});



$('.select-diagnostic-place').select2({
    width: "100%",
	placeholder: "Метро, район",
	templateSelection: formatdefault,
    templateResult: format
});	

$('.select-diagnostic-speciality').select2({
    width: "100%",
	placeholder: "Диагностика",
	templateSelection: formatdefault,
});



$('.select-taxonomy-spec-speciality').select2({
	width: "100%",
	placeholder: "Выберите специальность",
	templateSelection: formatdefault,
});

$('.select-taxonomy-spec-place').select2({
    width: "100%",
	placeholder: "Метро, район",
	templateSelection: formatdefault,
    templateResult: format
});	



$('.select-taxonomy-clinic-spec-speciality').select2({
	width: "100%",
	placeholder: "Выберите специальность",
	templateSelection: formatdefault,
});

$('.select-taxonomy-clinic-spec-place').select2({
    width: "100%",
	placeholder: "Метро, район",
	templateSelection: formatdefault,
    templateResult: format
});	




if($('.container-mix').length >0 ){	
	var containerEl = document.querySelector('.container-mix');

	var mixer = mixitup(containerEl, {
		load: {
			sort: 'price:asc'
		},
		selectors: {
			control: '[data-mixitup-control]'
		}
				
	});

}
	
	
$('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
});






    var $elmedic = $(".reviews-medic-docdoc-id").data('medicid');
    console.log($elmedic);
	
	$('.medic-docdoc-id-review').val($elmedic);






/* singl-clinic по клике на диагностику начало */

$('.sign-up-scinic-table').on('click', function () {
    var $el = $(this);
    console.log($el.data('price'), $el.data('diagnostic'));
	
	$('.form-clinic-diagnostic').val($el.data('diagconsticid')); 
	$('.form-clinic').val($el.data('clinic')); 

	
	$('.modal-diagnostic-price-single').html($el.data('price') + '<span class="currency"> Руб.</span>'); 
	$('.modal-diagnostic-name-single').text($el.data('diagnostic')); 
	
});

/* singl-clinic по клике на диагностику конец */


$('.open-modal-medic').on('click', function () {
    var $el = $(this);
    console.log($el.data('clinic'), $el.data('medic'), $el.data('time'), $el.data('class'));
	$('.form-medic-clinicfield').val($el.data('clinic')); 
	$('.form-medic-medicfield').val($el.data('medic')); 
	$('.form-medic-timefield').val($el.data('time')); 
	
	$("div.adress-clinic-popup").addClass('hidden'); 
	$($el.data('class')).removeClass('hidden'); 
	
	
});


/* $('.open-modal-diagnostic').on('click', function () {
    var $el = $(this);
    console.log($el.data('price'), $el.data('diagnostic'));
	
	$('.form-clinic-diagnostic').val($el.data('diagconsticid')); 
	$('.form-clinic').val($el.data('clinic')); 

	
	$('.modal-diagnostic-price-single').html($el.data('price') + '<span class="currency"> Руб.</span>'); 
	$('.modal-diagnostic-name-single').text($el.data('diagnostic')); 
	

	
}); */



$('.table-diagnostic-order').on('click', function () {
    var $el = $(this);
    console.log($el.data('price'), $el.data('id'));
	
	$('.form-clinic-diagnostic').val($el.data('diagnosticid')); 
	$('.form-clinic').val($el.data('id')); 
	
	$('.modal-diagnostic-price-taxonomy').html($el.data('price') + '<span class="currency"> Руб.</span>'); 

	
	
	
    var dataTargetAdress = '.table-clinic-adress-' + $(this).data('id'),
    dataContentAdress = $(dataTargetAdress).text();
	
	$('.street').text(dataContentAdress);
	
	

    var dataTargetMetro = '.table-clinic-metro-' + $(this).data('id'),
    dataContentMetro = $(dataTargetMetro).html();
	
	$('.metro-all').html(dataContentMetro);
	
	

    var dataTargetName = '.table-clinic-name-' + $(this).data('id'),
    dataContentName = $(dataTargetName).html();
	
	$('.adress-clinic-one-link').html(dataContentName);


	
});


$('.table-service-order').on('click', function () {
    var $el = $(this);
    console.log($el.data('price'), $el.data('id'));
	
	$('.form-service').val($el.data('diagnosticid')); 
	$('.form-clinic').val($el.data('id')); 
	
	$('.modal-diagnostic-price-taxonomy').html($el.data('price') + '<span class="currency"> Руб.</span>'); 

	
	
	
    var dataTargetAdress = '.table-clinic-adress-' + $(this).data('id'),
    dataContentAdress = $(dataTargetAdress).text();
	
	$('.street').text(dataContentAdress);
	
	

    var dataTargetMetro = '.table-clinic-metro-' + $(this).data('id'),
    dataContentMetro = $(dataTargetMetro).html();
	
	$('.metro-all').html(dataContentMetro);
	
	

    var dataTargetName = '.table-clinic-name-' + $(this).data('id'),
    dataContentName = $(dataTargetName).html();
	
	$('.adress-clinic-one-link').html(dataContentName);
	
	
});












    var $elmedic = $(".reviews-medic-docdoc-id").data('medicid');
    console.log($elmedic);
	
	$('.medic-docdoc-id-review').val($elmedic);

    var $el = $(".th-btnappointment").data('city');
    console.log($el);
	
	$('.form-medic-cityfield-fh').val($el);
    $('.form-medic-cityfield-right-form').val($el); 	
	$('.form-medic-cityfield-taxonomy').val($el); 
	
    var $elservice = $(".service-title").data('service');
    console.log($elservice);
	$('.form-service').val($elservice);




    var $elmedic = $(".body-class").data('city');
    console.log($elmedic);
	
	$('.form-medic-cityfield-right-form').val($elmedic);


	
	


$('.taxonomy-order-in').on('click', function () {
	var $el = $(this);
	
	$('.taxonomy-modal-image').html('<img src="' + ($el.data('image') + '">')); 
	$('.modal-medic-title-top').html(($el.data('title'))); 
	$('.modal-medic-speciality-list').html(($el.data('categoies'))); 
	$('.modal-expicience').html(($el.data('expicience'))); 
	$('.modal-price').html(($el.data('price'))); 
	$('.modal-adress-clinic-one-link').html(($el.data('clinicname'))); 
	$('.modal-street').html(($el.data('clinicstreet'))); 
	
	$('.form-medic-clinicfield').val($el.data('clinic')); 
	$('.form-medic-medicfield').val($el.data('medic')); 
	
	
});









$('.table-uslugi-order').on('click', function () {
    var $el = $(this);
	
	$('.form-service').val($el.data('servicecid')); 
	
	
});


$('.modal-default-cursor-point').on('click', function () {
    var $el = $(this);
	
	$('.form-medic-cityfield-fh').val($el.data('currentcity')); 
	
	
});





/* 	
$( "a.dropdown-toggle" ).hover(function() {
	$( ".menu-mini-block.dropdown" ).addClass( "open" );
}, function() {
    $( ".menu-mini-block.dropdown" ).removeClass( "open" );
  });



$( ".testing" )
    .hover(function() {
      $( this )
        .toggleClass( "active" )
        .next()
          .stop( true, true )
          .slideToggle();
    }); */


});








