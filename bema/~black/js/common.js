$(function () {
    initPopup();
    SendFormData();
    initUploadImages();
});

function initPopup() {
    if (!$('.fancybox').length) return;

    $('.fancybox').fancybox({
        padding: 0,
        helpers: {
            media: {},
            overlay: {
                locked: true
            }
        },
        afterClose: function () {
            var str = $("form").serialize();
            $.ajax({
                type: "POST",
                url: "../chunks/form-dumper.php",
                data: str,
                success: function (msg) {}
            });
        }

    });
}

function SendFormData() {
    $('.btn_next').on('click', function () {
        var str = $("form").serialize();
        //console.log(str);
        $.ajax({
            type: "POST",
            url: "../chunks/form-dumper.php",
            data: str,
            success: function (msg) {
                //console.log('success');
            }
        });
    });
}

function initUploadImages() {
    var maxFileSize = 3 * 1024 * 1024; // (байт) Максимальный размер файла (3мб)
    var maxFileCount = 10;
    var queue = {};
    var form = $('form#uploadImages');
    var imagesList = $('#uploadImagesList');
    var allFiles = [];

    var itemPreviewTemplate = imagesList.find('.item.template').clone();
    itemPreviewTemplate.removeClass('template');
    imagesList.find('.item.template').remove();

    $('.upload-counter').text(0 + ' из ' + maxFileCount);


    $('#file').on('change', function (e) {
        e.preventDefault();
        var files = this.files;

        $('.upload-counter').text(files.length + ' из ' + maxFileCount);

        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            if (!file.type.match(/image\/(jpeg|jpg|png|gif)/)) {
                alert('Фотография должна быть в формате jpg, png или gif');
                continue;
            }

            if (file.size > maxFileSize) {
                alert('Размер фотографии не должен превышать 3 Мб');
                continue;
            }

            if (file.size < maxFileCount) {
                alert('Загрузите не менее 10 фотографий проекта');
                continue;
            }
            
            preview(files[i]);
        }
        //console.log(queue);
    });

    // Создание превью
    function preview(file) {
        var reader = new FileReader();
        reader.addEventListener('load', function (event) {
            var img = document.createElement('img');

            var itemPreview = itemPreviewTemplate.clone();

            itemPreview.find('.upload-preview img').attr('src', event.target.result);
            itemPreview.data('id', file.name);

            imagesList.append(itemPreview);

            queue[file.name] = file;

        });
        reader.readAsDataURL(file);
    }

    // Удаление фотографий
    imagesList.on('click', '.upload-delete', function () {
        var item = $(this).closest('.item'),
            id = item.data('id');

        delete queue[id];

        item.remove();
    });
}
