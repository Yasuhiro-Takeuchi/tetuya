<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <title>カラフルWiki - 星友祭 2015</title>
    <style>
        :root {
            --primary-color: #FF1493;
            --secondary-color: #00BFFF;
            --accent-color: #FFD700;
            --text-color: #333;
            --bg-color: #F0F8FF;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Noto Sans JP', 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-link {
            color: white;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 5px 10px;
        }

        .nav-link:hover {
            text-shadow: 0 0 10px var(--accent-color);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            z-index: 1001;
        }

        .hamburger span {
            height: 3px;
            width: 25px;
            background: white;
            margin: 3px 0;
            display: block;
            transition: all 0.3s ease;
        }

        h1, h2 {
            color: var(--primary-color);
            text-align: center;
            margin: 2rem 0;
        }

        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .video-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .video-card:hover {
            transform: translateY(-5px);
        }

        .video-info {
            padding: 1rem;
        }

        .video-info h3 {
            color: var(--secondary-color);
            margin-top: 0;
        }

        .video-iframe {
            width: 100%;
            height: 200px;
        }

        .footer {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            color: white;
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        .footer p {
            margin: 0;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
                justify-content: center;
                align-items: center;
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .nav-links.active {
                display: flex;
                opacity: 1;
                visibility: visible;
            }

            .nav-link {
                font-size: 1.2rem;
                margin: 15px 0;
            }

            .hamburger.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            .hamburger.active span:nth-child(2) {
                opacity: 0;
            }

            .hamburger.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }

            .video-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a class="navbar-brand" href="#">カラフルWiki</a>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="nav-links">
                    <a class="nav-link" href="#">Home</a>
                    <a class="nav-link" href="#">LIVE</a>
                    <a class="nav-link" href="#">SONG</a>
                    <a class="nav-link" href="#">PEERS</a>
                    <a class="nav-link" href="#">BAND</a>
                    <a class="nav-link" href="#">LIBRARY</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>カラフルWiki</h1>
        <h2>星友祭 2015</h2>

        <div class="video-grid">
            <?php
            // データベース接続
            $dsn = 'mysql:host=localhost;dbname=xs262124_corfuldb';
            $db_username = 'xs262124_yasu';
            $db_password = 'pokopixgvp';

            try {
                $pdo = new PDO($dsn, $db_username, $db_password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // 投稿を取得
                $stmt = $pdo->query("SELECT bands.band_name, lives.live_name, live_bands.url, songs.song_name FROM live_bands 
                                    INNER JOIN bands ON live_bands.bands_id = bands.band_id 
                                    INNER JOIN lives ON live_bands.lives_id = lives.live_id 
                                    INNER JOIN songs ON live_bands.song_id = songs.song_id
                                    WHERE lives.live_id = 1");
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // URLからYouTubeの動画IDを抽出する関数
                function extractYoutubeID($url) {
                    preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/i", $url, $matches);
                    return $matches[1] ?? null;
                }

                // 投稿を表示
                foreach ($posts as $post) {
                    $youtube_id = extractYoutubeID($post['url']);
                    if ($youtube_id) {
                        echo "<div class='video-card'>";
                        echo "<iframe class='video-iframe' src='https://www.youtube.com/embed/" . htmlspecialchars($youtube_id, ENT_QUOTES, 'UTF-8') . "' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>";
                        echo "<div class='video-info'>";
                        echo "<h3>" . htmlspecialchars($post['band_name'], ENT_QUOTES, 'UTF-8') . "</h3>";
                        echo "<p>" . htmlspecialchars($post['song_name'], ENT_QUOTES, 'UTF-8') . "</p>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<div class='video-card'>";
                        echo "<div class='video-info'>";
                        echo "<h3>" . htmlspecialchars($post['band_name'], ENT_QUOTES, 'UTF-8') . "</h3>";
                        echo "<p>" . htmlspecialchars($post['song_name'], ENT_QUOTES, 'UTF-8') . "</p>";
                        echo "<p>無効なYouTube URLです</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            } catch (PDOException $e) {
                echo "<p>データベース接続に失敗しました: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 カラフルWiki. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            // メニューリンクをクリックしたらメニューを閉じる
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });
        });
    </script>
</body>

</html>