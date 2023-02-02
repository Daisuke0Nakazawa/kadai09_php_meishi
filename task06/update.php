<?php

session_start();

require_once('funcs.php');
loginCheck();

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$img = '';

// 簡単なバリデーション処理。
if (trim($title) === '') {
    $err = 1;
}
if (trim($content) === '') {
    $err[] = 1;
}

// imgがある場合
if (isset($_FILES['img']['name'])) {
    $fileName = $_FILES['img']['name'];
    $img = date('YmdHis') . '_' . $_FILES['img']['name'];
}

// imgのバリデーション
if (!empty($fileName)) {
    $check =  substr($fileName, -3);
    if ($check != 'jpg' && $check != 'gif' && $check != 'png') {
        $err[] = 1;
    }
}

// もしerr配列に何か入っている場合はエラーなので、redirect関数でindexに戻す。その際、GETでerrを渡す。
if (isset($err) && count($err) > 0) {
    redirect('post.php?error');
}

/**
 * (1)$_FILES['img']['tmp_name']... 一時的にアップロードされたファイル
 * (2)'../picture/' . $image...写真を保存したい場所。先にフォルダを作成しておく。
 * (3)move_uploaded_fileで、（１）の写真を（２）に移動させる。
 */
if (isset($_FILES['img']['name'])) {
    move_uploaded_file($_FILES['img']['tmp_name'], '../img/' . $img);
}

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
// もし写真がある場合は、UPDATE文の中にimgを追加
if (isset($_FILES['img']['name']) && $_FILES['img']['name'] !== '') {
    $stmt = $pdo->prepare('UPDATE gs_content_table
                        SET
                            title = :title,
                            content = :content,
                            img = :img,
                            update_time = sysdate()
                        WHERE id = :id;');
    $stmt->bindValue(':img', $img, PDO::PARAM_STR);
} else {
    //  画像がない場合imgは省略する。
    $stmt = $pdo->prepare('UPDATE gs_content_table
                        SET
                            title = :title,
                            content = :content,
                            update_time = sysdate()
                        WHERE id = :id;');
}
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute(); //実行

//４．データ登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('index.php');
}
