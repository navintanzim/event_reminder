<style>
    #model_main_content{
        max-width: 80%;
    }
    @media (max-width: 500px) {
        #model_main_content{
            max-width: 100%;
        }
    }
</style>

@if(env('IS_MOBILE')==false)
    <footer class="site-footer">
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="footer-item">
                            <h3 class="footer-title">Follow Us</h3>
                            <ul class="social-list">
                                <li><a href="{{isset($social_link['facebook']) ? $social_link['facebook'] : ''}}" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                <li><a href="{{isset($social_link['linkedin']) ? $social_link['linkedin'] : ''}}" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="{{isset($social_link['twitter']) ? $social_link['twitter'] : ''}}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="{{isset($social_link['youtube']) ? $social_link['youtube'] : ''}}" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                            </ul>
                            <h3 class="footer-title"></h3>
                            <ul class="social-list">
                                <li> <div class="id-qr-box" style="widh:90px">
                                       
                                    </div></li>
                            </ul>
                            <ul class="social-list">
                                <li><a href="{{isset($social_link['playstore']) ? $social_link['playstore'] : ''}}" target="_blank"><img height="auto" width="120px" src="assets/images/googleplay.png" alt="" style="opacity: 0.8;"></a></li>
                                <li><a href="{{isset($social_link['appstore']) ? $social_link['appstore'] : ''}}" target="_blank"><img height="auto" width="120px" src="assets/images/appstore.png" alt="" style="opacity: 0.8;"></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </footer>
@endif