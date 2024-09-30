<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="このページの説明文">
    <title>このページのタイトル</title>
    <link rel="stylesheet" href="/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>

<body>

    <?php
    try {
        //DB名、ユーザー名、パスワード
        $dsn = 'mysql:host=localhost;dbname=xs262124_corfuldb';
        $db_username = 'xs262124_yasu';
        $db_password = 'pokopixgvp';

        $pdo = new PDO($dsn, $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //input_post.phpの値を取得
        $band_name = $_POST['band_name'];
        $live_name = $_POST['live_name'];
        $live_year = $_POST['live_year'];
        $song_name = $_POST['song_name'];
        $composer = $_POST['composer'];
        $url = $_POST['url'];

        // $counts_band = "SELECT COUNT(*) FROM bands WHERE band_name = $band_name";
        //バンドが存在しているか確認
    
        $sql = "SELECT COUNT(*) FROM bands WHERE band_name = :band_name"; // COUNT文を変数に格納
        $stmt = $pdo->prepare($sql); // SQL実行の準備をする
        $params = array(':band_name' => $band_name); // 検索条件を配列に格納
        $stmt->execute($params); // SQLを実行
    
        $band_count = $stmt->fetchColumn(); // 結果を1つのカラムとして取得,fetchAllを使うより1行取得する場合はこっちの方が良いらしい
    
        if ($band_count == 0) {//バンド名が重複していない場合
            $sql = "INSERT INTO bands (band_name) VALUES (:band_name)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダという、値を入れるための単なる空箱
            $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
            $params = array(':band_name' => $band_name); // 挿入する値を配列に格納する
            $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
        } else {
            echo "バンド名が既に存在しているので追加しませんでした。";
        }

        //ライブが存在しているかの確認
        $sql = "SELECT COUNT(*) FROM lives WHERE live_name = :live_name AND live_year = :live_year"; // COUNT文を変数に格納
        $stmt = $pdo->prepare($sql); // SQL実行の準備をする
        $params = array(':live_name' => $live_name, ':live_year' => $live_year); // 検索条件を配列に格納
        $stmt->execute($params); // SQLを実行
        $live_count = $stmt->fetchColumn();

        if ($live_count == 0) {//バンド名が重複していない場合
            $sql = "INSERT INTO lives (live_name,live_year) VALUES (:live_name,:live_year)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダという、値を入れるための単なる空箱
            $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
            $params = array(':live_name' => $live_name, ':live_year' => $live_year); // 挿入する値を配列に格納する
            $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
        } else {
            echo "ライブ名が既に存在しているので追加しませんでした。";
        }

        //songsの重複をチェック
        $sql = "SELECT COUNT(*) FROM songs WHERE song_name = :song_name AND composer= :composer"; // COUNT文を変数に格納
        $stmt = $pdo->prepare($sql); // SQL実行の準備をする
        $params = array(':song_name' => $song_name, ':composer' => $composer); // 検索条件を配列に格納
        $stmt->execute($params); // SQLを実行
    
        $song_count = $stmt->fetchColumn(); // 結果を1つのカラムとして取得,fetchAllを使うより1行取得する場合はこっちの方が良いらしい
    
        if ($song_count == 0) {//バンド名が重複していない場合
            $sql = "INSERT INTO songs (song_name,composer) VALUES (:song_name,:composer)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダという、値を入れるための単なる空箱
            $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
            $params = array(':song_name' => $song_name, ':composer' => $composer); // 挿入する値を配列に格納する
            $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
        } else {
            echo "曲名が既に存在しているので追加しませんでした。";
        }


        //ライブid,bands_id,song_idの取得
        $sql = "SELECT band_id from bands where band_name = :band_name";
        $stmt = $pdo->prepare($sql);
        $params = array(':band_name' => $band_name);
        $stmt->execute($params); // SQLを実行
    
        $bandid_check = $stmt->fetchColumn();
        echo $bandid_check;


        $sql = "SELECT live_id from lives where live_name = :live_name";
        $stmt = $pdo->prepare($sql);
        $params = array(':live_name' => $live_name);
        $stmt->execute($params); // SQLを実行
    
        $liveid_check = $stmt->fetchColumn();
        echo $liveid_check;

        $sql = "SELECT song_id from songs where song_name = :song_name";
        $stmt = $pdo->prepare($sql);
        $params = array(':song_name' => $song_name);
        $stmt->execute($params); // SQLを実行
    
        $songid_check = $stmt->fetchColumn();
        echo $songid_check;


        $sql = "INSERT INTO live_bands (lives_id,bands_id,song_id,url) VALUES (:liveid_check,:bandid_check,:songid_check,:url)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダという、値を入れるための単なる空箱
        $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
        $params = array(':liveid_check' => $liveid_check, ':bandid_check' => $bandid_check,':songid_check' => $songid_check,':url' => $url); // 挿入する値を配列に格納する
        $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
    












        // echo "<p>name: " . $name . "</p>";
        // echo "<p>category: " . $category . "</p>";
        // echo "<p>description: " . $description . "</p>";
        // echo '<p>で登録しました。</p>'; // 登録完了のメッセージ
    



    } catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }

    ?>
</body>

</html>