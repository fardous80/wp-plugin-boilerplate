<?php 

namespace App\Database;

class QueryBuilder{

	protected $db = null;

	protected $table = null;

	protected $data = [];

	protected $condition = null;

	protected $values = [];

	protected $fields = ['*'];

	protected $model = null;

	protected $order_by = '';

	protected $limit = null;

	protected $page = 1;

	protected $sql = null;

	protected $total = 0;

	protected $items = [];

	protected $has_relation = false;

	protected $relations = [];


	public function __construct()
	{

		global $wpdb;
	
		$this->db = $wpdb;
	
	}

	public function table($table)
	{
	
		$this->table = $table;

		return $this;
	
	}

	public function getTable()
	{
	
		return $this->table;
	
	}

	public function model($model)
	{
	
		$this->model = $model;

		return $this;
	
	}

	public function limit($limit)
	{
	
		$this->limit = $limit;

		return $this;
	
	}

	public function getLimit()
	{

		$offset = ($this->page()-1) * $this->limit;

		if($this->limit)
			return "limit $offset, " . $this->limit;

		return '';
	
	}

	public function page(){
		$this->page = _sf_get_int('page', 1);

		return $this->page;
	}

	public function query($query, $data=[])
	{
		//dd($query);

		$sql = $this->db->prepare( $query );

		$sql->execute($data);

		$this->sql = $sql;

		return $this;
	
	}


	public function prepare()
	{
	
		$query = "select " . $this->getFields() . " from " . $this->table . ' '. $this->getCondition() . ' ' . $this->order_by . ' ' . $this->getLimit();

		dump($query);

		dump($this->values);

		try{

			//$result = $this->db->get_results( $this->db->prepare( $query, $this->values ) );

			global $wpdb;

			$result = $wpdb->get_results( $wpdb->prepare( "select * from wp_postmeta where meta_key=%s AND post_id in(%d,%d,%d,%d,%d)", $this->values ) );


			var_dump($result);

			die();


		}catch(\PDOException $ex){

			die($ex->getMessage());
		}
	}

	public function setCount()
	{
		$primary_key = $this->model->primaryKey();

		$query = "select count($primary_key) from " . $this->table . ' '. $this->getCondition();


		try{

			$sql = $this->db->prepare( $query );

			$sql->execute($this->values);

		}catch(\PDOException $ex){

			_o($ex->getMessage());
		}

		$this->total = $sql->fetchColumn();
	
	}

	public function paginate($limit)
	{
	
		$this->limit = $limit;

		$this->setCount();

		$this->items = $this->rows();

		return $this;
	
	}

	public function items()
	{
	
		return $this->items;
	
	}

	public function total()
	{
	
		return $this->total;
	
	}

	public function with($relation)
	{
	
		$this->has_relation = true;

		$this->relations[] = $relation;

		return $this;
	
	}

	public function getRelations($result)
	{
	
		foreach($this->relations as $relation)

			$this->mapRelation($result, $relation);
	
	}

	public function mapRelation($result, $relation)
	{
	
		$class = 'App\\' . ucfirst($relation);

		$relation_class = new $class;


		if(is_object($result)):

			$relation_id = $result->getRelationId($relation);

			$row = $class::where($relation_id, $result->$relation_id)->row();

			$result->{$relation} = $row;

			return $result;

		endif;

		$relation_id = $result[0]->getRelationId($relation);

		$ids = array_map(function($r) use($relation_id){

			return $r->{$relation_id};

		}, $result);

		$rows = $class::whereIn($relation_id, $ids)->get();

		$rel = [];

		foreach($rows as $row)
			$rel[$row->$relation_id] = $row;

		foreach($result as $r)
			$r->{$relation} = $rel[$r->$relation_id];	
	}

	public function get()
	{

		$result = $this->prepare();

		return $result;
	}

	public function row()
	{
	
		if(!$this->sql)
			$this->prepare();

		$result = $this->sql->fetch();

		if($this->has_relation)
			$this->getRelations($result);

		return $result;
	
	}

	public function rows()
	{
		if(!$this->sql)
			$this->prepare();

		$result = $this->sql->fetchAll();

		if($this->has_relation)
			$this->getRelations($result);

		return $result;
	
	}

