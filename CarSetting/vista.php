<?php
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
session_start();
include_once './php/dbh.inc.php'; 

$nome = isset($_POST['scopriAuto']) ? htmlentities($_POST['scopriAuto']) : "";
$brand = isset($_POST['scopriBrand']) ? htmlentities($_POST['scopriBrand']) : "";

$mega_query = '
create or replace view view_trazione as
select distinct tipotrazione from trasmissione
where (codicemotore, consumomotore) in (
  select codicemotore, consumomotore from dotazione
  where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
);';

$mega_query2 = '
create or replace view view_cambio as
select distinct tipocambio from meccanismo
where (codicemotore, consumomotore) in (
  select codicemotore, consumomotore from dotazione
  where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
);';

$mega_query3 = '
create or replace view view_peso_vel as
select peso, velocita from automobili 
where lower(modello) like "'.$nome.'" and lower(brand) like "'.$brand.'";
create or replace view view_pot_cil_con as
select potenza, cilindrata, consumo, classe from motori
where (codice, consumo) in (
  select codicemotore, consumomotore from dotazione
  where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
);';

$mega_query4 = '
create or replace view view_cap as
select valore, tipo from capacita 
where id in (
  select idcapacita from alimentazione
  where id in (
    select idalimentazione from motori
    where (codice, consumo) in (
      select codicemotore, consumomotore from dotazione
      where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
    )
  )
);';

$mega_query5 = '
create or replace view view_ver_opt_pr as
select nome, ariacond, sensoreparc, display, prezzo, idoptional from versione join optional
on versione.idoptional = optional.id
where optional.id in (
  select idoptional from versione 
  where idcarrozzeria in (
    select id from carrozzeria
    where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
  )
);';

$mega_query6 = '
create or replace view view_alim as
select distinct tipo from alimentazione 
where id in (
  select idalimentazione from motori
  where (codice, consumo) in (
    select codicemotore, consumomotore from dotazione
    where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
  )
);';

$mega_query7 = '
create or replace view view_completa_mot as
select * from alimentazione join motori 
on id = idalimentazione
where (codice, consumo) in (
  select codicemotore, consumomotore from dotazione
  where lower(nomeauto) like "'.$nome.'" and lower(nomebrand) like "'.$brand.'"
)
';

$conn->query($mega_query);
$conn->query($mega_query2);
$conn->query($mega_query3);
$conn->query($mega_query4);
$conn->query($mega_query5);
$conn->query($mega_query6);
$conn->query($mega_query7);

$sql_query_img = 'select imageurl from automobili where modello like "%'.$nome.'%" and brand like "%'.$brand.'%";';
$pic = mysqli_query($conn, $sql_query_img);
$resultCheck = mysqli_num_rows($pic);

if ($resultCheck > 0) {
    $row = mysqli_fetch_assoc($pic);
    $imageurl = $row['imageurl'];
}

$sql_query_motori = '
    select carburante, tipoibrido, consumo, potenza, cilindrata, co2, classe
    from view_completa_mot 
';

$array_motori = mysqli_query($conn, $sql_query_motori);
$resultCheck = mysqli_num_rows($array_motori);

$sql_query_cambi = '
    select * from view_cambio
';
$sql_query_trazioni = '
    select * from view_trazione
';

$array_cambi = mysqli_query($conn, $sql_query_cambi);
$resultCheckCambi = mysqli_num_rows($array_cambi);

$array_trazioni = mysqli_query($conn, $sql_query_trazioni);
$resultCheckTrazioni = mysqli_num_rows($array_trazioni);

$sql_query_versioni = '
    select * from view_ver_opt_pr 
';

$array_versioni = mysqli_query($conn, $sql_query_versioni);
$resultCheckCVersioni = mysqli_num_rows($array_versioni);

echo '
<!DOCTYPE html>
<html>
<head>
    <title>Vista auto</title>
    <link href="css/StyleSheetProcess.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/vista.css">
    <script src="js/rating.js"></script>
</head>

<body>


