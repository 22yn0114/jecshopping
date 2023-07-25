<?php
require_once 'DAO.php';

class Goods
{
    public string $goodscode; //商品コード
    public string $goodsname; //商品名
    public int    $price; //価格
    public string $detail; //商品詳細
    public int $groupcode; //商品グループコード
    public bool $recommend; //おすすめフラグ
    public string $goodsimage; //商品画像
}

//Goodsテーブルアクセス用クラス
class goodsDAO
{
    //おすすめ商品を取得するメソッド
    public function get_recommend_goods()
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();
        //Goodsテーブルからおすすめ商品を取得する
        $sql = "SELECT *
        FROM Goods
        WHERE recommend = 1";

        $stmt = $dbh->prepare($sql);
        //SQLを実行
        $stmt->execute();
        //取得したデータを配列にする
        $data = [];
        while ($row = $stmt->fetchObject('Goods')) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_by_groupcode(int $groupcode)
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();

        $sql = "SELECT *
        FROM goods
        WHERE groupcode = :groupcode
        ORDER BY recommend DESC";

        $stmt = $dbh->prepare($sql);

        //SQLに変数の値をあてはめる
        $stmt->bindValue(':groupcode', $groupcode, PDO::PARAM_INT);


        $stmt->execute();

        //取得したデータをGoodsクラスに配列する
        $data = [];
        while ($row = $stmt->fetchObject('Goods')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_goods_by_goodscode(string $goodscode)
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM goods WHERE goodscode = :goodscode";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(":goodscode", $goodscode, PDO::PARAM_STR);

        $stmt->execute();

        $goods = $stmt->fetchObject('Goods');
        return $goods;
    }
    public function get_goods_by_keyword(string $keyword)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT goodscode,goodsname,price,detail,groupcode,recommend,goodsimage 
                FROM Goods 
                WHERE detail LIKE  :keyword OR goodsname LIKE :keyword2 ORDER BY recommend DESC";;

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(":keyword", "%" . $keyword . "%", PDO::PARAM_STR);

        $stmt->bindValue(":keyword2", "%" . $keyword . "%", PDO::PARAM_STR);

        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetchObject('Goods')) {
            $data[] = $row;
        }

        return $data;
    }
}
