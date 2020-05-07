<?php
	class Connection {
		# vars
		private $mysqli;

		# constructor
		function __construct($host = HOST, $user = USER, $password = PASSWORD, $database = DATABASE) {
			# connect to database or have the value of a error
			$this->mysqli = new mysqli($host, $user, $password, $database) or die(mysqli_error());
		}

		# closer
		function close() {
			$this->mysqli->close();
		}

		# functions
		# query functions
		function select($from, $which = '*', $where = null) {
			return ($where != null) ? $this->mysqli->query("SELECT $which FROM $from WHERE $where;") : $this->mysqli->query("SELECT $which FROM $from");
		}

		function count($from, $what, $where = null) {
			return ($where != null) ? $this->mysqli->query("SELECT COUNT($what) FROM $from WHERE $where;") : $this->mysqli->query("SELECT COUNT($what) FROM $from");
		}

		function insert($table, $what, $values) {
			$this->mysqli->query("INSERT INTO $table ($what) VALUES ($values);");
		}
		# mysqli functions
		function nextResult($result) {
			return (gettype($result) != 'boolean') ? $result->fetch_assoc() : false;
		}
		
		function numRows($result) {
			return (gettype($result) != 'boolean') ? mysqli_num_rows($result) : false;
		}

		function prevent($value) {
			# to no prevent SQL injection
			return mysqli_escape_string($this->mysqli, $value);
		}

		function affectedRows() {
			return mysqli_affected_rows($this->mysqli);
		}
	}
?>