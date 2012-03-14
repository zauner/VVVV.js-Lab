$(document).ready(function() {
  initVVVV('vvvv_js', 'full');
  
  function establishVVVVConnection() {
    VVVV.Patches[0].VVVVConnector.host = 'ws://localhost';
    VVVV.Patches[0].VVVVConnector.enable({
      success: function() {
        $('#open_save_shelf').removeClass('disabled');
        $('.screenshot_toolbar').show();
      },
      error: function() {
        alert("Sorry, couldn't connect to VVVV. Make sure, you have an empty VVVV patch open, containing only a VVVVJsConnector node.");
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
      alert('To save a new revision of this patch, start VVVV on your machine, and add the VVVVJsConnector node to an empty patch. Then hit "Edit this patch".')
      return false;
    }
    $('#shelf').slideDown();
    return false;
  });
  
  $('#save').click(function() {
    if ($('#screenshot_data').text().length==0) {
      alert("You should make a screenshot for the gallery before you save. Just hit the Screenshot button on the top left of a renderer.");
      $('#shelf').slideUp();
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
  
  $('#cancel').click(function() {
    $('#shelf').slideUp();
  })
  
  var vvvviewer = undefined;
  $('#showpatch').click(function() {
    $('#shelf').slideUp();
    if (!vvvviewer) {
      vvvviewer = new VVVV.VVVViewer(VVVV.Patches[0], '#patch');
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
        
        if (location.hash=='#edit') 
          $screenshot_toolbar.css('display', 'block');
        $screenshot_toolbar.css('top', $(this).position().top);
        $screenshot_toolbar.css('left', $(this).position().left);
        $screenshot_toolbar.find('a.make_screenshot').click(function() {
          var data = $(that).get(0).toDataURL('image/png');
          $('#screenshot_image').attr('src', data);
          $('#screenshot_data').text(data);
          $('#shelf').slideDown();
          return false;
        });
      }
    })
  }, 1000);
  
})
