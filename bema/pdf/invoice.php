<!DOCTYPE HTML>
<html>
    <head>
        <style>
           * {
                font-family: 'DejaVu Sans', sans-serif;
                font-size: 10pt;
                color: #222;
            }
        </style>
    </head>
    <body>
    <table width="770" style="width:700px;font-family: Arial, sans-serif;">
        <tr>
            <td>

                <table style="border:1px solid black;width:100%;font-family: Arial, sans-serif;" border="1" cellspacing="0" cellpadding="3" width="100%">
                    <tr>
                        <td colspan="2" rowspan="2">ПАО СБЕРБАНК Г. МОСКВА<br><br>Банк получателя</td>
                        <td>БИК</td>
                        <td rowspan="2" style="vertical-align: top;">
                            <p style="padding:0;margin: 0;margin-bottom:15px;">044525225</p>
                            <p style="padding:0;margin: 0;">30101810400000000225</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Сч. №</td>
                    </tr>
                    <tr>
                        <td>ИНН 7719439745</td>
                        <td>КПП 771901001</td>
                        <td valign="top" rowspan="2">Сч. №</td>
                        <td valign="top" rowspan="2">40702810938000102569</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            ООО "БИЗНЕС-ФОРУМЫ"<br><br>
                            Получатель
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h2 style="border-bottom: 3px solid black;padding-bottom:10px;">Счет на оплату № <?=date('Y-m-d-his')?> от <?php
                    $m = [1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

                    $mb = intval(date('m'));
                    echo date('d') . ' ' . $m[$mb] . ' ' . date('Y') . 'г.';
                    ?></h2>
                <table width="100%">
                    <tr>
                        <td>
                            Поставщик<br>
                            (Исполнитель)
                        </td>
                        <td>ООО "БИЗНЕС-ФОРУМЫ", ИНН 7719439745, КПП 771901001, 105318, Москва г,
                            Измайловский Вал ул, дом № Дом 2, тел.: 8(495)6639363</td>
                    </tr>
                    <tr>
                        <td>
                            Покупатель
                            (Заказчик):
                        </td>
                        <td></td>
                    </tr>
                </table>
                <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <table style="border:2px solid black;width:100%;font-family: Arial, sans-serif;" border="2" cellspacing="0" cellpadding="5" width="100%">
                    <tr>
                        <th>№</th>
                        <th>Товары (работы, услуги)</th>
                        <th>Кол-во</th>
                        <th>Ед</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Регистрационный взнос за участие в премии bema!</td>
                        <td align="right">1</td>
                        <td></td>
                        <td align="right">5500,00</td>
                        <td align="right">5500,00</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="border:0px solid black;width:100%;font-family: Arial, sans-serif;" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td>&nbsp;</td>
                        <td width="150" align="right">
                            <b>Итого: 5500,00<br>
                                Без налога (НДС) -<br>
                                Всего к оплате: 5500,00</b>
                        </td>
                        <td width="110">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Всего наименований 1, на сумму 5500,00 руб<br>
                            <b>Пять тысяч пятьсот рублей 00 копеек</b>
                        </td>
                    </tr>
                </table>
                <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <img style="width: 700px;" src="<?=__DIR__?>/stamp.jpg" alt="">
            </td>
        </tr>
    </table>
    </body>
</html>