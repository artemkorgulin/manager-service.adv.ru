$(document).ready(function() {
    var files;
    $('#fileupl').change(function(){
        files = this.files;
    });       
    $('#loadfile').click(function( event ){
        event.stopPropagation(); 
        event.preventDefault();  
         
        var data = new FormData();
        $.each( files, function( key, value ){
            data.append( key, value );
        });
        data.append('fileupload', $('#fileupload').val());
        console.log(data);
        $.ajax({
            url: 'http://synergy.ru/lander/alm/intellectmoneyPay.php?addfiles',
            type: 'POST',
            data: data,
            processData: false, 
            contentType: false, 
            success: function(data) { 
                console.log(data);
                if( data == 'uploadok' ){
                        $('#fileUpload').html('Файл загружен');
                }
                else{
                    console.log(data);
                }   
            }
       });
    });
});