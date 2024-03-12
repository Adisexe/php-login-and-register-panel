<html>
    <head>
        <link rel="stylesheet" href="style/main_style.css">
        <title>Login panel</title>
        <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <script src="particles.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="script.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="notif-content"></div>
        <?php 
            session_start();
            if (!isset($_SESSION['loggin'])){
        ?>
                <div class="main-box">
                    <div class="main-box-content">
                        <div class="box-title">
                            <div class="glitch-wrapper">
                                <div class="glitch" data-text="Logowanie">Logowanie</div>
                            </div>
                        </div>
                        <form class='box-inputs-form' action="authenticate.php?action=login" method="POST">
                        <div class="box-inputs-container">
                            
                            <div class="box-input-container">
                                <label>Nazwa użytkownika</label>
                                <input name="username" type="text"/>  
                            </div>
                            <div class="box-input-container">
                                <label>Hasło</label>
                                <input name="password" type="password"/>  
                            </div>
                            <div id='box-input-password' class="box-input-container" style='display: none;'>
                                <label>Potwierdź hasło</label>
                                <input name="password-confirm" type="password"/>  
                            </div>
                            
                        </div>
                        <div class="box-change-action" onclick="changeAction(this)" data-status="login">Kliknij aby się zarejestrować</div>
                        <div class="box-button-container">
                            <button type="submit" class="box-button">Zaloguj</button>
                        </div>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                    <div class="logout-container">
                        <h3 class='username-header'>Witaj <?php echo $_SESSION['username'];?> <br> ID: #<?php echo $_SESSION['userid'];?></h3>
                        <div class="logout-button-container">
                            <a href="logout.php"><button class="box-button">Wyloguj się</button></a>
                        </div>
                    </div>
            <?php }?>
            <script>
                function createNotification(type, message){
                    if (type == 'error') {
                        $('.notif-content').append("<div class='notif' style='display: none;'><i class='fa-solid fa-circle-exclamation' style='color: #eb4034; font-size: 16px; padding-right: 5px;'></i> " + message + "</div>");
                        $('.notif').fadeIn(2000, function () {
                            setTimeout(function() { 
                                $('.notif').fadeOut(500, function () {
                                    $('.notif-content').empty();
                                });
                            }, 2000);
                        });
                    } else if(type =='success'){
                        $('.notif-content').append("<div class='notif'><i class='fa-solid fa-circle-check' style='color: #34eb71; font-size: 16px; padding-right: 5px;'></i> " + message + "</div>");
                        $('.notif').fadeIn(500, function () {
                            setTimeout(function() { 
                                $('.notif').fadeOut(500, function () {
                                    $('.notif-content').empty();
                                });
                            }, 2000);
                        });
                    }
                }

                var action = false;

                function changeContentOn(type) {
                    if (type == 'login'){
                        $('.box-change-action').html('Kliknij aby się zarejestrować');
                        $('.box-button').html('Zaloguj');

                        $("#box-input-password").css("display", "none");

                        $('.glitch').attr('data-text', 'Logowanie');
                        $('.glitch').html('Logowanie');

                        $(".box-inputs-form").get(0).reset();
                        $('.box-inputs-form').attr('action', 'authenticate.php?action=login');
                    } else if(type == 'register' || type == 'register_error'){
                        $('.box-change-action').html('Kliknij aby się zalogować');
                        $('.box-button').html('Zarejestruj');

                        $("#box-input-password").css("display", "block");

                        $('.glitch').attr('data-text', 'Rejestracja');
                        $('.glitch').html('Rejestracja');

                        $(".box-inputs-form").get(0).reset();

                        if (type == 'register_error'){
                            $('.box-change-action').attr('data-status', 'register');
                        }

                        $('.box-inputs-form').attr('action', 'authenticate.php?action=register');
                    }
                }

                function changeAction(el) {
                    if (action == false){
                        if (el.getAttribute('data-status') == 'login'){
                            $(".main-box-content").fadeOut(1000,function () {
                                action = true;
                                
                                changeContentOn('register');
                                el.setAttribute('data-status', 'register');

                                $(".main-box-content").fadeIn(1000,function () {
                                    action = false;
                                });
                            });
                        } else if (el.getAttribute('data-status') == 'register'){
                            $(".main-box-content").fadeOut(1000,function () {
                                action = true;

                                changeContentOn('login');
                                el.setAttribute('data-status', 'login');

                                $(".main-box-content").fadeIn(1000,function () {
                                    action = false;
                                });
                            });
                        }
                    }
                }
            </script>
            <?php
                if(isset($_GET['action'])){
                    if($_GET['action'] == 'register'){
                        echo "<script>
                            changeContentOn('register_error');
                        </script>";
                    }
                }
                if (isset($_GET['error'])){
                    $message = urldecode($_GET['error']);
                    echo "<script>
                        createNotification('error', '$message');
                    </script>";
                } else if (isset($_GET['success'])){
                    $message = urldecode($_GET['success']);

                    echo "<script>
                        createNotification('success', '$message');
                    </script>";
                }
            ?>
        <div id="particles-js"></div>
    </body>
</html>