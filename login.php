<?php
session_start();
require_once 'functions.php';

if (isUserLoggedin()) {
    header('Location: index.php');
    exit;
}

$bytes = random_bytes(32);
$token = bin2hex($bytes);
$_SESSION['csrf'] = $token;

require_once 'view/top.php';
?>
<main role="main" class="flex-shrink-0">
    <section class="container">

        <div id="loginform">
            <h2>Login</h2>
            <?php

if (!empty($_SESSION['message'])) {?>

            <div class="alert alert-info" id='message'><?=$_SESSION['message']?></div>

            <?php
$_SESSION['message'] = '';
}

?>

            <br>
            <form action="verify-login.php" method="POST">
                <input type="hidden" name="_csrf" value="<?=$token?>">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp"
                        required>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small>
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" name="password" class="form-control" id="Password" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="rememberme" class="form-check-input" id="rememberme">
                    <label class="form-check-label" for="rememberme">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </section>
</main>

<?php
require_once 'view/footer.php';
?>

<!-- facciamo una chiamata AJAX con jquery -->
<script>
$(
    function() {
        $('form').on('submit', function(evt) {

            evt.preventDefault();
            // https://api.jquery.com/serialize/
            const data = $(this).serialize();
            //alert(data);
            $.ajax({
                method: 'post',
                data: data,
                url: '/verify-login-ajax.php',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data) {
                        alert(data.message);
                        if (data.success) {
                            location.href = 'index.php';
                        }
                    }
                },
                failure: function() {
                    alert('PROBLEM CONTACTING SERVER')
                }
            })
        })
    }
);
</script>