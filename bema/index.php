<!doctype html>
<html class="no-js" lang="ru">

<head>
    <title>Bema festival</title>
    
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta property="og:title" content="Bema festival" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="//bemafestival.ru/black/img/og.png" />
    <meta name="theme-color" content="#1d1d1b" />

    <link type="image/png" rel="icon" href="//syn.su/bema/img/favicon.ico">
    
    <link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:200,300,400,500,600,700&amp;subset=cyrillic" rel="stylesheet">
    <link href="//syn.su/bema/css/style.css" rel="stylesheet">

</head>

<body>

        <div class="popup" id="reg-form-popup">
            <div class="request">
                <div class="request__content">
                    <div class="request__header">
                       <img src="img/request-logo.png" alt="" class="request__logo">
                        <!--a href="/" class="request__back"><img class="request__back-arrow" src="img/back-arrow.png" alt="<" />Вернуться на главную</a-->
                    </div>
                    <form name="request" class="nolander" method="post" enctype="multipart/form-data" action="http://syn.su/bema/chunks/form-processor.php">
                        <input type="hidden" id="version" value="black">
                        <input type="hidden" name="_csrf" value="<?=$csrfToken?>">
                        <div class="request__steps">
                            <div class="step step_active step_1">
                                <div class="step__title">ДАННЫЕ КОМПАНИИ</div>
                                <div class="step__subtitle">Укажите контактные данные вашей компании</div>
                                <div class="step__spacer"></div>
                                <label class="input"><div class="input__label-text">Название фирмы</div>
                                    <input id="company_name" type="text" name="comments[Название фирмы]" value="" placeholder="Название компании" required />
                                </label>
                                <label class="input">
                                    <div class="input__label-text">Телефон</div>
                                    <input id="phone" type="tel" name="phone" value="" placeholder="+_-___-___-__-__" required />
                                </label>
                                <label class="input">
                                    <div class="input__label-text">ФИО</div>
                                    <input id="fullname" type="text" name="name" value="" placeholder="Фамилия Имя Отчество" required />
                                </label>
                                <label class="input">
                                    <div class="input__label-text">Email</div>
                                    <input id="email" type="text" name="email" value="" placeholder="email@example.com" required />
                                </label>
                                <div class="checkbox checkbox_iagreetotc">
                                    <input type="checkbox" name="iagreetotc" id="iagreetotc" value="1" required />
                                    <label for="iagreetotc" class="checkbox-label"></label>
                                    <div class="checkbox__text">Я согласен с <a class="privacy-ajax fancybox-privacy-link" href="http://synergy.ru/lp/_chunk/privacy.php?date=28-04-2017&amp;lang=ru">Политикой конфиденциальности</a> и согласен на получение рассылок от организаторов и партнеров премии bema!</div>
                                </div>
                                
                                
                                
                                <div class="checkbox checkbox_iagreetotc">
                                    <input type="checkbox" name="iagreetotc2" id="iagreetotc2" value="2" required />
                                    <label for="iagreetotc2" class="checkbox-label"></label>
                                    <div class="checkbox__text checkbox__text_bottom">Я ознакомлен с <a class="privacy-ajax fancybox-privacy-link" href="pdf/Bema_Prize.pdf">положением премии</a></div>
                                </div>
                                
                                
                                
                                <div class="step__spacer"></div>
                                <div class="step__note">После заполнения анкеты вы будете направлены на страницу оплаты регистрационного взноса участника. Регистрационный взнос составляет 5 500 р. У каждого заявителя есть возможность дополнять/редактировать/сокращать информацию о проекте, предоставлять дополнительные иллюстрационные материалы в срок до 05.12.2017г.</div>
                            </div>
                            <div class="step step_inactive step_2">
                                <div class="step__title">ВЫБОР НОМИНАЦИЙ</div>
                                <div class="step__subtitle">Укажите основные номинации для представления вашего проекта.</div>
                                <div class="step__note_top">Вы можете представить один проект максимум в 3 номинациях.</div>
                                <div class="step__spacer"></div>
                                <div class="step__hidden-fields"></div>
                                <div class="tab-container">
                                    <ul>
                                        <li class='tab'><a href="#step2-b2b">B2B</a></li>
                                        <li class='tab'><a href="#step2-b2c">B2C</a></li>
                                    </ul>
                                    <div id="step2-b2b" class="nominations-group">
                                    
                                    
                                    
                                    
                                    <!--Test-->
                                    <div class="">
                                        <input type="checkbox" id="bestevent" name="comments[Номинация][]" value="лучшее клиентское событие" hidden>
                                        <label class="nomination__label nomination" for="bestevent">лучшее клиентское событие</label>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" id="pressevent" name="comments[Номинация][]" value="лучшее пресс-событие" hidden>
                                        <label class="nomination__label nomination" for="pressevent">лучшее пресс-событие</label>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" id="corpevent" name="comments[Номинация][]" value="Лучшее деловое событие для бизнес-аудитории" hidden>
                                        <label class="nomination__label nomination" for="corpevent">Лучшее деловое событие для бизнес-аудитории</label>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" id="hrevent" name="comments[Номинация][]" value="лучшее HR-событие" hidden>
                                        <label class="nomination__label nomination" for="hrevent">лучшее HR-событие</label>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" id="travelingevent" name="comments[Номинация][]" value="лучшее выездное событие" hidden>
                                        <label class="nomination__label nomination" for="travelingevent">лучшее выездное событие</label>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" id="bestceremony" name="comments[Номинация][]" value="лучшая церемония награждения" hidden>
                                        <label class="nomination__label nomination" for="bestceremony">лучшая церемония награждения</label>
                                    </div>
                                    </div>
                                    <!--
                                    <div id="step2-b2b" class="nominations-group">
                                        <div class="nomination">лучшее клиентское событие</div>
                                        <div class="nomination">лучшее пресс-событие</div>
                                        <div class="nomination">лучшее корпоративное деловое событие </div>
                                        <div class="nomination">лучшее HR-событие</div>
                                        <div class="nomination">лучшее выездное событие</div>
                                        <div class="nomination">лучшая церемония награждения</div>
                                    </div>
                                    -->
                                    
                                    
                                    <!--Test2-->
                                    <div id="step2-b2c" class="nominations-group">
                                        <div class="">
                                        <input type="checkbox" id="newproduct" name="comments[Номинация][]" value="презентация нового продукта (*кроме автомобильных)" hidden>
                                        <label class="nomination__label nomination" for="newproduct">презентация нового продукта (*кроме автомобильных)</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="grandopening" name="comments[Номинация][]" value="лучшее торжественное открытие" hidden>
                                        <label class="nomination__label nomination" for="grandopening">лучшее торжественное открытие</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="brandactivation" name="comments[Номинация][]" value="лучшая церемония награждения" hidden>
                                        <label class="nomination__label nomination" for="brandactivation">лучшая активация для бренда (*кроме автомобильных)</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="sponsorship" name="comments[Номинация][]" value="лучшая спонсорская интеграция" hidden>
                                        <label class="nomination__label nomination" for="sponsorship">лучшая спонсорская интеграция</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="roadshow" name="comments[Номинация][]" value="лучшее роад-шоу" hidden>
                                        <label class="nomination__label nomination" for="roadshow">лучшее роад-шоу</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="carevent" name="comments[Номинация][]" value="лучшее автомобильное событие" hidden>
                                        <label class="nomination__label nomination" for="carevent">лучшее автомобильное событие</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="darkmarket" name="comments[Номинация][]" value="лучшее событие для «dark market»" hidden>
                                        <label class="nomination__label nomination" for="darkmarket">лучшее событие для «dark market»</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="sportevent" name="comments[Номинация][]" value="лучшее спортивное событие" hidden>
                                        <label class="nomination__label nomination" for="sportevent">лучшее спортивное событие</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="musicevent" name="comments[Номинация][]" value="лучшее музыкальное событие" hidden>
                                        <label class="nomination__label nomination" for="musicevent">лучшее музыкальное событие</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="businessevent" name="comments[Номинация][]" value="лучшее деловое событие" hidden>
                                        <label class="nomination__label nomination" for="businessevent">лучшее деловое событие</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="socialevent" name="comments[Номинация][]" value="лучший социальный проект" hidden>
                                        <label class="nomination__label nomination" for="socialevent">лучший социальный проект</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="bestfestival" name="comments[Номинация][]" value="лучший фестиваль" hidden>
                                        <label class="nomination__label nomination" for="bestfestival">лучший фестиваль</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="urbanevent" name="comments[Номинация][]" value="лучшее городское / публичное событие" hidden>
                                        <label class="nomination__label nomination" for="urbanevent">лучшее городское / публичное событие</label>
                                    </div>
                                    </div>
                                       
                                       <!--
                                        <div class="nomination">презентация нового продукта (*кроме автомобильных)</div>
                                        <div class="nomination">лучшее торжественное открытие</div>
                                        <div class="nomination">лучшая активация для бренда (*кроме автомобильных)</div>
                                        <div class="nomination">лучшая спонсорская интеграция</div>
                                        <div class="nomination">лучшее роад-шоу</div>
                                        <div class="nomination">лучшее автомобильное событие</div>
                                        <div class="nomination">лучшее событие для «dark market»</div>
                                        <div class="nomination">лучшее спортивное событие</div>
                                        <div class="nomination">лучшее музыкальное событие</div>
                                        <div class="nomination">лучшее деловое событие</div>
                                        <div class="nomination">лучший социальный проект</div>
                                        <div class="nomination">лучший фестиваль</div>
                                        <div class="nomination">Лучшее городское / публичное событие</div>
                                        -->
                                        
                                </div>
                                <div class="errors"></div>
                            </div>
                            <div class="step step_inactive step_3">
                                <div class="step__title">СПЕЦИАЛЬНЫЕ НОМИНАЦИИ</div>
                                <div class="step__subtitle">Выберите специальные номинации в дополнение к основным</div>
                                <div class="step__note_top">Выберите не более 2 специальных номинаций для вашего проекта. Если вы не хотите участвовать в специальных номинациях, пропустите этот шаг, нажав на кнопку Далее.</div>
                                <div class="step__spacer"></div>
                                <div class="step__hidden-fields"></div>
                                <div id="step3-special" class="nominations-group">
                                   
                                    <div>
                                        <input type="checkbox" id="bestbudgetevent" name="comments[Специальные номинации][]" value="лучшее событие бюджетом до 500 000 р" hidden>
                                        <label class="nomination__label nomination" for="bestbudgetevent">лучшее событие бюджетом до 500 000 р</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="bestpromotion" name="comments[Специальные номинации][]" value="лучшее продвижение / коммуникационная стратегия" hidden>
                                        <label class="nomination__label nomination" for="bestpromotion">лучшее продвижение / коммуникационная стратегия</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="besttechnologies" name="comments[Специальные номинации][]" value="лучшее использование инновационных технологий" hidden>
                                        <label class="nomination__label nomination" for="besttechnologies">лучшее использование инновационных технологий</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="hybridevent" name="comments[Специальные номинации][]" value="лучшее гибридное событие" hidden>
                                        <label class="nomination__label nomination" for="hybridevent">лучшее гибридное событие</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="creativeconcept" name="comments[Специальные номинации][]" value="лучшая креативная концепция" hidden>
                                        <label class="nomination__label nomination" for="creativeconcept">лучшая креативная концепция</label>
                                    </div>
                                   
                                    <!--Test3-->     
                                    <!--        
                                    <div class="nomination">лучшее событие бюджетом до 500 000 р</div>
                                    <div class="nomination">лучшее продвижение / коммуникационная стратегия</div>
                                    <div class="nomination">лучшее использование инновационных технологий</div>
                                    <div class="nomination">лучшее гибридное событие</div>
                                    <div class="nomination">лучшая креативная концепция</div>
                                    -->
                                
                                </div>
                                <div class="errors"></div>
                            </div>
                            <div class="step step_inactive step_4">
                                <div class="step__title">ДАННЫЕ КОМПАНИИ</div>
                                <!-- <div class="step__subtitle">Укажите контактные данные вашей компании</div> -->
                                <div class="step__spacer"></div>
                                <label class="input">
                                <div class="input__label-text">Название проекта</div>
                                <input  type="text" name="comments[Название проекта]" value="" placeholder="Название проекта" />
                                </label>
                                <div class="inline-radio-select">
                                    <div class="irs__label">Бюджет проекта</div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-0" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" checked value="500 000 Р"/>
                                        <label for="irs-comments[Бюджет проекта]-0" class="irs__option-label">&lt; 500 000 Р</label>
                                    </div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-1" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" value="500 000 - 3 000 000"/>
                                        <label for="irs-comments[Бюджет проекта]-1" class="irs__option-label">500 000 - 3 000 000</label>
                                    </div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-2" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" value="3 000 000 - 10 000 000"/>
                                        <label for="irs-comments[Бюджет проекта]-2" class="irs__option-label">3 000 000 - 10 000 000</label>
                                    </div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-3" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" value="10 000 000 - 25 000 000"/>
                                        <label for="irs-comments[Бюджет проекта]-3" class="irs__option-label">10 000 000 - 25 000 000</label>
                                    </div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-4" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" value="25 000 000 - 50 000 000"/>
                                        <label for="irs-comments[Бюджет проекта]-4" class="irs__option-label">25 000 000 - 50 000 000</label>
                                    </div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-5" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" value="> 50 000 000"/>
                                        <label for="irs-comments[Бюджет проекта]-5" class="irs__option-label">> 50 000 000</label>
                                    </div>
                                    <div class="irs__option">
                                        <input id="irs-comments[Бюджет проекта]-6" class="irs__option-input" type="radio" name="comments[Бюджет проекта]" value="Не разглашается"/>
                                        <label for="irs-comments[Бюджет проекта]-6" class="irs__option-label">Не разглашается</label>
                                    </div>
                                </div>
                                <div class="textarea">
                                    <div class="textarea__label-text">Цели и задачи</div>
                                    <textarea name="comments[Цели и задачи]"></textarea>
                                </div>
                                <div class="textarea">
                                    <div class="textarea__label-text">Креативная концепция</div>
                                    <textarea name="comments[Креативная концепция]"></textarea>
                                </div>
                                <div class="textarea">
                                    <div class="textarea__label-text">Целевая аудитория проекта</div>
                                    <textarea name="comments[Целевая аудитория проекта]"></textarea>
                                </div>
                                <div class="textarea">
                                    <div class="textarea__label-text">Инновационные решения</div>
                                    <textarea name="comments[Инновационные технические решения]"></textarea>
                                </div>
                                <div class="errors"></div>
                            </div>
                            <div class="step step_inactive step_5">
                                <div class="step__title">ОПИСАНИЕ ПРОЕКТА</div>
                                <div class="step__subtitle">Расскажите еще больше о вашем проекте</div>
                                <div class="step__spacer"></div>
                                <div class="step__group">
                                    <label class="input input_half">
                                        <div class="input__label-text">Количество подрядчиков</div>
                                        <input  type="text" name="comments[Количество подрядчиков]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Количество участников</div>
                                        <input  type="text" name="comments[Количество участников]" value="">
                                    </label>
                                </div>
                                <div class="step__spacer"></div>
                                <div class="step__note"><strong>Достигнутые числовые показатели:</strong><br>(заполнить показатели релевантные для формата проекта)</div>
                                <div class="step__spacer"></div>
                                <div class="step__group">
                                    <label class="input input_half">
                                        <div class="input__label-text">Media outreach</div>
                                        <input  type="text" name="comments[Media outreach]" value="">
                                    </label>
                                        <label class="input input_half">
                                        <div class="input__label-text">Media value</div>
                                        <input  type="text" name="comments[Media value]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Social media outreach</div>
                                        <input  type="text" name="comments[Social media outreach]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Публикации с хэштегом события</div>
                                        <input  type="text" name="comments[Публикации с хэштегом события]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Количество celebrities</div>
                                        <input  type="text" name="comments[Количество celebrities]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Рост продаж</div>
                                        <input  type="text" name="comments[Рост продаж]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Рост лояльности</div>
                                        <input  type="text" name="comments[Рост лояльности]" value="">
                                    </label>
                                    <label class="input input_half">
                                        <div class="input__label-text">Повышение узнаваемости бренда</div>
                                        <input  type="text" name="comments[Повышение узнаваемости бренда]" value="">
                                    </label>
                                </div>
                            </div>
                            <div class="step step_inactive step_6">
                                <div class="form-box">
                                    <div class="form-upload">
                                        <div class="upload-area">
                                           <div class="upload-counter">
                                               7 из 10
                                           </div>
                                           <div class="upload-preview-block" id="uploadImagesList">
                                               <div class="item template">
                                                    <div class="upload-preview">
                                                        <img src="" alt="">
                                                        <span class="upload-delete" title="Удалить"></span>
                                                    </div>                                        
                                               </div>
                                           </div>
                                        </div>
                                        <div class="upload-button">
                                            <label class="styled-upload">
                                                <span class="button">Выбрать файлы</span>
                                                <input class="btn-upload btn btn_orange-border" type="file" id="file" name="file[]" multiple>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-link">
                                        <div class="form-link__group">
                                            <label class="input">
                                                <div class="input__label-text">Ссылка на видео о проекте (YouTube, Vimeo)</div>
                                                <input class="form__input" name="link" placeholder="Введите ссылку">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step step_inactive step_success">
                                <div class="step__title">Спасибо!</div>
                                <div class="step__subtitle">Ваша заявка принята. Для завершения регистрации пройдите на страницу оплаты регистрационного взноса участника.</div>
                                <div class="step__submit"><button type="submit" class="btn btn_orange-border">Перейти к оплате</button></div>
                            </div>
                        </div>
                    </form>
                    <div class="request__footer">
                        <div class="footer__steps">
                            <div class="footer__step footer__step_1 footer__step_active">1</div>
                            <div class="footer__step footer__step_2 ">2</div>
                            <div class="footer__step footer__step_3 ">3</div>
                            <div class="footer__step footer__step_4 ">4</div>
                            <div class="footer__step footer__step_5 ">5</div>
                            <div class="footer__step footer__step_6 ">6</div>
                        </div>
                        <div class="btn btn_orange-border btn_next">Дальше</div>
                    </div>
                </div>
            </div>
        </div>
    
    <script>
    app = {
        lang: 'ru',
        live_site: '',
        assets: '/assets/',
        active_modules: ['pages/index', 'nav', 'index/top', 'cta', 'index/about', 'icon-title', 'index/side-download', 'index/nominations', 'index/info-block', 'index/criteria', 'index/calendar', 'index/council', 'index/partners', 'index/contacts', 'index/footer', 'pages/request', 'request/header', 'request/step-1', 'form/input', 'form/checkbox', 'request/step-2', 'request/step-3', 'request/step-4', 'form/inline-radio-select', 'form/textarea', 'request/step-5', 'request/step-6', 'request/step-success', 'request/footer'],
        footer_request: {
            "steps": 6
        },
        nav: {
            "home": {
                "title": "<img class=\"logo logo_main\" src=\"img\/logo.png\" \/><img class=\"logo logo_mobile\" src=\"\/assets\/img\/nav\/logo_on-transparent.png\" \/>",
                "href": ""
            },
            "about": {
                "title": "\u041e \u043f\u0440\u0435\u043c\u0438\u0438"
            },
            "nominations": {
                "title": "\u041d\u043e\u043c\u0438\u043d\u0430\u0446\u0438\u0438"
            },
            "criteria": {
                "title": "\u041a\u0440\u0438\u0442\u0435\u0440\u0438\u0438"
            },
            "calendar": {
                "title": "\u041a\u0430\u043b\u0435\u043d\u0434\u0430\u0440\u044c"
            },
            "council": {
                "title": "\u042d\u043a\u0441\u043f\u0435\u0440\u0442\u044b"
            },
            "partners": {
                "title": "\u041f\u0430\u0440\u0442\u043d\u0435\u0440\u044b"
            },
            "contacts": {
                "title": "\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u044b"
            }
        }
    }

    </script>
        
    
    <script src="http://syn.su/bema/js/bundle.js" async></script>
    <script src="http://syn.su/bema/js/modernizr-custom.js"></script>
    
    <!--[if lt IE 9]><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><![endif]-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//syn.su/bema/js/common.js"></script>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>
