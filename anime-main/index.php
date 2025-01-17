<?php
session_start();
?>
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
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    include "header.php";
    ?>
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <?php $getidAnime = $anime->getAnimeById(3);
                foreach ($getidAnime as $key => $value):
                    $getTag = $animetag->getTag($value['id']);
                ?>
                    <div onclick="goToAnimeDetail('<?php echo $value['id'] ?>')" class="hero__items set-bg"
                        data-setbg="<?php echo proceedUrl($value['thumbnail']); ?>">
                        <div id="move_detail" class="row">
                            <div class="col-lg-6">
                                <div class="hero__text">
                                    <div class="label">Adventure</div>
                                    <h2><?php echo $value['name']; ?></h2>
                                    <p>
                                    <p><?php echo substr($value['descrip'], 0, 50); ?></p>
                                    </p>
                                    <a href="anime-watching.php?id=<?php echo $value["id"]; ?>"><span>Watch Now</span> <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Recently Added Shows</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $count = 12;
                            $page = 1;
                            $total = count($anime->getAllAnimes());
                            if (isset($_GET["page"])) {
                                $page = $_GET["page"];
                            }

                            $getAllAnime = $anime->getAllAnimesPaginate($page, $count);  // Gọi phương thức với tham số limit và start

                            // Kiểm tra nếu có dữ liệu
                            foreach ($getAllAnime as $key => $value):
                                $getTag = $animetag->getTag($value['id']);
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="<?php echo proceedUrl($value['thumbnail']); ?>">
                                            <div class="ep"><?php echo $value['so_tap']; ?> tập</div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                <?php foreach ($getTag as $keyTag => $valueTag): ?>
                                                    <li><?php echo $valueTag['name_tag']; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <h5><a href="anime-details.php?id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>



                    <div class="product__pagination">
                        <?php


                        // lấy đường dẫn đến file hiện hành
                        $url = $_SERVER['PHP_SELF'];
                        echo $anime->paginateIndex($url, $total, $count); ?>

                        <!-- <a href="#"><i class="fa fa-angle-double-right"></i></a> -->
                        <?php //endif; 
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">


                        <div class="product__sidebar__comment">
                            <div class="section-title">
                                <h5>New Comment</h5>
                            </div>

                            <?php
                            $listAnimeNewComment = $comment->getAnimeByNewComment();
                            foreach ($listAnimeNewComment as $keyAnime => $valueAnime):

                            ?>
                                <div class="product__sidebar__comment__item">
                                    <div class="product__sidebar__comment__item__pic">
                                        <img src="<?php echo proceedComment($valueAnime['thumbnail']); ?>" alt="">
                                    </div>
                                    <div class="product__sidebar__comment__item__text">
                                        <ul>
                                            <?php foreach ($animetag->getTag($valueAnime['id']) as $keyAnimeTag => $valueAnimeTag): ?>
                                                <li><?php echo $valueAnimeTag['name_tag']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <h5><a href="anime-details.php?id=<?php echo $valueAnime['id']; ?>"><?php echo $valueAnime['name']; ?></a></h5>
                                        <span>Review : <?php echo $valueAnime['comment']; ?></span>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Product Section End -->

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
                        </script> All rights reserved | This template is made with <i class="fa fa-heart"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
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
        function goToAnimeDetail(animeSlug) {
            // Sử dụng tham số truyền vào
            window.location.href = 'anime-details.php?id=' + animeSlug;
            //window.location.href = 'anime-details.php'
        }
        /*document.getElementById('move_detail').addEventListener('click', function () {
            window.location.href = 'anime-details';
        });*/
    </script>

</body>

</html>