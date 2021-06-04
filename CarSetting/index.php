<?php session_start(); ?>

<!doctype html>
<html lang="en">


<head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/slider.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="css/StyleSheet.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("a").on('click', function(event) {

                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 100, function() {
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>
   

    <style type="text/css">
        #p1 {
            text-align: justify;
        }
    </style>



</head>

<body>

<button onclick="topFunction()" class="myBtn" id="myBtn" title="Go to top">Top</button>
<script>
        //Get the button
        var mybutton = document.getElementById("myBtn");
      
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>  

    

    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href='index.php'>
                <img src="images/logo/logo.svg" alt="" class="d-inline-block align-text-top">

            </a>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link active" href="process.php">Cerca Auto</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="#section1">Come Funziona</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="#section2">About</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="garageCheck.php">Garage</a>
                            </li>

                            <li class="nav-item">
                                <?php if (isset($_SESSION['session_user'])) { ?>

                            <li><a class="nav-link active" href="index2.php" title="">Logout</a></li>

                        <?php } else { ?>

                            <li><a class="nav-link active" href="login.html" title="">Login</a></li>

                        <?php } ?>

                        </li>
                        </ul>
                    </div>
                </div>
            </nav>
            </header>
        </div>
    </nav>
    <header class="head-banner text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 style="font-size: 45px;">Troviamo l'auto giusta per te</h2>
                    <h5 style="font-size: 20px;"> Confrontando dettagli, prezzi e promozioni ufficiali tra 49 marche e
                        più di 500 modelli</h5>
                </div>
            </div>
        </div>

        <style>
            @media screen and (max-width: 560px) {
                .search-form-row{
                    flex-direction: column;
                    align-items: center;
                }
            }
        </style>

        <div class="container-sm">
            <form method="post" action="process.php">
                <div class="row search-form-row">
                    <div class="col-3 my-prezzo-home dinamic-col-3-header" style="justify-content: center">
                        <div class="range-slider flat" data-ticks-position='top' style='--min:0; --max:100000; --value-a:0; --value-b:100000; --suffix:"€"; --text-value-a:"0"; --text-value-b:"100000";'>
                            <input name="prezzoBasso" type="range" min="0" max="100000" value="0" oninput="this.parentNode.style.setProperty('--value-a',this.value); this.parentNode.style.setProperty('--text-value-a', JSON.stringify(this.value))">
                            <output style="color: #fff"></output>
                            <input name="prezzoAlto" type="range" min="0" max="100000" value="100000" oninput="this.parentNode.style.setProperty('--value-b',this.value); this.parentNode.style.setProperty('--text-value-b', JSON.stringify(this.value))">
                            <output style="color: #fff"></output>
                            <div class='range-slider__progress'></div>
                        </div>

                    </div>
                    <div class="col-3 dinamic-col-3-header" style="padding-top: 15px;">
                        <select name="scegliCarrozzeria" class="form-select">
                            <option value="">Scegli la carrozzeria...</option>
                            <option value="berlina">Berlina</option>
                            <option value="cabrio">Cabrio</option>
                            <option value="coupe">Coupe</option>
                            <option value="monovolume">Monovolume</option>
                            <option value="suv">Suv/Crossover</option>
                        </select>
                    </div>
                    <div class="col-3 dinamic-col-3-header" style="padding-top: 15px;">
                        <input type="submit" class="btn btn-primary auto-search-btn" value="Trova l'auto!">
                    </div>
                </div>
            </form>
        </div>
    </header>

    <section class="sezione-icone bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div>
                        <h3 id="p1">Nuova Ford Fiesta</h3>
                        <p id="p1" text- class="lead mb-">Ogni viaggio diventa ispirazione. Prenotala subito online!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <p class="lead mb-0"><img class = "fiesta" src="images/fiestahome.png" style = "max-width: 300px"></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <br>
                        <p class="lead mb-0">
                            <form action = "vista.php" method = "post">
                                <input type="hidden" name="scopriBrand" value = "Ford">
                                <input type="hidden" name="scopriAuto" value = "Fiesta">
                                <input type="submit" class= "btn btn-primary btn-lg discover-btn" value="Scopri di più">
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .resize-img{
            width: 100%;
            height: auto;
        }
    </style>
    
    

    <h2 style ="text-align: center; margin-top:20px">Porsche 911 - 360°</h2>
    <section class = "model">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img class="zoom-in" style="text-align:center" onClick="document.getElementById('modal-wrapper').style.display='block'" src="images/CAR.png">
                </div>
            </div>
        </div>
    </section>

    <section class="sezione-brand bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg1">
                    <div>
                        <h2>Che marca preferisci?</h2>
                        <p class="lead mb-">Scegli fra le 50 marche nel nostro listino</p>
                    </div>
                </div>
                <section class="logo-list">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input type="image" src="https://cdn.drivek.it/cars/make/full-logo/alfa-romeo.svg">
                                    <input name="scegliAlfa" class="form-check-input" type="hidden" value="alfa" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input type="image" src="https://cdn.drivek.it/cars/make/full-logo/audi.svg">
                                    <input name="scegliAudi" class="form-check-input" type="hidden" value="audi" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliHyundai" value="hyundai" type="image" src="https://cdn.drivek.it/cars/make/full-logo/hyundai.svg">
                                    <input name="scegliHyundai" class="form-check-input" type="hidden" value="hyundai" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliBmw" value="bmw" type="image" src="https://cdn.drivek.it/cars/make/full-logo/bmw.svg">
                                    <input name="scegliBmw" class="form-check-input" type="hidden" value="bmw" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliCitroen" value="citroen" type="image" src="https://cdn.drivek.it/cars/make/full-logo/citroen.svg">
                                    <input name="scegliCitroen" class="form-check-input" type="hidden" value="citroen" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliDacia" value="dacia" type="image" src="https://cdn.drivek.it/cars/make/full-logo/dacia.svg">
                                    <input name="scegliDacia" class="form-check-input" type="hidden" value="dacia" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliDR" value="dr" type="image" src="https://cdn.drivek.it/cars/make/full-logo/dr-automobiles.svg">
                                    <input name="scegliDR" class="form-check-input" type="hidden" value="dr" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliDS" value="ds" type="image" src="https://cdn.drivek.it/cars/make/full-logo/ds.svg">
                                    <input name="scegliiDS" class="form-check-input" type="hidden" value="ds" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliEvo" value="evo" type="image" src="https://cdn.drivek.it/cars/make/full-logo/evo.svg">
                                    <input name="scegliEvo" class="form-check-input" type="hidden" value="evo" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliFiat" value="fiat" type="image" src="https://cdn.drivek.it/cars/make/full-logo/fiat.svg">
                                    <input name="scegliFiat" class="form-check-input" type="hidden" value="fiat" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliFord" value="ford" type="image" src="https://cdn.drivek.it/cars/make/full-logo/ford.svg">
                                    <input name="scegliFord" class="form-check-input" type="hidden" value="ford" id="flexCheckDefault14">
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <form method="post" action="process.php">
                                    <input name="scegliHonda" value="honda" type="image" src="https://cdn.drivek.it/cars/make/full-logo/honda.svg">
                                    <input name="scegliHonda" class="form-check-input" type="hidden" value="honda" id="flexCheckDefault14">
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>



    <section class="sezione-funzionamento text-center" id="section1">
        <div class="container">
            <div class="row">
                <div class="col-lg1">
                    <div>
                        <h2 style="font-size: 40px;">Come funziona CarSetting</h2>
                        <p class="lead mb-">CarSetting in tre semplici passi</p>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div>

                            <svg style='max-width:50px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
                                <path d="M38.176 24.23l-7.888-7.888a8.517 8.517 0 1 0-2.122 2.121l7.888 7.888zm-14.859-7.237a5.496 5.496 0 1 1 5.499-5.498 5.489 5.489 0 0 1-5.499 5.498zM1.824 27v6h7v4h6v-4h2V21l-3-1-2-10h-10v15m9 3a2 2 0 1 1 2-2 2 2 0 0 1-2 2z" fill="#0083c2"></path>
                            </svg>
                            <h5 class="color--primary">PRIMO PASSO</h5>
                            <h4>Cerca la tua auto ideali</h4>
                            <p text- class="lead mb-">Ti offriamo un configuratore auto avanzato. Usa i nostri
                                filtri su tutto il listino per trovare l'auto giusta per te</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>

                            <svg style='max-width:50px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
                                <path d="M34 20l-2-10H12V8h7l-1-5H6L4.8 9 3 9.6V16h1v2h4v-2h2.8l-.8 4-3 1v12h2v4h6v-4h14v4h6v-4h2V21l-3-1zM7 13c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm6 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm18 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" fill="#0083c2"></path>
                            </svg>
                            <h5 class="color--primary">SECONDO PASSO</h5>
                            <h4>Confrontala
                                con gli altri modelli</h4>
                            <p text- class="lead mb-">Ancora non sei sicuro? Sfrutta la nostra funzionalità di
                                confronto per confrontare la tua auto con le altre sul mercato e vivile con il
                                nostro showroom virtuale a 360°</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <svg style='max-width:50px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
                                <path d="M31.386 14.286A6.455 6.455 0 0 1 24 7.854c0-.17.013-.335.025-.5H10l-2 10-3 1v12h2v4h6v-4h14v4h6v-4h2v-12l-3-1zM11 25.354a2 2 0 1 1 2-2 2 2 0 0 1-2 2zm18 0a2 2 0 1 1 2-2 2 2 0 0 1-2 2zm1-14.586L27.293 8.06l1.414-1.415L30 7.94l2.293-2.293 1.414 1.415z" fill="#0083c2"></path>
                            </svg>
                            <h5 class="color--primary">TERZO PASSO</h5>
                            <h4>Chiedi un preventivo
                                gratis </h4>
                            <p text- class="lead mb-">Richiedi un preventivo o un test drive in pochi click. Ti
                                mettiamo in contatto con il concessionario ufficiale più vicino a te e ti aiutiamo
                                fino all'acquisto, gratis</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>

    <style>
        footer {
            margin-top: 20px;
        }
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

    <footer class="bg-dark text-center text-white" id = "section2">

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
        $(window).on('load resize', function() {
            width = this.innerWidth;
            height = this.innerHeight;
            var array = [];

            if (width <= 560) {
                array = document.getElementsByClassName('dinamic-col-3-header');
                el = document.getElementsByClassName('dinamic-360')[0];
                el.style.width = "100%";
                el.style.height= "auto";
                for(var i = 0; i < array.length; i++) {
                    if(array[i].className.includes("my")) array[i].className = "col-10 my-prezzo-home dinamic-col-10-header";
                    else array[i].className = "col-10 dinamic-col-10-header";
                }

            } else {
                array = document.getElementsByClassName('dinamic-col-10-header');
                el = document.getElementsByClassName('dinamic-360')[0];
                el.style.removeProperty("width");
                el.style.removeProperty("height");
                for(var i = 0; i < array.length; i++) {
                    if(array[i].className.includes("my")) array[i].className = "col-3 my-prezzo-home dinamic-col-3-header";
                    else array[i].className = "col-3 dinamic-col-3-header";
                }
            }

            if(width <= 720) {
                array = document.getElementsByClassName('col-3 dinamic-col');
                for (var i = 0; i < array.length; i++) array[i].className ='col-6 dinamic-col'; 
            } else {
                array = document.getElementsByClassName('col-6 dinamic-col');

                for (var i = 0; i < array.length; i++) array[i].className ='col-3 dinamic-col'; 
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>



    <div id="modal-wrapper" class="modal">
        <div class="center dinamic-360">
            <span onClick="document.getElementById('modal-wrapper').style.display='none'" class="close" style="color: #fff">&times;</span>
            <div class="rotation">
                <img class = "pictres" src="images/360/2.png">
                <img class = "pictres" src="images/360/3.png">
                <img class = "pictres" src="images/360/4.png">
                <img class = "pictres" src="images/360/5.png">
                <img class = "pictres" src="images/360/6.png">
                <img class = "pictres" src="images/360/7.png">
                <img class = "pictres" src="images/360/8.png">
                <img class = "pictres" src="images/360/9.png">
                <img class = "pictres" src="images/360/10.png">
                <img class = "pictres" src="images/360/11.png">
                <img class = "pictres" src="images/360/12.png">
                <img class = "pictres" src="images/360/13.png">
                <img class = "pictres" src="images/360/14.png">
                <img class = "pictres" src="images/360/15.png">
                <img class = "pictres" src="images/360/16.png">
                <img class = "pictres" src="images/360/17.png">
                <img class = "pictres" src="images/360/18.png">
                <img class = "pictres" src="images/360/19.png">
                <img class = "pictres" src="images/360/20.png">
                <img class = "pictres" src="images/360/21.png">
                <img class = "pictres" src="images/360/22.png">
                <img class = "pictres" src="images/360/23.png">
                <img class = "pictres" src="images/360/24.png">
                <img class = "pictres" src="images/360/25.png">
                <img class = "pictres" src="images/360/26.png">
                <img class = "pictres" src="images/360/27.png">
                <img class = "pictres" src="images/360/28.png">
                <img class = "pictres" src="images/360/29.png">
                <img class = "pictres" src="images/360/30.png">
                <img class = "pictres" src="images/360/31.png">
                <img class = "pictres" src="images/360/32.png">
                <img class = "pictres" src="images/360/33.png">
                <img class = "pictres" src="images/360/34.png">
                <img class = "pictres" src="images/360/35.png">
                <img class = "pictres" src="images/360/36.png">
                <img class = "pictres" src="images/360/37.png">
                <img class = "pictres" src="images/360/38.png">
                <img class = "pictres" src="images/360/39.png">
                <img class = "pictres" src="images/360/40.png">
                <img class = "pictres" src="images/360/41.png">
                <img class = "pictres" src="images/360/42.png">
                <img class = "pictres" src="images/360/43.png">
                <img class = "pictres" src="images/360/44.png">
                <img class = "pictres" src="images/360/45.png">
            </div>
        </div>
    </div>
    <script src="js/360deg.js"></script>

</body>

</html>
</body>

</html>