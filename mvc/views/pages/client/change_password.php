<!-- body -->
<div class="container-fluid d-flex justify-content-center p-5 bg-login-regis">
    <div class="container-sm" data-aos="flip-right">


        <!-- Login Form -->
        <div class="form login">
            <span class="login-title">Thay đổi mật khẩu</span>
            <form action="<?php echo _WEB_ROOT . '/auth/treatment_password' ?>" method="post" id="form">
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
                    <input type="password" name="password" id="password" class="password" placeholder="Nhập mật khẩu mới">
                    <div class="icon-left">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <i class="fa-solid fa-eye-slash eye-icon showHidePw"></i>
                </div>
                <div class="input-field">
                    <input type="password" name="confirm_password" id="confirm_password" class="password" placeholder="Nhập lại mật khẩu">
                    <div class="icon-left">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <i class="fa-solid fa-eye-slash eye-icon showHidePw"></i>

                </div>
                <input type="hidden" name="email" value="<?= $data['email'] ?>">
                <input type="hidden" name="accessEmail" value="<?= $data['emailAccess'] ?>">

                <div class="input-field">
                    <button name="btn-submit" class="w-100 btn-main p-4" type="submit">Thay đổi</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>