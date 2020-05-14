<?php

# 数据库操作类
class Model{

	public $field;  //字段
	public $table;  //表名
	public $where;  //条件
	public $order;  //排序
	public $limit;  //条数
	public $link;   //链接数据库

	# 初始化
	function __construct($table){
		$conn = mysqli_connect(HOST, DB_NAME, DB_PASS, BASE_NAME);
		mysqli_set_charset($conn,"utf8");
		$this->table = $table;
		$this->link = $conn;
	}

	function __destruct(){
		mysqli_close($this->link);
	}

	/**
	 * 组合查询字段集
	 * @param $field 字段
	 */
	function field($field){
		$this->field = $field;
		return $this;
	}

	/**
	 * 组合查询条件
	 * @param $where sql条件
	 */
	function where($where){
		$this->where = "WHERE ".$where;
		return $this;
	}

	/**
	 * 组合排序
	 * @param $order sql排序
	 */
	function order($order){
		$this->order = "ORDER BY ".$order;
		return $this;
	}

	/**
	 * 组合查询条数
	 * @param $limit sql查询条数
	 */
	function limit($limit){
		$this->limit = "LIMIT ".$limit;
		return $this;
	}

	/**
	 * 执行sql查询单条操作
	 * @return row 返回单条数据
	 */
	function find(){

		$sql = "SELECT * FROM {$this->table} {$this->where} {$this->order} limit 1";
		$res = mysqli_query($this->link,$sql);
		$row = mysqli_fetch_assoc($res);

		return $row;
	}

	/**
	 * 执行sql查询汇总操作
	 * @return row 返回结果总数
	 */
	function total(){

		$sql = "SELECT count(*) FROM {$this->table}";
		$res = mysqli_query($this->link,$sql);
		$row = mysqli_fetch_row($res);

		return $row[0];
	}

	/**
	 * 执行sql查询操作
	 * @return rows 返回结果集
	 */
	function select($all=""){
		if($all){
			$sql = "SELECT * FROM {$this->table} ORDER BY id";
		} else {
			$sql = "SELECT {$this->field} FROM {$this->table} {$this->where} {$this->order} {$this->limit} ";
		}

		$res = mysqli_query($this->link,$sql);
		while ( $row = mysqli_fetch_assoc($res)) {
			$rows[] = $row;
		}

		return $rows;
	}

	/**
	 * 执行sql新增操作
	 * @param post 新增数据array
	 * @return id 返回 自增id
	 */
	function insert($post){

		# array数据格式转换
		foreach ($post as $key => $value) {
			$keys[] = $key;
			$values[] = "'".$value."'";
		}
		$keystr = join(",",$keys);
		$valuestr = join(",",$values);

		$sql = "INSERT INTO {$this->table}($keystr) VALUES($valuestr)";

		$res = mysqli_query($this->link,$sql);
		if($res) {
			return mysqli_insert_id($this->link);
		} else {
			return false;
		}
		
	}

	/**
	 * 执行sql更新操作
	 * @param post 更新数据array
	 * @return 1/0 返回 mysqli_affected_rows 获取上一个MySQL操作中受影响的行数
	 */
	function update($post){

		foreach ($post as $key => $value) {
			$update[] = "`".$key."`='".$value."'";
		}
		$updates = join(",",$update);

		$sql = "UPDATE {$this->table} SET $updates {$this->where}";

		$res = mysqli_query($this->link,$sql);
		if($res) {
			return mysqli_affected_rows($this->link);
		} else {
			return false;
		}
	}

	/**
	 * 执行sql删除操作
	 * @return 1/0 返回 获取上一个MySQL操作中受影响的行数
	 */
	function delete(){

		$sql = "DELETE FROM {$this->table} {$this->where}";

		$res = mysqli_query($this->link,$sql);
		if($res) {
			return mysqli_affected_rows($this->link);
		} else {
			return false;
		}
	}



}

// 工厂模式
function M($table){
	return new Model($table);
}

