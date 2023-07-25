<?php
require_once "DAO.php";

//GoodsGroupテーブルのデータを保持するクラス
class GoodsGroup
{
    public int $groupcode;  //商品分類コード
    public string $groupname;   //商品分類名
}
//GoodsGrouupデーブルにアクセスするクラス
class GoodsGroupDAO
{

    public function get_goodsgroup()
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();
        //全商品グループを取得するSQL
        $sql = "SELECT * FROM GoodsGroup";
        $stmt = $dbh->prepare($sql);
        //SQL実行
        $stmt->execute();
        //取得したデータをGoodsGroupクラスの配列にする
        $data = [];
        while ($row = $stmt->fetchObject('GoodsGroup')) {
            $data[] = $row;
        }
        return $data;
    }
}