<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href=\'index.php\'>
        <img src="images/logo/logo.svg" alt="" class="d-inline-block align-text-top">

      </a>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

              echo '
              <li><a class="nav-link active" href="index2.php" title="">Logout</a></li>';



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

    

    <section class = "carname">
        <div class = "container">
            <div class = "row" style= "display: flex; flex-direction: row">
                <div class = "col-10">
                    <h3 style = "padding-top: 20px">'.$brand.'</h3>
                    <h2 style="font-size:40px;">'.$nome.'</h2>
                </div>
                <div class = "col-2 rating-col">
                ';
                $query_rating = 'select rating from valutazioni where id in (
                   select idvalutazione from automobili where lower(modello) like "%'.$nome.'%" and lower(brand) like "%'.$brand.'%"
                   )';

                $result_rating = mysqli_query($conn, $query_rating);
                $row_rating = mysqli_fetch_assoc($result_rating);

                $id_valutazione = 'select idvalutazione from automobili where lower(modello) like "%'.$nome.'%" and lower(brand) like "%'.$brand.'%"';
                $id_valutazione_query = mysqli_query($conn, $id_valutazione);
                $row_id = mysqli_fetch_assoc($id_valutazione_query);
                
                switch($row_rating['rating']) {
                   case(5) : echo
                   '
                   <span name = '.$row_id['idvalutazione'].' id="star1" class="fa fa-star checked" onclick = "changeStarColorClick(\'star1\')" onmouseover = "changeStarColorOn(\'star1\')" onmouseout = "changeStarColorOut(\'star1\')"></span>
                   <span id="star2" class="fa fa-star checked" onclick = "changeStarColorClick(\'star2\')" onmouseover = "changeStarColorOn(\'star2\')" onmouseout = "changeStarColorOut(\'star2\')"></span>
                   <span id="star3" class="fa fa-star checked" onclick = "changeStarColorClick(\'star3\')" onmouseover = "changeStarColorOn(\'star3\')" onmouseout = "changeStarColorOut(\'star3\')"></span>
                   <span id="star4" class="fa fa-star checked" onclick = "changeStarColorClick(\'star4\')" onmouseover = "changeStarColorOn(\'star4\')" onmouseout = "changeStarColorOut(\'star4\')"></span>
                   <span id="star5" class="fa fa-star checked" onclick = "changeStarColorClick(\'star5\')" onmouseover = "changeStarColorOn(\'star5\')" onmouseout = "changeStarColorOut(\'star5\')"></span>
                   '; break;
                   case(4) : echo
                   '
                   <span name = '.$row_id['idvalutazione'].' id="star1" class="fa fa-star checked" onclick = "changeStarColorClick(\'star1\')" onmouseover = "changeStarColorOn(\'star1\')" onmouseout = "changeStarColorOut(\'star1\')"></span>
                   <span id="star2" class="fa fa-star checked" onclick = "changeStarColorClick(\'star2\')" onmouseover = "changeStarColorOn(\'star2\')" onmouseout = "changeStarColorOut(\'star2\')"></span>
                   <span id="star3" class="fa fa-star checked" onclick = "changeStarColorClick(\'star3\')" onmouseover = "changeStarColorOn(\'star3\')" onmouseout = "changeStarColorOut(\'star3\')"></span>
                   <span id="star4" class="fa fa-star checked" onclick = "changeStarColorClick(\'star4\')" onmouseover = "changeStarColorOn(\'star4\')" onmouseout = "changeStarColorOut(\'star4\')"></span>
                   <span id="star5" class="fa fa-star " onclick = "changeStarColorClick(\'star5\')" onmouseover = "changeStarColorOn(\'star5\')" onmouseout = "changeStarColorOut(\'star5\')"></span>
                   '; break;
                   case(3) : echo
                   '
                   <span name = '.$row_id['idvalutazione'].' id="star1" class="fa fa-star checked" onclick = "changeStarColorClick(\'star1\')" onmouseover = "changeStarColorOn(\'star1\')" onmouseout = "changeStarColorOut(\'star1\')"></span>
                   <span id="star2" class="fa fa-star checked" onclick = "changeStarColorClick(\'star2\')" onmouseover = "changeStarColorOn(\'star2\')" onmouseout = "changeStarColorOut(\'star2\')"></span>
                   <span id="star3" class="fa fa-star checked" onclick = "changeStarColorClick(\'star3\')" onmouseover = "changeStarColorOn(\'star3\')" onmouseout = "changeStarColorOut(\'star3\')"></span>
                   <span id="star4" class="fa fa-star " onclick = "changeStarColorClick(\'star4\')" onmouseover = "changeStarColorOn(\'star4\')" onmouseout = "changeStarColorOut(\'star4\')"></span>
                   <span id="star5" class="fa fa-star " onclick = "changeStarColorClick(\'star5\')" onmouseover = "changeStarColorOn(\'star5\')" onmouseout = "changeStarColorOut(\'star5\')"></span>
                   '; break;
                   case(2) : echo
                   '
                   <span name = '.$row_id['idvalutazione'].' id="star1" class="fa fa-star checked" onclick = "changeStarColorClick(\'star1\')" onmouseover = "changeStarColorOn(\'star1\')" onmouseout = "changeStarColorOut(\'star1\')"></span>
                   <span id="star2" class="fa fa-star checked" onclick = "changeStarColorClick(\'star2\')" onmouseover = "changeStarColorOn(\'star2\')" onmouseout = "changeStarColorOut(\'star2\')"></span>
                   <span id="star3" class="fa fa-star " onclick = "changeStarColorClick(\'star3\')" onmouseover = "changeStarColorOn(\'star3\')" onmouseout = "changeStarColorOut(\'star3\')"></span>
                   <span id="star4" class="fa fa-star " onclick = "changeStarColorClick(\'star4\')" onmouseover = "changeStarColorOn(\'star4\')" onmouseout = "changeStarColorOut(\'star4\')"></span>
                   <span id="star5" class="fa fa-star " onclick = "changeStarColorClick(\'star5\')" onmouseover = "changeStarColorOn(\'star5\')" onmouseout = "changeStarColorOut(\'star5\')"></span>
                   '; break;
                   case(1) : echo
                   '
                   <span name = '.$row_id['idvalutazione'].' id="star1" class="fa fa-star checked" onclick = "changeStarColorClick(\'star1\')" onmouseover = "changeStarColorOn(\'star1\')" onmouseout = "changeStarColorOut(\'star1\')"></span>
                   <span id="star2" class="fa fa-star " onclick = "changeStarColorClick(\'star2\')" onmouseover = "changeStarColorOn(\'star2\')" onmouseout = "changeStarColorOut(\'star2\')"></span>
                   <span id="star3" class="fa fa-star " onclick = "changeStarColorClick(\'star3\')" onmouseover = "changeStarColorOn(\'star3\')" onmouseout = "changeStarColorOut(\'star3\')"></span>
                   <span id="star4" class="fa fa-star " onclick = "changeStarColorClick(\'star4\')" onmouseover = "changeStarColorOn(\'star4\')" onmouseout = "changeStarColorOut(\'star4\')"></span>
                   <span id="star5" class="fa fa-star " onclick = "changeStarColorClick(\'star5\')" onmouseover = "changeStarColorOn(\'star5\')" onmouseout = "changeStarColorOut(\'star5\')"></span>
                   '; break;
                   case(0) : echo
                   '
                   <span name = '.$row_id['idvalutazione'].' id="star1" class="fa fa-star " onclick = "changeStarColorClick(\'star1\')" onmouseover = "changeStarColorOn(\'star1\')" onmouseout = "changeStarColorOut(\'star1\')"></span>
                   <span id="star2" class="fa fa-star " onclick = "changeStarColorClick(\'star2\')" onmouseover = "changeStarColorOn(\'star2\')" onmouseout = "changeStarColorOut(\'star2\')"></span>
                   <span id="star3" class="fa fa-star " onclick = "changeStarColorClick(\'star3\')" onmouseover = "changeStarColorOn(\'star3\')" onmouseout = "changeStarColorOut(\'star3\')"></span>
                   <span id="star4" class="fa fa-star " onclick = "changeStarColorClick(\'star4\')" onmouseover = "changeStarColorOn(\'star4\')" onmouseout = "changeStarColorOut(\'star4\')"></span>
                   <span id="star5" class="fa fa-star " onclick = "changeStarColorClick(\'star5\')" onmouseover = "changeStarColorOn(\'star5\')" onmouseout = "changeStarColorOut(\'star5\')"></span>
                   '; break;
                }

                echo '
                </div>
            </div>
        </div>
    </section>

    <style>
    body{
        background-color: rgb(233, 233, 233);
    }
    .car-pic{
        padding-top: 8rem;
        padding-bottom: 8rem;
        background-image: url("'.$imageurl.'");
        background-size: cover;
        background-position: center;
        display: block;
        justify-content: center;
        margin-bottom: 1rem;
        width:100%;
        min-height: 500px;
    }
    @media screen and (max-width: 900px) {
        .car-pic {
            min-height: 0px;
            height: auto;
        }
    }
    .card{
        margin-bottom: 25px;
    }
    .card-header{
        padding: 20px;
        font-weight: bolder;
    }
    .p-value{
        font-size: 16px;
        font-weight: 700;
    }
    .p-value1{
        font-size: 16px;
        font-weight: 700;
    }
    strong{
        float: right;      
        color: #0068bd;    
    }
    strong:first-letter{
        text-transform: uppercase;
    }
    </style>

    <section class = "car-pic-section">
        <div class="container">
            <div class="row">
                <div class="col-12 car-pic">
                </div>
            </div>
        </div>
    </section>

    <section class = "cards">
        <div class = "container">';

    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($array_motori))
            //echo is_null($row['tipoibrido']);
            echo '
            <div class="card">
                <h5 class="card-header">MOTORE E PERFORMANCE <strong>'.(is_null($row['tipoibrido']) ? $row['carburante'] : $row['tipoibrido']).'</strong></h5>
                
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style = "border-right: 0.5px solid #000;">
                                <div class="my-row" style = "display: flex; justify-content: space-between;">
                                    <p>Cilindrata</p>
                                    <p class = "p-value">'.$row['cilindrata'].'cc</p>
                                </div> 
                            </div>
                            <div class="col">
                                <div class="my-row" style = "display: flex; justify-content: space-between;">
                                    <p>Consumo</p>
                                    <p class = "p-value">'.$row['consumo'].'l/100km</p>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style = "border-right: 0.5px solid #000;">
                                <div class="my-row" style = "display: flex; justify-content: space-between;">
                                    <p>Potenza</p>
                                    <p class = "p-value">'.$row['potenza'].'hp</p>
                                </div> 
                            </div>
                            <div class="col">
                                <div class="my-row" style = "display: flex; justify-content: space-between;">
                                    <p>Classe di emissione</p>
                                    <p class = "p-value">'.$row['classe'].'</p>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
    }
        

    echo '
           
            <div class="card">
                <h5 class="card-header">TRASMISSIONI</h5>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style = "border-right: 0.5px solid #000;">
                                <div class="my-row" style = "display: flex; justify-content: space-between;">
                                    <p>Cambio</p>
                                    <p class = "p-value">';
                                    $cont = 0;
                                    if ($resultCheckCambi > 0) {
                                        while ($row = mysqli_fetch_assoc($array_cambi)){
                                            if ($cont >= 1) echo " / ";
                                            echo $row['tipocambio'];
                                            $cont++;
                                        }
                                    }
                                    echo
                                    '</p>
                                </div> 
                            </div>
                            <div class="col">
                                <div class="my-row" style = "display: flex; justify-content: space-between;">
                                    <p>Trazione</p>
                                    <p class = "p-value">';
                                    $cont = 0;
                                    if ($resultCheckTrazioni > 0) {
                                        while ($row = mysqli_fetch_assoc($array_trazioni)){
                                            if($cont >= 1) echo " / ";
                                            echo $row['tipotrazione']." ";
                                            $cont++;
                                        }
                                    }
                                    echo '
                                    </p>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header">VERSIONI</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class = "p-value">Nome</p>
                        </div>
                        <div class="col">
                            <p class = "p-value">Display</p>
                        </div>
                        <div class="col">
                            <p class = "p-value">Sensori Parcheggio</p>
                        </div>
                        <div class="col">
                            <p class = "p-value">Aria Condizionata</p>
                        </div>
                        <div class="col">
                            <p class = "p-value">Prezzo</p>
                        </div>
                        <div class="col">
                        <p class = "p-value">Preventivo</p>
                    </div>
                    </div>';

                    if ($resultCheckCVersioni > 0) {
                        while ($row = mysqli_fetch_assoc($array_versioni)) {
                            echo '
                                <div class="row">
                                    <div class="col">
                                        <p class = "p-value1">'.$row['nome'].'</p>
                                    </div>
                                    <div class="col">
                                        <p class = "p-value1">'.($row['display'] == 0 ? '-' : '<i class="far fa-check-circle"></i>').'</p>
                                    </div>
                                    <div class="col">
                                        <p class = "p-value1">'.($row['sensoreparc'] == 0 ? '-' : '<i class="far fa-check-circle"></i>').'</p>
                                    </div>
                                    <div class="col">
                                        <p class = "p-value1">'.($row['ariacond'] == 0 ? '-' : '<i class="far fa-check-circle"></i>').'</p>
                                    </div>
                                    <div class="col">
                                        <p class = "p-value1">'.$row['prezzo'].'€</p>
                                    </div>
                                    <div class="col">';
                                    if (isset($_SESSION['session_user']))
                                    echo '
                                        <form method="post" action="insert_preventivo.php">
                                            <input type="hidden" name="scopriPrezzo" value = "'.$row['prezzo'].'">
                                            <input type="hidden" name="scopriOptional" value = "'.$row['idoptional'].'">
                                            <input type="hidden" name="scopriNome" value = "'.$nome.'">
                                            <input type="hidden" name="scopriBrand" value = "'.$brand.'">
                                            <input type="submit" class= "btn btn-primary" value="Aggiungi" style = "max-width: 120px">
                                        </form>';
                                    else 
                                    echo '
                                        <form method="post" action="./login.html">
                                                <input type="submit" class= "btn btn-primary" value="Aggiungi" style = "max-width: 120px">
                                        </form>
                                    ';

                                    echo '
                                    </div>
                                </div>
                            ';
                        }
                    }
                    echo '
                </div>
            </div>
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
            for (var i = 0; i < array.length; i++) array[i].className =\'col-6 dinamic-col\';
        } else {
            array = document.getElementsByClassName(\'col-6 dinamic-col\');
            for (var i = 0; i < array.length; i++) array[i].className =\'col-3 dinamic-col\'; 
        }
    });
 </script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>
';