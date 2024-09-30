<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>カラフル</title>
    <title>星友祭 2014</title>

    <style>
        /* カスタムスタイル: iframeをリサイズして横並びに配置しやすく */
        .video-iframe {
            width: 100%;
            height: 315px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>星友祭 2014</h2>
        <div class="row">
            <?php
            // データベース接続
            $dsn = 'mysql:host=localhost;dbname=xs262124_corfuldb';
            $db_username = 'xs262124_yasu';
            $db_password = 'pokopixgvp';

            try {
                $pdo = new PDO($dsn, $db_username, $db_password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // 投稿を取得
                $stmt = $pdo->query("SELECT bands.band_name,lives.live_name,url FROM live_bands INNER JOIN bands ON live_bands.bands_id = bands.band_id INNER JOIN lives ON live_bands.lives_id = lives.live_id WHERE lives.live_id = 3");
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


                // 投稿を表示
                $band_name = $_POST['band_name'];
                $live_name = $_POST['live_name,'];
                $url = $_POST['url'];

            } catch (PDOException $e) {
                echo "データベース接続に失敗しました: " . $e->getMessage();
            }
            ?>
        </div>
    </div>
</body>

</html>