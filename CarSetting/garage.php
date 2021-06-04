<?php
session_start();

include_once './php/dbh.inc.php'; 

function concat_din($array, $stringa, $nomeattr) {
   $flag = 0;
   $aggiungi = false;
   $c = 0;
   //print_r ($array);
   foreach($array as $key => $value) {

      if(!empty($array[$key])) {

         if ($aggiungi && $c < count($array)) $stringa .= 'or lower('.$nomeattr.') like ';
         $stringa .= '"%'.$array[$key].'%" ';
         $aggiungi = true;
      }
      else $flag ++; 
   }
   if ($flag == count($array)) $stringa .= '"%%"';     
   
   return $stringa;
}

   $prezzoBasso = isset($_POST['prezzoBasso']) ? htmlentities($_POST['prezzoBasso'], ENT_QUOTES, "UTF-8") : 0;
   $prezzoAlto = isset($_POST['prezzoAlto']) ? htmlentities($_POST['prezzoAlto'], ENT_QUOTES, "UTF-8") : 100000;

   $cilBassa = isset($_POST['cilBassa']) ? htmlentities($_POST['cilBassa'], ENT_QUOTES, "UTF-8") : 0;
   $cilAlta = isset($_POST['cilAlta']) ? htmlentities($_POST['cilAlta'], ENT_QUOTES, "UTF-8") : 6000;

   $potBassa = isset($_POST['potBassa']) ? htmlentities($_POST['potBassa'], ENT_QUOTES, "UTF-8") : 0;
   $potAlta = isset($_POST['potAlta']) ? htmlentities($_POST['potAlta'], ENT_QUOTES, "UTF-8") : 1000;

   $carrozzerie = [
      'berlina' => isset($_POST['scegliBerlina']) ? htmlentities($_POST['scegliBerlina']) : "",
      'cabrio' => isset($_POST['scegliCabrio']) ? htmlentities($_POST['scegliCabrio']) : "",
      'coupe' => isset($_POST['scegliCoupe']) ? htmlentities($_POST['scegliCoupe']) : "",
      'monovolume' => isset($_POST['scegliMono']) ? htmlentities($_POST['scegliMono']) : "",
      'suv' => isset($_POST['scegliSuv']) ? htmlentities($_POST['scegliSuv']) : ""
   ];

   if(isset($_POST['scegliCarrozzeria'])) {
      $carr = htmlentities($_POST['scegliCarrozzeria']);
      $carrozzerie[$carr] = $carr;
   }

   $carburanti = [
      'benzina' => isset($_POST['scegliBenzina']) ? htmlentities($_POST['scegliBenzina']) : "",
      'diesel' => isset($_POST['scegliDiesel']) ? htmlentities($_POST['scegliDiesel']) : "",
      'gpl' => isset($_POST['scegliGPL']) ? htmlentities($_POST['scegliGPL']) : "",
      'hybrid' => isset($_POST['scegliHybrid']) ? htmlentities($_POST['scegliHybrid']) : "",
      'elettrico' => isset($_POST['scegliElettrico']) ? htmlentities($_POST['scegliElettrico']) : "",
   ];

   $cambi = [
      'manuale' => isset($_POST['scegliManuale']) ? htmlentities($_POST['scegliManuale']) : "",
      'automatico' => isset($_POST['scegliAutomatico']) ? htmlentities($_POST['scegliAutomatico']) : ""
   ];

   $brands = [
      'alfa' => isset($_POST['scegliAlfa']) ? htmlentities($_POST['scegliAlfa']) : "",
      'audi' => isset($_POST['scegliAudi']) ? htmlentities($_POST['scegliAudi']) : "",
      'bmw' => isset($_POST['scegliBmw']) ? htmlentities($_POST['scegliBmw']) : "",
      'citroen' => isset($_POST['scegliCitroen']) ? htmlentities($_POST['scegliCitroen']) : "",
      'dacia' => isset($_POST['scegliDacia']) ? htmlentities($_POST['scegliDacia']) : "",
      'dr' => isset($_POST['scegliDR']) ? htmlentities($_POST['scegliDR']) : "",
      'ds' => isset($_POST['scegliDS']) ? htmlentities($_POST['scegliDS']) : "",
      'evo' => isset($_POST['scegliEvo']) ? htmlentities($_POST['scegliEvo']) : "",
      'fiat' => isset($_POST['scegliFiat']) ? htmlentities($_POST['scegliFiat']) : "",
      'ford' => isset($_POST['scegliFord']) ? htmlentities($_POST['scegliFord']) : "",
      'honda' => isset($_POST['scegliHonda']) ? htmlentities($_POST['scegliHonda']) : "",
      'hyundai' => isset($_POST['scegliHyundai']) ? htmlentities($_POST['scegliHyundai']) : "",
   ];

   $trazioni = [
      'anteriore' => isset($_POST['scegliAnteriore']) ? htmlentities($_POST['scegliAnteriore']) : "",
      'posteriore' => isset($_POST['scegliPosteriore']) ? htmlentities($_POST['scegliPosteriore']) : "",
      '4x4' => isset($_POST['scegli4x4']) ? htmlentities($_POST['scegli4x4']) : ""
   ];

