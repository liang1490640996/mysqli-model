<?php 

include "config.inc.php";
include "model.class.php";

# 查询操作
/*$goods = M("goods");
$result = $goods->field("id,name")->where("id>1")->order("id desc")->select();*/

# 新增操作
/*$data = array("name" => "桃子","sku" => 1);
$goods = M("goods");
$result = $goods->insert($data);*/

# 更新操作
/*$data = array("name" => "桃子","sku" => 3);
$goods = M("goods");
$result = $goods->where("id=6")->update($data);*/

# 删除操作
/*$goods = M("goods");
$result = $goods->where("id=6")->delete();*/

# 汇总操作
$goods = M("goods");
$result = $goods->total();

echo '<pre>';
print_r($result);
echo '</pre>';die;

# 单条操作
/*$goods = M("goods");
$result = $goods->where("sku=2")->find();*/

/*echo '<pre>';
print_r($result);
echo '</pre>';die;*/

