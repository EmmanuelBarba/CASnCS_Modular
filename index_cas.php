<?php

require_once 'config/functions.php';

$conexion = connect($server,$db,$user,$pass);
if(!$conexion){
    header('Location: config/404.php');
}
session_start();//se crea la sesion

if(isset($_SESSION['acceso'])){
    header('Location: acceso_cas.php');
}
//se verifica si existe el envio de datos. Inicio de sesion
if(isset($_POST['login'])){
    $user = ($_POST['name']);
    $state = $conexion->prepare("SELECT nombre_taller, pass_taller, type FROM admin_taller WHERE nombre_taller = :user");
    // $state = $conexion->prepare("SELECT name, pass, type FROM users WHERE name = :user");//busqueda preparada
    $state->bindValue(':user', $user);//se utiliza la variable de usuario en la validacion
    $state->execute();//se ejecuta la busqueda

    $result = $state->fetch(PDO::FETCH_ASSOC);

    if($result === false){
        $error2="";
    }else{
        if(password_verify($_POST['pass'], $result['pass_taller'])) {
            $_SESSION['acceso'] = $result['nombre_taller'];//se asigna en nombre
            $_SESSION['permisos'] = $result['type'];//se asigna el permiso
            header('Location: acceso_cas.php');
           }else{
            $error2="";
        }
    }

}

if(isset($_SESSION['acceso'])){
    if($_SESSION['permisos']=="admin"){
        $name="admin";
    }else{
        $name=($_SESSION['acceso']);
    }
    
}else{
    $name="Def_Users";
}

