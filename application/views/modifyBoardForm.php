<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="/static/css/style.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<link href="/static/summernote/summernote.css" rel="stylesheet">
<script src="/static/summernote/summernote.js"></script>
<script src="/static/js/write.js"></script>

<div class="container">
    <div class="box">
        <div class="board">
            <div class="writeboard">
                <p>글수정</p>
                <form action="/board/modifyBoard" method="post">
                    <input type="hidden" name="board_no" value="<?= $board->board_no ?>">
                    <input type="hidden" name="board_user_id" value="<?=$board->board_user_id ?>">
                    <input type="text" name="title" class="board_title" placeholder="제목을 입력하세요."
                           value="<?= $board->board_title ?>">
                    <p></p>
                    <!-- summernote와 관련된 영역 -->
                    <textarea id="summernote" name="contents"><?= $board->board_content ?></textarea>
                    <!-- 버튼과 관련된 영역 -->
                    <div align="center">
                        <input type="submit" value="작성">
                        <input type="button" id="btn" value="취소">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>