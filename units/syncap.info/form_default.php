<?php
$config['ignore']['bitrix24'] 	= false;

/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "OK";
$config['user']['sendduplicate'] = "DUPLICATE";

/* Конфигуратор MessageForCallCentre */
$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('aradul@synergy.ru', 'alitkov@synergy.ru'));

$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда $lead->land [$lead->url]";
$config['mail']['smtp']['cc']['message'] = "
<p>
<br>Клиент: <b>$lead->name</b>
<br>Телефон: <b>$lead->phone</b>
<br>Email: <b>$lead->email</b>
<br>-----
<br>Город: <b>$lead->city</b>
<br>Источник: <b>$lead->source</b>
<br>-----
<br>ФИО: $lead->last_name $lead->first_name $lead->middle_name
<br>Паспорт: $lead->passport_series $lead->passport_no
<br>Кем выдан: $lead->passport_issued
<br>Дата выдачи: $lead->passport_issueD $lead->passport_issueM $lead->passport_issueY
<br>Код подразделения: $lead->passport_code1 $lead->passport_code2
<br>Дата рождения: $lead->birth_d $lead->birth_m $lead->birth_y
<br>Место рождения: $lead->birth_place
<br><br>-----Адрес постоянной регистрации
<br>Индекс: $lead->registration_index
<br>Регион: $lead->registration_region
<br>Город/населенный пункт: $lead->registration_city
<br>Улица: $lead->registration_street
<br>Дом/Корпус/Строение: $lead->registration_house
<br>Квартира: $lead->registration_flat
<br><br>-----Адрес фактического проживания
<br>Индекс: $lead->residential_index
<br>Регион: $lead->residential_region
<br>Город/населенный пункт: $lead->residential_city
<br>Улица: $lead->residential_street
<br>Дом/Корпус/Строение: $lead->residential_house
<br>Квартира: $lead->residential_flat
<br>Телефон по месту проживания: $lead->residential_phoneCode $lead->residential_phoneNo
<br>Стационарный телефон родственников или знакомых: $lead->relatives_phoneCode $lead->relatives_phoneNo, имя, кем приходится: $lead->relatives_name
<br>-----
<br>Сумма займа: $lead->sum
<br>Срок займа: $lead->time
<br>Статус заемщика: $lead->borrower_status
<br>Образовательное учреждение: $lead->borrower_education
<br>Год поступления: $lead->borrower_year
<br><br>-----Успеваемость студента
<br>Средний балл за прошлый семестр: $lead->borrower_score
<br>Академические задолженности: $lead->borrower_academic
<br>Тип занятости: $lead->job_type
<br>Статус: $lead->job_status
<br>-----
<br>Название организации: $lead->job_organization
<br>Занимаемая должность: $lead->job_position
<br>Рабочий телефон: $lead->job_phoneCode $lead->job_phoneNo
<br>Срок работы: лет $lead->job_years, месяцев $lead->job_months
<br><br>-----Рабочий адрес
<br>Индекс: $lead->job_index
<br>Регион: $lead->job_region
<br>Город/населенный пункт: $lead->job_city
<br>Улица: $lead->job_street
<br>Дом/Корпус/Строение: $lead->job_house

<br><br>-----Информация о семье
<br>Семейное положение: $lead->info_marital
<br>Количество детей: $lead->info_childrens
<br>Образование: $lead->info_education
<br>Персональный доход: $lead->info_income
<br>Сумма арендной платы за квартиру: $lead->info_rental
<br>Сумма платежей по текущим кредитам: $lead->info_credits
<br>-----
<br>Адрес страницы: $lead->url
<br>-----------------------------------------
</p>
<p style='font-size:11px;'>Реферер: $lead->refer</p>
";

/* Адрес и имя для отправки писем */
$config['mail']['smtp']['from']		= "no-reply@syncap.info";
$config['mail']['smtp']['fromname']	= "SynCap.info";
