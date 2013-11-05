<?php
	class Database {
		private $database, $username, $password, $pdo;
		
		function __construct() {
			$this->database = "socialAPI";
			$this->username = "berend";
			$this->password = "h4rrh4rr";
			try{
				$this->pdo = new PDO('mysql:host=localhost;dbname='.$this->database, $this->username, $this->password);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			}catch(PDOException $pdex){
				$error = "";
				$error .= '<pre>'; 
				$error .= 'Regelnummer: '.$pdex->getLine().'<br>'; 
				$error .= 'Bestand: '.$pdex->getFile().'<br>'; 
				$error .= 'Foutmelding: '.$pdex->getMessage().'<br>'; 
				$error .= '</pre>';
				return $error;
			}
		}
		
		public function doQuery($sql, $param){
			try{
				$stm = $this->pdo->prepare($sql);
				$stm->execute($param);
				$results = $stm->fetchAll(PDO::FETCH_CLASS);
				return $results;
			}
			catch(PDOException $e) 
			{ 
				echo '<pre>'; 
				echo 'Regelnummer: '.$e->getLine().'<br>'; 
				echo 'Bestand: '.$e->getFile().'<br>'; 
				echo 'Foutmelding: '.$e->getMessage().'<br>'; 
				echo '</pre>';
			}
		}
		
		public function rowCount($sql, $param){
			try{
				$stm = $this->pdo->prepare($sql);
				$stm->execute($param);
				$rows = $stm->rowCount();
				return $rows;
			} catch(PDOException $e){
				echo '<pre>'; 
				echo 'Regelnummer: '.$e->getLine().'<br>'; 
				echo 'Bestand: '.$e->getFile().'<br>'; 
				echo 'Foutmelding: '.$e->getMessage().'<br>'; 
				echo '</pre>';
			}
		}
		public function execQuery($sql, $parameters){
				
			try{
				$stm = $this->pdo->prepare($sql);
				$stm->execute($parameters);
				return true;
			}
			catch(PDOException $e) 
			{ 
				echo '<pre>'; 
				echo 'Regelnummer: '.$e->getLine().'<br>'; 
				echo 'Bestand: '.$e->getFile().'<br>'; 
				echo 'Foutmelding: '.$e->getMessage().'<br>'; 
				echo '</pre>'; 
			}
		}
		public function delQuery($sql){
			try{
				$this->pdo->exec($sql); 
			}
			catch(PDOException $e) 
			{ 
				echo '<pre>'; 
				echo 'Regelnummer: '.$e->getLine().'<br>'; 
				echo 'Bestand: '.$e->getFile().'<br>'; 
				echo 'Foutmelding: '.$e->getMessage().'<br>'; 
				echo '</pre>';
			}
		}
		
		public function getRows($sql) {
			try{
				$stm = $this->pdo->prepare($sql);
				$stm->execute();
				return $stm->rowCount();
			}
			catch(PDOException $e) 
			{ 
				echo '<pre>'; 
				echo 'Regelnummer: '.$e->getLine().'<br>'; 
				echo 'Bestand: '.$e->getFile().'<br>'; 
				echo 'Foutmelding: '.$e->getMessage().'<br>'; 
				echo '</pre>';
			}
		}
		public function getRowsParam($sql, $param) {
			try{
				$stm = $this->pdo->prepare($sql);
				$stm->execute($param);
				return $stm->rowCount();
			}
			catch(PDOException $e) 
			{ 
				echo '<pre>'; 
				echo 'Regelnummer: '.$e->getLine().'<br>'; 
				echo 'Bestand: '.$e->getFile().'<br>'; 
				echo 'Foutmelding: '.$e->getMessage().'<br>'; 
				echo '</pre>';
			}
		}
		
	}
?>
