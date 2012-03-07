$(document).ready(function() {
  initVVVV('vvvv_js', 'full');
  
  
  $('#save').click(function() {
    if ($('#screenshot_data').text().length==0) {
      alert("You should make a screenshot for the gallery before you save. Just hit the Screenshot button on the top left of a renderer.");
      return false;
    }
    console.log('saving ...');
    VVVV.Patches[0].clientbridge.pullCompletePatch();
    window.setTimeout(function() {
      $('#xml').text(VVVV.Patches[0].XMLCode);
      $('#new_form').submit();
    }, 1000);
    return false;
  })
  
  $('#showpatch').click(function() {
    var vvvviewer = new VVVV.VVVViewer(VVVV.Patches[0], '#patch');
    return false;
  });
  
  window.setInterval(function() {
    $('canvas').each(function() {
      if (!$(this).next().is('div.screenshot_toolbar')) {
        var that = this;
        $screenshot_toolbar = $('<div class="screenshot_toolbar"><a href="#" class="make_screenshot">Screenshot</a></div>');
        $(this).after($screenshot_toolbar);
        
        $screenshot_toolbar.css('top', $(this).position().top);
        $screenshot_toolbar.css('left', $(this).position().left);
        $screenshot_toolbar.find('a.make_screenshot').click(function() {
          var data = $(that).get(0).toDataURL('image/png');
          $('#screenshot_image').attr('src', data);
          $('#screenshot_data').text(data);
          return false;
        });
      }
    })
  }, 1000);
  
})
