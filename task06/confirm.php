<?php
// confirm.phpの中身は、ほとんどpost.phpに似ています。
session_start();
require_once('funcs.php');
require_once('head_parts.php');
require_once('header_nav.php');

loginCheck();

// post受け取る
$title = $_POST['title'];
$content = $_POST['content'];
$_SESSION['post']['title'] = $_POST['title'];
$_SESSION['post']['content'] = $_POST['content'];



// 画像に名前があれば(画像が送られてきたら)
// formで送られてきたら
if ($_FILES['img']['name'] !== '') {
    // 名前を取得する
    // A=B=C CがBに入って、BがAに入る
    // 送られてきた画像をsessionに送る、sessionをfile_nameへ
    // tem_name一時的に保存する
    $file_name = $_SESSION['post']['file_name'] = $_FILES['img']['name'];
    // 一時保存先にある画像のデータを取得する
    // 一時保存先：$_FILES['img']['tmp_name'])
    // file_get_contentsで一時保存先からデータを取得する
    $image_data = $_SESSION['post']['image_data'] = file_get_contents($_FILES['img']['tmp_name']);
    // ファイルのタイプを確認する
    $image_type = $_SESSION['post']['image_type'] = exif_imagetype($_FILES['img']['tmp_name']);

// ファイルで送らないけどセッションの中にデータがあれば
} elseif($_FILES['img']['name'] === '' && $_SESSION['post']['image_data'] !== '') {
    $file_name = $_SESSION['post']['file_name'] ='';
    $image_data = $_SESSION['post']['image_data']='';
    $image_type = $_SESSION['post']['image_type']='';

// formにも、セッションにも何もデータがなければ。
} else {
    $file_name = $_SESSION['post']['file_name'] = '';
    $image_data = $_SESSION['post']['image_data'] = '';
    $image_type = $_SESSION['post']['image_type'] = '';
}

// 画像が文字化けしていることを確認
// 文字化けさせない、画像を表示するためにimage.phpでheaderをつけている
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

// 簡単なバリデーション処理。
if (trim($title) === '' || trim($content) === '') {
    redirect('post.php?error');
}

// imgある場合
// 添付ファイルの拡張子を確認する。
if (!empty($file_name)) {
    $extension = substr($file_name, -3);
    if ($extension != 'JPG' && $extension != 'gif' && $extension != 'png' && $extension != 'jpg' ) {
        redirect('post.php?error=1');
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <?= head_parts('記事管理') ?>
</head>

<body>
    <?=  $header_nav?>
    <!-- errorを受け取ったら、エラー文出力。 -->

    <form method="POST" action="register.php" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="hidden"name="title" value="<?= $title ?>">
            <p><?= $title ?></p>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">記事内容</label>
            <input type="hidden"name="content" value="<?= $content ?>">
            <div><?= nl2br($content) ?></div>
        </div>
<!-- イメージデータがあれば画像を表示してください -->
        <?php if ($image_data) :?>
            <div class="mb-3">
                <img src="image.php">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">投稿</button>
    </form>
    

    <a href="post.php?re-register=true">前の画面に戻る</a>
</body>
</html>
