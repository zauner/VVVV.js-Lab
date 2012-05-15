function openShelf(name) {
    $('.shelf').slideUp();
    $('#'+name+'_shelf').slideDown();
  }

$(document).ready(function() {
  
  if (location.hash=="#create_success") {
    openShelf("create_success");
  }
  
  if (document.cookie.indexOf("welcome_message_read=1")>=0) {
    openShelf('welcome');
    document.cookie = "welcome_message_read=1;"
  }

  $('.close').click(function() {
    $('.shelf').slideUp();
  })  

});