<?php
/* 	Die Objektvariable für den DB-Zugriff wird in einer
	Include-Datei festgelegt. Ändern sich die Parameter für 
	den DB-Zugriff, muss dies nur an einer Stelle nachgetragen werden.
*/		

class Database {
	private $host = "localhost"; 
	private $db_name = "modul183ag"; 
	private $db_kundename = "vmadmin"; 
	private $db_passw = "Riethuesli>12345"; 
	private $connection; 
	
	public function getConnection() {
		$this->conn = null; 
		
		try { 
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->db_kundename, $this->db_passw); 
		} 
		catch (Exception $ex) {
		//	Keine Internas bekannt geben! Eine schlechte Lösung wäre folgende Zeile:
		//		echo "System-Fehlermeldung:", $ex->getMessage(), "<br>";
		//
		echo "Bitte melden Sie den Fehler 123 dem Betreiber. <br>";
		exit (123);
		} finally {
		// wird ausgeführt, egal, ob Exception eintrifft oder nicht.
			return $this->conn; 
		}
	}
	
}

?>