	public function select($fields=['*'])
	{
	
		if(is_string($fields))
			$fields = [$fields];

		$this->arrayToFields($fields);

		return $this;
	
	}

	public function all()
	{
	
		return $this->rows();
	
	}

	public function find()
	{
		if(func_num_args() > 1)
			return $this->where(func_get_arg(0), func_get_arg(1))->row();
	
		return $this->where('id', func_get_arg(0))->row();
	
	}


	public function create($data)
	{
	
		$fields = $this->arrayToFields($data);

		$values = $this->arrayToValues($data);

		$query = " insert ignore into $this->table ($fields) values ($values) ";

		$this->db->prepare($query)->execute($data);

		return $this->db->lastInsertId();
	
	}

	public function update($data)
	{
	
		$field = '';

		foreach($data as $k=>$v):
			$field .= $k . '=:' . $k . ',';
			$this->values[$k] = $v;
		endforeach;

		$field = rtrim($field, ',');

		$query = "update $this->table set $field " . $this->getCondition();

		$this->db->prepare($query)->execute($this->values);
	
	}

	public function remove()
	{
	
		$this->query("delete from $this->table " . $this->getCondition(), $this->values);
	
	}

	public function first()
	{
	
		$result = $this->row();

		return $result;
	}

	

	public function where($key, $value)
	{

		if($value===null):
			$this->setCondition($key . ' is null');
			return $this;
		endif;

		$type = is_int($value) ? '%d' : '%s';

		
		//key=:key
		$condition = $key . '=' . $type;

		$this->setCondition($condition);

		// storing values
		array_push($this->values, $value);

		return $this;
	
	}

	public function whereRaw($q) {
		
		$this->setCondition($q);

		return $this;
	
	}

	public function whereIn($key, $values)
	{
	
		// create placeholder %s based on the length of $values array

		$placeholders = [];

		array_walk($values, function(&$value) use (&$placeholders) {

			array_push($this->values, $value);

			$placeholder = is_int($value) ?  '%d' :  '%s';

			array_push($placeholders, $placeholder);

		});

		$keys = implode(',', $placeholders);

		$this->setCondition("$key in($keys)");

		return $this;
	
	}

	public function whereLike($field, $keys)
	{
	
		$ekeys = explode(' ', $keys);

		$condition = '';

		$total_words = count($ekeys);

		if($total_words==1){

			$condition = $field . ' like :' . $this->format_field($field);

			$this->setCondition($condition);

			$this->values[$this->format_field($field)] = '%' . $keys . '%';

			return $this;

		}

		for($i=0; $i<count($ekeys); $i++):

			$condition .= $field . ' like :' . $this->format_field($field).$i . '' . ($i<$total_words-1?' AND ':' ');

			$this->values[$this->format_field($field).$i] = '%' . $ekeys[$i] . '%';

		endfor;

		$this->setCondition($condition);

		return $this;
	
	}

	public function orderBy($name, $order='asc')
	{
	
		if(empty($this->order_by))
			$this->order_by = 'order by ' . $name . ' ' . $order;
		else
			$this->order_by .= ', ' . $name . ' ' . $order; 

		return $this;
	
	}

	public function setCondition($condition, $type='AND')
	{
		if($this->condition)
			$this->condition .= ' ' . $type . ' ' . $condition;	
		else
			$this->condition .= $condition;
	}

	public function getCondition()
	{
		if($this->condition)
			return 'where ' . $this->condition;

		return '';
	
	}

	public function getValues()
	{
	
		return $this->values;
	
	}

	public function getOrder()
	{
	
		return $this->order_by;
	
	}

	public function getFields()
	{
	
		return implode(',', $this->fields);
	
	}

	public function setValues($value)
	{
		if(is_array($value))
			foreach($value as $v)
				array_push($this->values, $v);
		else
			array_push($this->values, $value);
	
	}



	public function arrayToFields($array)
	{
	
		return implode(',', array_keys($array));
	
	}

	public function arrayToValues($array)
	{
	
		return ':'.implode(',:', array_keys($array));
	
	}

	public function format_field($field)
	{
	
		return str_replace('.', '_', $field);
	
	}

}