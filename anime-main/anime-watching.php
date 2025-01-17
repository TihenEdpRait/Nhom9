<?php
session_start();?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anime | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        .video-container {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .video-placeholder {
            width: 100%;
            height: 360px;
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
        }
    </style>

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    include 'header.php';
    $idAnime = 1;
    $episode = 1;
    if (isset($_GET['id'])) {
        $idAnime = $_GET['id'];
    }
    if (isset($_GET['episode'])) {
        $episode = $_GET['episode'];
    }

    foreach ($epi->getUrl($idAnime, $episode) as $key => $value) {
        $urlVideo = proceedVideo($value['id']);
    }

    $getListEpisode = $epi->getEpisode($idAnime);
    //var_dump($idAnime);

    $getAllAnime = $anime->getAllAnimes();
    //var_dump($getListEpisode);


    //nếu anime chưa có tập nào thì in ra thông báo
    if (empty($getListEpisode)):
    ?>

        <div class="video-container">
            <div class="video-placeholder">
                Hiện phim chưa có tập nào xin vui lòng đợi cập nhật
            </div>
        </div>

        <?php else:
        foreach ($getAllAnime as $key => $value):
            if ($idAnime == $value['id']):
        ?>

                <!-- Breadcrumb Begin -->
                <div class="breadcrumb-option">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="breadcrumb__links">
                                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                                    <a href="./categories.php">Categories</a>
                                    <a href="#">Romance</a>
                                    <span><?php echo $value['name']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Breadcrumb End -->

                <!-- Anime Section Begin -->
                <section class="anime-details spad">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="anime__video__player">
                                    <div class="iframe-container">
                                        <iframe id="ifrvideo" width="640" height="360" allow="autoplay" allowfullscreen="true"></iframe>
                                    </div>

                                </div>
                                <div class="anime__details__episodes">
                                    <div class="section-title">
                                        <h5>List Name</h5>
                                    </div>

                                    <?php

                                    foreach ($getListEpisode as $episo => $valueEpi):
                                    ?>

                                        <a href="anime-watching.php?id=<?php echo $idAnime; ?>&episode=<?php echo $valueEpi['tentap']; ?>">Tập <?php echo $valueEpi['tentap']; ?></a>

                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                    
                    <?php
            endif;
            endforeach;
                    ?>
                            </div>
                        </div>


                        <!-- review anime -->
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="anime__details__form">
                                    <div class="section-title">
                                        <h5>Your Comment</h5>
                                    </div>
                                    <form action="add-comment.php" method="POST">
                                        <textarea name="comment" placeholder="Your Comment"></textarea>
                                        <input type="hidden" name="id_anime" value="<?php echo $idAnime; ?>">
                                        <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                                    </form>
                                </div>
                                <br>
                                <div class="anime__details__review">
                                    <div class="section-title">
                                        <h5>Reviews</h5>
                                    </div>
                                    <?php
                                    $listReviews = $comment->getAllReviewByIdAnime($idAnime);
                                    foreach ($listReviews as $key => $value):
                                    ?>
                                        <div class="anime__review__item">
                                            <div class="anime__review__item__pic">
                                                <img src="<?php echo proceedAvarta($value["image"]); ?>" alt="">
                                            </div>
                                            <div class="anime__review__item__text">
                                                <h6><?php echo $value["displayname"]; ?> - <span><?php echo $value["created_at"]; ?></span></h6>
                                                <p><?php echo $value["comment"]; ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </section>
                <!-- Anime Section End -->
<?php 
endif;
?>
                <!-- Footer Section Begin -->
                <footer class="footer">
                    <div class="page-up">
                        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="footer__logo">
                                    <a href="./index.php"><img src="img/logo.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="footer__nav">
                                    <ul>
                                        <li class="active"><a href="./index.php">Homepage</a></li>
                                        <li><a href="./categories.php">Categories</a></li>
                                        <li><a href="./blog.php">Our Blog</a></li>
                                        <li><a href="#">Contacts</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script> All rights reserved | This template
                                    is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                        target="_blank">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </p>

                            </div>
                        </div>
                    </div>
                </footer>
                <!-- Footer Section End -->

                <!-- Search model Begin -->
                <div class="search-model">
                    <div class="h-100 d-flex align-items-center justify-content-center">
                        <div class="search-close-switch"><i class="icon_close"></i></div>
                        <form class="search-model-form" action="result.php" method="get">
                            <input name="search" type="text" id="search-input" placeholder="Search here.....">
                        </form>
                    </div>
                </div>
                <!-- Search model end -->

                <!-- Js Plugins -->
                <script src="js/jquery-3.3.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/player.js"></script>
                <script src="js/jquery.nice-select.min.js"></script>
                <script src="js/mixitup.min.js"></script>
                <script src="js/jquery.slicknav.js"></script>
                <script src="js/owl.carousel.min.js"></script>
                <script src="js/main.js"></script>
                <script>
                    window.onload = function() {
                        // Đợi trang web đã tải xong, sau đó gán src cho iframe
                        var iframe = document.getElementById("ifrvideo");
                        iframe.src = "<?php echo addslashes($urlVideo); ?>"; // Thay đổi URL theo nhu cầu của bạn
                    }
                </script>
</body>

</html>