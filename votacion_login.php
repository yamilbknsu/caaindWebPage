<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: votacion_home.php");
    exit;
}

// Include config file
require_once "config/config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["matricula"])) || strlen(trim($_POST["matricula"])) != 10 || !ctype_digit(trim($_POST["matricula"]))){
        $username_err = "Porfavor ingresa una matrícula válida.";
    } else{
        $username = trim($_POST["matricula"]);
    }
    
    // Check if password is empty
    if(strlen(trim($_POST["pass"])) < 10){
        $password_err = "Contraseña inválida. Minimo 10 caracteres.";
    } else{
        $password = trim($_POST["pass"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT email, password FROM Usuario WHERE matricula = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["matricula"] = $username;
                            
                            //Get the name of the user
                            $sql = "SELECT nombre FROM Alumno WHERE matricula = ?";
                            if($stmt = mysqli_prepare($link, $sql)){
                                mysqli_stmt_bind_param($stmt, "s", $param_username);
                                $param_username = $username;
                                if(mysqli_stmt_execute($stmt)){
                                    mysqli_stmt_store_result($stmt);
                                    if(mysqli_stmt_num_rows($stmt) == 1){  
                                        mysqli_stmt_bind_result($stmt, $name);
                                        $_SESSION["name"] = $name;
                                    }
                                }
                            }              
                            
                            // Redirect user to welcome page
                            header("location: votacion_home.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "La contraseña ingresada no corresponde a la ingresada en el sistema.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No existe una cuenta asociada a esa matricula.";
                }
            } else{
                echo "Oops! Algo salió mal.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CAAIND UdeC - Votacion Asamblea</title>
    <link rel="icon" href="images/logo_caaind_no_text.png">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">

    <!--MATERIALIZE Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

<body>
    <div class="global-wrapper">
        <div class="top-view">
            <img id="main-logo" src="images/logo_caaind_no_text.png" alt="Logo CAAIND">
            <div class="top-bar">
                <ul id="main-nav-bar">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="#">Equipo</a></li>
                    <li><a href="https://drive.google.com/drive/folders/0B6rQsLrGSDLgTmpPU0hvMWN5Y00">Drive</a></li>
                    <li><a href="#" class="featured">Votación</a></li>
                </ul>
            </div>

            <div class="social-buttons-bar">
                <a href="https://www.facebook.com/CaaIndustrial">
                    <div class="social-button">
                        <img class="social-icon img-bot" src="images/fb_no_color.png" alt="FB oscuro">
                        <img class="social-icon img-top" src="images/fb_color.png" alt="FB oscuro">
                    </div>
                </a>
                <a href="https://www.instagram.com/caaind.udec">
                    <div class="social-button">
                        <img class="social-icon img-bot" src="images/ig_no_color.png" alt="FB oscuro">
                        <img class="social-icon img-top" src="images/ig_color.png" alt="FB oscuro">
                    </div>
                </a>
                <a href="https://twitter.com/CAAIND_UdeC">
                    <div class="social-button">
                        <img class="social-icon img-bot" src="images/twitter_no_color.png" alt="FB oscuro">
                        <img class="social-icon img-top" src="images/twitter_color.png" alt="FB oscuro">
                    </div>
                </a>
            </div>
        </div>
        <div class="divider"></div>

        <div class="login-wrapper">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="login-body z-depth-2">
                    <h5>Inicia sesión</h5>
                    <p>Por favor, inicia sesión para participar</p>
                    <div class="login-form">
                        <div class="row">
                            <div class="input-field col s10">
                                <input class="<?php echo (!empty($username_err)) ? 'invalid' : ''; ?>" id="matricula_input" type="text" name="matricula">
                                <label for="matricula_input">Matricula</label>
                                <span class="helper-text" data-error="<?php echo (!empty($username_err)) ? $username_err : ''; ?>" data-success="right"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s10">
                                <input class="<?php echo (!empty($password_err)) ? 'invalid' : ''; ?>" id="password_input" type="password" class="validate" name="pass">
                                <label for="password_input">Contraseña</label>
                                <span class="helper-text" data-error="<?php echo (!empty($password_err)) ? $password_err : ''; ?>" data-success="right"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <button class="btn waves-effect waves-light" type="submit" value="Login">Entrar</button>
                                <br>
                                <a href="register.php">¿No tienes una cuenta?</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>

        <div class="footer">
            CAAIND 2019<br>
            Centro de alumnos Ingenieria Civil Industrial<br>
            Universidad de Concepción<br>
            Desarrollado por Yamil Essus
        </div>
    </div>

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>