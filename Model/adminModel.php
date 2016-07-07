<?php

include("../../View/cms_admin/LayoutLoginAdmin.php");
include("../../View/cms_admin/LayoutPanelAdmin.php");

/**
 * klasa modelu
 */
class AdminModel {


	public function __construct()
	{
      require('../../../../Configuration/config.php');
      require('../../Information/information.php');
	}


	public function sciezkaFiles()
	{
      $config = new Config;
             
      return $config->files;
	}		
	
	
	public function sciezkaFilesFtp()
	{
		$config = new Config;
		 
		return $config->filesFtp;
	}
	

	public function sciezkaFilesServer()
	{
      $config = new Config;
             
      return $config->filesServer;
	}
	

	public function pobierzGrupy()
	{
      $config = new Config;
      $info = new Information;
             
      $polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
      mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */                   
      mysql_query ("SET NAMES utf8");  
      
      $sql = "SELECT * FROM komponent_generator_tresci_grupy ORDER BY nazwaGrupy ASC;";
      
      $wynik=mysql_query($sql) or die(mysql_error());
      $i=0;
      while ($linia=mysql_fetch_array($wynik)) {
      	$tab[$i]['id']=$linia['id'];
      	$tab[$i]['nazwaGrupy']=$linia['nazwaGrupy'];
      	$i++;
      }        	

      mysql_close($polaczenie); 
      return $tab;
	}
		

	public function dodajGrupe()
	{
      $config = new Config;
      $info = new Information;
             
      $polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
      mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */                   
      mysql_query ("SET NAMES utf8");  
      
      $sql = "INSERT INTO komponent_generator_tresci_grupy (`id`, `nazwaGrupy`) VALUES ('', '');";
      $wynik=mysql_query($sql) or die(mysql_error());
            
      mysql_close($polaczenie);
	}
	
	
	public function skasujGrupe($id)
	{
      $config = new Config;
      $info = new Information;
             
      $polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
      mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */                   
      mysql_query ("SET NAMES utf8");  
      
      $sql = "DELETE FROM komponent_generator_tresci_grupy WHERE id ='$id'";
	  $wynik=mysql_query($sql) or die(mysql_error());    	        
      
      mysql_close($polaczenie);
	}
	
	
  public function aktualizujGrupy($id = null, $nazwa = null)
	{
	  $config = new Config;
      $info = new Information;
             
      $polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
      mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */                   
      mysql_query ("SET NAMES utf8");  
      
      $i=0;
      foreach ($id as $ids) {
      $sql = "UPDATE komponent_generator_tresci_grupy SET `nazwaGrupy` = '$nazwa[$i]' WHERE `id` = '$ids'";
	 	$wynik=mysql_query($sql) or die(mysql_error());
		$i++;
      }
      mysql_close($polaczenie);
	}
	
	
	public function pobierzPozycje($idGrupy = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT * FROM komponent_generator_tresci_pozycje WHERE `idGrupy`=$idGrupy ORDER BY id ASC;";
	
		$wynik=mysql_query($sql) or die(mysql_error());
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['id']=$linia['id'];
			$tab[$i]['tresc']=$linia['tresc'];
			$i++;
		}
	
