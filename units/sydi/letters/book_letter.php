<?php

$body = <<<EOD
<h3>Приветствуем, {$lead->name}!</h3>
<p>Спасибо, что подписались на&nbsp;рассылку агентства Synergy Digital. Обещаем не&nbsp;спамить, а&nbsp;присылать только первосортный и&nbsp;увлекательный контент. Теперь вы&nbsp;будете в&nbsp;числе первых узнавать о&nbsp;наших скидках и&nbsp;предложениях.
</p>
<p>А сейчас время подарка! Скачивайте 5 глав книги «Святая Троица Трафика. Битва за конверсию» — автор Дмитрий Юрков, генеральный директор Synergy Digital.</p>
<p style="text-align: center">
  <a href="https://synergydigital.ru/pdf/Svyataya-triika-traffika_5glav.pdf">&gt;&gt;&gt; Скачать 5 глав &lt;&lt;&lt;</a>
</p>
<table style="width:100%; background: #FAFAFA;">
    <tbody><tr>
       <td style="text-align:center"><a href="https://synergydigital.ru/catalog.pdf">&gt;&gt;&gt; Узнать о нас больше &lt;&lt;&lt;</a></td>
       <td style="text-align:center"><a href="https://synergydigital.ru/uslugi/">&gt;&gt;&gt; Перейти на сайт услуг &lt;&lt;&lt;</a></td>
    </tr>
</tbody></table>
EOD;


$letter = include 'template.php';
return $letter;