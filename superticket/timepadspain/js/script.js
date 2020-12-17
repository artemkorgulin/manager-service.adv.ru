$(document).ready(function() {
        document.getElementById('dragdrop').style.display='none';               
        document.getElementById('progress').style.display='none';  
    $("#start").click(function(){
        document.getElementById('start').style.display='none';
        document.getElementById('dragdrop').style.display='block';  
        document.getElementById('addTicket').style.display='none';
        $('#startId').val(makeid());
    });

    function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
    }

     $("#finish").click(function(){
            document.getElementById('progress').style.display='block';  
            document.getElementById('finish').style.display='none';  
            var mp3 = new Mprogress({
                        template: 3,
                        parent: '#progress'
                    });
                     
            mp3.start();
            var msg   = $('#create').serialize();
            var msgupload   = $('#upload').serialize();
            msg = msg + "&" + msgupload;

            console.log(msg);
            $.ajax({
              type: 'POST',
              url: 'http://synergy.ru/lander/alm/intellectmoneyPay.php',
              data: msg,
              success: function(data) {
   
            console.log(data)
            if (data == "uploadOK") {
                $('#dragdrop').html('<div style="width:300px; height:300px; margin:auto; color:#007a96 0%;  font-size: 300%; text-align: center; padding:20%;">Tickets have been successfully uploaded</div>')
              }
            if (data == 'fileuploadOK') {
                $('#dragdrop').html('<div style="width:300px; height:300px; margin:auto; color:#007a96 0%;  font-size: 300%; text-align: center; padding:20%;">Файл прикреплен</div>')
            }
            }
         });   
    });

    var ul = $('#upload ul');

    $('#drop a').click(function(){
 
        $(this).parent().find('input').click();
    });

    var countFile = 0;
    var countFileUpload = 0;


    var sTime = new Date().getTime();
    var countDown = 10;

    function UpdateTime() {
        var cTime = new Date().getTime();
        var diff = cTime - sTime;
        var seconds = countDown - Math.floor(diff / 1000);
    }

    $('#upload').fileupload({
        dropZone: $('#drop'),
        add: function (e, data) {
            var tpl = $('<li class="working"><p></p><span></span></li>');

            tpl.find('p').text(data.files[0].name )
                         .append('(' + formatFileSize(data.files[0].size) + ')');

            data.context = tpl.appendTo(ul);

            countFile++;

            console.log(countFile);
      
            tpl.find('input').knob();

            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });

            });

            var jqXHR = data.submit();           
            
            },

        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);

            console.log(progress);
     
            data.context.find('input').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');

                countFileUpload++;

            }
            document.getElementById('addTicket').style.display='block';
        },

        fail:function(e, data){
          
            data.context.addClass('error');
        }
});
  
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    }
});