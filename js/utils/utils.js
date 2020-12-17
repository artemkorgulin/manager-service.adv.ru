/* 

всякие утилиты для лендов, не входят в базовый функционал лендера

*/

// возвращает склоненное по числу слово. Принимает число и массив ['день','дня','дней']
window.lander_declOfNum = function(num, titles){

	var cases = [2, 0, 1, 1, 1, 2];
	return titles[ (num%100>4 && num%100<20)? 2 : cases[(num%10<5)?num%10:5] ];

}

/*

сопоставляет 2 объекта и записывает туда значения:
elements: { money: '.money' }
values: { money: 100 }

=> $('.money').html(100)

*/
window.lander_multiplyHtml = function(elements, values){

	for(var el in elements){

		if(!elements.hasOwnProperty(el)) continue;

		if( typeof values[el] !== undefined && $( elements[el] ) ){

			$( elements[el] ).html( values[el] );
			
		}

	}

}

// таймер обратного отсчета
window.lander_timer = function(op, elements){

	/* 

	timeEnd format: YYYY-MM-DDTHH:mm:ss.sss (2017-05-18T10:00:00.000)
	http://www.ecma-international.org/ecma-262/5.1/#sec-15.9.1.15

	*/

	var defaults = {

		timeEnd: 0,
		interval: 1000,
		elements: {

			days: 			'.syn-utils-timer__days',
			days_text: 		'.syn-utils-timer__days-text',
			hours: 			'.syn-utils-timer__hours',
			hours_text: 	'.syn-utils-timer__hours-text',
			minutes: 		'.syn-utils-timer__minutes',
			minutes_text: 	'.syn-utils-timer__minutes-text',
			seconds: 		'.syn-utils-timer__seconds',
			seconds_text: 	'.syn-utils-timer__seconds-text'

		}

	};

	$.extend(defaults.elements, elements);
	$.extend(defaults, op);

	defaults.timeEnd = window.lander_timerGetTimeOffset(defaults.timeEnd);

	var times = window.lander_timerIterator(defaults.timeEnd);
	window.lander_multiplyHtml(defaults.elements, times);

	var interval = setInterval(function(){

		var times = window.lander_timerIterator(defaults.timeEnd);

		if(times.ms <= 0){

			clearInterval(interval);

		} else {

			window.lander_multiplyHtml(defaults.elements, times);

		}

	}, 1000);

	return {interval: interval, defaults: defaults};

}

// преобразует местное время в UTC
window.lander_timerGetTimeOffset = function(timeEnd){

	//return new Date(timeEnd).getTime() - (new Date().getTimezoneOffset() * 60 * 1000);
	return new Date(timeEnd).getTime();

}

// итератор таймера. Используется в setInterval, возвращает остаток времени до timeEnd
window.lander_timerIterator = function(timeEnd){

	var days = 		['день','дня','дней'];
	var hours = 	['час','часа','часов'];
	var minutes = 	['минута','минуты','минут'];
	var seconds = 	['секунда','секунды','секунд'];

	var diff_ms = timeEnd - Date.now();

	var diff = new Date(diff_ms);

	var d = Math.floor(diff/1000/60/60/24);
	var h = Math.floor(diff/1000/60/60) - d*24;
	var m = diff.getMinutes();
	var s = diff.getSeconds();

	var values = {

		days: 			d,
		days_text: 		window.lander_declOfNum(d, days),
		hours: 			h,
		hours_text: 	window.lander_declOfNum(h, hours),
		minutes: 		m,
		minutes_text: 	window.lander_declOfNum(m, minutes),
		seconds: 		s,
		seconds_text: 	window.lander_declOfNum(s, seconds),
		ms: 			diff_ms

	}

	return values;

}

/* 

https://sd.synergy.ru/Task/View/136881

функционал для лендов вебинаров:

за 2 часа до начала вебинара появляется обратный отсчет (до вебинара осталось бла бла бла)
Когда вебинар начинается, появляется попап iframe в котором отображается сам вебинар (это поведение настраивается)

*/
window.lander_webinarTimer = function(op, elements){

	console.log(1);

	var defaults = {

		href: 'about:blank',
		webinarStart: 0,
		webinarDuration: 1000 * 60 * 60 * 4,
		timerStart: 1000 * 60 * 60 * 2,
		txt: 'До начала вебинара осталось: ',
		elements: {
			iframe: 		'fancybox',
			timer: 			'.syn-utils-webinar-timer',
			days: 			'.syn-utils-webinar-timer__days',
			days_text: 		'.syn-utils-webinar-timer__days-text',
			hours: 			'.syn-utils-webinar-timer__hours',
			hours_text: 	'.syn-utils-webinar-timer__hours-text',
			minutes: 		'.syn-utils-webinar-timer__minutes',
			minutes_text: 	'.syn-utils-webinar-timer__minutes-text',
			seconds: 		'.syn-utils-webinar-timer__seconds',
			seconds_text: 	'.syn-utils-webinar-timer__seconds-text'
		}

	}

	$.extend(defaults.elements, elements);
	$.extend(defaults, op);

	defaults.webinarStart = window.lander_timerGetTimeOffset(defaults.webinarStart);

	var times = window.lander_timerIterator(defaults.webinarStart);
	window.lander_multiplyHtml(defaults.elements, times);

	var timerShowed = false;
	var webinarShowed = false;

	var interval = setInterval(function(){

		var times = window.lander_timerIterator(defaults.webinarStart);
		console.log(times);

		// вебинар начался
		if(times.ms <= 0){

			if( times.ms <= -defaults.webinarDuration ){

				// вебинар закончился

			} else {

				// вебинар начался и продолжается
				if(!webinarShowed){

					webinarShowed = true;
					$.fancybox({
						href: defaults.href,
						type: 'iframe',
						padding: 0
					})

				}

			}

			clearInterval(interval);

		} else {

			if(times.ms > defaults.timerStart){

				// до вебинара еще больше чем 2 часа (по умлочанию)

			} else {

				// до вебинара меньше чем 2 часа
				if(!timerShowed){

					timerShowed = true;

					var $timer = $(defaults.elements.timer);

					if(!$timer.length){

						$('body').append('<div class="syn-utils-webinar-timer"><div class="container">'+defaults.txt+'<span class="syn-utils-webinar-timer__days"></span><span class="syn-utils-webinar-timer__days-text"></span><span class="syn-utils-webinar-timer__hours"></span><span class="syn-utils-webinar-timer__hours-text"></span><span class="syn-utils-webinar-timer__minutes"></span><span class="syn-utils-webinar-timer__minutes-text"></span><span class="syn-utils-webinar-timer__seconds"></span><span class="syn-utils-webinar-timer__seconds-text"></span></div></div>');

					}

					$(defaults.elements.timer).show();

				}

				window.lander_multiplyHtml(defaults.elements, times);

			}

		}

	}, 1000);

}
