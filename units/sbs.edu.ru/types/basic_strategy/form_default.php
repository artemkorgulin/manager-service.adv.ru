<?php 
if($lead->form == 'popup-sponsor' || $lead->form == 'popup-partner') {
      $config['user']['sendsuccess'] = "
            <div class='send-success'>
                  <h3>Заявка успешно отправлена!</h3>
                  <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>  
            </div>
      ";
}
else {
      $config['user']['sendsuccess'] = "
            <div class='send-success'>
                  <h3>Заявка успешно отправлена!</h3>
                  <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
                  <script> $.fancybox.open('#popuper-prices');
                  // $(document).ready(function(){
                  //    setTimeout(function() {
                  //           location.reload();
                  //    }, 3000);
                  // });
                  </script>
                  <script>$('a[href=\"#popup-tickets\"]').trigger('click');</script>
            </div>
      ";
}

	/* Конфигуратор UserMail */
      $config['ignore']['send_to_user']   = false;



if ($lead->land == 'sbs_bs2019' && $lead->partner == 'franchising_kursk') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;
}
      





?>