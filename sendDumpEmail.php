<?php

defined('DB_HOST') or define('DB_HOST', 'localhost');
defined('DB_NAME') or define('DB_NAME', 'lander');
defined('DB_USER') or define('DB_USER', 'lander_user');
defined('DB_PASS') or define('DB_PASS', 'PRp26V');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $stmt = $pdo->query("select distinct * from db_land_dump where updated_at < DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $data = json_decode($row['data']);

        //https://sd.synergy.ru/Task/View/216719

        $parts = parse_url($data->action);
        parse_str($parts['query'], $query);
        if (isset($query['unit']) && $query['unit'] != '') {
            $unit = $query['unit'];
            if ($unit == 'sbs') {
                $unit = 'Школа Бизнеса';
            } elseif ($unit == 'synergy') {
                $unit = 'Университет';
            }
        }

        $jsdata = json_decode($row['data'], true);
        
        if ($jsdata['url']) {
            $jsdata['url']= htmlspecialchars_decode($jsdata['url']);
            if (false !== strpos($jsdata['url'], '?')) {
                $tmpData = substr($jsdata['url'], strpos($jsdata['url'], "?") + 1);
                $tmpData = explode("&", $tmpData);
                foreach($tmpData as $v) {
                    list($keyData, $varData) = explode("=", $v);
                    $utmData[$keyData] = $varData;
                }
            }
        }
        
        $sourceData = $utmData['utm_source'] ?? '';
        
        $resdata = [
            'title' => $query['land'],
            'phone' => $jsdata['phone'],
            'email' => $jsdata['email'],
            'NAME' => $jsdata['name'],
            'sourceName' => 'WEB',
            "sourceDesc" => $unit,
            "sourceCode" => $sourceData,
            "landCode" => $query['land'],
            'campaign' => $jsdata['campaign'],
            'medium' => $jsdata['medium'],
            'gclid' => $jsdata['gclid'],
            'term' => $jsdata['term'],
            'partnerName' => $jsdata['partner'],
            "comments" => "автоматический лид, без отправки формы",
            "notsend" => 1,
            'url' => $jsdata['url'],
            'version' => $jsdata['version'],
            'form' => $jsdata['form'],
            'ip' => $jsdata['ip'],
            'landerCode' => $jsdata['lead_uuid']
        ];
        if (strpos($row['url'], 'synergy.ru') !== false) {
        } else {
            if ($query['land'] != '' && $unit != 'sydi' && $query['land'] != 'synergyinsight_main') {
                $stmtinser = $pdo->query("INSERT INTO  `db_job_queue` (`company`,`status`,`service`,`data`,`email`) VALUES ('" . $unit . "','0','bitrix24','" . json_encode($resdata, JSON_UNESCAPED_UNICODE) . "','" . $row['email'] . "')");
            }
        }

        if ((strpos($row['url'], 'synergy') !== false || strpos($row['url'], 'synergyonline') !== false) && $query['land'] != 'robbins-coach') {
            $email = $row['email'];
            $url = $row['url'];
            $utm = 'utm_source=tranz-mail&utm_medium=lae&utm_campaign=NwguTHdaT35XARhw110X';

            if (strpos($url, 'utm_') !== false) {
                $utm .= '&utm_content=' . urlencode(stristr($url, 'utm_'));
                $url = stristr($url, 'utm_', true);
            }

            if (false === strpos($url, '?')) $url .= '?' . $utm;
            else $url .= '&' . $utm;
            $nextMonthArray = [
                1 => '1 февраля',
                2 => '1 марта',
                3 => '1 апреля',
                4 => '1 мая',
                5 => '1 июня',
                6 => '1 июля',
                7 => '1 августа',
                8 => '1 сентября',
                9 => '1 октября',
                10 => '1 ноября',
                11 => '1 декабря',
                12 => '1 января',
            ];
            $discountDateString = $nextMonthArray[intval(date('m'))];
            $message = 'Здравствуйте! <p>Мы&nbsp;заметили, что вы&nbsp;проявили интерес к&nbsp;программам обучения, но&nbsp;не&nbsp;оформили заявку на&nbsp;подбор программы. <p>Успейте оставить заявку — <strong>до ' . $discountDateString . '</strong> для Вас действуют <strong>скидки на обучение до 20%!</strong></p><p>Чтобы вернуться на сайт, просто <a href=\"' . $url . '\">пройдите по этой ссылке >>></a></p>Мы&nbsp;свяжемся с&nbsp;Вами и&nbsp;поможем подобрать оптимальный курс обучения!<p>Всегда Ваша,<br>Команда Университета &laquo;Синергия&raquo;<br><a href="https://synergy.ru/">Synergy.ru</a>';
            if ($query['land'] == "synergymba") {
                $message = '<p>Здравствуйте!</p><p>Мы заметили, что вы проявили интерес к образовательным программам <a href=\"https://synergy.mba?utm_source=tr_mail&utm_medium=eaa&utm_campaign=email&utm_term=tr_mail\">SYNERGY MBA</a>, но не оформили заявку на подбор программы.</p><p>Успейте оставить заявку — ' . $discountDateString . ' и получите уникальную скидку на обучение от 20%!</p>Чтобы вернуться на сайт, просто <a href=\"' . $url . '\">пройдите по этой ссылке >>></a></p><p>Мы&nbsp;свяжемся с&nbsp;Вами и&nbsp;поможем подобрать оптимальный курс обучения!</p><p>Всегда Ваша,<br>Команда Университета &laquo;Синергия&raquo;<br>Synergy.mba</p>';
            }
            $fromname = 'Университет Синергия';
            $subject = 'Университет Синергия';
            if ($data->lang == 'en') {
                $nextMonthArray = [
                    1 => 'February 1',
                    2 => 'March 1',
                    3 => 'April 1',
                    4 => 'May 1',
                    5 => 'June 1',
                    6 => 'July 1',
                    7 => 'August 1',
                    8 => 'September 1',
                    9 => 'October 1',
                    10 => 'November 1',
                    11 => 'December 1',
                    12 => 'January 1',
                ];
                $discountDateString = $nextMonthArray[intval(date('m'))];
                $message = '<p>Hello!</p><p>We noticed that you took the interest in our academic programs, but didn’t complete the form.<br>To return to the site, just click on this <a href=\"' . $url . '\">link</a>.<br>Leave an application — till ' . $discountDateString . ' and get the scholarship up to 20%!<br>We will contact you and help you to choose the best course!</p><p>Sincerely yours,<br>Synergy University Team</p>';
                $fromname = 'Synergy University Team';
                $subject = 'Synergy University';
            }
            $emailData = [
                'aim' => 'user',
                'host' => 'localhost',
                'secure' => false,
                'port' => 25,
                'SMTPAuth' => false,
                'from' => 'no-reply@synergy.ru',
                'fromname' => $fromname,
                'charset' => 'UTF-8',
                'emails' => [[$email]],
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ];
            print_r($query);
            if ($query['land'] == 'synergy-digital-forum') {
                $emailData['subject'] = 'Завершите регистрацию на Synergy Digital Forum';
                $emailData['fromname'] = 'Synergy Digital Forum';
                $emailData['message'] = '<p><b>Добрый день!</b></p><p>Мы заметили, что вы проявили интерес к <a href=\"http://synergydigital.com/?utm_source=only-email\">Synergy Digital Forum</a>, который состоится 21-22 мая в Vegas City Hall, но не оформили заявку.</p><p>Успейте зарегистрироваться сейчас, пока все категории билетов есть в продаже! Для этого перейдите <a href=\"http://synergydigital.com/?utm_source=only-email#packages\">по ссылке >>></a></p><p>ВЫ ПОЛУЧИТЕ:</p><ul><li>новые тактики, стратегии и инструменты,</li><li>главные мировые тренды в области интернет-маркетинга,</li><li>понимание, как их использовать в своем бизнесе.</li></ul><p>Это must do-форум, где вы зафиксируете не меньше 100 решений, которые нужно реализовать в вашей компании.</p><p>Спикеры форума – известные интернет-предприниматели, топовые эксперты, ведущие мировые и российские специалисты в области привлечения трафика, повышения конверсии, email- и контент-маркетинга.</p><p>Вот некоторые из них:</p><ul><li>Йонас Кьеллберг — сооснователь Skype и iCloud, преподаватель Стэнфордского университета, венчурный инвестор, вложивший 700 млн евро в Lamoda, Avito и других интернет-гигантов.</li><li>Том Бриз — основатель и генеральный директор Viewability — компании, которая помогает международным брендам проводить эффективные рекламные кампании в YouTube. Благодаря финансовой модели «Pay For Results» Viewability стала самой успешной компанией в области рекламы в YouTube.</li><li>Авинаш Кошик — эксперт №1 в мире по веб-аналитике, евангелист Google Analytics автор бестселлера «Веб-аналитика 2.0 на практике. Тонкости и лучшие методики».</li></ul><p>С уважением,<br>команда Synergy Digital Forum<br>+7 (495) 787 87 67</p>';
            }
            if ($query['land'] !== 'synergy-digital-forum-2019' && $query['land'] !== 'birzha_lidov' && $query['land'] !== 'synergydigital') {
                $pdo->query("insert into db_job_queue set dateCreated=now(), company='SYNERGY', status=0, service='mail', data='" . json_encode($emailData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "', email='{$email}'");
            }
        }
        $pdo->query("DELETE from db_land_dump where email='" . $email . "'");
    }

    $stmt = $pdo->query("select distinct * from db_land_dump where updated_at < DATE_SUB(NOW(), INTERVAL 1 MINUTE)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $data = json_decode($row['data']);

        $parts = parse_url($data->action);
        parse_str($parts['query'], $query);

        if ($query['land'] == "synergymba") {
            $email = $row['email'];
            $url = $row['url'];
            $utm = 'utm_source=tr_mail&utm_medium=eaa&utm_campaign=email&utm_term=tr_mail';

            if (strpos($url, 'utm_') !== false) {
                $utm .= '&utm_content=' . urlencode(stristr($url, 'utm_'));
                $url = stristr($url, 'utm_', true);
            }

            if (false === strpos($url, '?')) $url .= '?' . $utm;
            else $url .= '&' . $utm;
            $nextMonthArray = [
                1 => '1 февраля',
                2 => '1 марта',
                3 => '1 апреля',
                4 => '1 мая',
                5 => '1 июня',
                6 => '1 июля',
                7 => '1 августа',
                8 => '1 сентября',
                9 => '1 октября',
                10 => '1 ноября',
                11 => '1 декабря',
                12 => '1 января',
            ];
            $discountDateString = $nextMonthArray[intval(date('m'))];

            $message = '<p>Здравствуйте!</p><p>Мы заметили, что вы проявили интерес к образовательным программам <a href=\"https://synergy.mba?utm_source=tr_mail&utm_medium=eaa&utm_campaign=email&utm_term=tr_mail\">SYNERGY MBA</a>, но не оформили заявку на подбор программы.</p><p>Успейте оставить заявку — ' . $discountDateString . ' и получите уникальную <b>скидку на обучение от 20%!</b></p><p>Чтобы вернуться на сайт, просто просто пройдите по этой ссылке: <br>  <br> <div style=\"text-align: center;  width:340px;height:35px;\"><a style=\"color: #fff; background: #e44365; font-family: arial; font-weight: bold; padding: 6px 10px 4px; display: inline-block; text-decoration: none; min-width: 350px; transform: scaleY(1.1);\" href=\"' . $url . '\">ПОЛУЧИТЬ СКИДКУ НА ПРОГРАММУ MBA</a></div></p><p>Мы&nbsp;свяжемся с&nbsp;Вами и&nbsp;поможем подобрать оптимальный курс обучения!</p><p>Всегда Ваша,<br>Команда Университета &laquo;Синергия&raquo;</p>';

            $fromname = 'Университет Синергия';
            $subject = 'Университет Синергия';

            $emailData = [
                'aim' => 'user',
                'host' => 'localhost',
                'secure' => false,
                'port' => 25,
                'SMTPAuth' => false,
                'from' => 'no-reply@synergy.ru',
                'fromname' => $fromname,
                'charset' => 'UTF-8',
                'emails' => [[$email]],
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ];

            $pdo->query("insert into db_job_queue set dateCreated=now(), company='SYNERGY', status=0, service='mail', data='" . json_encode($emailData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "', email='{$email}'");

            $pdo->query("DELETE from db_land_dump where email='" . $email . "'");
        }
    }

} catch (PDOException $e) {
}