//Se verifica si existe el envio de datos. Registro
if(isset($_POST['reg'])){
    $name = $_POST["name"];//variable con el nombre de usuario
    $pass = $_POST["pass"];//variable con la contraseña
    $telefono  = $_POST["telefono"];
    $email = $POST["email"];
    $domicilio = $POST["domicilio"];
    
    //queremos saber si existe
    $validar = $conexion->prepare("SELECT nombre_taller FROM admin_taller WHERE  nombre_taller= .$name. LIMIT 1;");
    $validar->execute([$name]);
    //Ver cuántas filas devuelve
    $filas = $validar->rowCount();

    //Si son 0 o menos, significa que no existe
    if ($filas <= 0) {
        $passHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
        $insert = $conexion->prepare("INSERT INTO admin_taller (nombre_taller, tel_taller, mail_taller, domicilio_taller, pass_taller,
         type) VALUES (:name, :telefono, :email, :domicilio, :pass, :type)");//registro de datos
        $insert->execute(array(
            ':name' => $_POST['name'],
            ':pass' => $passHash,
            ':email' => $_POST['email'],
            ':telefono' => $_POST['telefono'],
            ':domicilio' => $_POST['domicilio'],
            ':type' => "user"
        ));
        //  $state->bindParam(':nombre_taller', $name, PDO::PARAM_STR);
        //  $state->bindParam(':tel_taller', $telefono, PDO::PARAM_STR);
        //  $state->bindParam(':mail_taller', $email, PDO::PARAM_STR);
        //  $state->bindParam(':pass_taller', $passHash, PDO::PARAM_STR);
        //  $state->bindParam(':domicilio_taller', $domicilio, PDO::PARAM_STR);
        //  $state->execute();

        $insert = $conexion->prepare("INSERT INTO users (name, email, pass, type) VALUES (:name, :email, :pass, :type)");//registro de datos
        $insert->execute(array(
            ':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':pass' => $passHash,
            ':type' => "user"
        ));
        //se crea la tabla para el usuario
        $conexion->exec("CREATE TABLE ".$name." (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(35),
            intro TEXT,
            descripcion TEXT,
            image VARCHAR(255)
        );");

        $_SESSION['acceso'] = $_POST["name"];//se asigna en nombre
        $_SESSION['permisos'] = "user";//se asigna el permiso

        mkdir("img/admins/$name", 0755);//se crea su propia carpeta

        header('Location: acceso_cas.php');
        
     } else {
         $error = "";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logos/img.04.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://mod2021cas.s3.amazonaws.com/Web/CAS+%26+CAR+SERVICE/Assets/CSS/slick.css"> 
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
        <!-- EN CASO DE PEDO BORRAR LA LINEA DEBAJO -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- MODAL DE FORMULARIO -->
        <link rel="stylesheet" href="https://mod2021cas.s3.amazonaws.com/Web/CAS+%26+CAR+SERVICE/Assets/CSS/modal.css">
        <link rel="stylesheet" href="https://mod2021cas.s3.amazonaws.com/Web/CAS+%26+CAR+SERVICE/Assets/CSS/jquery.modally.css">
        <title>CAS</title>
    </head>

<!-- PRINCIPAL INICIO -->
    <body id="pop">
        <!-- NAVEGACIÓN -->
            <!-- MENÚ -->
                <!-- MENU  -->
                        <!-- MENU CON MIVIMIENTO LIBRE PARA EL RESPONSIVE -->
                                <nav class="body">
                                    <div class="navigation">
                                        <div class="toggle"></div> 
                                        <ul>
                                            <li>
                                                <a href="#lorem" target="_modal">
                                                    <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                    <span class="title">Home</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                    <span class="title">Profile</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#dolorr" target="_modal">
                                                    <span class="icon"><i class="fa fa-comment-o" aria-hidden="true"></i></span>
                                                    <span class="title">Messages</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="icon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                    <span class="title">Settings</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                    <span class="title">Password</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="icon"><i class="fa fa-sign-in" aria-hidden="true"></i></span>
                                                    <span class="title">Sing Out</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                    <!-- MENU CON MIVIMIENTO LIBRE PARA EL RESPONSIVE -->
                    <div class="positioner">
                        <!-- SOCIAL  -->
                        <div class="menu">
                            <!-- <div class="menu-title">
                                 Admin CAS
                            </div> -->
                            <?php echo "<div class='menu-title'>$name</div>";?>

                            <div class="menu-item" href="#dolorr" target="_modal:open">
                                <input type="radio" class="toggle" name="menu_group" id="sneaky-toggle" href="#dolorr" target="_modal:open">
                                <div class="expander" href="#dolorr" target="_modal:open">
                                    <label for="sneaky_toggle" href="#dolorr" target="_modal:open">
                                        <i class="menu-icon fa fa-home" href="#dolorr" target="_modal:open" ></i>
                                        <span class="menu-text" href="#dolorr" target="_modal:open">Inicio</span>
                                    </label>
                                </div>
                            </div>

                        <a href="#dolorr" target="_modal:open">
                            <div class="menu-item" href="#dolorr" target="_modal:open">
                                <input type="radio" class="toggle" name="menu_group"id="sneaky-toggle2">
                                <div class="expander">
                                    <label for="sneaky_toggle2">
                                        
                                        <i class="menu-icon fa fa-user" href="#dolorr" target="_modal:open"></i>
                                        <span class="menu-text">Profile</span>
                                    </label>
                                </div>
                            </div>
                        </a>

                        <a href="#dolorr" target="_modal:open">
                            <div class="menu-item">
                                <input type="radio" class="toggle" name="menu_group"id="sneaky-toggle3">
                                <div class="expander">
                                    <label for="sneaky_toggle3">
                                        <i class="menu-icon fa fa-file"></i>
                                        <span class="menu-text">Servicios</span>
                                    </label>
                                </div>
                            </div>
                        </a>

                            <div class="menu-item">
                                <input type="radio" class="toggle" name="menu_group"id="sneaky-toggle4">
                                <div class="expander">
                                    <label for="sneaky_toggle4">
                                        <i class="menu-icon fa fa-edit"></i>
                                        <span class="menu-text">Compras</span>
                                    </label>
                                </div>
                            </div>

                            <div class="menu-item">
                                <input type="radio" class="toggle" name="menu_group"id="sneaky-toggle5">
                                <div class="expander">
                                    <label for="sneaky_toggle5">
                                        <i class="menu-icon fa fa-edit"></i>
                                        <span class="menu-text">Ordenes</span>
                                    </label>
                                </div>
                            </div>

                            <div class="menu-item">
                                <input type="radio" class="toggle" name="menu_group"id="sneaky-toggle6">
                                <div class="expander">
                                    <label for="sneaky_toggle6">
                                        <i class="menu-icon fa fa-envelope"></i>
                                        <span class="menu-text">Contacto</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- CONTENEDOR PADRE -->
                <header id="fullpage">
                    <div class="banner-area" id="slick-slide-control00">
                
                        <!-- PRIMER SECCIÓN  -->

                            <div class="sigle-banner, img1"  id="section1">
                                <br> 
                                <img src="https://mod2021cas.s3.amazonaws.com/Images+modular/Logos+CAS/img.01.png" class="logo" >
                                <div class="line typer">Bienvenido Al Portal De Servicios En Gestión Automotríz.</div>
                                <div class="banner-text">
                                <!-- <br><br><br><br><br><br><br><br><br> -->
                                <br><br><br><br><br><br><br>
                                <div class="ghost">Gestión Automotríz</div> 
                                <br>
                                <a href="#lorem" target="_modal" class="button white">Logearse</a>
                                    <!-- ONDAS DE ADORNO "WAVE" -->
                                <div class="wave"></div><div class="wave wave2"></div><div class="wave wave3"></div>
                                <div class="wav"></div><div class="wav wav2"></div><div class="wav wav3"></div>
                                    <!--  FIN DE ONDAS DE ADORNO "WAVE" -->
                                <div id="lorem" modally-max_width="500">
                                    <!-- <h1 class="modal-title serif">Bienvenido</h1> -->

                                    <!-- Contenedor registro/login  -->
                                        
                                    <section class="registro" id="color2">
                                        <div class="contenedor-form">
                                        <div class="toggle">
                                            <span> Crear Cuenta</span>
                                        </div>
                                        
                                        <div class="formulario">
                                            <h2>Iniciar Sesión</h2>
                                            <form action="#" method="POST">
                                                <input type="text"     name="name" placeholder="Usuario" required>
                                                <input type="password" name="pass" placeholder="Contraseña" required>
                                                <input type="submit"   name="login" value="Iniciar Sesión">
                                                <?php if (isset($error2)){ echo "<p style='color:white;'>Datos no validos</p>";} ?>
                                            </form>
                                            <div class="reset-password">
                                            <a href="#dolorr" target="_modal:open">Olvide mi Contraseña?</a>
                                        </div> 
                                        </div>
                                        
                                        <div class="formulario">
                                            <h2>Crea tu Cuenta</h2>
                                            <form action="#" method="POST">
                                                <input type="text" name="name" placeholder="Usuario Taller" required>
                                                
                                                <input type="password" name="pass" placeholder="Contraseña" required>
                                                
                                                <input type="email"  name="email" placeholder="Correo Electronico" required>
                                                
                                                <input type="text"   name="telefono"  placeholder="Teléfono" required>

                                                <!-- <input type="text" placeholder="Ciudad" required>] -->

                                                <input type="text" name="domicilio" placeholder="Domicilio" required>
                                                
                                                <input type="submit"  name="reg" value="Registrarse">

                                                <?php if (isset($error)){ echo "<label style='color:white;'> El Usuario ya existe</label>";} ?>
                                            </form>
                                        </div>
                                        <!-- <div class="reset-password">
                                            <a href="#">Olvide mi Contraseña?</a>
                                        </div> -->
                                        </div>
                                    </section>

                                    </div>
                                    <!-- modally-max_width="380" -->
                                    <div id="dolorr" modally-max_width="323">
                                        <div class="chatbot">
                                        <iframe width="278" height="520" allow="microphone;" src="https://console.dialogflow.com/api-client/demo/embedded/9c7656be-7921-441f-b4c9-408a4646b170"></iframe>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <!-- SEGUNDA SECCIÓN  -->

                            <div class="sigle-banner">
                                <div class="img2">
                                    <!-- <h2>jaja</h2> -->
                                </div>
                                <div class="banner-text">
                                    <h2>¿Quienes somos?</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                    Quibusdam aliquid maxime reprehenderit dolorem incidunt.</p>
                                    <p class="banner-btn"><a href="#">Contact US</a></p>
                                </div>
                            </div>

                        <!-- TERCERA SECCIÓN  -->

                            <div class="sigle-banner">
                                <div class="img3">
                                    <!-- <h2>jaja</h2> -->
                                </div>
                                <div class="banner-text">
                                    <h2> Nuestros Servicios</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                    Quibusdam aliquid maxime reprehenderit dolorem incidunt.</p>
                                    <p class="banner-btn"><a href="#">Contact US</a></p>
                                </div>
                            </div>

                        <!-- CUARTA SECCIÓN  -->

                            <div class="sigle-banner">
                                <div class="img4">
                                    <!-- <h2>jaja</h2> -->
                                </div>
                                <div class="banner-text">
                                    <h2>Ordenes SG</h2>
                                    <div class="process-wrapper">
                                        <div id="progress-bar-container">
                                            <ul>
                                                <li class="step step01 active"><div class="step-inner">HOME WORK</div></li>
                                                <li class="step step02"><div class="step-inner">RESPONSIVE</div></li>
                                                <li class="step step03"><div class="step-inner">CREATIVE</div></li>
                                                <li class="step step04"><div class="step-inner">TESTIMONIALS</div></li>
                                                <li class="step step05"><div class="step-inner">OUR LOCATIONS</div></li>
                                            </ul>
                                            
                                            <div id="line">
                                                <div id="line-progress"></div>
                                            </div>
                                        </div>

                                        <div id="progress-content-section">
                                            <div class="section-content discovery active">
                                                <h2>HOME SECTION</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec neque justo, consequat non fermentum ac, tempor eu turpis. Proin nulla eros, placerat non ipsum ut, dapibus ullamcorper ex. Nulla in dapibus lorem. Suspendisse vitae velit ac ante consequat placerat ut sed eros. Nullam porttitor mattis mi, id fringilla ex consequat eu. Praesent pulvinar tincidunt leo et condimentum. Maecenas volutpat turpis at felis egestas malesuada. Phasellus sem odio, venenatis at ex a, lacinia suscipit orci.</p>
                                            </div>
                                            
                                            <div class="section-content strategy">
                                                <h2>GALLERY SECTION</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec neque justo, consequat non fermentum ac, tempor eu turpis. Proin nulla eros, placerat non ipsum ut, dapibus ullamcorper ex. Nulla in dapibus lorem. Suspendisse vitae velit ac ante consequat placerat ut sed eros. Nullam porttitor mattis mi, id fringilla ex consequat eu. Praesent pulvinar tincidunt leo et condimentum. Maecenas volutpat turpis at felis egestas malesuada. Phasellus sem odio, venenatis at ex a, lacinia suscipit orci.</p>
                                            </div>
                                            
                                            <div class="section-content creative">
                                                <h2>Creative CREATIONS</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec neque justo, consequat non fermentum ac, tempor eu turpis. Proin nulla eros, placerat non ipsum ut, dapibus ullamcorper ex. Nulla in dapibus lorem. Suspendisse vitae velit ac ante consequat placerat ut sed eros. Nullam porttitor mattis mi, id fringilla ex consequat eu. Praesent pulvinar tincidunt leo et condimentum. Maecenas volutpat turpis at felis egestas malesuada. Phasellus sem odio, venenatis at ex a, lacinia suscipit orci.</p>
                                            </div>
                                            
                                            <div class="section-content production">
                                                <h2>TESTIMONIALS NOW</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec neque justo, consequat non fermentum ac, tempor eu turpis. Proin nulla eros, placerat non ipsum ut, dapibus ullamcorper ex. Nulla in dapibus lorem. Suspendisse vitae velit ac ante consequat placerat ut sed eros. Nullam porttitor mattis mi, id fringilla ex consequat eu. Praesent pulvinar tincidunt leo et condimentum. Maecenas volutpat turpis at felis egestas malesuada. Phasellus sem odio, venenatis at ex a, lacinia suscipit orci.</p>
                                            </div>
                                            
                                            <div class="section-content analysis">
                                                <h2>OUR LOCATIONS</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec neque justo, consequat non fermentum ac, tempor eu turpis. Proin nulla eros, placerat non ipsum ut, dapibus ullamcorper ex. Nulla in dapibus lorem. Suspendisse vitae velit ac ante consequat placerat ut sed eros. Nullam porttitor mattis mi, id fringilla ex consequat eu. Praesent pulvinar tincidunt leo et condimentum. Maecenas volutpat turpis at felis egestas malesuada. Phasellus sem odio, venenatis at ex a, lacinia suscipit orci.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- QUINTA SECCIÓN  -->

                            <div class="sigle-banner">
                                <div class="img5">
                                    <!-- <h2>jaja</h2> -->
                                </div>
                                <div class="banner-text">
                                    <h2>Galería</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                    Quibusdam aliquid maxime reprehenderit dolorem incidunt.</p>
                                    <p class="banner-btn"><a href="#">Contact US</a></p>
                                </div>
                            </div>

                        <!-- SEXTA SECCIÓN  -->

                            <div class="sigle-banner">
                                <div class="img6">
                                    <!-- <h2>jaja</h2> -->
                                </div>
                                <div class="banner-text">
                                    <h2>Contactanos</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                    Quibusdam aliquid maxime reprehenderit dolorem incidunt.</p>
                                    <p class="banner-btn"><a href="#">Contact US</a></p>
                                </div>
                            </div>
                    <!-- FIN PADRE  -->
                    </div>
                </header>
            <!-- CONTENEDOR PADRE      -->
    </body>

    <footer>
        <div class="social-bar">
            <a href="https://www.facebook.com/bittecnologia81" class="icon icon-facebook" target="_blank"></a>
            <a href="https://twitter.com/DevCodela" class="icon icon-twitter" target="_blank"></a>
            <a href="https://www.youtube.com/c/devcodela" class="icon icon-youtube" target="_blank"></a>
            <a href="https://www.instagram.com/bit_tecnologia_81b/" class="icon icon-instagram" target="_blank"></a>
        </div>
    </footer>

<!-- JAVASCRIPT -->

<!-- <script src="assets/js/jquery-3.1.1.min.js"></script>    -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://mod2021cas.s3.amazonaws.com/Web/CAS+%26+CAR+SERVICE/Assets/JS/main.js"></script> 
    <script type="text/javascript" src="https://mod2021cas.s3.amazonaws.com/Web/CAS+%26+CAR+SERVICE/Assets/JS/jquery.modally.js"></script>
    <script src="https://mod2021cas.s3.amazonaws.com/Web/CAS+%26+CAR+SERVICE/Assets/JS/slick.min.js"></script>

<!-- SCRIPT PARA EL MODAL DE FORMULARIO  -->

    <script type="text/javascript">
        jQuery(document).ready(function() {
            // $('#ipsum').modally('ipsum', {max_width: 800});
            $('#lorem').modally();
            // $('#dolor').modally();
            $('#dolorr').modally();
        });
    </script>

<!-- SCRIPT PARA EL EFECtO DE TRANSICIÓN  -->

    <Script>
        $('.banner-area').slick({
            autoplay: false, speed:800, arrows: false, dots: true, fade: true
            // scrollBar: true,
            // navigation: true,
            // navigationTooltips: ['Inicio', '¿Quienes somos?', 'Servicios', 'Compras', 'Ordenes', 'Contacto'],
            // loopBottom: true,
            // sectionSelector: 'section'
        });
    </Script>

<!-- SCRIPT PARA EL MENU CON MOVIMIENTO LIBRE -->

    <script>
            const navigation = document.querySelector('.navigation');
            document.querySelector('.toggle').onclick = function(){
                this.classList.toggle('active'),
                navigation.classList.toggle('active');
            }
    </script>
    
    <!-- ondblclick para dos clicks, onclick para uno, caomentar la navegación si no quieres que se mueva libremente el menú  -->

<!-- SCRIPT PARA EL MENU CON MOVIMIENTO LIBRE -->
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
        //   $(".navigation").draggable();//comentar sino quieres que se mueva libre y se quede fijo
        } );
    </script>
