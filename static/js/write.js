$(document).ready(function() {
  $('#summernote').summernote({
    height : 400,
    maxHeight : null,
    minHeight : 200,
    focus : true,
    lang : 'ko-KR',
    callbacks: {
      onImageUpload: function(files, editor, welEditable) {
        for (var i = files.length - 1; i >= 0; i--) {
          sendFile(files[i], this);
        }
      }
    }
  });
  var writef = function(){
    var markup = $('#summernote').summernote('code');
    return markup;
  }
  function sendFile(file, el) {
      var data = new FormData();
      data.append('file', file);
      $.ajax({
        data: data,
        type: 'POST',
        url: 'saveimage.php',
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function(img_name) {
          $(el).summernote('editor.insertImage', img_name);
        },
        error: function(jqXHR, textStatus, errorThrown){
          console.log(textStatus + " " + errorThrown);
        }
      });
  }
});
