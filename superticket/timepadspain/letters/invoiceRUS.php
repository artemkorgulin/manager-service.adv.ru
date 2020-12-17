<?php
	return '<!DOCTYPE html>
				<html lang="en">
				<head>
					<meta charset="UTF-8">
					<title>Document</title>
				</head>
				<body style="font-family: Arial;">
					<table border=1 cellpadding=10 cellspacing=0 width="100%">
						<tr>
							<td rowspan=2 colspan=2>ПАО СБЕРБАНК Г. МОСКВА<br><br>Банк получателя</td>
							<td>БИК</td>
							<td rowspan=2>044525225<br><br>30101810400000000225</td>
						</tr>
						<tr>	
							<td>Сч. №</td>			
						</tr>
						<tr>
							<td>ИНН 7743904190</td>			
							<td>КПП 770201001</td>
							<td rowspan=2 valign=top>Сч. №</td>
							<td rowspan=2 valign=top>40702810838000116914</td>
						</tr>
						<tr>
							<td colspan=2>ООО "ММГ"<br><br>Получатель</td>			
						</tr>
					</table>
					<br><br>
					<b style="font-size: 20px">Счет на оплату № SGF-'.$managers->regional->code.$leadId.' от '.$dateInvoice.'</b>
					<br><br>
					<hr size=3 noshade>
					<table border=0 cellpadding=10 width="100%">
						<tr>
							<td>Поставщик<br>(Исполнитель)</td>
							<td><b>ООО "ММГ", ИНН 7743904190, КПП 770201001, 129090, Москва г, Мещанская ул, дом # 9/14, строение 1, этаж 2 пом I ком 3</b></td>
						</tr>
						<tr>
							<td>Покупатель<br>(Заказчик)</td>
							<td><b>"'.$companyName.'"</b></td>
						</tr>
						<tr>
							<td>Основание</td>
							<td><b>заказ '.$leadId.'</b></td>
						</tr>
					</table>
					<table width="100%" border=1 cellspacing=0 cellpadding=10>
						<tr align="center" style="font-weight: bold">
							<td>№</td>
							<td>Товары (работы, услуги)</td>
							<td>Кол-во</td>
							<td>Ед.</td>
							<td>Цена</td>
							<td>Сумма</td>
						</tr>
						'.$tickets.'
						<tr border=0>
							<td border=0 colspan=5 align="right"><b>Итого:<br>В том числе НДС:<br>Всего к оплате:</b></td>
							<td align="right" border=0>'.$price.'<br>'.$priceNDS.'<br>'.$priceFinal .'</td>
						</tr>
					</table>
					<br><br>
					Оплата в рублях по курсу ЦБ РФ на дату оплаты, с добавлением 3% на конвертацию<br>
					Всего наименований: '.$ticketsNum.', на сумму '.$priceFinal.' долларов США.<br>
					<b>'.$strPriceFinal.'</b>
					<hr size=3 noshade>
					<table width=100% cellpadding=10 border=0>
						<tr>
							<td style="font-weight: 600">Руководитель:</td>
							<td align="right" style="border-bottom: 1px solid #000">Шулькевич К.К.</td>
							<td style="font-weight: 600">Бухгалтер</td>
							<td align="right" style="border-bottom: 1px solid #000">Шулькевич К.К.</td>
						</tr>
					</table>
					<br><br><b>ВНИМАНИЕ! В назначении платежа обязательно указывать номер счета!</b>
				</body>
				</html>';