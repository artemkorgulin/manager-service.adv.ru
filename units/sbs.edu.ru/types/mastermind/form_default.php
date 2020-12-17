<?php

    $config['ignore']['send_to_user']   = true;
    $config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Mastermind Day " . $lead->dater;
    $config['mail']['smtp']['user']['message'] = "<p>Здравствуйте, " . $lead->name . "!</p>
    <p>Вы зарегистрировались на Mastermind Day, самый масштабный брейншторм в России. Событие состоится " . $lead->dater . " в Экспоцентре. Хедлайнер события - Джей Абрахам, мировой эксперт по фасилитации.
    Приобрести билеты и узнать больше о программе Mastermind Day вы можете на <a href=\"http://sbs.edu.ru/lp/mastermind/\">сайте мероприятия</a>.</p>
    <p>Следите за нашими письмами, мы будем сообщать вам обо всех деталях события.</p>
    <hr>
    <br>
    <p>С уважением, команда Школы Бизнеса «Синергия»<br>8 800 707 41 77</p>";

    
    $config['user']['sendsuccess'] = "
        <div class='form__title text-center'>Спасибо</div>
        <div class='form__group text-center'>Ваша заявка была успешно отправлена</div>
        <div class='form__group'>
            <button class='button button button_gradient close'>Ок</button>
        </div>
        
        <script>
            $('.close').click(function() {
                $.fancybox.close();
            })
        </script>
    ";