		mysql_close($polaczenie);
		return $tab;
	}

	
	public function dodajPole($id = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "INSERT INTO komponent_generator_tresci_pozycje (`id`, `idGrupy`, `tresc`) VALUES ('', $id,'');";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function aktualizujPozycje($id = null, $tresc = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$i=0;
		foreach ($id as $ids) {
			$sql = "UPDATE komponent_generator_tresci_pozycje SET `tresc` = '$tresc[$i]' WHERE `id` = '$ids'";
			$wynik=mysql_query($sql) or die(mysql_error());
			$i++;
		}
		mysql_close($polaczenie);
	}
	
	
	public function skasujPozycje($id)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "DELETE FROM komponent_generator_tresci_pozycje WHERE id ='$id'";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function generuj()
	{	
		if ( (isset($_COOKIE['uzyj'])) AND ($_COOKIE['uzyj'] != 0) AND ($_COOKIE['uzyj'] != '0') AND ($_COOKIE['uzyj'] != null) ) {
			$tmp = explode("|", $_COOKIE['uzyj']);
			
			$odp = '';
			foreach ($tmp as $value) {
				$odp = $odp.'<br>'.$this->pobierzPojednyczyKod($value);
			}
		}
		
		return $odp;
	}
	
	
	public function pobierzPojednyczyKod($idPozycji = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT * FROM komponent_generator_tresci_pozycje WHERE `id`=$idPozycji;";
		$wynik=mysql_query($sql) or die();
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab=$linia['tresc'];
			$i++;
		}
	
		mysql_close($polaczenie);
		return $tab;
	}
	
	
	public function pobierzSzablon($id = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT * FROM komponent_generator_tresci_szablony WHERE `id`=$id;";
		$wynik=mysql_query($sql) or die(mysql_error());
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['id']=$linia['id'];
			$tab[$i]['html']=$linia['html'];
			$i++;
		}
	
		mysql_close($polaczenie);
		return $tab;
	}
	
	
	public function pobierzProduktyCrossSelling()
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT * FROM komponent_allegro_produkty ORDER BY id ASC;";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]=$linia;
			$i++;
		}
	
		mysql_close($polaczenie);
		 
		return $tab;
	}
	
	
	public function addCache($hash = null, $obszar = null, $html = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
		
		$sql = "SELECT obszar FROM komponent_generator_tresci_cache WHERE `hash` = '$hash';";
		$wynik=mysql_query($sql) or die(mysql_error());
		
		$pom = 0;
		while ($linia=mysql_fetch_array($wynik)) {
			if ($obszar == $linia['obszar']) {
				$pom = 1;
			}
		}
		
		if ($pom == 1) {
			$sqlUpdate = "UPDATE komponent_generator_tresci_cache SET `html` = '$html' WHERE `hash` = '$hash' AND `obszar` = '$obszar';";
			$wynikUpdate=mysql_query($sqlUpdate) or die(mysql_error());
		} elseif ($pom == 0) {
			$sqlInsert = "INSERT INTO komponent_generator_tresci_cache (`id`, `obszar`, `html`, `hash`) VALUES ('', '$obszar', '$html', '$hash');";
			$wynikInsert=mysql_query($sqlInsert) or die(mysql_error());
		}
	
		mysql_close($polaczenie);
			
		return $tab;
	}
	
	
	public function pobierzObszary($idSzablonu = null)
	{
		$config = new Config;
		$info = new Information;

		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT id, nazwaObszaru FROM komponent_generator_tresci_szablony_obszary WHERE `idSzablonu`=$idSzablonu;";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['id']=$linia['id'];
			$tab[$i]['nazwaObszaru']=$linia['nazwaObszaru'];
			$i++;
		}
	
		mysql_close($polaczenie);
			
		return $tab;
	}
	
	
	public function pobierzCache($hash = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT obszar, html FROM komponent_generator_tresci_cache WHERE `hash` = '$hash';";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['obszar']=$linia['obszar'];
			$tab[$i]['html']=$linia['html'];
			$i++;
		}
	
		mysql_close($polaczenie);
			
		return $tab;
	}
	
	
	public function eraseObszar($hash = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "DELETE FROM komponent_generator_tresci_cache WHERE hash ='$hash'";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function pobierzSzablony()
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT * FROM komponent_generator_tresci_szablony ORDER BY nazwaSzablonu ASC;";
	
		$wynik=mysql_query($sql) or die(mysql_error());
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['id']=$linia['id'];
			$tab[$i]['nazwaSzablonu']=$linia['nazwaSzablonu'];
			$tab[$i]['html']=$linia['html'];
			$i++;
		}
	
		mysql_close($polaczenie);
		return $tab;
	}
	
	
	public function skasujSzablony($id)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "DELETE FROM komponent_generator_tresci_szablony WHERE id ='$id'";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function aktualizujSzablony($id = null, $nazwa = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$i=0;
		foreach ($id as $ids) {
			$sql = "UPDATE komponent_generator_tresci_szablony SET `nazwaSzablonu` = '$nazwa[$i]' WHERE `id` = '$ids'";
			$wynik=mysql_query($sql) or die(mysql_error());
			$i++;
		}
		mysql_close($polaczenie);
	}
	
	
	public function dodajSzablon()
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "INSERT INTO komponent_generator_tresci_szablony (`id`) VALUES ('');";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function skasujObszary($id = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "DELETE FROM komponent_generator_tresci_szablony_obszary WHERE `id` =$id";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function aktualizujObszary($id = null, $nazwa = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$i=0;
		foreach ($id as $ids) {
			$sql = "UPDATE komponent_generator_tresci_szablony_obszary SET `nazwaObszaru` = '$nazwa[$i]' WHERE `id` = '$ids'";
			$wynik=mysql_query($sql) or die(mysql_error());
			$i++;
		}
		mysql_close($polaczenie);
	}
	
	
	public function dodajObszar($id = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "INSERT INTO komponent_generator_tresci_szablony_obszary (`id`, `idSzablonu`) VALUES ('', $id);";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	
	
	public function aktualizujSzablon($id = null, $html = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");

		$html = addslashes($html);
		
		$sql = "UPDATE komponent_generator_tresci_szablony SET `html` = '$html' WHERE `id` = $id;";
		$wynik=mysql_query($sql) or die(mysql_error());
			
		mysql_close($polaczenie);
	}
	
	
	public function pobierzDaneFtp($idRoot = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		if ( ($idRoot == '') OR ($idRoot == null) ) {
			$idRoot = 0;
		}
	
		$sql = "SELECT * FROM komponent_generator_tresci_ftp WHERE `idRoot`=$idRoot AND `typ`='dir' ORDER BY nazwa ASC;";
		$wynik=mysql_query($sql) or die(mysql_error());
		$i=0;
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['id']=$linia['id'];
			$tab[$i]['idRoot']=$linia['idRoot'];
			$tab[$i]['nazwa']=$linia['nazwa'];
			$tab[$i]['typ']=$linia['typ'];
			$i++;
		}
	
		$sql = "SELECT * FROM komponent_generator_tresci_ftp WHERE `idRoot`=$idRoot AND `typ`='file' ORDER BY nazwa ASC;";
		$wynik=mysql_query($sql) or die(mysql_error());
		while ($linia=mysql_fetch_array($wynik)) {
			$tab[$i]['id']=$linia['id'];
			$tab[$i]['idRoot']=$linia['idRoot'];
			$tab[$i]['nazwa']=$linia['nazwa'];
			$tab[$i]['typ']=$linia['typ'];
			$i++;
		}
		
		mysql_close($polaczenie);
		return $tab;
	}
	
	public function pobierzDanePomFtp($idRoot = null)
	{
		$config = new Config;
		$info = new Information;

		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
		
		if ( ($idRoot == '') OR ($idRoot == null) ) {
			$idRoot = 0;
		}
	
		$sql = "SELECT nazwa, idRoot FROM komponent_generator_tresci_ftp WHERE `id`=$idRoot;";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		$wynik=mysql_query($sql) or die(mysql_error());
		while ($linia=mysql_fetch_array($wynik)) {
			$tab['idRoot']=$linia['idRoot'];
			$tab['nazwa']=$linia['nazwa'];
		}
	
		return $tab;
	}
	
	
	public function pobierzPrevRoot($id = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT idRoot, nazwa FROM komponent_generator_tresci_ftp WHERE `id`=$id;";
	
		$wynik=mysql_query($sql) or die(mysql_error());
		while ($linia=mysql_fetch_array($wynik)) {
			$tab['idRoot']=$linia['idRoot'];
			$tab['nazwa']=$linia['nazwa'];
		}
	
		mysql_close($polaczenie);
		return $tab;
	}
	
	
	public function utworzKatalog($nazwa = null, $idRoot = null)
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");

		if ( ($idRoot == '') OR ($idRoot == null) ) {
			mkdir("../../../../Files/".$nazwa, 0755);
		} else {
			$tmpIdRoot = $idRoot;
			$path = '';
			
			while ($tmpIdRoot > 0) {
				$dir = $this->pobierzDanePomFtp($tmpIdRoot);

				$tmpIdRoot = $dir['idRoot'];
				
				$path = $dir['nazwa'].'/'.$path;
			}
			
			mkdir("../../../../Files/".$path.'/'.$nazwa, 0755);
		}
		
		$sql = "INSERT INTO komponent_generator_tresci_ftp (`id`, `idRoot`, `nazwa`, `typ`) VALUES ('', $idRoot, '$nazwa', 'dir');";		
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
		return $tab;
	}
	
	
	public function aktualizujFtp($id = null, $nazwa = null, $oldNazwa = null, $idRoot = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		
		if ( ($idRoot == '') OR ($idRoot == null) ) {
			rename("../../../../Files/".$oldNazwa, "../../../../Files/".$nazwa);
		} else {
			$tmpIdRoot = $idRoot;
			$path = '';
				
			while ($tmpIdRoot > 0) {
				$dir = $this->pobierzDanePomFtp($tmpIdRoot);
		
				$tmpIdRoot = $dir['idRoot'];
		
				$path = $dir['nazwa'].'/'.$path;
			}
				
			rename("../../../../Files/".$path.$oldNazwa, "../../../../Files/".$path.$nazwa);
		}
		
		$sql = "UPDATE komponent_generator_tresci_ftp SET `nazwa` = '$nazwa' WHERE `id` = '$id'";
		$wynik=mysql_query($sql) or die(mysql_error());
		
		mysql_close($polaczenie);
	}
	
	
	public function delete_folder($folder) {
		$glob = glob($folder);
	    foreach ($glob as $g) {
	        if (!is_dir($g)) {
	            unlink($g);
	        } else {
	            $this->delete_folder("$g/*");
	            rmdir($g);
	        }
	    }
	}
	
	
	public function skasujFtp($id)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "SELECT nazwa, idRoot FROM komponent_generator_tresci_ftp WHERE `id`=$id;";
		$wynik=mysql_query($sql) or die(mysql_error());
		$odp = mysql_fetch_array($wynik);

		$idRoot = $odp['idRoot'];
		
		$sql = "DELETE FROM komponent_generator_tresci_ftp WHERE id =$id";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		if ( ($idRoot == '') OR ($idRoot == null) OR ($idRoot == 0) OR ($idRoot == '0') ) {
			$this->delete_folder("../../../../Files/".$odp['nazwa']);
		} else {
			$tmpIdRoot = $idRoot;
			$path = '';
				
			while ($tmpIdRoot > 0) {
				$dir = $this->pobierzDanePomFtp($tmpIdRoot);

				$tmpIdRoot = $dir['idRoot'];
		
				$path = $dir['nazwa'].'/'.$path;
			}
			
			$this->delete_folder("../../../../Files/".$path.$odp['nazwa']);
		}
		
		$sql = "DELETE FROM komponent_generator_tresci_ftp WHERE idRoot =$id";
		$wynik=mysql_query($sql) or die(mysql_error());
		
		mysql_close($polaczenie);
	}
	
	
	public function dodajPlikDoFtp($nazwa = null, $idRoot = null)
	{
		$config = new Config;
		$info = new Information;
		 
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
	
		$sql = "INSERT INTO komponent_generator_tresci_ftp (`id`, `idRoot`, `nazwa`, `typ`) VALUES ('', $idRoot, '$nazwa', 'file');";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
	

	public function eraseCache()
	{
		$config = new Config;
		$info = new Information;
			
		$polaczenie = mysql_connect($config->sql_host,$config->sql_user,$config->sql_pass); /* Nawi�zanie po��czenia z baz� */
		mysql_select_db($config->sql_db_name,$polaczenie); /* Wybranie odpowiedniej bazy danych */
		mysql_query ("SET NAMES utf8");
		$sql = "TRUNCATE TABLE komponent_generator_tresci_cache;";
		$wynik=mysql_query($sql) or die(mysql_error());
	
		mysql_close($polaczenie);
	}
}

?>