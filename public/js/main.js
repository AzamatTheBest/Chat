const chat = $('.chat');
const chatWindow = chat.find('.chat-window');
const currentUser = chat.data('user-id');

const sendMessageURL = '/chat/' + chat.data('chat-id');
const fetchMessageURL = sendMessageURL + '/getMessages';

$(document)
     .on('click', '#send_message', function (e){
       e.preventDefault();
       let form = $(this).closest('form');
       let input = form.find('input#message_text');
       $.ajax({
                url: sendMessageURL,
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
     })
     
     ;
chatWindow.scroll(function () {
  
  if (chatWindow.scrollTop() == 0){


      $.ajax({
        url: fetchMessageURL,
        method: 'GET',
        data: {offset: 10},
        success: function(data){
          $(data).each(function (e) {
            drawMessage(this);
          })
        } 
      })
  }
 
})

function drawMessage(message)
{
  if(chatWindow.find('.chat-message[data-message-id="' + message.id + '"]').length > 0){
    return false;
  }


  let prototypeClass = 'message-to-me-prototype';
  if(message.sender != null && message.sender.id == currentUser){
    prototypeClass = 'message-from-me-prototype';
  }
  let prototype = $('.' + prototypeClass).clone();
  prototype.removeClass(prototypeClass);

  prototype.data('message-id', message.id);
  prototype.attr('data-message-id', message.id);

  prototype.find('p.message-text').text(message.text);

  let date = new Date(message.senAt);
	let time = date.getHours()+":"+date.getMinutes();
                
  prototype.find('p.message-time').text(time)
  $('.chat-window').prepend(prototype);
}