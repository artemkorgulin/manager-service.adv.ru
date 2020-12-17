<?php

$config['ignore']['getresponse'] =  false;

$lead->name = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
$birthdate = $lead->birthdate;
$lead->birthdate = str_replace('/','.',$lead->birthdate);
$lang = 'ru';
if (isset($_REQUEST['langv']) && $_REQUEST['langv'] != '') {
    $lang = $_REQUEST['langv'];
}


switch ($lang) {
    case 'cn':
            $lang = 'ch';
        break;
    case 'sa':
            $lang = 'ar';
        break;
}

$postData = array(
	'NAME'             => $_REQUEST['firstname'],
	'SECOND_NAME'      => '',
	'LAST_NAME'        => $_REQUEST['lastname'],
	'EMAIL'            => $lead->email,
	'PHONE'            => $lead->phone,
	'BIRTHDATE'        => $lead->birthdate,
	'PERSONAL_CITY'    => $_REQUEST['city'],
	'PERSONAL_COUNTRY' => $_REQUEST['country'],
    'UF_LANG'          => $lang,
    'UF_SCHOOL'        => $_REQUEST['school']
);


$response = cURLsend('http://konkurs.globalyoungleader.com/api/v1/?action=user_register', json_encode($postData));

$jsonresponse = json_decode($response);

if (isset($jsonresponse->ERR_CODE) && $jsonresponse->ERR_CODE !='') {
	$config['user']['sendsuccess'] = '<div class="form-testing__container">
            <form action="https://syn.su/lander.php?r=land/index&amp;unit=synergy&amp;type=globalyoungleader&amp;land=globalyoungleader&amp;partner=&amp;version=&amp;graccount=&amp;grcampaign=" method="POST" novalidate="novalidate">
            	<div class="send-success">
			<h3>Произошла ошибка</h3>
			<p>'.$jsonresponse->ERR_CODE.'</p>
			</div>
                <div class="form-testing__group">
                    <input name="firstname" id="firstname" class="form-testing__textinput" type="text" placeholder="Имя" required="" aria-required="true" value="'.$_REQUEST['firstname'].'">
                </div>
                <div class="form-testing__group">
                    <input name="lastname" id="lastname" class="form-testing__textinput" type="text" placeholder="Фамилия" required="" aria-required="true" value="'.$_REQUEST['lastname'].'">
                </div>
                <div class="form-testing__group">
                    <input name="phone" id="phone" class="form-testing__textinput valid" type="text" placeholder="Телефон" required="" aria-required="true" data-inputmasks-inited="" aria-invalid="false" value="'.$lead->phone.'">
                </div>
                <div class="form-testing__group">
                    <input name="email" id="email" class="form-testing__textinput" type="text" placeholder="E-mail" required="" aria-required="true" value="'.$lead->email.'">
                </div>
                <div class="form-testing__group">
                    <input name="birthdate" id="datepicker" class="form-testing__datepicker select-form hasDatepicker" type="text" placeholder="Дата рождения" value="'.$birthdate.'">
                </div>
                <div class="form-testing__group">
                    <div class="styled-select">
                        <div class="select-form"><select name="country" id="country" class="form-testing__select select-hidden" placeholder="Страна">
                  
                            <option value="russian">Россия</option>
                        </select><div class="select-styled">Россия</div><ul class="select-options" style="display: none;"><li rel="russian">Россия</li></ul></div>
                    </div>
                </div>
                <div class="form-testing__group">
                    <div class="form-testing-select styled-select">
                        <div class="select-form"><select name="city" id="city" class="form-testing__select select-hidden">
         
                            <option value="moscow">Москва</option>
                        </select><div class="select-styled">Москва</div><ul class="select-options" style="display: none;"><li rel="moscow">Москва</li></ul></div>
                    </div>
                </div>
                <div class="form-testing__group">
                    <button class="form-testing__button" type="submit">Начать тестирование</button>
                </div>
            </form>
        </div>';
	
} else {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена</h3>
		<p>{$lead->name}, вы успешно зарегистрировались! Проверьте вашу почту, куда мы отправили доступ к личному кабинету.</p>
		<script>
		location.href='http://konkurs.globalyoungleader.com/?login=".$jsonresponse->GUID."&auth=Y&lang=".$lang."';
		</script>
	</div>";
}





function cURLsend($url,$postData) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
