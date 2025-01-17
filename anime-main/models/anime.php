<?php
class Anime extends Db
{
    public function getAllAnimes()
    {
        $sql = self::$connection->prepare("SELECT * FROM `anime` ORDER BY anime.id DESC");
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    public function getAllAnimesPaginate($page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT * FROM `anime` ORDER BY anime.id DESC  LIMIT ?,?");
        $sql->bind_param("ii", $start, $count);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    // public function getAnimeByID($idanime)
    // {
    //     $sql = self::$connection->prepare("SELECT * FROM `anime` WHERE `id` = ?");
    //     $sql->bind_param("i",$idanime);
    //     $sql->execute();
    //     $item = array();
    //     $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    //     return $item;
    // }
    public function getAllEpOfAnime($id_anime)
    {
        $sql = self::$connection->prepare("SELECT `episode`.*, `anime`.`name` FROM `episode`,`anime` WHERE anime.id = episode.id_anime AND episode.id_anime = ? ORDER BY tentap ASC");
        $sql->bind_param("i", $id_anime);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    public function search($keyword, $start, $count)
    {
        $sql = self::$connection->prepare("SELECT * FROM `items` 
        WHERE `content` LIKE ?
        LIMIT ?,?");
        $keyword = "%$keyword%";
        $sql->bind_param("sii", $keyword, $start, $count);
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
    public function searchCount($keyword)
    {
        $sql = self::$connection->prepare("SELECT * FROM `items` 
        WHERE `content` LIKE ?");
        $keyword = "%$keyword%";
        $sql->bind_param("s", $keyword);
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    }



    //Hàm in paginate theo cate Hy
    function paginateCate($url, $total, $count)
    {
        $totalLinks = ceil($total / $count);
        $link = "";
        for ($j = 1; $j <= $totalLinks; $j++) {
            $link = $link . "<a href='$url&page=$j'> $j</a>";
        }
        return $link;
    }

    //Hàm in paginate theo cate Hy
    function paginateIndex($url, $total, $count)
    {
        $totalLinks = ceil($total / $count);
        $link = "";
        for ($j = 1; $j <= $totalLinks; $j++) {
            $link = $link . "<a href='$url?page=$j'> $j</a>";
        }
        return $link;
    }



    //xử lý địa chỉ hình ảnh để nhúng vào web
    function proceedImg($url)
    {
        $idImg = substr($url, 32, 33);
        $newUrl = "https://drive.google.com/thumbnail?id=" . $idImg . "&sz=w10000";
        return $newUrl;
    }
    //xử lý địa chỉ video để nhúng vào web
    function proceedVideo($url)
    {
        $idvid = substr($url, 0, 66);
        $newUrl = $idvid . "preview";
        return $newUrl;
    }

    //lấy anime theo tag
    public function getAnimeByTag($idTag)
    {
        $sql = self::$connection->prepare("SELECT *,tag.name_tag 
                                        FROM anime,anime_tag,tag 
                                        WHERE anime_tag.id_tag = ? AND anime.id = anime_tag.id_anime AND tag.id_tag = anime_tag.id_tag;");
        $sql->bind_param("i", $idTag);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
    public function getAnimeByTagRecentAdd($idTag, $page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT *,tag.name_tag 
                                        FROM anime,anime_tag,tag 
                                        WHERE anime_tag.id_tag = ? AND anime.id = anime_tag.id_anime AND tag.id_tag = anime_tag.id_tag
                                        ORDER BY anime.id
                                        LIMIT ?,?;");
        $sql->bind_param("iii", $idTag, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
    public function getAnimeByTagAZ($idTag, $page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT *,tag.name_tag 
        FROM anime,anime_tag,tag 
        WHERE anime_tag.id_tag = ? AND anime.id = anime_tag.id_anime AND tag.id_tag = anime_tag.id_tag 
        ORDER BY anime.name ASC
        LIMIT ?,? ;");
        $sql->bind_param("iii", $idTag, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }

    public function getAnimeByTagZA($idTag, $page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT *,tag.name_tag 
        FROM anime,anime_tag,tag 
        WHERE anime_tag.id_tag = ? AND anime.id = anime_tag.id_anime AND tag.id_tag = anime_tag.id_tag 
        ORDER BY anime.name DESC
        LIMIT ?,? ;");
        $sql->bind_param("iii", $idTag, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }

    public function getAnime($page, $count)
    {
        // Tính số thứ tự trang bắt đầu 
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT * FROM `anime`ORDER BY `id` DESC LIMIT ?,?");
        $sql->bind_param("ii", $start, $count);
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
    public function getAnimeById($id)
    {
        $sql = self::$connection->prepare("SELECT * FROM `anime` ORDER BY `id` DESC  LIMIT ?;");
        $sql->bind_param("i", $id);
        $sql->execute(); //thuc thi 
        $items = array(); //tra ve du lieu
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
    //lấy anime theo tag
    public function getAnimeBySearch($key)
    {
        $key = "%$key%";
        $sql = self::$connection->prepare("SELECT *
                                        FROM anime
                                        WHERE anime.name LIKE ?;");
        $sql->bind_param("s", $key);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
    public function getSearchAnimeByTagRecentAdd($key, $page, $count)
    {
        $start = ($page - 1) * $count;
        $key = "%$key%";
        $sql = self::$connection->prepare("SELECT *
                                        FROM anime
                                        WHERE anime.name LIKE ?
                                        ORDER BY anime.id
                                        LIMIT ?,?;");
        $sql->bind_param("sii", $key, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
    public function getSearchAnimeByTagAZ($key, $page, $count)
    {
        $start = ($page - 1) * $count;
        $key = "%$key%";
        $sql = self::$connection->prepare("SELECT *
        FROM anime
        WHERE anime.name LIKE ?
        ORDER BY anime.name ASC
        LIMIT ?,? ;");
        $sql->bind_param("sii", $key, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }

    public function getSearchAnimeByTagZA($key, $page, $count)
    {
        $start = ($page - 1) * $count;
        $key = "%$key%";
        $sql = self::$connection->prepare("SELECT *
        FROM anime
        WHERE anime.name LIKE ?
        ORDER BY anime.name DESC
        LIMIT ?,? ;");
        $sql->bind_param("sii", $key, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
    function paginateAnime($url, $total, $count)
    {
        $totalLinks = ceil($total / $count);
        $link = "";
        for ($j = 1; $j <= $totalLinks; $j++) {
            $link = $link . "<a class='btn btn-sm btn-outline-secondary m-1' href='$url&page=$j'> $j </a>";
        }
        return $link;
    }

function getAnimeByFollow($idUser){
        
        $sql = self::$connection->prepare("SELECT *,anime.* FROM `follow`,anime WHERE follow.user_id = ? AND follow.anime_id = anime.id;");
        $sql->bind_param("i", $idUser);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
}

    public function getFollowAnimeByTagRecentAdd($idUser, $page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT *,anime.* FROM `follow`,anime WHERE follow.user_id = ? AND follow.anime_id = anime.id
                                        ORDER BY anime.id
                                        LIMIT ?,?;");
        $sql->bind_param("iii", $idUser, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
    public function getFollowAnimeByTagAZ($idUser, $page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT *,anime.* FROM `follow`,anime WHERE follow.user_id = ? AND follow.anime_id = anime.id
        ORDER BY anime.name ASC
        LIMIT ?,? ;");
        $sql->bind_param("sii", $idUser, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }

    public function getFollowAnimeByTagZA($idUser, $page, $count)
    {
        $start = ($page - 1) * $count;
        $sql = self::$connection->prepare("SELECT *,anime.* FROM `follow`,anime WHERE follow.user_id = ? AND follow.anime_id = anime.id
        ORDER BY anime.name DESC
        LIMIT ?,? ;");
        $sql->bind_param("iii", $idUser, $start, $count);
        $sql->execute();
        $animes = array();
        $animes = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $animes;
    }
}
