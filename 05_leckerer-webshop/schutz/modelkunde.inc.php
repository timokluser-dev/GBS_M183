<?php
class Kunde {

	private $table_name = "kunde";

	// Die Klasse 'Kunde' verfügt über eine Methode 'connect', 
	// die den der Verweis auf den Datenbankzugriff enthält. 
	// Über diese Methode werden SQL-Befehle ausgeführt.
	public function __construct($db) {
		$this->connect = $db;	
	}	
	
	// Es wird nach einem Benutzer anhand des Inputs 'email' gesucht. 
	// Die Antwort gibt den gefundenen Benutzer mit 'email' zurück:
	public function getKundeByEmail($emailLoc) {
		$statement = $this->connect->prepare("SELECT email FROM $this->table_name WHERE email = :tmpemail");
		$result = $statement->execute(array('tmpemail' => $emailLoc));
		return $statement->fetch();
	}

	// Es wird nach einem Benutzer anhand des Inputs 'email' gesucht. 
	// Die Antwort gibt den gefundenen Benutzer mit 'email' und 'aclallaccounts' zurück:
	public function getEmailAndRightsByEmail($emailLoc) {
		$statement = $this->connect->prepare("SELECT email, aclallaccounts FROM $this->table_name WHERE email = :tmpemail");
		$result = $statement->execute(array('tmpemail' => $emailLoc));
		return $statement->fetch();
	}

	// Es wird nach einem Benutzer anhand des Inputs 'email' gesucht. 
	// Die Antwort gibt den gefundenen Benutzer mit 'id', 'email' und 'passw' zurück:
	public function getLoginInfoByEmail($emailLoc) {
		$statement = $this->connect->prepare("SELECT id, email, passw FROM $this->table_name WHERE email = :tmpemail");
		$result = $statement->execute(array('tmpemail' => $emailLoc));
		return $statement->fetch();
	}

	// Es wird nach einem Benutzer anhand des Inputs 'email' gesucht. 
	// Die Antwort gibt den gefundenen Benutzer mit 'email', 'vorname', 'nachname', 'created_at' und 'updated_at' zurück:
	public function getKundeInfoByEmail($emailLoc) {
			$statement = $this->connect->prepare("SELECT email, vorname, nachname, created_at, updated_at FROM $this->table_name WHERE email = :tmpemail");
			$result = $statement->execute(array('tmpemail' => $emailLoc));
			return $statement->fetch();
	}

	// Es wird nach allen Benutzer gesucht. 
	// Die Antwort gibt den gefundenen Benutzer mit 'email', 'vorname', 'nachname', 'created_at', 'updated_at' und 'aclallaccounts' zurück:
	public function getAllKunde() {
			$statement = $this->connect->prepare("SELECT email, vorname, nachname, created_at, updated_at, aclallaccounts FROM $this->table_name");
			$result = $statement->execute(array());
			$kundeArray = array();
			while($u = $statement->fetch()) {
				$kundeArray[] = $u;
			}
			return $kundeArray; 
	}

	// Es wird ein neuer Benutzer mit den Inputs eingetragen:
	// * 'email' 
	// * Das Passwort 'passw' wird nicht im Klartext eingetragen, sondern der Hashwert.
	// Die Antwort sagt, ob der Eintrag möglich war:
	public function changeKundePasswordByEmail($emailLoc, $newPasswordLoc) {
		$passw_hash = password_hash($newPasswordLoc, PASSWORD_DEFAULT);
		$statement = $this->connect->prepare("INSERT INTO $this->table_name (email, passw) VALUES (:tmpemail, :tmppassw)");
		$result = $statement->execute(array('tmpemail' => $emailLoc, 'tmppassw' => $passw_hash));
		return $result; 
	}
	
}

?>