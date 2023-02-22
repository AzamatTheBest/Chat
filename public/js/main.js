const chat = $('.chat');
const chatWindow = chat.find('.chat-window');
const currentUser = chat.data('user-id');

let sendMessageURL = '/chat/' + chat.data('chat-id');

let fetchMessageURL = sendMessageURL + '/getMessages';
const personalURL = '/chat/personal';
const deleteMessage = chat.find('.delete-btn');


$(document)
     .on('click', '#send_message', function (e){
       e.preventDefault();
       let form = $(this).closest('form');
       let formData = form.serialize();
       let input = form.find('input#message_text');
       input.val('');
       $.ajax({
                url: sendMessageURL,
                method: 'POST',
                data: formData,
                success: function(data) {
                  drawMessage(data);
                }
            } 
       );
     })
     
     ;





// $(document)
//      .on('click', deleteMessage, function (e){
//        let message = $(this).closest('.chat-message');
//        let formData = message.serialize();
//        $.ajax({
  
//          method: 'DELETE',
         
//          data: formData,
//          success: function(data) {
//             message.remove();
//          } 
//        })
      
     
//      })


chatWindow.scroll(function () {
  
  if (chatWindow.scrollTop() == 0){
     let firstMessage = chatWindow.find('.chat-message:first')
     if (firstMessage.length > 0) {
      let messages = fetchMessages(chatWindow.find('.chat-message').length);
      let contentIsLoaded = true;
      $(messages).each(function (e) {
        drawMessage(this, 'top');
      });

      chatWindow.scrollTop(firstMessage.offset().top - 170);
    }
  }
 
});


$(document).ready(function () {
  if(chatWindow.length > 0){
    chatWindow.scrollTop(chatWindow[0].scrollHeight)
    setInterval(function (){
    let messages = fetchMessages();
    $(messages).each(function (e) {
        drawMessage(this);
    })
  }, 5000)
  }
  
});


function fetchMessages(offset = 0)
{
  let messages = [];
  $.ajax({
    url: fetchMessageURL,
    method: 'GET',
    async: false,
    data: {offset: offset},
    success: function(data){
      messages = data;
    } 
  })
  return messages;
}


// {
//   $(this).closest('.chat-message').remove()

// }

const imageUploadURL = '/image/upload';

let currentChatId = null;
$(document)
    .on('change', '.upload-image', function(e) {
        let fd = new FormData();
        fd.append('file', this.files[0]);
        $.ajax({
            url: imageUploadURL,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                $('input.image-id').val(data.id);
            },
        });
    })
    .on('click', '.chat-user', function (e) {
        const userDiv = $(this);
        const userId = userDiv.data('user-id');
        const chatId = userDiv.data('chat-id');

        if (!currentChatId || chatId !== currentChatId) {
            $.ajax({
                url: '/chat/personal',
                method: 'GET',
                data: {userId: userId},
                async: false,
                success: function (data) {
                    currentChatId = data.id;
                    userDiv.data('chat-id', data.id);
                }
            })
        }
        sendMessageURL = '/chat/' + currentChatId;
        fetchMessageURL = sendMessageURL + '/getMessages';
        chatWindow.find('.chat-message').remove();
        $(fetchMessages()).each(function(e){
          drawMessage(this, 'top');
        })
    })



function drawMessage(message, place = 'bottom')
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
  if(message.sender && message.sender.image){
    prototype.find('img.message-image').attr('src', '/' + message.sender.image.path);
  }

  let date = new Date(message.senAt);
	let time = date.getHours()+":"+date.getMinutes();
                
  prototype.find('p.message-time').text(time)
  if (place === 'bottom'){
    chatWindow.append(prototype);
  }
  else{
    chatWindow.prepend(prototype);
  }
}


$(document)
    .on('change', '.upload-image', function(e){
        let fd = new FormData();
        fd.append('file', this.files[0]);
        $.ajax({
          url: imageUploadURL,
          method: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data){
            $('input.image-id').val(data.id);
          },
        })
    })