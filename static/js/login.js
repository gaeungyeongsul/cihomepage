$(document).ready(function(){
  $('#login_btn').click(function(){
    $.ajax({
      method: 'POST',
      url : '/index.php/user/login',
      data : {
        user_id : $('#user_id').val(),
        user_password : $('#user_password').val()
      },
      success : function(result){
        if(result){
          location.href='/index.php/main';
        }else{
          alert('잘못된 아이디 혹은 비밀번호입니다.');
        }
      },
      error : function(xhrReq, status, error) {
				alert(error)
			}
    })
  })
});
