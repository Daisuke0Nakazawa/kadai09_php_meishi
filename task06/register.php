<?php

session_start();
require_once('funcs.php');
loginCheck();

$title = $_POST['title'];
$content  = $_POST['content'];
$img = '';


// 簡単なバリデーション処理追加。
// 下部の場合、全角のスペースは通してしまうので注意
if (trim($title) === '' || trim($content) === '') {
    redirect('post.php?error');
}

// ★★★★Macはimagesフォルダの書き込み権限を変更してください。★★★★
// imgに画像があれば、データベースには保存した画像のアドレスを書く
// ファイルそのものはデータベースのフォルダ内に保存する
// 同じ名前の画像が投稿されたときに上書きされないように日付をファイル名につける
// 保存するときの名前を$imgにいれる
// file_put_contents(ファイル,書き込むデータ)でファイル名を(画像のアドレス)をつけて保存
if ($_SESSION['post']['image_data'] !== "") {
    $img = date('YmdHis') . '_' . $_SESSION['post']['file_name'];
    file_put_contents("img/$img", $_SESSION['post']['image_data']);
}

// var_dump($_SESSION['post']['image_data'] );



//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO ga_image_table(
                            title, content, img, date
                        )VALUES(
                            :title, :content, :img, sysdate()
                        )');
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':img', $img, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    $_SESSION['post'] = [] ;
    redirect('index.php');
}
