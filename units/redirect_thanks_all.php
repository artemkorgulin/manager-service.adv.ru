<?php
//if( stristr( $lead->url, 'test=1' ) !== false ){
if (!$_GET['ignore-thanksall']) {
    $needle = parse_url($lead->url)['host'];
    $result = null;

    $config['user']['sendsuccess'] .= "<!-- $needle -->";

    $arrSearch = [
        'http://synergy.ru/lp/thanks_all/' => ['synergy.ru', 'магистратура.рф', 'xn--80aaakzv5abgkcm.xn--p1ai'],
        'http://synergyonline.ru/lp/thanks_all/' => ['synergyonline.ru'],
        'http://sbs.edu.ru/lp/thanks_all/' => ['sbs.edu.ru'],
        'http://synergyregions.ru/lp/thanks_all/' => ['synergyregions.ru']
    ];

    foreach ($arrSearch as $key => $value) {

        if (in_array($needle, $value)) {

            $result = $key;
            break;

        }

    }

    if (null !== $result) {

        // общие исключения
        $exceptions = preg_match("/proftest/is", $config['user']['sendsuccess']);
        // исключения для тех где есть оплата
        $isPayment = preg_match("/intellect|redkassa|timepad/is", $config['user']['sendsuccess']);
        // если уже есть редирект
        $isRedirect = preg_match("/redirect|location|href/is", $config['user']['sendsuccess']);
        // для сбс, если есть редирект на оплату через лендер
        $isRedirectIntellectMoney = preg_match("/http\:\/\/synergy\.ru\/lander\/alm\/intellectmoneyPay\.php\?invoicepayment/is", $config['user']['sendsuccess']);

        //$redirectUrl = "{$result}?email={$lead->email}&name={$lead->name}";
        $redirectUrl = "{$result}?";


        // нет платежей и исключений
        if (!$isPayment && !$exceptions) {

            // если есть редирект или ссылка
            if ($isRedirect) {

                $isRedirectSynergyThanks = preg_match("/http\:\/\/synergy\.ru\/lp\/thanks\//is", $config['user']['sendsuccess']);

                // если есть http://synergy.ru/lp/thanks/ - меняем его на новую страницу
                if ($isRedirectSynergyThanks) {

                    $config['user']['sendsuccess'] = str_replace('http://synergy.ru/lp/thanks/', $redirectUrl, $config['user']['sendsuccess']);

                } // если нет http://synergy.ru/lp/thanks/ но есть любой редирект - открываем новую ссылку в новом окне
                else {

                    $config['user']['sendsuccess'] .= "
					<script>

						(function(){

							var link = document.createElement('a');
							link.href = '$redirectUrl';
							link.setAttribute('target', '_blank');
							link.click();

						})();

					</script>";

                }

            } // если нет платежа и нет редиректа или ссылок, делаем редирект в том же окне c задержкой 3 секунды
            else {

                $config['user']['sendsuccess'] .= "
				<script>

					(function(){

						setTimeout(function(){

							location.href = '$redirectUrl';

						}, 3000);

					})();

				</script>";

            }

        } else if ($isRedirectIntellectMoney) {

            $config['user']['sendsuccess'] = str_replace('http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment', 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&postpayredirect=' . $result, $config['user']['sendsuccess']);

        }

    }

}

if ($lead->land === "yuridicheskij") {
    $config['user']['sendsuccess'] .= "
				<script>

					(function(){

						setTimeout(function(){

							location.href = 'https://synergy.ru/lp/thanks/?utm_source=thanks';

						}, 2000);

					})();

				</script>";
}