<!-- SCRIPT PARA EL MENU CON MOVIMIENTO LIBRE -->

<!-- SCRIPT PARA LA BARRA DE PROGRESO DE LAS ORDENES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(".step").click( function() {
            $(this).addClass("active").prevAll().addClass("active");
            $(this).nextAll().removeClass("active");
        });

        $(".step01").click( function() {
            $("#line-progress").css("width", "3%");
            $(".discovery").addClass("active").siblings().removeClass("active");
        });

        $(".step02").click( function() {
            $("#line-progress").css("width", "25%");
            $(".strategy").addClass("active").siblings().removeClass("active");
        });

        $(".step03").click( function() {
            $("#line-progress").css("width", "50%");
            $(".creative").addClass("active").siblings().removeClass("active");
        });

        $(".step04").click( function() {
            $("#line-progress").css("width", "75%");
            $(".production").addClass("active").siblings().removeClass("active");
        });

        $(".step05").click( function() {
            $("#line-progress").css("width", "100%");
            $(".analysis").addClass("active").siblings().removeClass("active");
        });
    </script>
<!-- FIN SCRIPT PARA LA BARRA DE PROGRSO DE LAS ORDENES -->

<!-- SCRIPT PARA EL CHATBOT -->
    <!-- DIALOGFLOW CON MICRO  -->

        <!-- DESHABILITADO POR EL MOMENTO, SE ENCUENTRA EN MESSAGES(MENÚ PRINCIPAL) -->

    <!-- DIALOGFLOW CHAT BETA -->

        <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
        <df-messenger
        intent="WELCOME"
        chat-title="C&CS"
        agent-id="9c7656be-7921-441f-b4c9-408a4646b170"
        language-code="es"
        ></df-messenger>
        
