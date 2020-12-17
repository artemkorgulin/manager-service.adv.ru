$(document).ready(function(){

	// в activeSlide будет содержаться номер слайда который нужно поставить в центр (начиная с 1)
	var activeSlide = initCalendair();

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

})