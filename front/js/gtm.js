;(function () {
	
	var domains = {

		'synergy.ru': 'GTM-P4H3L8',
		'synergyonline.ru': 'GTM-K7GK9K',
		'synergy.online': 'GTM-TTN54WK',
		'sbs.edu.ru': 'GTM-K77TBB',
		'synergyglobal.ru': 'GTM-M7T7GF',
		'synergyglobal.kz': 'GTM-M96734W',
		'synergyglobal.com': 'GTM-WRC28N5',
		'synergytravel.ru': 'GTM-PFNKP7',
		'synergystore.ru': 'GTM-MHHPRK',
		'megacampus.ru': 'GTM-PNZW28',
		'synergylectorium.ru': 'GTM-NLJHX3',
		'lingva.edu.ru': 'GTM-NB47WD',
		'egemetr.ru': 'GTM-MMDNLB',
		'studenthostel.ru': 'GTM-PH3LQ7',
		'*.synergy.ru': 'GTM-PSBWRH',
		'moi.edu.ru': 'GTM-N5XRLZ',
		'synergyartclub.ru': 'GTM-NX5XX4',
		'synergysport.ru': 'GTM-KL58LF',
		'mol.synergy.ru': 'GTM-N2CDGD',
		'mosap.ru': 'GTM-5QDVLP',
		'synergyakselerator.ru': 'GTM-595TNF',
		'synergy-extreme-centre.ru': 'GTM-5JNDX3',
		'synergyzavod.ru': 'GTM-P4SB8J',
		'referat.ru': 'GTM-PKBM3M',
		'synergy.mba': 'GTM-K7JJ2V',
		'synergymba.ru': 'GTM-T8ZX6C',
		'synergy.university': 'GTM-PGJJ39',
		'synergyvision.ru': 'GTM-NS9K26',
		'synergyuniversity.com': 'GTM-57X27N',
		'blog.synergy.ru': 'GTM-KD5FMC',
		'synergyonline.kz': 'GTM-MPRVGR',
		'synergyserviceforum.ru': 'GTM-M9N2W4',
		'synergyregions.ru': 'GTM-5PPT8TD',
		'synergy.vc': 'GTM-5P7J5W5',
		'servicesynergy.ru': 'GTM-MR8DK4M',
		'arsenal-i.ru': 'GTM-NCVWJ3R',
		'amazonkimedia.com': 'GTM-PM2J2TW',
		'maxmediagroup.ru': 'GTM-WLKNKTW',
		'synergydigital.ru': 'GTM-KLF6RLG',
		'miss.synergy.ru': 'GTM-KRFJL3G',
		'scollege.ru': 'GTM-T7V8RNC',
		'recruitment.synergy.ru': 'GTM-MX6Q55B',
		'synergy-leadership.ru': 'GTM-56965FL',
		'synergytv.ru': 'GTM-5VBTPV6',
		'gozoboronzakaz.ru': 'GTM-KKQ5XCL',
		'amba.kz': 'GTM-P3V56WW',
		'synergybusiness.kz': 'GTM-WRXV34X',
		'trueedu.ru': 'GTM-5LWPGM9',
		'synergy.film': 'GTM-KSWNKF',
		'sosday.ru': 'GTM-M2WJLCZ',
		'bemafestival.ru': 'GTM-TD3C44W',
		'www.russianfilmweek.org': 'GTM-TCZ9RXQ',
		'souzsadovodovmos.ru': 'GTM-WLJPWJR',
		'synergymanagement.ru': 'GTM-TTC2FBS',
		'suniversity.ru': 'GTM-K7VCTML',
		'synergybase.ru': 'GTM-K394Q23',
		'synergywomen.ru': 'GTM-W3BD45Z',
		'xn--b1aaqaiadai3acbqmcd2a0p.xn--p1ai': 'GTM-WQQC6RQ', /* экскурсиивсколково.рф */
		'xn--b1agaegcqr4akmbd4b.xn--p1ai': 'GTM-WGSV39V', /* университетжкх.рф */
		'xn--c-htbcabf2beffclo2aj.xn--p1ai': 'GTM-WM96LC8', /* cпортменеджмент.рф */
		'xn--1-itbibssi5j.xn--p1ai': 'GTM-T68JMK2', /* империя1.рф */
		'xn--c1ad7e.xn--p1ai': 'GTM-M62HCD', /* егэ.рф */
		'xn--80afdojmghbd5am9k.xn--p1ai': 'GTM-MCWS9B', /* экономистгода.рф */
		'xn--90acawbgfg1aekeibee2a1n.xn--p1ai': 'GTM-WTBRJ7', /* брусиловскийпрорыв.рф */
		'xn--80abmmodlsdpl2d.xn--p1ai': 'GTM-WTBRJ7', /* штурмберлина.рф */
		'xn--80adbaibdayc5ctbbvqcqbk.xn--p1ai': 'GTM-WBLXPP', /* университетсадоводов.рф */
		'xn--80ajnedmjjz0gj.xn--p1ai': 'GTM-MF979WC', /* реальныйкот.рф */
		'xn--2017-43d5ea.xn--p1ai': 'GTM-PH6FHRP', /* мма2017.рф */
		'xn--80aayoegldhg0a2a2j.xn--80adxhks': 'GTM-TC86W4J', /* трансформация.москва */
		'xn--80aacpblgnjy9bfbkm6k.xn--p1ai': 'GTM-WJD2NV', /* факультетбизнеса.рф */
		'xn--80aaoaaqmiub6atbceeo2m.xn--p1ai': 'GTM-ML5D2D', /* факультетинтернета.рф */
		'xn--2015-f4d3agcs2asm9l.xn--p1ai': 'GTM-PJW552', /* призывник2015.рф */
		'xn--80aaakzv5abgkcm.xn--p1ai': 'GTM-K8BDQJ', /* магистратура.рф */
		'examples': 'GTM-P4H3L8' /* TODO: для теста на локалке подключаем GTM от synergy.ru */

	};

	var GTMID;
	var locationDamains = window.location.hostname.split('.');
	var locationDomainsString = locationDamains.join('.');

	// сначала смотрим прямое вхождение
	GTMID = domains[window.location.hostname];

	// если прямое вхождение не прокатило, ищем GTM на поддомены типа *.synergy.ru
	if(!GTMID){

		// заменяем поочередно каждую часть поддомена на *, чтобы найти прямое вхождение в domains
		for(var i = 0; i < locationDamains.length; i++){

			locationDamains[i] = '*';
			locationDomainsString = locationDamains.join('.');

			if(domains[locationDomainsString]){

				GTMID = domains[locationDomainsString];
				break;

			}

		}

	}

	if(GTMID){

		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer',GTMID);

	}

	console.log(Date.now());

})();