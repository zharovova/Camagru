<!DOCTYPE html>
<head>
    <title>Camagru</title>
</head>
<style>
    body {
        text-align: center;
    }
</style>
<body>
<script src='/js/main.js'></script>
<?php
$postlike = false;
    if (isset($data['like_post']) && $data['like_post'] != NULL) {
        $like = $data['like_post'];
        unset($data['like_post']);
    } else {
        unset($data['like_post']);
        $like = NULL;
    }
    if (isset ($data['like_post']) && $data['comments'] != NULL) {
        $comment = $data['comments'];
        unset($data['comments']);
    } else {
        $comment = NULL;
        unset($data['comments']);
    }
    foreach ($data as $value) {
        echo <<<POST
<div class="post">
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br><br>
<p>{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;
        if(isset($like))
        foreach ($like as $id) {
            if (isset($_SESSION['login']) && ($value['Post_ID'] === $id['Post_ID'])) {
                echo <<< LIKES
 <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
 <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'images/like.png' onclick="getLike({$value['Post_ID']})" width="35px" height="30px">
                </form>
LIKES;
                $postlike = true;
            }
        }
        else if (!isset($_SESSION['login'])) {
            echo <<< UNLIKES
            <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
                <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'images/unlike.png'  width="35px" height="30px">
            </form>
UNLIKES;
        }
        if (isset($_SESSION['login']) && $postlike === false) {
            echo <<< UNLIKES
        <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
            <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'images/unlike.png' onclick="getLike({$value['Post_ID']})" width="35px" height="30px">
        </form>
UNLIKES;
        }
        if (isset($_SESSION['login']))
            $id = $_SESSION['login'];
        else
            $id = 0;
        $postlike = false;
        echo <<<COMMENT
<div id="parentElement">
  <span id="childElement"></span>
  <input id='user_id' value = '{$id}'style="display:none">
</div>
    <div class="comments_{$value['Post_ID']}">
        <form method="post" action="/main/comments">
            <input type="text" id="comments_{$value['Post_ID']}" class="comments" name="message" placeholder="Add a comment..." required="required">
            <input type="submit" name="submit" value="send">
        </form>
</div>
</div>
<br>
COMMENT;
}
?>
</body>
</html>