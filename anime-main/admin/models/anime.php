<?php
class Anime extends Db
{
    public function getAllAnime()
    {
        $sql = self::$connection->prepare("SELECT * FROM `anime`");
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    public function animeSearchName($keyword,$page,$count)
    {
        $keyword = "%$keyword%";
        $start = ($page - 1)* $count;
        $sql = self::$connection->prepare("SELECT * FROM `anime` WHERE `name` LIKE ? LIMIT ?,?");
        $sql->bind_param("sii",$keyword,$start,$count);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    public function getAnimeLimit($page,$count)
    {
        $start = ($page - 1)*$count;
        $sql = self::$connection->prepare("SELECT * FROM `anime` LIMIT ?,?");
        $sql->bind_param("ii",$start,$count);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    public function sechcount($keyword)
    {
        $keyword = "%$keyword%";
        $sql = self::$connection->prepare("SELECT * FROM `anime` WHERE `name` LIKE ?");
        $sql->bind_param("s",$keyword);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return count($item);
    }
    function paginateItem($url, $total, $count)
    {
        $totalLinks = ceil($total / $count);
        $link = "";
        for ($j = 1; $j <= $totalLinks; $j++) {
            $link = $link . "<li><a href='$url?page=$j'> $j</a></li>";
        }
        return $link;
    }
    public function updateAnime($name,$author,$studio,$descrip,$thumbnail,$so_tap,$idanime)
    {
        $sql = self::$connection->prepare("UPDATE `anime` SET `name`=?,`author`=?,`studio`=?,`descrip`=?,`thumbnail`=?,`so_tap`=? WHERE `anime`.`id` = ?");
        $sql->bind_param("ssssssi",$name,$author,$studio,$descrip,$thumbnail,$so_tap,$idanime);
        
        if($sql->execute()){
            return true;
        }
        return false;
    }
    public function deleteEpAnime($idanime,$tentap)
    {
        $sql = self::$connection->prepare("DELETE FROM `episode` WHERE `id_anime` = ? AND `tentap` = ?");
        $sql->bind_param("ii",$idanime,$tentap);
        if($sql->execute()){
            return true;
        }
        return false;
    }
    public function deleteAnime($idanime)
    {
        $sql = self::$connection->prepare("DELETE `anime`,`episode`,`anime_tag`,`comment` FROM `anime`,`episode`,`anime_tag`,`comment` WHERE `anime`.`id` = `episode`.`id_anime` AND `anime_tag`.`id_anime` = `anime`.`id` AND `anime`.`id` = `comment`.`id_anime` AND `anime`.`id` = ?");
        $sql->bind_param("i",$idanime);
        if($sql->execute()){
            return true;
        }
        return false;
    }
    public function addEpAnime($idanime,$tentap,$link)
    {
        $sql = self::$connection->prepare("INSERT INTO `episode`(`id_anime`, `tentap`, `id`) VALUES (?,?,?)");
        $sql->bind_param("iis",$idanime,$tentap,$link);
        
        if($sql->execute()){
            return true;
        }
        return false;
    }
    public function addAnime($name,$author,$studio,$descr,$thumbnail,$so_tap=0)
    {
        $sql = self::$connection->prepare("INSERT INTO `anime`(`id`, `name`, `author`, `studio`, `descrip`, `thumbnail`, `so_tap`) VALUES ('',?,?,?,?,?,?)");
        $sql->bind_param("sssssi",$name,$author,$studio,$descr,$thumbnail,$so_tap);
        
        if($sql->execute()){
            return true;
        }
        return false;
    }
    public function getAnimeByID($idanime)
    {
        $sql = self::$connection->prepare("SELECT * FROM `anime` WHERE `id` = ?");
        $sql->bind_param("i",$idanime);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
    public function getAllEpOfAnime($id_anime)
    {
        $sql = self::$connection->prepare("SELECT `episode`.*, `anime`.`name` FROM `episode`,`anime` WHERE anime.id = episode.id_anime AND episode.id_anime = ? ORDER BY tentap ASC");
        $sql->bind_param("i",$id_anime);
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

    public function updateEpAnime($id_anime,$tentap,$link)
    {
        $sql = self::$connection->prepare("UPDATE `episode` SET `id`= ? WHERE `id_anime`= ? AND `tentap` = ?");
        $sql->bind_param("sii",$link,$id_anime,$tentap);
        $sql->execute();
    }

    function paginate($url, $total, $count)
    {
        $totalLinks = ceil($total / $count);
        $link = "";
        for ($j = 1; $j <= $totalLinks; $j++) {
            $link = $link . "<a class='btn btn-sm btn-outline-secondary m-1' href='$url&page=$j'> $j </a>";
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
function proceedVideo($url){
    $idvid = substr($url,0, 66);
    $newUrl = $idvid . "preview";
    return $newUrl;
}
}
