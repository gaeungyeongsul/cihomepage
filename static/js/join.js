$(document).ready(function() {

	$('#user_id').blur(function(){
		idcheck();
	});

	$('#user_nickname').blur(function(){
		nicknamecheck();
	});

	$('#user_password').blur(function() {
		passwordcheck();
	});

	$('#user_password2').keyup(function(){
		password2check();
	})
});

var idcheck = function(){
	if($('#user_id').val() == ""){
		$('#user_id_res').html('아이디를 입력해주세요.').css("color","red");
	}else{
		$.ajax({
			method: 'GET',
			url: '/index.php/user/selectOneUser',
			data: {
				user_id : $('#user_id').val()
			},
			success : function(result){
				if(!result){
					$('#user_id_res').html('사용가능한 아이디입니다.').css("color","black");
				}else{
					$('#user_id_res').html('사용불가한 아이디입니다.').css("color","red");
				}
			},
			error : function(xhrReq, status, error) {
				alert(error)
			}
		})
	}
}

var nicknamecheck = function(){
	if($('#user_nickname').val() == ""){
		$('#user_nickname_res').html('닉네임을 입력해주세요.').css("color","red");
	}else{
		$.ajax({
			method: 'GET',
			url: '/index.php/user/selectOneUser',
			data: {
				user_nickname : $('#user_nickname').val()
			},
			success : function(result){
				if(!result){
					$('#user_nickname_res').html('사용가능한 닉네임입니다.').css("color","black");
				}else{
					$('#user_nickname_res').html('사용불가한 닉네임입니다.').css("color","red");
				}
			},
			error : function(xhrReq, status, error) {
				alert(error)
			}
		})
	}
}

var passwordcheck = function(){
	var user_pass = $('#user_password').val();
	if(user_pass == ""){
		$('#user_password_res').html('PW를 입력해주세요.').css("color","red");
	}else{
		var passPattern = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;

		if(passPattern.test(user_pass)){
			$('#user_password_res').html('사용가능 한 PW입니다.').css("color","black");
		}else{
			$('#user_password_res').html('소문자, 숫자, 특수문자를 포함하여 8글자 이상 <br> 입력하세요.').css("color","red");
		}
	}
}

var password2check = function(){
	if ($('#user_password').val() != $('#user_password2').val()) {
		$('#user_password2_res').html('비밀번호가 다릅니다.').css("color","red");
	}else{
		$('#user_password2_res').html('');
	}
}

var joincheck = function(){
	if($('#user_id_res').html() == '사용가능한 아이디입니다.' &&
		 $('#user_nickname_res').html() == '사용가능한 닉네임입니다.' &&
		 $('#user_password_res').html() == '사용가능 한 PW입니다.' &&
		 $('#user_password').val() == $('#user_password2').val() &&
		 $('input:radio[name=user_gender]').is(':checked')
	 ){
		 return true;
	 }else{
		 alert('가입조건을 확인해주세요.');
		 return false;
	 }
}
