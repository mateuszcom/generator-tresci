<?php

include("Model/adminModel.php");
include("../../../../api/Model/AppModel.php");

/**
 * klasa kontrolera
 * obsługuje model oraz uruchamia widok
 */
 
class Admin {
 
	public function __construct()
	{
		session_start();

		$this->uruchomModel();
		
		/* WYGENEROWANIE HASH*/
		if (!isset($_COOKIE['hash'])) {
			setcookie("hash", md5(microtime()));
		}
		/**/
		
		$odp = $this->AppModel->pobierzDaneAdmina();
    	$odp=mysql_fetch_array($odp);

	    $this->tmpZalogowanyAdmin = 'zalogowany||'.$odp['username'].'||'.$odp['pass'];


		if ($this->AppModel->pobierzHaslo($_SESSION['login']) == $_SESSION['pass']) {
       	 $this->tmpZalogowany = 'zalogowany||'.$_SESSION['login'].'||'.$_SESSION['pass'];
		} else {
       	 $this->tmpZalogowany = 'wylogowany';
		}
		

    if (isset($_GET['dodajGrupe'])) {
        $this->dodajGrupe();        
    } elseif (isset($_GET['edytujGrupe'])) {
        $this->edytujGrupe($_GET['edytujGrupe']);
    } elseif (isset($_GET['ajax'])) {
        $this->ajax();
    } elseif (isset($_GET['dodajPole'])) {
        $this->dodajPole($_GET['dodajPole']);
    } elseif (isset($_GET['generuj'])) {
        $this->generuj();
    } elseif (isset($_GET['dodajDoSzablonu'])) {
        $this->dodajDoSzablonu();
    } elseif (isset($_GET['szablonPodglad'])) {
        $this->szablonPodglad();
    } elseif (isset($_GET['edycjaSzablonu'])) {
        $this->edycjaSzablonu();
    } elseif (isset($_GET['addCache'])) {
        $this->addCache($_GET['addCache']);
    } elseif (isset($_GET['eraseObszar'])) {
        $this->eraseObszar();
    } elseif (isset($_GET['ustawienia'])) {
        $this->ustawienia();
    } elseif (isset($_GET['zarzadzanieSzablonami'])) {
        $this->zarzadzanieSzablonami();
    } elseif (isset($_GET['obszaryDlaSzablonow'])) {
        $this->obszaryDlaSzablonow();
    } elseif (isset($_GET['edytujObszary'])) {
        $this->edytujObszary($_GET['edytujObszary']);
    } elseif (isset($_GET['dodajSzablon'])) {
        $this->dodajSzablon();
    } elseif (isset($_GET['dodajObszar'])) {
        $this->dodajObszar($_GET['dodajObszar']);
    } elseif (isset($_GET['edytujSzablony'])) {
        $this->edytujSzablony($_GET['edytujSzablony']);
    } elseif (isset($_GET['klientFtp'])) {
        $this->klientFtp();
    } else {
		    $this->uruchomKomponent();
		}			
	}
 
 
	private function uruchomModel()
	{
		$this->AdminModel = new AdminModel;
		$this->AppModel = new AppModel;		
	}


  /* ustawianie danych dla widoku */
  public function set($nazwa, $wartosc) {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) { 
  		$_SESSION[$nazwa] = $wartosc; 
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  }


