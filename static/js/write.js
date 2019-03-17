$(document).ready(function() {
  $('#summernote').summernote({
    height: 400,
    maxHeight: null,
    minHeight: 200,
    focus: true,
    lang: 'ko-KR',
    callbacks: {
      onImageUpload : function(files, editor, welEditable) {
        console.log('image upload:', files);
        sendFile(files[0], this);

      },
    }
  });
  function sendFile(file,el) {
    var data = new FormData();
    data.append('file', file);
    $.ajax({
      data: data,
      type: 'POST',
      url: '/board/uploadImg',
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false,
      success: function(data) {
        data = '/static/img/board_img/'+ data;
        $(el).summernote('editor.insertImage', data);
      },
      error: function(jqXHR, textStatus, errorThrown){
        console.log(textStatus + " " + errorThrown);
      }
    });
  }
});