<!-- FIN SCRIPT PARA EL CHATBOT -->

</html>

<!-- ESTILOS -->

  <!-- ESTILO SLIDER Y FONDOS -->

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,body{
            overflow-x: hidden;
            overflow-y: hidden; 
            height:100%;
            width:101%;
            margin: 0px;

        }

        body{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .banner-area, 
        .single-banner{
            height: 100vh;
        }

        .single-banner{
            position: relative;
        }

        .single-banner .banner-img{
            width: 100%;
            height: auto;
            overflow: hidden;
        }

        img.logo {
            display: block;
            margin: auto;
            justify-content: center;
            filter: drop-shadow(1px 4px 3px #f03);
            mix-blend-mode: color-burn;
            animation: change 0.5s .03s forwards;
            width: 100%;
            height: 100%;
            max-width: 431px;
            max-height: 445px;
            min-width: 200px;
            min-height: 120px;
            z-index: 0;
            position: sticky;
            display: block;
            margin: auto;
        }

        .logo:hover{
            cursor: pointer;
            filter: drop-shadow(10px 4px 48px crimson); 
            mix-blend-mode: color;
            /* box-shadow: 3px 3px 10px 0 rgba(220, 20, 60, 0.452); */
        }
         
        .img1 {
            background-image: linear-gradient(to top, rgb(15, 0, 0) 0%, hsla(0, 0%, 100%, 0.36) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(17).webp");
            /* background-image: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(28).webp"); */
            background-size: cover;
            background-attachment: fixed;
            width: 100%;
            height: 100vh;
        }

        .img2{
            background-image: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(15).webp");
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
        }

        .img3{
            background-image: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(9).webp");
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
        }

        .img4{
            background-image: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(10).webp");
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
        }

        .img5{
            background-image: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(14).webp");
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
        }

        .img6{
            background-image: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%), url("https://mod2021cas.s3.amazonaws.com/Images+modular/Images+CAS/img+(42).webp");
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
        }

        /* BOTON LOGIN */

        .button.white {
            border: solid 3px #ffffff;
            text-decoration: unset;
            transform: translateY(40%);
        }

        .button {
            cursor: pointer;
            text-decoration: unset;
            border: solid 3px white;
            font-size: 12px;
            letter-spacing: 5px;
            color: white;
            background: #00000000;
            text-decoration: none;
            border-radius: 96px 25px;
            transition: all 0.3s;
            z-index: 5;
            position: sticky;
            margin: auto;
         }

         .button:hover{
            border-radius: 96px 25px;
            cursor: pointer;
            border: solid 3px crimson;
            background-color: white;
            color: #222;
            text-decoration: none;
            /* border-color: white; */
            box-shadow: 3px 3px 10px 0 rgba(220, 20, 60, 0.452);
            /* box-shadow: 0 0 .5rem crimson; */
        }

         /* Modal de la ventana */

         .button.small {
            text-decoration: none;
        }

         .modally-wrap .modally-underlay {
            background: linear-gradient(to top, rgb(0 0 0) 0%, hsl(0deg 0% 26% / 70%) 100%);
        }

        .modally{
            background: #2d2d2d;
            background-color: rgba(45, 45, 45, 0.99);
            background-position-x: 0%;
            background-position-y: 0%;
            background-repeat: repeat;
            background-attachment: scroll;
            background-image: none;
            background-size: auto;
            background-origin: padding-box;
            background-clip: border-box;
            box-shadow: 5px 5px 5px 0 rgba(220, 20, 60, 0.452);
            border: solid 3px crimson;
            color: #ffffffa3;
        }

        .banner-text{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            text-align: center;
        }

        .banner-text h2{
            font-size: 55px;
            text-transform: uppercase;
            color: rgba(255, 255, 255);
            margin: 0;
            z-index: 4;
            position: sticky;
            display: block;
            margin: auto;
            /* filter: drop-shadow(3px 3px 3px #dc143c69); */
        }
        .ghost{
            font-size: 55px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0);
            margin: 0;
            z-index: 4;
            position: sticky;
            display: block;
            margin: auto; 
        }


        .banner-text p{
            color: #fff;
        }
        
        .banner-btn a{
            text-decoration: none;
            background: crimson;
            color: #fff;
            padding: 15px 25px;
            border-radius: 73px 15px;
            border: 1px solid;
            display: inline-block;
            text-transform: uppercase;
        }

        .slick-dots{
            position: absolute;
            bottom: 25px;
            list-style: none;
            display: block;
            text-align: center;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .slick-dots li{
            position: relative;
            display: inline-block;
            margin: 0 5px;
            padding: 0;
            cursor: pointer;
        }

        .slick-dots li button{
            position: relative;
            background-color: #fff;
            opacity: .25;
            width: 50px;
            height: 3px;
            padding: 0;
            font-size: 0;
        }

        .slick-dots li.slick-active button{
            color: #fff;
            opacity: .75;
        }

    </style>

  <!-- ESTILO MENÚ NAVIGATION  -->
    <style >
        .menu{
            font-family: sans-serif;
            display: table;
            position: fixed;
            z-index: 1;
            right: 2.2px;
            box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
            padding: .5rem;
            cursor: pointer;
        }

        .menu-title {
            color: white;
            font-size: 2rem;
            display: ´block;
            float: left;
            line-height: 4rem;
            padding: 1;
            box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
            cursor: pointer;
        }

        label {
            display: inline-block;
            max-width: 100%;
            margin-top: -12px;
            font-weight: 600;
            cursor: pointer;
        }

        .menu:before{
            left: -0.50rem;
        }

        .menu:after{
            left: -0.50rem;
        }

        .menu-item {
            display: block;
            float: left;
            white-space: nowrap;
            color: crimson;
            font-size: 2rem;
            line-height: 1.5rem;
            /* font-size: 2rem; */
            box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .fa {
            display: inline-block;
            font: normal normal normal 29px/1 FontAwesome;
            font-size: 27px;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            cursor: pointer;
        }

        .menu-item .expander {
            max-width: 30px;
            overflow: hidden;
            transition: all cubic-bezier(0.46, 0.03, 0.52, 0.96) 340ms;
            padding-top: 15px;
            padding-left: 5px;
            height: 4rem;
            cursor: pointer;
        }

        .menu-item:last-child{
            margin-right: 0;
        }

        .menu-item .toggle{
            display: none;
        }

        .menu-item .toggle:checked ~ .expander{
            max-width: 16rem;
            background: #222;
            cursor: pointer;
        }

        .menu-item .toggle:checked ~ .expander .menu-icon{
            color: white;
            animation: none;
        }

        .menu-item .toggle:checked ~ .expander .menu-text{
            color: white;
        }

        .menu-item .expander:hover{
            background: rgba(133, 133, 136, 0.637);
            padding-right: 12rem;
            height: 4rem;
        }

        .menu-item .expander:hover .menu-icon{
            color: white;
            animation: jiggle ease-in-out 400ms infinite;
        }

        .menu-item menu-icon{
            display: inline-block;
            font-size: 5rem;
            line-height: 3rem;
            vertical-align: middle;
            width: 4rem;
            text-align: center;
            margin-right: 0.5rem;
            transition: color ease-in-out 80ms;
            cursor: pointer;
        }

        .menu-item menu-text{
            line-height: 0rem;
            color: transparent;
            display: inline-block;
            vertical-align: middle;
            padding-right: 1.5rem;
            transition: color ease-in-out 333ms;
            box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
        }

        .positioner{
            display: table;
        }

        @keyframes jiggle{
            0%{
                transform: none;
            }
            25%{
                transform: rotateZ(5deg);
            }
            75%{
                transform: rotateZ(-5deg);
            }
            100%{
                transform: none;
            }

        }
    </style>


<!-- ESTILO DE FONTS Y SU MAIN DEL SOCIAL  -->

<style>
    .social-bar {
        position: fixed;
        right: 0;
        top: 70%;
        /* font-size: 1.5rem; */
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        z-index: 1;
    }
    
    .icon {
        color: rgb(0, 0, 0);
        text-decoration: none;
        padding: .7rem;
        /* padding-right: 1rem; poner esto en min with  */
        display: flex;
        transition: all .5s;
    }
    
    .icon-facebook, .icon-twitter, .icon-youtube, .icon-instagram{
        background: #ffffff38;
    }
    
    .icon:first-child {
        border-radius: 1rem 0 0 0;
    }
    
    .icon:last-child {
        border-radius: 0 0 0 1rem;
    }
    
    .icon:hover {
        padding-right: 3rem;
        border-radius: 1rem 0 0 1rem;
        color: crimson;
        text-decoration: none;
        box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
    }
    
    @font-face {
      font-family: 'icomoon';
      src:  url('https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.eot');/*https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.eot*/
      src:  url('https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.eot?i226ha#iefix') format('embedded-opentype'),
        url('https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.ttf') format('truetype'),/*https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.ttf*/
        url('assets/fonts/icomoon.woff?i226ha') format('woff'),/*https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.woff*/
        url('https://sors7cualtos.s3.amazonaws.com/SOR/icomoon.svg?i226ha#icomoon') format('svg');
      font-weight: normal;
      font-style: normal;
    }
    
    [class^="icon-"], [class*=" icon-"] {
      /* use !important to prevent issues with browser extensions that change fonts */
      font-family: 'icomoon' !important;
      /* speak: none; */
      font-style: normal;
      font-weight: normal;
      font-variant: normal;
      text-transform: none;
      line-height: 1;
    
      /* Better Font Rendering =========== */
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    
    .icon-facebook:before {
      content: "\ea90";
    }
    .icon-instagram:before {
      content: "\ea92";
    }
    .icon-twitter:before {
      content: "\ea96";
    }
    .icon-youtube:before {
      content: "\ea9d";
    }
    #fp-nav ul li a span, .fp-slidesNav ul li a span {
        border-radius: 50%;
        position: absolute;
        z-index: 1;
        height: 4px;
        width: 4px;
        border: 0;
        background: #6b6b6b;
        left: 196%;
        top: 50%;
        margin: -2px 0 0 -2px;
        -webkit-transition: all .1s ease-in-out;
        -moz-transition: all .1s ease-in-out;
        -o-transition: all .1s ease-in-out;
        transition: all .1s ease-in-out;
        } 
    </style>

<!-- SLIDER SLICK  -->

    <style>
        .slick-dots li button {
            position: relative;
            background-color: crimson;
            opacity: .25;
            width: 29px;
            height: 2px;
            padding: 0;
            border-radius: 5px;
            font-size: 0;
        }

        .slick-dots li {
            position: relative;
            display: inline-block;
            margin: 0 4px;
            padding: 0;
            cursor: pointer;
        }

        .slick-dots {
            position: absolute;
            bottom: 12px;
            list-style: none;
            display: block;
            text-align: center;
            padding: 0;
            margin: 0;
            width: 100%;
        }

    </style>

<!-- ESTILO DEL WAVE  -->

<style>
    .wave {
        opacity: 0.45;
        position: absolute;
        bottom: 60%;
        left: 260%;
        width: 6000px;
        height: 6000px;
        background: rgba(0, 0, 0, 0.8);
        background: crimson;
        margin-left: -2650px;
        transform-origin: 50% 50%;
        border-radius: 45%;
        animation: wave 12s infinite linear;
        pointer-events: none;
    }
    
    .wave2 {
        animation: wave 28s infinite linear;
        /* opacity: 0.3;
        background: rgba(211, 5, 149, 0.5); */
        /* background: rgba(0, 0, 0, 0.75); */
        background: crimson;
    }
    
    .wave3 {
        animation: wave 20s infinite linear;
        background: rgb(13, 10, 4);
    }
    
    /*Movimientos de animaciones de los wave*/
    @keyframes change{
        from{
            transform: translateY(2rem);
            opacity: 0;
        }
        to{
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes wave{
        from{
            transform: rotate(0deg);
        }
        to{
            transform: rotate(360deg);
        }
    }

    .wav {
        opacity: 0.45;
        position: absolute;
        top: 60%;
        right: 260%;
        width: 6000px;
        height: 6000px;
        background: rgba(0, 0, 0, 0.8);
        /* background: crimson; */
        margin-right: -2650px;
        transform-origin: 50% 50%;
        border-radius: 45%;
        animation: wave 12s infinite linear;
        pointer-events: none;
    }
        
    .wav2 {
        animation: wave 28s infinite linear;
        /* /* opacity: 0.3; */
        /* background: rgba(211, 5, 149, 0.5);  */
        /* background: rgba(0, 0, 0, 0.75); */
        background: crimson;
    }
    
    .wav3 {
        animation: wave 20s infinite linear;
        background: rgb(13, 10, 4);
    }
    
    /* color del primer wave */
    .code{
        position: relative;
        /* background-color: #0d5584de; */
        /* background-color: #ffffffde;  */
        z-index: 2;
    }
    /*Movimientos de animaciones de los wave*/
    @keyframes change{
        from{
            transform: translateY(2rem);
            opacity: 0;
        }
        to{
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes wave{
        from{
            transform: rotate(0deg);
        }
        to{
            transform: rotate(360deg);
        }
    }
    </style>

    <!-- TYPERWAPER -->
<style>
    .typer{
        position: absolute;
        top: 61%;
        left: 50%;
        transform: translate(-50%,-50%);
        filter: drop-shadow(3px 3px 3px #dc143c69);
     }

    .line {
        border-right: 2px solid rgba(255, 255, 255, 0.75);
        white-space: nowrap;
        overflow: hidden;
        padding: .2rem 0;
        font-size: 3.3rem;
        text-align: center;
        color: white;
        animation: change 0.5s 0.3s forwards;
        animation: typewriter 4s steps(40) 1s 1 normal both, blinkTextCursor 500ms steps(40) infinite normal;
    }
    @keyframes typewriter {from { width: 0; }
        to {width: 28em;}
    }

    @keyframes blinkTextCursor {
        from {border-right-color: rgba(255, 255, 255, 0.75);}
        to { border-right-color: transparent;}
    }

</style>

<!-- CSS para el formulario de login/registro  -->

<style>
    
    .contenedor-form {
        background-color: rgba(255, 255, 255, 0.5);
        max-width: 500px;
        border-radius: 10px;
        color: #fff;
        background-attachment: fixed;
        position: relative;
    }

    .contenedor-form .toggle {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 100px;
        height: 30px;
        font-size: 12px;
        line-height: 25px;
        text-align: center;
        border-top: 2px solid #fff;
        border-bottom: 2px solid #fff;
        cursor: pointer;
        transition: all .5s ease;
    }

    .contenedor-form .toggle:hover {
        border-top:    2px solid crimson;
        border-bottom: 2px solid crimson;
    }

    .contenedor-form .toggle span {
        letter-spacing: 1px;
    }

    .contenedor-form h2 {
        margin: 0 0 28px 0;
        font-size: 20px;
        font-weight: 400;
        line-height: 1;
    }

    .contenedor-form input[type="text"], .contenedor-form input[type="password"], .contenedor-form input[type="email"] {
        outline: none;
        display: block;
        width: 100%;
        padding: 9px 16px;
        margin: -20px 100px 26px 0;
        background: rgba(0,0,0,.5);
        border: none;
        border-bottom-color: currentcolor;
        border-bottom-style: none;
        border-bottom-width: medium;
        border-radius: 7px;
        border-bottom: 3px solid #ffffff;
        box-sizing: border-box;
        font-size: 18px;
        transition: all .5s ease;
        font-family: 'Poppins', sans-serif;
    }

    .contenedor-form input[type="text"]:focus,
    .contenedor-form input[type="password"]:focus,
    .contenedor-form input[type="email"]:focus {
        border-bottom: 3px solid crimson;
    }

    .contenedor-form input[type="submit"] {
        background: #3a3a3aab;
        color: #FFF;
        width: 43%;
        padding: 5px 0;
        border: none;
        border-radius: 7px;
        border-bottom: 3px solid rgb(255 255 255);
        font-size: 18px;
        font-weight: normal;
        font-family: Roboto;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all .5s ease;
        font-family: 'Poppins', sans-serif;
        transform: translate(65%, -10px);
    }

    .contenedor-form input[type="submit"]:hover {
        background:  crimson;
    }

    .contenedor-form .reset-password {
        background: rgba(0,0,0,.5);
        width: 100%;
        padding: 9px 0;
        text-align: center;
        border-radius: 5px;
        transform: translateY(13px);
    }

    .contenedor-form .reset-password:hover{
        background: crimson;
    }

    .contenedor-form .reset-password a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
    }

    .contenedor-form .formulario {
        display: none;
        padding: 40px;
    }

    .contenedor-form .formulario:nth-child(2) {
        display: block;
    }
</style>

<!-- ESTILO PARA EL MENU CON MOVIMIENTO LIBRE -->
<style>

        @import url('https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap');

        .body
        {
            display: block;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .navigation
        {
            margin: 5px;
            position: fixed;
            width: 50px;
            height: 50px;
            background: black;
            transition: width 0.5s, heigth 0.5s;
            transition-delay: 0s,0.75s;
            z-index: 100;
            border-radius: 8px;
            overflow: hidden;
            border: solid 3px #ffffff;
        }

        .navigation:hover{
            cursor: pointer;
            border: solid 3px crimson;
            box-shadow: 3px 3px 10px 0 rgba(220, 20, 60, 0.452);
        }

        .navigation.active
        {
            width: 250px;
            height: 350px;
            transition: heigth 0.5s, width 0.5s;
            transition-delay: 0s,0.75s;
        }


        .navigation .toggle
        {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background: crimson;
            transition: 0.5s;
            cursor: pointer;
        }

        .navigation .toggle.active
        {
            background: gray;
        }

        .navigation .toggle::before
        {
            content: '+';
            /* position: absolute; */
            font-size: 2em;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            color: white;
            font-weight: 400;
            transition: 0.5s;
        }



        .navigation .toggle.active::before
        {
            transform: rotate(315deg);
        }

        .navigation ul
        {
            position: absolute;
            left: 0;
            width: 100%;
        }

        .navigation ul li{
            position: relative;
            list-style: none;
            width: 100%;
        }

        .navigation ul li:hover
        {
            background: crimson;
        }


        .navigation ul li a{
            position: relative;
            display: block;
            width: 100%;
            display: flex;
            text-decoration: none;
            color: white;
        }

        .navigation ul li a .icon
        {
            position: relative;
            display: block;
            min-width: 50px;
            height: 50px;
            text-align: center;
            line-height: 50px;
        }

        .navigation ul li a .icon .fa
        {
            font-size: 24px;
            color: gray;
        }

        .navigation ul li a .title
        {
            position: relative;
            display: block;
            line-height: 50px;
            text-align: start;
            white-space: nowrap;
        }

        .navigation ul li:hover a .icon .fa,
        .navigation ul li:hover a .icon title
        {
            color: white;
        }

</style>

<!-- ESTILO DEL PROGRESS BAR DE LOS SG -->

<style>
        .process-wrapper {
            margin:auto;
            max-width:1080px;
        }

        #progress-bar-container {
            position:relative;
            width:90%;
            margin:auto;
            height:100px;
            margin-top:65px;
        }

        #progress-bar-container ul {
            padding:0;
            margin:0;
            padding-top:15px;
            z-index:9999;
            position:absolute;
            width:100%;
            margin-top:-40px
        }

        #progress-bar-container li:before {
            content:" ";
            display:block;
            margin:auto;
            width:30px;
            height:30px;
            border-radius:10px;
            border:solid 2px crimson;
            transition:all ease 0.3s;
            
        }

        #progress-bar-container li.active:before, #progress-bar-container li:hover:before {
            border:solid 2px crimson;
                
            background: linear-gradient(to right, crimson 0%,#5e0000 100%); 
            border-radius: 10px;
        }

        #progress-bar-container li {
            list-style:none;
            float:left;
            width:20%;
            text-align:center;
            color:crimson;
            text-transform:uppercase;
            font-size:11px;
            cursor:pointer;
            font-weight:700;
            transition:all ease 0.2s;
            vertical-align:bottom;
            height:60px;
            position:relative;
        }

        #progress-bar-container li .step-inner {
            position:absolute;
            width:100%;
            bottom:0;
            font-size: 14px;
        }

        #progress-bar-container li.active, #progress-bar-container li:hover {
            color:#aa0101;
        }

        #progress-bar-container li:after {
            content:" ";
            display:block;
            width:8px;
            height:8px;
            background:crimson;
            margin:auto;
            border:solid 3px #5e0000;
            /*! border-radius:50%; */
            margin-top:43px;
            box-shadow:0 2px 13px -1px crimson;
            transition:all ease 0.2s;
            
            border-radius: 4px;
            /*! border-color: linear-gradient(to right, crimson 0%,#000000c9 100%); */
        }

        #progress-bar-container li:hover:after {
            background:#5e0000;
        }

        #progress-bar-container li.active:after {
            background:#5e0000;
        }

        #progress-bar-container #line {
            width:80%;
            margin:auto;
            background: linear-gradient(to right, black 0%,#dc143c00 100%);
            height:6px;
            position:absolute;
            left:10%;
            top:57px;
            z-index:1;
            border-radius:50px;
            transition:all ease 0.9s;
        }

        #progress-bar-container #line-progress {
            content:" ";
            width:3%;
            height:100%;
            /* background: #207893;	  */
            background: linear-gradient(to right, #5e0000 0%, crimson 100%); 
            position:absolute;
            z-index:2;
            border-radius:50px;
            transition:all ease 0.9s;
        }

        #progress-content-section {
            
            width:90%;
            margin: auto;
            background: #620909;
            border-radius: 20px;
        }

        #progress-content-section .section-content {
            padding:30px 40px;
            text-align:center;
        }

        #progress-content-section .section-content h2 {
            font-size:17px;
            text-transform:uppercase;
            color:#333;
            letter-spacing:1px;
        }

        #progress-content-section .section-content p {
            font-size:16px;
            line-height:1.8em;
            color:#777;
        }

        #progress-content-section .section-content {
            display:none;
            animation: FadeInUp 700ms ease 1;
            animation-fill-mode:forwards;
            transform:translateY(15px);
            opacity:0;
        }

        #progress-content-section .section-content.active {
            display:block;
        }

        @keyframes FadeInUp {
            0% {
                transform:translateY(15px);
                opacity:0;
            }
            
            100% {
                transform:translateY(0px);
                opacity:1;
            }
        }

    button#widgetIcon {
        background: #42a5f500;
        background: #42a5f500;
        border: none;
        border-radius: 50%;
        bottom: 0px;
        /* box-shadow: rgb(0 0 0 / 24%) 1px 4px 15px 0px; */
        cursor: pointer;
        height: 105px;
        position: absolute;
        right: 0px;
        width: 22px;
    }

</style>
<!-- FIN ESTILO DEL PROGRESS BAR DE LOS SG -->
 
 <!-- STYLE PARA CHATBOT -->
<style>

    df-messenger {
        --df-messenger-bot-message: crimson;
        --df-messenger-button-titlebar-color: #420404;
        --df-messenger-chat-background-color: #2e2e2e;
        --df-messenger-font-color: rgb(255 255 255);
        --df-messenger-send-icon: #ff0000;
        --df-messenger-user-message: #420404;
        --df-messenger-input-box-color: #2e2e2e;
        --df-messenger-input-font-color: #ffff;
    }
</style>
 <!-- STYLE PARA CHATBOT -->