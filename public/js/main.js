$(document)
     .on('click', '#send_message', function (e){
       e.preventDefault();
       let form = $(this).closest('form');
       let input = form.find('input#message_text');
       $.ajax({
                url: window.location.href,
                method: 'POST',
                data: form.serialize(),
                success: function(data) {
                    let text = input.val();
                input.val('');
                let prototype = $('.message-from-me-prototype').clone();
                prototype.removeClass('message-from-me-prototype');
                prototype.find('p.message-text').text(text);

                let date = new Date();
	            let time = date.getHours()+":"+date.getMinutes();
                
                prototype.find('p.message-time').text(time)
                $('.chat-window').append(prototype);
                }
            } 
       );
     });