$sql_query = '
   create or replace view view_for_preventivi as
   select * from automobili 


   where
   
   -- filtro prezzo
   
      prezzolistino >= '.$prezzoBasso; 

   $sql_query .= '
   
       and prezzolistino <= '.$prezzoAlto;

   $sql_query .= '
   
       and
   
   -- filtro carrozzeria
   
       (modello, brand) in (
           select nomeauto, nomebrand from carrozzeria
           where lower(variante) like ';

   $sql_query = concat_din($carrozzerie, $sql_query, "variante");

   $sql_query .= '
   
       )
     
        and
       
   -- filtro alimentazione
      
       (modello, brand) in (
            select nomeauto, nomebrand from dotazione 
            where codicemotore in (
                select codice from motori
                where idalimentazione in (
                    select id from alimentazione
                    where lower(carburante) like '; 
                    
   $sql_query = concat_din($carburanti, $sql_query, "carburante");

   $sql_query .= '

               )
           )  
       )
       
       and
       
   -- filtro brand
   
      lower(brand) like ';

   $sql_query = concat_din($brands, $sql_query, "brand");

   $sql_query .= '
       
       and
       
   -- filtro cambio
   
       (modello, brand) in (
           select nomeauto, nomebrand from dotazione 
           where codicemotore in (
               select codice from motori 
                where (codice, consumo) in (
                  select codicemotore, consumomotore from meccanismo
                    where lower(tipocambio) like ';
   
   $sql_query = concat_din($cambi, $sql_query, "tipocambio");

   $sql_query .= '
               )
           )
       )	
       
       and
   
   -- filtro trazione
   
       (modello, brand) in (
           select nomeauto, nomebrand from dotazione 
           where codicemotore in (
               select codice from motori 
                where (codice, consumo) in (
                  select codicemotore, consumomotore from trasmissione
                    where lower(tipotrazione) like ';
   
   $sql_query = concat_din($trazioni, $sql_query, "tipotrazione");

   $sql_query .= '
               )
           )
       )	
       
       and
   
   -- filtro potenza motore
   
       (modello, brand) in (
           select nomeauto, nomebrand from dotazione 
           where codicemotore in (
               select codice from motori 
                where potenza >= '.$potBassa.' and potenza <= '.$potAlta.'
           )
       )
       
   /*    and
   
   
   -- filtro cilindrata motore
   
       (modello, brand) in (
           select nomeauto, nomebrand from dotazione 
           where codicemotore in (
               select codice from motori 
                where cilindrata >='.$cilBassa.' and cilindrata <= '.$cilAlta.'
           )
       )
   */

   ';

$firstResult = mysqli_query($conn, $sql_query);
//$firstResultCheck = mysqli_num_rows($firstResult);

$sql_query = '
select * from preventivi
where (nomeauto, nomebrand) in (
	select modello, brand from view_for_preventivi
) and emailutente like "%'.$_SESSION['session_user'].'%"
';

$result = mysqli_query($conn, $sql_query);
$resultCheck = mysqli_num_rows($result);

