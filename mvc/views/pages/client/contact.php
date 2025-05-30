<!-- body -->

<div class="grid wide font-size-14">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= _WEB_ROOT . '/home' ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active"><?= $data['title'] ?></li>
        </ol>
    </nav>
    <div class="row p-3 pt-0">

        <div class="contact-form col-lg-6" data-aos="fade-right">
            <div class="contact-heading">
                <h3>
                    Nơi giải đáp toàn bộ mọi thắc mắc của bạn?
                </h3>

                <div class="time_work">
                    <div class="contact-item">
                        <b>Hotline:</b>
                        <a class="fone" href="tel:0987123654" title="0987123654">0987123654</a>
                    </div>
                    <div class="contact-item">
                        <b>Email:</b>
                        <a href="mailto:zvhshop@gmail.com" title="zvhshop@gmail.com">zvhshop@gmail.com</a>
                    </div>

                </div>
            </div>
            <h3 class="contact-title font-weight-bold">LIÊN HỆ VỚI CHÚNG TÔI!</h3>
            <p>Chúng tôi mong muốn lắng nghe từ bạn. Hãy liên hệ với chúng tôi và một thành viên của chúng tôi
                sẽ liên lạc với bạn trong thời gian sớm nhất. Chúng tôi yêu thích việc nhận được email của bạn
                mỗi ngày.</p>
            <form method="post" class="bg-form-control p-3 border-radius-main border-main form-contact" action="<?= _WEB_ROOT . '/contact/send_contact' ?>">
                <div class="row contact-group">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input placeholder="Họ và tên" type="text" class=" form-control  form-control-lg" required value="<?php if (isset($_SESSION['user'])) echo $_SESSION['user']['name'] ?>" name="name">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="text" placeholder="Điện thoại" name="phone" class=" form-control form-control-lg" required value="<?php if (isset($_SESSION['user'])) echo $_SESSION['user']['phone'] ?>">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <input placeholder="Email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required class=" form-control form-control-lg" value="<?php if (isset($_SESSION['user'])) echo $_SESSION['user']['email'] ?>" name="email">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <textarea placeholder="Nội dung" name="content" id="comment" class=" form-control form-control-lg" rows="2" required=""></textarea>
                        <button type="submit" class="btn-main my-4" name="send_contact" value="send">Gửi thông tin</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="map user-select-none col-lg-6 mt-4" data-aos="fade-left">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.6263397586017!2d105.75999004856682!3d10.047660640394579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0880cf0bdcbf1%3A0x475f8cc75bfa19b2!2zMTM5IE5ndXnhu4VuIMSQ4buHLCBBbiBIb8OgLCBOaW5oIEtp4buBdSwgQ-G6p24gVGjGoSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1662642238432!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <div class="row p-3 pt-0">
        <?php
        if (!empty($data['contacts'])) {
        ?>
            <h2 class="text-color-main m-0 mt-2">Các liên hệ bạn đã gửi</h2>
            <div class="row pt-3 justify-content-between">
                <?php
                foreach ($data['contacts'] as $item) {
                ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 row contact-group my-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <input placeholder="Họ và tên" type="text" class=" form-control  form-control-lg" disabled value="<?= $item['name'] ?? '' ?>" name="name">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <input type="text" placeholder="Điện thoại" name="phone" class=" form-control form-control-lg" disabled value="<?= $item['phone'] ?? '' ?>">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <input placeholder="Email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" disabled class=" form-control form-control-lg" value="<?= $item['email'] ?? '' ?>" name="email">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <textarea placeholder="Nội dung" name="content" id="comment" class=" form-control form-control-lg" rows="2" disabled><?= $item['content'] ?? '' ?></textarea>
                        </div>
                        <p class="m-0 mt-2"><b>Phản hồi từ ZVHShop:</b></p>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <textarea placeholder="Hãy đợi ZVHShop phản hồi" name="content" id="comment" class=" form-control form-control-lg" rows="2" disabled><?= $item['responded'] ?? '' ?></textarea>
                        </div>
                        <div class="checkout-heading"></div>
                    </div>
                <?php
                } ?>
            </div>

        <?php
        } else {
        ?>
        <?php
        }
        ?>
    </div>


</div>