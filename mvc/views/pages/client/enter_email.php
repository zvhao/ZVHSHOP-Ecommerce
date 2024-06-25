<!-- body -->
<div class="container-fluid d-flex justify-content-center p-5 bg-login-regis">
    <div class="container-sm" data-aos="flip-right">


        <!-- Login Form -->
        <div class="form login">
            <span class="login-title">Kiểm tra tài khoản</span>
            <form action="<?php echo _WEB_ROOT . '/auth/checkEmail' ?>" method="post" id="form">
                <?php
                if (isset($_SESSION['msg_true_email']) && $_SESSION['msg_true_email'] != "") {
                ?>
                    <div id="message" class="alert alert-success"><?php echo $_SESSION['msg_true_email'] ?></div>
                <?php
                    $_SESSION['msg_true_email'] = '';
                }
                ?>

                <?php
                if (isset($_SESSION['msg_false_email']) && $_SESSION['msg_false_email'] != "") {
                ?>
                    <div id="message" class="alert alert-danger"><?php echo $_SESSION['msg_false_email'] ?></div>
                <?php
                    $_SESSION['msg_false_email'] = '';
                }
                ?>
                <?php
                if (isset($_SESSION['msg_false']) && $_SESSION['msg_false'] != "") {
                ?>
                    <div id="message" class="alert alert-danger"><?php echo $_SESSION['msg_false'] ?></div>
                <?php
                    $_SESSION['msg_false'] = '';
                }
                ?>
                <div class="input-field">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Nhập email của tài khoản">
                </div>
                    
                <div class="input-field">
                    <button class="w-100 btn-main p-4" type="submit">Kiểm tra</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>