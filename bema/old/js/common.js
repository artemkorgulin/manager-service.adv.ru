$(function(){
	initPopup();
	// в activeSlide будет содержаться номер слайда который нужно поставить в центр (начиная с 1)
	var activeSlide = initCalendair();
	initCarousel();
	/*initChekbox();*/
	go_to();
	initStilizedList();
	initPopupSteps();
    initUploadImages();
    SendFormData();
    
    function initUploadImages() {
            var maxFileSize = 3 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
            var maxFileCount = 10;
            var queue = {};
            var form = $('form#uploadImages');
            var imagesList = $('#uploadImagesList');
            var allFiles = [];

            var itemPreviewTemplate = imagesList.find('.item.template').clone();
            itemPreviewTemplate.removeClass('template');
            imagesList.find('.item.template').remove();
        
            $('.upload-counter').text(0 + ' из ' + maxFileCount);


            $('#file').on('change', function(e) {
                e.preventDefault();
                var files = this.files;
                
                $('.upload-counter').text(files.length + ' из ' + maxFileCount);

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];

                    if (!file.type.match(/image\/(jpeg|jpg|png|gif)/)) {
                        alert('Фотография должна быть в формате jpg, png или gif');
                        continue;
                    }

                    if (file.size > maxFileSize) {
                        alert('Размер фотографии не должен превышать 3 Мб');
                        continue;
                    }
                    
                    if (file.size < maxFileCount) {
                        alert('Загрузите не менее 10 фотографий проекта');
                        continue;
                    }
                    

                    preview(files[i]);
                }
                //console.log(queue);
            });

            // Создание превью
            function preview(file) {
                var reader = new FileReader();
                reader.addEventListener('load', function(event) {
                    var img = document.createElement('img');

                    var itemPreview = itemPreviewTemplate.clone();

                    itemPreview.find('.upload-preview img').attr('src', event.target.result);
                    itemPreview.data('id', file.name);

                    imagesList.append(itemPreview);

                    queue[file.name] = file;

                });
                reader.readAsDataURL(file);
            }

            // Удаление фотографий
            imagesList.on('click', '.upload-delete', function() {
                var item = $(this).closest('.item'),
                    id = item.data('id');

                delete queue[id];

                item.remove();
            });        
    }
    

	function initStilizedList(){

		$('.stilized-list').on('click', function(el){

			var $listToOpen = $(el.target).next('ul');

			var toggleClass = $($listToOpen).attr('class').split(' ')[0] + '_opened';

			$($listToOpen).toggleClass(toggleClass);
			setTimeOut(function(){$.fancybox.update()},2000);

		})

	}

	function initPopupSteps(){

		
		$('.advice-flap-text').perfectScrollbar();
		$('.flaper-txt').perfectScrollbar();
		$('.scroll-1').perfectScrollbar();

		$('.selecter__items').perfectScrollbar();

		$(document).on('click step:validate', '.popup-next, .popup-getback', function(ev, in1, in2){

			var nextIncrement = $(this).hasClass('popup-next') ? 1 : -1;

			var $currentTab = $(this).closest('.form-inner');
			var currentTabIndex = $currentTab.attr('id').split('-')[1] - 0;

			var nextTabIndex = currentTabIndex + nextIncrement;

			var $nextTab = $('#step-'+nextTabIndex);

			if(!$nextTab.length){

				$.fancybox.close();
				return false;

			}

			if(nextIncrement == 1){

				var stepFormIsCorrect = validate($currentTab, in1 != 'step:validate');

				if(stepFormIsCorrect){

					if(in1 != 'step:validate'){

						$currentTab.addClass('hidden');
						$nextTab.removeClass('hidden');

					} else {

						$(this).removeClass('popup-next_disable');

					}

				} else {

					$(this).addClass('popup-next_disable');

				}

			} else {

				$currentTab.addClass('hidden');
				$nextTab.removeClass('hidden');

			}

			return false;

		});

		$(document).on('click', '.popup-cancelation', function(){

			$.fancybox.close();
			return false;

		})

		$(document).on('click change keyup keypress', '#registration-form input, #registration-form textarea, #registration-form select', function(){

			//console.log(1);

			$(this).closest('.form-inner').find('.popup-next').trigger('step:validate', 'step:validate');

		});

		// чекбоксы в выпадающем списке
		$(document).on('change', '.selecter__item input', function(){

			var $viewContainer = $(this).closest('.form-inner').find('.cheker-box');

			var id = $(this).attr('id');

			var txt = $(this).prev().html();

			$(this).val( $(this).prop('checked') ? $(this).data('value') : '' );
			
			if($viewContainer.find('[data-id="'+id+'"]').length){

				$viewContainer.find('[data-id="'+id+'"]').remove();

			} else {

				//console.log($viewContainer.find('.popup-line').length, $viewContainer.data('maxitems'));

				if( $viewContainer.find('.popup-line').length >= $viewContainer.data('maxitems') ){

					$(this).val( $(this).prop('checked') ? $(this).data('value') : '' );
					$(this).prop('checked', false); 

					return false;

				}

				$viewContainer.append('<div class="popup-line" data-id="'+id+'">'+txt+'<input type="hidden" value="'+txt+'" name="'+$viewContainer.data('inputname')+'"></div>');
				
			}



		});

		// tabs
		$(document).on('click', '.tab-box__tab', function(){

			var $tab = $( $(this).attr('href') );

			var $linksContainer = $(this).parent();
			
			var $otherLinks = $linksContainer.find('.tab-box__tab');
			$otherLinks.removeClass('tab-box__tab_active');

			$otherLinks.each(function(){

				$( $(this).attr('href') ).addClass('hidden');

			})

			$(this).addClass('tab-box__tab_active');
			$tab.removeClass('hidden');

			return false;

		})

		$('.tab-box__tab_active').trigger('click');

	}

	function validate($container, focus){

		$container = $($container);

		$inputs = $container.find('input, textarea, select');

		var validateErrors = [];

		$inputs.each(function(){

			var validateMethod = $(this).data('validate-method');

			if( !$(this).val() && !$(this).attr('required') ) return;

			var valid = (validateMethod) ? validateMethods[validateMethod]( $(this).val(), $(this) ) : true;

			if(!valid) validateErrors.push( $(this) );

			$(this).addClass('validate-error');

		});

		if(validateErrors.length){

			if(focus) $(validateErrors[0]).trigger('focus');
			return false;

		} else {

			return true;

		}

	}

	var validateMethods = {

		'email': function(val, $el){

			var reg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

			return reg.test(val);

		},

		'name': function(val, $el){

			var reg = /^[а-яa-z -]{2,100}$/i;

			return reg.test(val);

		},

		'phone': function(val, $el){

			return $el.inputmask('isComplete');

		},

		'reg': function(val, $el){

			var reg = new RegExp($el.data('regexp'), 'i');

			return reg.test(val);

		},

		'requiredChecked': function(val, $el){

			return $el.prop('checked');

		}

	}
 
	function go_to() {
		$('.go_to').click( function(){ /* ловим клик по ссылке с классом go_to */
			var scroll_el = $(this).attr('href'); /* возьмем содержимое атрибута href, должен быть селектором, т.е. например начинаться с # или . */
			if ($(scroll_el).length != 0) { /* проверим существование элемента чтобы избежать ошибки */
				$('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500); /* анимируем скроолинг к элементу scroll_el */

			}
			return false; /* выключаем стандартное действие */
		});
	}

	function initChekbox() {
		/* Проверяем чекбокс, дизаблим/раздизабливаем кнопку */
		$('.chekbox [name="personalDataAgree"]')
		.on('change', function() {
			var $form = $(this).closest('form');

			/*if ( this.checked ) {
				$(':submit', $form).removeAttr('disabled');
			}
			else {
				$(':submit', $form).attr('disabled', 'disabled');
			}*/
			$(':submit', $form).prop('disabled', !this.checked);
			
		})
		.prop('checked', false).trigger('change')
		;
	}
    
//    function PostForData() {
//        var str = $("form").serialize();        
//        $.ajax({
//            type: "POST",
//            url: "ajax/user.php",
//            data: str,
//            success: function (msg){
//                console.log('success');
//            }
//        });
//    }

	function initPopup() {
		if (!$('.fancybox').length) return;

		$('.fancybox').fancybox({
			padding: 0,
			helpers: {
				media: {},
				overlay: {
					locked: true
				}
			},
            afterClose: function() {
                var str = $("form").serialize();
                $.ajax({
                    type: "POST",
                    url: "chunks/form-dumper.php",
                    data: str,
                    success: function (msg){
                    }
                });
            }
            
		});
	}
    
    function SendFormData() {
        $('.next-prev-buttons').on('click', 'a', function() {
            var str = $("form").serialize();
            //console.log(str);
            $.ajax({
                type: "POST",
                url: "chunks/form-dumper.php",
                data: str,
                success: function (msg){
                    //console.log('success');
                }
            });
        });
    }
    

	/* Проверяем чекбокс, дизаблим/раздизабливаем кнопку */
	$(document).on('change', ':checkbox[name="personalDataAgree"]', function() {
		var $form = $(this).closest('form');

		if ( this.checked ) {
			$(':submit', $form).removeAttr('disabled');
		}
		else {
			$(':submit', $form).attr('disabled', 'disabled');
		}
	});


	var dot = $('.experts-wrap .owl-dot');
	dot.each(function() {
		var index = $(this).index() + 1;
		if(index < 10){
			$(this).html(index);  /* если надо ставить 0 перед цифрой $(this).html('0').append(index);*/
		}else{
			$(this).html(index);
		}
	});
 









	

	function initCalendair(){

		var months = 	[];
			months[0] 	= 'Янв';
			months[1] 	= 'Февр';
			months[2] 	= 'Март';
			months[3] 	= 'Апр';
			months[4] 	= 'Май';
			months[5] 	= 'Июнь';
			months[6] 	= 'Июль';
			months[7] 	= 'Авг';
			months[8] 	= 'Сент';
			months[9] 	= 'Окт';
			months[10] 	= 'Нояб';
			months[11] 	= 'Дек';

		var fullWidth = $('.calendair__points').outerWidth();
		var activeSlide = 0;

		var currentDate = window.location.hash ? new Date( window.location.hash.split('#')[1] ) : new Date();
		var currentDay = {

			x: 0,
			date: new Date(currentDate), // MM-DD-YYYY hh:mm:ss.ms
			label: 'Сегодня<br><span class="calendair__today-cyan">' + months[ (new Date(currentDate)).getMonth() ] + ' ' + (new Date(currentDate)).getDate() + '</span>',
			flag: [],
			slide: 1

		}

		var calendairPoints = [

			{
				x: 0,
				date: new Date('09-20-2017 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Сент 20',
				flag: ['right'],
				slide: 1,
				labelMerge: 2,
				labelToText: 'Прием<br>заявок'
			},
			{
				x: 50/3,
				date: new Date('10-01-2017 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Окт 1',
				flag: [],
				slide: false
			},
			{
				x: (50/3) * 2,
				date: new Date('11-20-2017 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Нояб 20',
				flag: ['left', 'right'],
				slide: 2,
				labelMerge: 1,
				labelToText: 'Предварительный<br>отбор'
			},
			{
				x: 50,
				date: new Date('12-01-2017 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Дек 1',
				flag: ['left', 'right'],
				slide: 3,
				labelMerge: 2,
				labelToText: 'Заочный этап<br>голосования'
			},
			{
				x: 60,
				date: new Date('01-01-2018 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Янв 1',
				flag: [],
				slide: false
			},
			{
				x: 70,
				date: new Date('01-31-2018 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Янв 31',
				flag: ['left'],
				slide: 4
			},
			{
				x: 80,
				date: new Date('02-01-2018 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Февр 1',
				flag: ['right'],
				slide: 5
			},
			{
				x: 90,
				date: new Date('02-15-2018 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Февр 15',
				flag: ['right'],
				slide: 6
			},
			{
				x: 100,
				date: new Date('02-16-2018 00:00:00.00'), // MM-DD-YYYY hh:mm:ss.ms
				label: 'Февр 16',
				flag: ['right'],
				slide: 7
			}

		];

		if(currentDay.date >= calendairPoints[calendairPoints.length-1].date){

			currentDay.label = '';
			currentDay.date = calendairPoints[calendairPoints.length-1].date;

		}
		
		if(currentDay.date <= calendairPoints[0].date){

			currentDay.label = '';

		}

		for(var i = 0; i < calendairPoints.length; i++){

			var currentPoint = calendairPoints[i];
			var nextPoint = calendairPoints[i+1] ? calendairPoints[i+1] : calendairPoints[i];

			// текущая ключевая точка в px
			currentPoint.x = (fullWidth/100) * currentPoint.x;

			// расстояние до след шага в px
			currentPoint.right = (fullWidth/100) * nextPoint.x - currentPoint.x;

			// дней от начала до следующей точки
			currentPoint.rightDays = (nextPoint.date - currentPoint.date)/1000/60/60/24;

			// offset отрезка
			currentPoint.xOffsetLeft = currentPoint.x + 35;
			currentPoint.xOffsetRight = currentPoint.x + currentPoint.right - 35;

			// реальный отрезок на котором рисовать текущий день
			currentPoint.rightReal = currentPoint.xOffsetRight - currentPoint.xOffsetLeft;
			currentPoint.oneDay = currentPoint.rightReal/currentPoint.rightDays;

			// проверка, уже прошло или нет
			currentPoint.isActive = currentDay.date >= currentPoint.date;

			if(currentPoint.isActive){

				activeSlide = currentPoint.slide || nextPoint.slide;
				currentDay.x = currentPoint.xOffsetLeft + ( (currentDay.date - currentPoint.date)/1000/60/60/24 ) * currentPoint.oneDay;

				if(new Date(currentDay.date).getDate() == new Date(currentPoint.date).getDate() && new Date(currentDay.date).getMonth() == new Date(currentPoint.date).getMonth()){

					currentDay.label = '';
					currentDay.x = currentPoint.x;

				}

			}

		}

		for(var i = 0; i < calendairPoints.length; i++){

			var currentPoint = calendairPoints[i];

			if(currentPoint.labelToText){

				$('.calendair__line').append('<div id="calendair__add-text-'+i+'" class="calendair__add-text"><span class="calendair__add-text-inner">'+currentPoint.labelToText+'</span></div>');

				$('#calendair__add-text-'+i)
				.css('left', currentPoint.x)
				.css('width', currentPoint.right * currentPoint.labelMerge);

			}

		}

		$('.calendair__line-elapsed').css('width', Math.round(currentDay.x));
		$('.calendair__today-txt').html(currentDay.label);
		$('.calendair__today-txt').css( 'right', -Math.round($('.calendair__today-txt').outerWidth()/2) );

		for(var i = 0; i < calendairPoints.length; i++){

			var $flag = '';

			if(calendairPoints[i].flag.length >= 1){

				$flag = $('<div class="calendair__flag"></div>');

				for(var f = 0; f < calendairPoints[i].flag.length; f++){

					$flag.append('<div class="calendair__flag_' + calendairPoints[i].flag[f] + ' ' + (calendairPoints[i].isActive ? 'calendair__flag_active' : '') + '"></div>');

				}

			}

			$('.calendair__line').append('<div id="calendair__point_' + i + '" class="calendair__point ' + (calendairPoints[i].isActive ? 'calendair__point_active' : '') + ' ' + (calendairPoints[i].flag.length ? '' : 'calendair__point_nopoint') + '">' + calendairPoints[i].label + '</div>');

			$('#calendair__point_'+i)
			.append($flag)
			.css( {left: Math.round(calendairPoints[i].x - $('#calendair__point_'+i).outerWidth()/2)} );


		}

		return calendairPoints[activeSlide].slide;

	}






	function initCarousel() {

		if (!$('div.owl-carousel').length) return; 
		//console.log (activeSlide)

		$(document).on('init', 'div.owl-carousel', function() {
			var
			$carousel = $(this),
			defaults = {
				loop: true,
				autoplay:true,
				autoplayTimeout:10000,
				autoplayHoverPause:false,
				margin: 0,
				startPosition: activeSlide,
				nav: true,
				dots: true,
        		items: 1,
				/*
				onInitialized: function() {
					$('.owl-prev').after('<div class="slide-num"><span class="current">1</span> <span class="seperator">/</span> <span class="all">3</span></div>');
				},
				onTranslated: function() {
					var current = $('.owl-carousel .owl-item.active .slides').data('owl-slide');
					$('.slide-num .current').html(current);
				}, */
			},
			options = {}
			;

			if ( $carousel.data('owl-options') ) {
				options = eval('[' + $carousel.data('owl-options') + ']')[0];
				$.extend(defaults, options);
			}

			$carousel.owlCarousel(defaults);
		});

		$('div.owl-carousel').trigger('init');
	}


	$(document).ready(function(){
	    $('.go_to').click( function(){ // ловим клик по ссылке с классом go_to
		var scroll_el = $(this).attr('href'); // возьмем содержимое атрибута href, должен быть селектором, т.е. например начинаться с # или .
	        if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
		    $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500); // анимируем скроолинг к элементу scroll_el
	        }
		    return false; // выключаем стандартное действие
	    });
	});

});