echo '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
    src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="css/StyleSheetProcess.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/slider.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
    <title>Document</title>
</head>

<body style = "background-color: rgb(233, 233, 233);">


<nav class="navbar navbar-light bg-light">
<div class="container-fluid">
    <a class="navbar-brand" href=\'index.php\'>
        <img src="images/logo/logo.svg" alt="" class="d-inline-block align-text-top">

    </a>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                     <li class="nav-item">
                     <a class="nav-link active" href="process.php">Cerca Auto</a>
                     </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="garageCheck.php">Garage</a>
                    </li>

                    <li class="nav-item">';
                        if (isset($_SESSION['session_user'])) { 

                    echo '<li><a class="nav-link active" href="index2.php" title="">Logout</a></li>';



                } else { 

                    echo '<li><a class="nav-link active" href="login.html" title="">Login</a></li>';


                 } 


                 echo '

                </li>
                </ul>
            </div>
        </div>
    </nav>
    </header>
</div>
</nav>
      <section class = "title-section">
         <div class = "container-sm">
            <div class = "row">
               <div class = "col-lg-12">
                  <h1>I tuoi preventivi:</h1>
               </div>
            </div>
         </div>
      </section>

      <section class = "results-section">
         <div class = "container">
         
            <div class = "row">

               <div class = "col-4 dinamic-filtering-col">
               <form method="post" action="garage.php">
                  <div class="accordion" id="accordionExample">

                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <a style = "font-weight: bolder">Prezzo di listino</a>
                           </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body my-prezzo">
                              <div class="range-slider flat" data-ticks-position=\'top\' style=\'--min:0; --max:100000; --value-a:0; --value-b:100000; --suffix:"€"; --text-value-a:"0"; --text-value-b:"100000";\'>
                                 <input name="prezzoBasso" type="range" min="0" max="100000" value="0" oninput="this.parentNode.style.setProperty(\'--value-a\',this.value); this.parentNode.style.setProperty(\'--text-value-a\', JSON.stringify(this.value))">
                                 <output></output>
                                 <input name="prezzoAlto" type="range" min="0" max="100000" value="100000" oninput="this.parentNode.style.setProperty(\'--value-b\',this.value); this.parentNode.style.setProperty(\'--text-value-b\', JSON.stringify(this.value))">
                                 <output></output>
                                 <div class=\'range-slider__progress\'></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              <a style = "font-weight: bolder">Carrozzeria</a>
                           </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              <div class="form-check">
                                 <input name="scegliBerlina" class="form-check-input" type="checkbox" value="berlina" id="flexCheckDefault">
                                 <label class="form-check-label" for="flexCheckDefault">
                                    Berlina
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliCabrio" class="form-check-input" type="checkbox" value="cabrio" id="flexCheckDefault2">
                                 <label class="form-check-label" for="flexCheckDefault2">
                                    Cabrio
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliCoupe" class="form-check-input" type="checkbox" value="coupe" id="flexCheckDefault3">
                                 <label class="form-check-label" for="flexCheckDefault3">
                                    Coupe
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliMono" class="form-check-input" type="checkbox" value="monovolume" id="flexCheckDefault4">
                                 <label class="form-check-label" for="flexCheckDefault4">
                                    Monovolume
                                 </label>
                              </div> 
                              <div class="form-check">
                                 <input name="scegliSuv" class="form-check-input" type="checkbox" value="suv" id="flexCheckDefault5">
                                 <label class="form-check-label" for="flexCheckDefault5">
                                    Suv
                                 </label>
                              </div>                                                         
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                           <a style = "font-weight: bolder">Alimentazione</a>
                           </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              <div class="form-check">
                              <input name="scegliBenzina" class="form-check-input" type="checkbox" value="benzina" id="flexCheckDefault6">
                              <label class="form-check-label" for="flexCheckDefault">
                                 Benzina
                              </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliDiesel" class="form-check-input" type="checkbox" value="diesel" id="flexCheckDefault7">
                                 <label class="form-check-label" for="flexCheckDefault7">
                                    Diesel
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliGPL" class="form-check-input" type="checkbox" value="gpl" id="flexCheckDefault8">
                                 <label class="form-check-label" for="flexCheckDefault8">
                                    GPL
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliHybrid" class="form-check-input" type="checkbox" value="batteria/benzina" id="flexCheckDefault9">
                                 <label class="form-check-label" for="flexCheckDefault9">
                                    Hybrid
                                 </label>
                              </div> 
                              <div class="form-check">
                                 <input name="scegliElettrico" class="form-check-input" type="checkbox" value="batteria" id="flexCheckDefault10">
                                 <label class="form-check-label" for="flexCheckDefault10">
                                    Elettrico
                                 </label>
                              </div>             
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                           <a style = "font-weight: bolder">Brand</a>
                           </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              <div class="form-check">
                                 <input name="scegliAlfa" class="form-check-input" type="checkbox" value="alfa" id="flexCheckDefault11">
                                 <label class="form-check-label" for="flexCheckDefault11">
                                    Alfa Romeo
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliAudi" class="form-check-input" type="checkbox" value="audi" id="flexCheckDefault12">
                                 <label class="form-check-label" for="flexCheckDefault12">
                                    Audi
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliBmw" class="form-check-input" type="checkbox" value="bmw" id="flexCheckDefault13">
                                 <label class="form-check-label" for="flexCheckDefault13">
                                    BMW
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliCitroen" class="form-check-input" type="checkbox" value="citroen" id="flexCheckDefault14">
                                 <label class="form-check-label" for="flexCheckDefault14">
                                    Citroen
                                 </label>
                              </div> 
                              <div class="form-check">
                                 <input name="scegliDacia" class="form-check-input" type="checkbox" value="dacia" id="flexCheckDefault15">
                                 <label class="form-check-label" for="flexCheckDefault15">
                                    Dacia
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliDR" class="form-check-input" type="checkbox" value="dr" id="flexCheckDefault16">
                                 <label class="form-check-label" for="flexCheckDefault16">
                                    DR
                                 </label>
                              </div>                                   
                              <div class="form-check">
                                 <input name="scegliDS" class="form-check-input" type="checkbox" value="ds" id="flexCheckDefault17">
                                 <label class="form-check-label" for="flexCheckDefault17">
                                    DS
                                 </label>
                              </div> 
                              <div class="form-check">
                                 <input name="scegliEvo" class="form-check-input" type="checkbox" value="evo" id="flexCheckDefault18">
                                 <label class="form-check-label" for="flexCheckDefault18">
                                    Evo
                                 </label>
                              </div> 
                              <div class="form-check">
                                 <input name="scegliFiat" class="form-check-input" type="checkbox" value="fiat" id="flexCheckDefault19">
                                 <label class="form-check-label" for="flexCheckDefault19">
                                    FIAT
                                 </label>
                              </div> 
                              <div class="form-check">
                                 <input name="scegliFord" class="form-check-input" type="checkbox" value="ford" id="flexCheckDefault20">
                                 <label class="form-check-label" for="flexCheckDefault20">
                                    Ford
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliHonda" class="form-check-input" type="checkbox" value="honda" id="flexCheckDefault21">
                                 <label class="form-check-label" for="flexCheckDefault21">
                                    Honda
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliHyundai" class="form-check-input" type="checkbox" value="hyundai" id="flexCheckDefault22">
                                 <label class="form-check-label" for="flexCheckDefault22">
                                    Hyundai
                                 </label>
                              </div>  
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                           <a style = "font-weight: bolder">Cambio</a>
                           </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              <div class="form-check">
                                 <input name="scegliManuale" class="form-check-input" type="checkbox" value="manuale" id="flexCheckDefault23">
                                 <label class="form-check-label" for="flexCheckDefault23">
                                    Manuale
                                 </label>
                              </div>
                              <div class="form-check">
                                 <input name="scegliAutomatico" class="form-check-input" type="checkbox" value="automatico" id="flexCheckDefault24">
                                 <label class="form-check-label" for="flexCheckDefault24">
                                    Automatico
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                           <a style = "font-weight: bolder">Trazione</a>
                           </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                           <div class="form-check">
                              <input name="scegliAnteriore" class="form-check-input" type="checkbox" value="anteriore" id="flexCheckDefault25">
                              <label class="form-check-label" for="flexCheckDefault25">
                                 Anteriore
                              </label>
                           </div>
                           <div class="form-check">
                              <input name="scegliPosteriore" class="form-check-input" type="checkbox" value="posteriore" id="flexCheckDefault26">
                              <label class="form-check-label" for="flexCheckDefault26">
                                 Posteriore
                              </label>
                           </div>
                           <div class="form-check">
                              <input name="scegli4x4" class="form-check-input" type="checkbox" value="4x4" id="flexCheckDefault27">
                              <label class="form-check-label" for="flexCheckDefault27">
                                 4x4
                              </label>
                           </div> 
                           </div>
                        </div>
                     </div> 
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                              <a style = "font-weight: bolder">Cilindrata</a>
                           </button>
                        </h2>
                        <div id="collapseSeven"  class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                           <div class="accordion-body my-prezzo">
                              <div class="range-slider flat" data-ticks-position=\'top\' style=\'--min:0; --max:6000; --value-a:0; --value-b:6000; --suffix:"cc"; --text-value-a:"0"; --text-value-b:"6000";\'>
                                 <input name="cilBassa" type="range" min="0" max="6000" value="0" oninput="this.parentNode.style.setProperty(\'--value-a\',this.value); this.parentNode.style.setProperty(\'--text-value-a\', JSON.stringify(this.value))">
                                 <output></output>
                                 <input name="cilAlta" type="range" min="0" max="6000" value="6000" oninput="this.parentNode.style.setProperty(\'--value-b\',this.value); this.parentNode.style.setProperty(\'--text-value-b\', JSON.stringify(this.value))">
                                 <output></output>
                                 <div class=\'range-slider__progress\'></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEight">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                              <a style = "font-weight: bolder">Potenza</a>
                           </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                           <div class="accordion-body my-prezzo">
                              <div class="range-slider flat" data-ticks-position=\'top\' style=\'--min:0; --max:1000; --value-a:0; --value-b:1000; --suffix:"hp"; --text-value-a:"0"; --text-value-b:"1000";\'>
                                 <input name="potBassa" type="range" min="0" max="1000" value="0" oninput="this.parentNode.style.setProperty(\'--value-a\',this.value); this.parentNode.style.setProperty(\'--text-value-a\', JSON.stringify(this.value))">
                                 <output></output>
                                 <input name="potAlta" type="range" min="0" max="1000" value="1000" oninput="this.parentNode.style.setProperty(\'--value-b\',this.value); this.parentNode.style.setProperty(\'--text-value-b\', JSON.stringify(this.value))">
                                 <output></output>
                                 <div class=\'range-slider__progress\'></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="submit" class= "btn btn-primary" value="Applica filtri" style = "margin-top: 20px">  
                  </form>                 
               </div>
               <div class="col-6">
               ';

   if ($resultCheck > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            $sql_query_img = '
            select imageurl from automobili
            where lower(modello) like "%'.$row['nomeauto'].'%" and lower(brand) like "%'.$row['nomebrand'].'%"
            ';
            $resultImg = mysqli_query($conn, $sql_query_img);
            $resultCheckImg = mysqli_num_rows($resultImg);
            $rowImg = mysqli_fetch_assoc($resultImg);
            $imageurl = $rowImg['imageurl'];
            echo '
                  <div class="card mb-3" style="max-width: 768px;">
                     <div class="row g-0">
                        <div class="col-md-4">
                           <div class="container">
                              <img src = "'.$imageurl.'" class = "search-pic-result">
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="card-body">
                              <h5 class="card-title">'.$row['nomebrand']." ".$row['nomeauto'].'</h5>
                              <p class="card-text"><strong>Prezzo:</strong> '.$row['totale'].'€</p>
                              <p class="card-text"><strong>Data creazione:</strong> '.$row['datacreazione'].'</p>
                              <form method = "post" action="./vista.php">
                                 <input type="hidden" name="scopriBrand" value = "'.$row['nomebrand'].'">
                                 <input type="hidden" name="scopriAuto" value = "'.$row['nomeauto'].'">
                                 <input type="submit" class= "btn btn-primary discover-btn" value="Scopri di più">
                              </form>
                              <form method = "post" action = "php/deleteprev.php">
                                 <input type="hidden" name="scopriBrand" value = "'.$row['nomebrand'].'">
                                 <input type="hidden" name="scopriAuto" value = "'.$row['nomeauto'].'">
                                 <input type="submit" class= "btn btn-primary discover-btn" value="Cancella preventivo" style = "margin-right: 5px;">
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
            ';
         }
   }
   else{
      echo "No result";
   }
   echo '
               </div>
            </div>
         </form>
         </div>
      </section>

   <style>
      footer a {
          text-decoration: none;
          color: #fff;
          transition: all(0.8s);
      }

      .footer-info h2 {
          margin-bottom: 20px;
          padding-bottom: 10px;
          border-bottom: 4px solid #0065b8;
      }

      @media screen and (max-width: 940px) {
          .footer-info .row {
              flex-direction: column;
              align-items: center;
          }
      }
      @media screen and (max-width: 720px) {

      }
   </style>

   <footer class="bg-dark text-center text-white">

         <div class="container">
            <section class="footer-info">
               <div class="row" style="justify-content: space-around;">
                     <div class="col-3 dinamic-col">
                        <h2 class="footer-title">CarSetting</h2>
                        <p> Come Funziona</p>
                        <p> F.A.Q CarSetting</p>
                        <p> Chi Siamo</p>
                        <p> Offerte</p>
                        <p> Guide</p>
                        <p> Veicoli Commerciali</p>
                     </div>
                     <div class="col-1"></div>
                     <div class="col-3 dinamic-col">
                        <h2 class="footer-title">Navigate</h2>
                        <p><a href="#">Home</a></p>
                        <p><a href="#">Store</a></p>
                        <p><a href="#">About</a></p>
                        <p><a href="#">Contact</a></p>
                     </div>
                     <div class="col-1"></div>
                     <div class="col-3 dinamic-col">
                        <h2 class="footer-title">Contacts</h2>
                        <p>Politi Mirko </p>
                        <p>Simone Zannini </p>
                        <p><i class="far fa-envelope"></i> politi.1857617@ studenti.uniroma1.it</p>
                        <p><i class="far fa-envelope"></i> zannini.1837364@ studenti.uniroma1.it</p>
                        <p><i class="fas fa-map-marker-alt"></i> Roma, IT </p>
                     </div>
               </div>
            </section>

            <section class="mb-4">
               <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <!-- Facebook -->
                           <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fab fa-facebook-f"></i></a>
                           <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fab fa-twitter"></i></a>
                           <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fab fa-google"></i></a>
                           <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fab fa-instagram"></i></a>
                           <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fab fa-linkedin-in"></i></a>
                           <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fab fa-github"></i></a>
                        </div>
                     </div>
               </div>
            </section>

            <section class="footer-copyright">
               <div class="container">
                     <div class="row">
                        <div class="col-12">
                           © 2021 Copyright: <a href="index.php">CarSetting</a>
                        </div>
                     </div>
               </div>
            </section>
         </div>
   </footer>

   <script>

      var width,height;
      $(window).on(\'load resize\', function() {
          width = this.innerWidth;
          height = this.innerHeight;
          var array = [];
          if(width <= 720) {
              array = document.getElementsByClassName(\'col-3 dinamic-col\');
              el = document.getElementsByClassName(\'dinamic-filtering-col\')[0];
              for (var i = 0; i < array.length; i++) array[i].className =\'col-6 dinamic-col\';
              el.className = \'col-6 dinamic-filtering-col\';
          } else {
              array = document.getElementsByClassName(\'col-6 dinamic-col\');
              el = document.getElementsByClassName(\'dinamic-filtering-col\')[0];
              for (var i = 0; i < array.length; i++) array[i].className =\'col-3 dinamic-col\'; 
              el.className = \'col-4 dinamic-filtering-col\';
          }
      });

   </script>



   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
      ';
?>