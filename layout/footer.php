
        <!-- Footer -->
        <footer id="footer" class="bg-dark dark">

            <div class="container">
                <!-- Footer 1st Row -->
                <div class="footer-first-row row">
                    <div class="col-lg-3 text-center">
                        <a href="<?= Router::route($restaurant->url_name);?>"><img src="<?= $restaurant->logo_secondary ?? $restaurant->logo;?>" alt="" width="88" class="mt-5 mb-5"></a>
                    </div>
                    <div class="col-lg-4 col-md-6 d-flex flex-column justify-content-center">
                      <h5 class="text-muted mb-3">Social Media</h5>
                      <ul class="unstyled-list row-list" style="gap: 1rem;">
                        <?php if (isset($restaurant->facebook) && is_string($restaurant->facebook) && strlen($restaurant->facebook) > 1):?>
                          <li><a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a></li>
                        <?php endif;?>
                        <?php if (isset($restaurant->whatsapp) && is_string($restaurant->whatsapp) && strlen($restaurant->whatsapp) > 1):?>
                          <li><a target="_blank" href="https://wa.me/<?= $restaurant->whatsapp; ?>?text=مرحبا, لقد رأيت موقعكم وأريد ان اعرف المزيد عنكم" class="icon icon-social icon-circle icon-sm icon-success"><i class="fa fa-whatsapp"></i></a></li>
                        <?php endif;?>
                        <?php if (isset($restaurant->instagram) && is_string($restaurant->instagram) && strlen($restaurant->instagram) > 1):?>
                          <li><a href="https://instagram.com/<?= $restaurant->instagram;?>" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a></li>
                        <?php endif;?>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-6 d-flex flex-column justify-content-center">
                        <h5 class="text-muted">Subscribe Us!</h5>
                        <!-- MailChimp Form -->
                        <form action="//suelo.us12.list-manage.com/subscribe/post-json?u=ed47dbfe167d906f2bc46a01b&amp;id=24ac8a22ad" id="sign-up-form" class="sign-up-form validate-form mb-5" method="POST" novalidate="novalidate">
                            <div class="input-group">
                                <input name="EMAIL" id="mce-EMAIL" type="email" class="form-control" placeholder="Tap your e-mail..." required="">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-submit" type="submit">
                                        <span class="description">Subscribe</span>
                                        <span class="success">
                                            <svg x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg>
                                        </span>
                                        <span class="error">Try again...</span>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Footer 2nd Row -->
                <div class="footer-second-row">
                    <span class="text-muted">Copyright Res-M 2023&copy;. Made with love by SS.</span>
                </div>
            </div>

            <!-- Back To Top -->
            <button id="back-to-top" class="back-to-top"><i class="ti ti-angle-up"></i></button>

        </footer>
        <!-- Footer / End -->

    </div>
    <!-- Content / End -->
