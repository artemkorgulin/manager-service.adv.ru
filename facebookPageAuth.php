<?php isset($_REQUEST['syn_add_fb_page']) ? true : exit(); ?>
<html>
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({cache: true});
            $.getScript('https://connect.facebook.net/en_US/sdk.js', function () {
                FB.init({
                    appId: '2242869896027279',
                    version: 'v3.2'
                });

                $('.btn_fb-login').on('click', function () {
                    FB.login(function (response) {
                        console.log('Success login!', response);
                        $('.pages').html('');
                        FB.api('/me/accounts', function (response) {
                            var pages = response.data;
                            for (var i = 0, len = pages.length; i < len; i++) {
                                var page = pages[i];
                                $('.pages').append('<div class="page__link" data-page-id="' + page.id + '" data-page-access-t="' + page.access_token + '">' + page.name + '</div>');
                            }
                        });
                    }, {scope: 'manage_pages,ads_management,leads_retrieval'});
                });
            });

            $('body').on('click', '.page__link', function () {
                var pageId = $(this).data('page-id');
                var pageAccessToken = $(this).data('page-access-t');
                FB.api('/' + pageId + '/subscribed_apps', 'post', {
                    access_token: pageAccessToken,
                    subscribed_fields: 'leadgen'
                }, function (response) {
                    console.log('Success subscribed!', response);
                });
            });
        });
    </script>
</head>
<body>
<div class="pages"></div>
<button class="btn_fb-login">Авторизоваться</button>
</body>
</html>