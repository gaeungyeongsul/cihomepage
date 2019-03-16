<script>
    $(document).ready(function(){
        $('#delete_btn').click(function(){
            var result = confirm('정말로 삭제하시겠습니까?');
            if(result){
                var board_no = $('input[name=board_no]').val();
                $.ajax({
                    method: 'POST',
                    url : 'deleteBoard.php',
                    data : {
                        'board_no' : board_no
                    },
                    success : function(result){
                        if(result)
                            $(location).attr('href', '/board/readBoardList');
                    },
                    error : function(xhrReq, status, error) {
                        alert(error)
                    }
                })
            }
        })
    })
</script>
<div class="container">
    <div class="box">
        <div class="board">
            <div class="boardone">
                <div class="board_nav_1">
                    <?php

                    ?>
                    <div class="board_no"><?= $board->board_no; ?></div>
                    <div class="board_title"><?= $board->board_title; ?></div>
                    <div class="board_date"><?= $board->board_write_date; ?></div>
                </div>
                <div class="board_nav_2">
                    <div class="board_nick">닉네임 : <?= $board->board_user_nickname; ?></div>
                    <div class="board_reviewnum"><?= $board->board_views; ?></div>
                </div>
                <div class="board_content">
                    <?= $board->board_content; ?>
                </div>
                <div class="btn">
                    <?php
                    $url = '/board/readBoardList/?page='.$search['page'].'&numb='.$search['numb'].'&type='.$search['type'].'&keyword='.$search['keyword'];
                    ?>
                    <?php
                    if(@$this -> session -> userdata('logged_in') == TRUE){
                        ?>
                    <form method="post" action="/board/modifyBoardForm">
                        <input type="hidden" value="<?= $board['board_no']; ?>" name="board_no">
                        <input type="submit" value="수정하기">
                        <input type="button" value="삭제하기" id="delete_btn">
                        <?php
                        }
                        ?>
                        <input type="button" value="목록으로" onclick="location.href='<?=$url; ?>'">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php /*---------------------------------목록-------------------------------*/ ?>
<div class="container">
    <div class="box">
        <div class="board">
            <p>여행 후기 게시판</p>

            <input type="hidden" name="search" value="">
            <table class="board_list">
                <tr>
                    <th>글번호</th>
                    <th>제목</th>
                    <th>글쓴이</th>
                    <th>날짜</th>
                    <th>조회수</th>
                </tr>
                <?php
                foreach ($board_list as $row){
                    echo '<tr>';
                    echo '	<td>'.$row->board_no.'</td>';
                    echo '	<td><a href=/board/readBoardOne/?board_no='.$row->board_no;
                    echo          '&page='.$search['page'].'&numb='.$search['numb'];
                    echo          '&type='.$search['type'].'&keyword='.$search['keyword'].'>';
                    echo          $row->board_title.'</a></td>';
                    echo '	<td>'.$row->board_user_nickname.'</td>';
                    echo '	<td>'.$row->board_write_date.'</td>';
                    echo '	<td>'.$row->board_views.'</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <?php
            if(@$this -> session -> userdata('logged_in') == TRUE){
                ?>
                <input type="button" value="글쓰기" class="write_button" onclick="location.href='/board/writeForm'">
                <?php
            }
            ?>
        </div>
        <div class="page">
            <div class="pagination">
                <?php
                $common_url = 'numb='.$search['numb'].'&type='.$search['type'].'&keyword='.$search['keyword'];
                $start_url = '?page=1&'.$common_url;
                $prev_url = '?page='.$page_list['prev'].'&'.$common_url;
                $next_url = '?page='.$page_list['next'].'&'.$common_url;
                $last_url = '?page='.$page_list['last'].'&'.$common_url;
                ?>
                <?php
                if($search['start'] != 1){
                    ?>
                    <a href="/board/readBoardList/<?=$start_url?>">&Lang;</a>
                    <a href="/board/readBoardList/<?=$prev_url?>">&lang;</a>
                    <?php
                }
                ?>
                <?php
                for($i = $page_list['start']; $i <= $page_list['end']; $i++) {
                    if($i == $page_list['current']){
                        ?>
                        <a href="/board/readBoardList/?page=<?=$i?>&<?=$common_url?>" class="active"><?php echo $i?></a>
                        <?php
                    }else{
                        ?>
                        <a href="/board/readBoardList/?page=<?=$i?>&<?=$common_url?>"><?php echo $i?></a>
                        <?php
                    }
                }
                ?>
                <?php
                if($page_list['end'] < $page_list['last']){
                    ?>
                    <a href="/board/readBoardList/<?=$next_url?>">&rang;</a>
                    <a href="/board/readBoardList/<?=$last_url?>">&Rang;</a>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="search">
            <form action="/board/readBoardList">
                <select name="type">
                    <option value="0">전체</option>
                    <option value="1">제목</option>
                    <option value="2">내용</option>
                    <option value="3">제목+내용</option>
                    <option value="4">글쓴이</option>
                </select>
                <input type="text" placeholder="검색어를 입력하세요." name="keyword">
                <input type="submit" value="검색">
            </form>
        </div>
    </div>
</div>