  private function uruchomKomponent() {
    /* Sprawdzenie czy sesja istnieje, jezeli nie, to wyswietla pole logowania */
    if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {     	
    	$this->set('grupy', $this->AdminModel->pobierzGrupy());
        
        $this->LayPanel = new LayoutPanelAdmin();
        $this->set('adres', '../../');

        $this->LayPanel->wyswietlStrone('./View/admin/admin.view');	
        
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            
        	if (isset($_POST['skasujGrupe'])) {
        		$zaznaczone = $_POST['zaznacz'];
        		 
        		foreach($zaznaczone as $value) {
        			$this->AdminModel->skasujGrupe($value);
        		}
        	}
        	
        	if (isset($_POST['aktualizujGrupy'])) {
        		$this->AdminModel->aktualizujGrupy($_POST['id'], $_POST['nazwa']);
        	}
        	
            echo "<script>window.location = 'admin.php'</script>";                
        }
        
      
    } else { 
            echo "<script>window.location = '../../admin.php'</script>";                
    }
    
  }
  

  private function dodajGrupe() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->AdminModel->dodajGrupe();
    	echo "<script>window.location = 'admin.php'</script>";
    } else {
    	echo "<script>window.location = '../../admin.php'</script>";
    }    
  }
  
  
  private function edytujGrupe($idGrupy) {
  	/* Sprawdzenie czy sesja istnieje, jezeli nie, to wyswietla pole logowania */
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->set('pozycje', $this->AdminModel->pobierzPozycje($idGrupy));
  		
  		$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  	
  	
  		$this->LayPanel->wyswietlStrone('./View/admin/edycjaGrupy.view');
  	
  		if($_SERVER['REQUEST_METHOD'] == "POST"){
  	
  			if (isset($_POST['skasujPozycje'])) {
  				$zaznaczone = $_POST['zaznacz'];
  				 
  				foreach($zaznaczone as $value) {
  					$this->AdminModel->skasujPozycje($value);
  				}
  			}
  			 
  			if (isset($_POST['aktualizujPozycje'])) {
  				$this->AdminModel->aktualizujPozycje($_POST['id'], $_POST['tresc']);
  			}
  			 
  			echo "<script>window.location = 'admin.php?edytujGrupe=".$idGrupy."'</script>";
  		}
  	
  	
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  }  
  
  
  private function dodajPole($idGrupy = null) {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$this->AdminModel->dodajPole($idGrupy);
	  	echo "<script>window.location = 'admin.php?edytujGrupe=".$idGrupy."'</script>";
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }
  

  private function generuj() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$this->set('wygenerowanyKod', $this->AdminModel->generuj());
	  	
	  	$this->LayPanel = new LayoutPanelAdmin();
	  	$this->set('adres', '../../');
	
	  	$this->LayPanel->wyswietlStrone('./View/admin/wygenerowanyKod.view');
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  }
  
  
  private function ajax() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		echo $this->AdminModel->generuj();
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }
  
 
  private function szablonPodglad() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$kafeki = $this->AdminModel->generuj();
	  	$szablon = $this->AdminModel->pobierzSzablon(); /*DODAĆ ID SZABLONY*/
	  	 
	  	$odp = str_replace("|KAFELKI|", $kafeki, $szablon);
	  	$odp = str_replace("|TYTUL|", $_COOKIE['tytul'], $odp);
	  	$odp = str_replace("|CECHY|", $_COOKIE['cechy'], $odp);
	  	$odp = str_replace("|OPIS-GORA|", $_COOKIE['tekstNad'], $odp);
	  	$odp = str_replace("|OPIS-DOL|", $_COOKIE['tekstPod'], $odp);
	  	 
	  	$kodCrossSelling = '<br><br><br><center><a href="http://digital-it.pl/sites/web/Components/reklama-allegro/Store/produkty/'.$_COOKIE['cross'].'/ad.php" target="_blank"><img src="http://digital-it.pl/sites/web/Components/reklama-allegro/Store/produkty/'.$_COOKIE['cross'].'/ad.gif"></a></center><br><br><br>';
	  	$odp = str_replace("|CROSS-SELLING|", $kodCrossSelling, $odp);
	  	
	  	echo $odp;
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }
  
  
  private function dodajDoSzablonu() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$kafeki = $this->AdminModel->generuj();
	  	$szablon = $this->AdminModel->pobierzSzablon();
	  	
	  	$odp = str_replace("|KAFELKI|", $kafeki, $szablon);
	  	$odp = str_replace("|TYTUL|", $_COOKIE['tytul'], $odp);
	  	$odp = str_replace("|CECHY|", $_COOKIE['cechy'], $odp);
	  	$odp = str_replace("|OPIS-GORA|", $_COOKIE['tekstNad'], $odp);
	  	$odp = str_replace("|OPIS-DOL|", $_COOKIE['tekstPod'], $odp);
	  	
	  	$kodCrossSelling = '<br><br><br><center><a href="http://digital-it.pl/sites/web/Components/reklama-allegro/Store/produkty/'.$_COOKIE['cross'].'/ad.php" target="_blank"><img src="http://digital-it.pl/sites/web/Components/reklama-allegro/Store/produkty/'.$_COOKIE['cross'].'/ad.gif"></a></center><br><br><br>';
	  	$odp = str_replace("|CROSS-SELLING|", $kodCrossSelling, $odp);
	
	  	
	  	$this->set('wygenerowanyKod', $odp);
	  	
	  	$this->LayPanel = new LayoutPanelAdmin();
	  	$this->set('adres', '../../');  	
	  	$this->LayPanel->wyswietlStrone('./View/admin/wygenerowanyKod.view');
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }
  

  private function edycjaSzablonu() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$hash = $_COOKIE['hash'];
	  	
	  	$this->set('crossSelling', $this->AdminModel->pobierzProduktyCrossSelling());
		$this->set('obszary', $this->AdminModel->pobierzObszary());
		$this->set('cache', $this->AdminModel->pobierzCache($hash));
	  	 
	  	$this->LayPanel = new LayoutPanelAdmin();
	  	$this->set('adres', '../../');
	  	$this->LayPanel->wyswietlStrone('./View/admin/edycjaSzablonu.view');
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }  
  
  
  private function addCache($obszar = null) {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$hash = $_COOKIE['hash'];
		
		$this->AdminModel->addCache($hash, $obszar, $_POST['code']);
	} else {
		echo "<script>window.location = '../../admin.php'</script>";
	}	
  }
  

  private function eraseObszar() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
	  	$hash = $_COOKIE['hash'];
	  
	  	$this->AdminModel->eraseObszar($hash);
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }
  
  
  private function ustawienia() {
  	/* Sprawdzenie czy sesja istnieje, jezeli nie, to wyswietla pole logowania */
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  
  		$this->LayPanel->wyswietlStrone('./View/admin/ustawienia.view'); 
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  
  }
  
  
  private function zarzadzanieSzablonami() {
  	/* Sprawdzenie czy sesja istnieje, jezeli nie, to wyswietla pole logowania */
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->set('szablony', $this->AdminModel->pobierzSzablony());
  		
  		$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  
  		$this->LayPanel->wyswietlStrone('./View/admin/zarzadzanieSzablonami.view');
  		
  		if($_SERVER['REQUEST_METHOD'] == "POST"){
  		
  			if (isset($_POST['skasujSzablony'])) {
  				$zaznaczone = $_POST['zaznacz'];
  				 
  				foreach($zaznaczone as $value) {
  					$this->AdminModel->skasujSzablony($value);
  				}
  			}
  			 
  			if (isset($_POST['aktualizujSzablony'])) {
  				$this->AdminModel->aktualizujSzablony($_POST['id'], $_POST['nazwa']);
  			}
  			 
  			echo "<script>window.location = 'admin.php?zarzadzanieSzablonami'</script>";
  		}
  		
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  
  }
  
  
  private function obszaryDlaSzablonow() {
  	/* Sprawdzenie czy sesja istnieje, jezeli nie, to wyswietla pole logowania */
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->set('szablony', $this->AdminModel->pobierzSzablony());
  		
  		$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  
  		$this->LayPanel->wyswietlStrone('./View/admin/obszaryDlaSzablonow.view');
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  
  }
  
  
  private function dodajSzablon() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->AdminModel->dodajSzablon();
  		echo "<script>window.location = 'admin.php?zarzadzanieSzablonami'</script>";
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}  	
  }
  
  
  private function edytujObszary($idSzablonu = null) {
    if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) { 		
    	$this->set('obszary', $this->AdminModel->pobierzObszary($idSzablonu));
    	$this->set('idSzablonu', $idSzablonu);
    	
    	$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  
  		$this->LayPanel->wyswietlStrone('./View/admin/edycjaObszary.view');
  		
  		if($_SERVER['REQUEST_METHOD'] == "POST"){
  		
  			if (isset($_POST['skasujObszary'])) {
  				$zaznaczone = $_POST['zaznacz'];
  					
  				foreach($zaznaczone as $value) {
  					$this->AdminModel->skasujObszary($value);
  				}
  			}
  		
  			if (isset($_POST['aktualizujObszary'])) {
  				$this->AdminModel->aktualizujObszary($_POST['id'], $_POST['nazwa']);
  			}
  		
  			echo "<script>window.location = 'admin.php?edytujObszary=".$idSzablonu."'</script>";
  		}
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  }  

  
  private function dodajobszar($idSzablonu = null) {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->AdminModel->dodajObszar($idSzablonu);
  	    echo "<script>window.location = 'admin.php?edytujObszary=".$idSzablonu."'</script>";
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  } 
  

  private function edytujSzablony($idSzablonu = null) {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->set('szablon', $this->AdminModel->pobierzSzablon($idSzablonu));
  		$this->set('idSzablonu', $idSzablonu);
  		 
  		$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  
  		$this->LayPanel->wyswietlStrone('./View/admin/edycjaSzablony.view');
  
  		if($_SERVER['REQUEST_METHOD'] == "POST"){
  			$this->AdminModel->aktualizujSzablon($idSzablonu, $_POST['tresc']);
  			
  			echo "<script>window.location = 'admin.php?edytujSzablony=".$idSzablonu."'</script>";
  		}
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  }
  
  
  private function klientFtp() {
  	if ( ($_SESSION['zalogowany'] == $this->tmpZalogowany) OR ($_SESSION['zalogowany'] == $this->tmpZalogowanyAdmin) ) {
  		$this->LayPanel = new LayoutPanelAdmin();
  		$this->set('adres', '../../');
  
  		$this->LayPanel->wyswietlStrone('./View/admin/klientFtp.view');
  	} else {
  		echo "<script>window.location = '../../admin.php'</script>";
  	}
  }
  
}

?>