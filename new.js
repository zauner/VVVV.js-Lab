$(document).ready(function() {
  VVVV.Config.auto_undo = true;
  var patch;
  var mainloop;
  
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
  
    patch = new VVVV.Core.Patch("ws://localhost",
      function() {
        mainloop = new VVVV.Core.MainLoop(this);
        $('.shelf').slideUp();
        $('#open_save_shelf').removeClass('disabled');
        $('#showpatch').removeClass('disabled');
      },
      function() {
        openShelf('connection_error');
      }
    );
    
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
      patch.VVVVConnector.pullCompletePatch();
      window.setTimeout(function() {
        $('#xml').text(patch.XMLCode);
        $('#new_form').submit();
      }, 1000);
      return false;
    });
    
    var vvvviewer = undefined;
    $('#showpatch').click(function() {
      $('.shelf').slideUp();
      if (!vvvviewer) {
        vvvviewer = new VVVV.VVVViewer(patch, '#patch');
        $('#patch').slideDown();
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
