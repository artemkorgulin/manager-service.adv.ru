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
							<td rowspan=2 colspan=2>SBERBANK PLC, MOSCOW<br><br>Bank of recepient</td>
							<td>BIC</td>
							<td rowspan=2>044525225<br><br>30101810400000000225</td>
						</tr>
						<tr>	
							<td>Acc. №</td>			
						</tr>
						<tr>
							<td>TIN	7743904190</td>			
							<td>KPP 770201001</td>
							<td rowspan=2 valign=top>Acc. №</td>
							<td rowspan=2 valign=top>40702810838000116914</td>
						</tr>
						<tr>
							<td colspan=2>MMG Ltd.<br><br>Recepient</td>			
						</tr>
					</table>
					<br><br>
					<b style="font-size: 20px">Invoice № for SGF-'.$managers->regional->code.$leadId.' from '.$dateInvoice.'</b>
					<br><br>
					<hr size=3 noshade>
					<table border=0 cellpadding=10 width="100%">
						<tr>
							<td>Supplier<br>(Executor)</td>
							<td><b>MMG Ltd., TIN 7743904190, KPP 770201001, 129090, Moscow, Meschanskaya str. 9/14, bldg. 1, 2-nd floor, office space I, room 3</b></td>
						</tr>
						<tr>
							<td>Buyer<br>(Customer)</td>
							<td><b>"'.$companyName.'"</b></td>
						</tr>
						<tr>
							<td>Base</td>
							<td><b>order '.$leadId.'</b></td>
						</tr>
					</table>
					<table width="100%" border=1 cellspacing=0 cellpadding=10>
						<tr align="center" style="font-weight: bold">
							<td>№</td>
							<td>Goods (work, services)</td>
							<td>Amount</td>
							<td>Unit</td>
							<td>Cost, USD</td>
							<td>Sum, USD</td>
						</tr>
						'.$tickets.'
						<tr border=0>
							<td border=0 colspan=5 align="right"><b>Total services:<br>Including VAT 18%:<br>Total cost:</b></td>
							<td align="right" border=0>'.$price.'<br>'.$priceNDS.'<br>'.$priceFinal .'</td>
						</tr>
					</table>
					<br><br>
					Payment in Rubles according to rate set by the Central Bank of the Russian Federation on date of payment, including 3% conversion chanrge<br>
					Total articles '.$ticketsNum.', for the sum of '.$priceFinal.' USD.<br>
					<b>'.$strPriceFinal.'</b>
					<hr size=3 noshade>
					<table width=100% cellpadding=10 border=0>
						<tr>
							<td style="font-weight: 600">Manager:</td>
							<td align="right" style="border-bottom: 1px solid #000">Shulkevich K. K.</td>
							<td style="font-weight: 600">Accountant</td>
							<td align="right" style="border-bottom: 1px solid #000">Shulkevich K. K.</td>
						</tr>
					</table>
					<style>
						.summ:first-letter {
						    text-transform: uppercase;
						}
					</style>
				</body>
				</html>';