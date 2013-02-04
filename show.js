$(document).ready(function() {
  VVVV.Config.auto_undo = true;
  VVVV.ImageProxyPrefix = 'fileproxy.php?f=';
  
  var message_hide_timeout;
  VVVV.onNotImplemented = function(nodename) {
    clearTimeout(message_hide_timeout);
    $('#log_message').html(nodename+" is not implemented yet!");
    $('#log_message').show();
    message_hide_timeout = window.setTimeout(function() {
      $('#log_message').fadeOut();
    }, 3000);
  }
  VVVV.init('vvvv_js-26c779666', 'full', function() {
  
    function establishVVVVConnection() {
      VVVV.Patches[0].VVVVConnector.host = 'ws://localhost';
      VVVV.Patches[0].VVVVConnector.enable({
        success: function() {
          $('.shelf').slideUp();
          $('#open_save_shelf').removeClass('disabled');
          $('.screenshot_toolbar').show();
        },
        error: function() {
          openShelf('connection_error');
          location.hash = '#';
        }
      });
    }
    if (window.location.hash=='#edit')
      establishVVVVConnection();
    
    $(window).bind('hashchange', function() {
      if (window.location.hash=='#edit')
        establishVVVVConnection(); 
    });
    
    $('#open_save_shelf').click(function() {
      if ($(this).hasClass('disabled')) {
        openShelf('not_connected');
        return false;
      }
      openShelf('save');
  
      return false;
    });
    
    $('.open_help_shelf').click(function() {
      openShelf('help');
      return false;
    });
    
    $('#save').click(function() {
      if ($('#screenshot_data').text().length==0) {
        alert("You should make a screenshot for the gallery before you save. Just hit the Screenshot button on the top left of a renderer.");
        $('#save_shelf').slideUp();
        return false;
      }
      if ($('form input:text[value=""]').length>0) {
        alert("Please give a title and your name.");
        return false;
      }
      VVVV.Patches[0].VVVVConnector.pullCompletePatch();
      window.setTimeout(function() {
        $('#xml').text(VVVV.Patches[0].XMLCode);
        $('#new_form').submit();
      }, 1000);
      return false;
    });
    
    var vvvviewer = undefined;
    $('#showpatch').click(function() {
      $('.shelf').slideUp();
      if (!vvvviewer) {
        vvvviewer = new VVVV.VVVViewer(VVVV.Patches[0], '#patch');
        $('#patch').css('width', '600px');
        $('#patch').css('height', '600px');
        $('#patch').show();
        $('#showpatch').text('Hide Patch');
      }
      else {
        $('#patch').slideUp(function() {
          delete vvvviewer;
          vvvviewer = undefined;
          $('#patch').empty();
          $('#showpatch').text('Show Patch');
        });
        
      }
      
      return false;
    });
    
    window.setInterval(function() {
      $('canvas').each(function() {
        if (!$(this).next().is('div.screenshot_toolbar')) {
          var that = this;
          $screenshot_toolbar = $('<div class="screenshot_toolbar"><a href="#" class="make_screenshot">Screenshot</a></div>');
          $(this).after($screenshot_toolbar);
          
          if (location.hash=='#edit') 
            $screenshot_toolbar.css('display', 'block');
          $screenshot_toolbar.css('top', $(this).position().top);
          $screenshot_toolbar.css('left', $(this).position().left);
          $screenshot_toolbar.find('a.make_screenshot').click(function() {
            var data = $(that).get(0).toDataURL('image/png');
            $('#screenshot_image').attr('src', data);
            $('#screenshot_data').text(data);
            $('#save_shelf').slideDown();
            return false;
          });
        }
      })
    }, 1000);
  });
  
})
