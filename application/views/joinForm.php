<link rel="stylesheet" href="/static/css/join.css">
<script type="text/javascript" src="/static/js/join.js"></script>

<div class="container">
    <div class="box">
        <div class="board">
            <div class="joinForm">
                <form action="/user/join" method="post" id="joinForm" onsubmit="return joincheck()">
                    <p>회원가입</p>
                    <table class="join_table">
                        <tr>
                            <td>아이디</td>
                            <td><input type="text" name="user_id" id="user_id"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="user_id_res"></td>
                        </tr>
                        <tr>
                            <td>비밀번호</td>
                            <td><input type="password" name="user_password" id="user_password"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="user_password_res"></td>
                        </tr>
                        <tr>
                            <td>비밀번호 확인</td>
                            <td><input type="password" name="user_password2" id="user_password2"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="user_password2_res"></td>
                        </tr>
                        <tr>
                            <td>닉네임</td>
                            <td><input type="text" name="user_nickname" id="user_nickname"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="user_nickname_res"></td>
                        </tr>
                        <tr>
                            <td>성별</td>
                            <td>여 <input type="radio" name="user_gender" value=1 class="user_gender">
                                남 <input type="radio" name="user_gender" value=2 class="user_gender"></td>
                        </tr>
                    </table>
                    <div class="btn">
                        <input type="submit" value="가입하기">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
