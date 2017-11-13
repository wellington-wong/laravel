        <footer class="app-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-md-2 footer-list">
                        <h4>Services</h4>
                        <ul>
                            <li><a href="https://www.perxi.com/how-it-works/">How it Works</a></li>
                            <li><a href="https://www.perxi.com/features/">Features</a></li>
                            <li><a href="https://www.perxi.com/about-us/">About Us</a></li>
                            <li><a href="https://www.perxi.com/pricing/">Pricing</a></li>
                            <li><a href="javascript:void(0)">Blog</a></li>
                            <li><a href="{{ route('login') }}">Log In</a></li>
                        </ul>
                    </div>  
                    <div class="col-xs-4 col-md-2 footer-list">
                        <h4>Contact</h4>
                        <ul>
                            <li><a href="#">(866) 808-9902</a></li>
                            <li><a href="mailto:info@perxi.com">info@perxi.com</a></li>
                        </ul>
                    </div>         
                    <!--<div class="col-md-2 footer-list">
                        <h4>Headline 3</h4>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>-->  
                    <div class="col-md-2 footer-list col-md-offset-6">
                        <ul class="list-inline">
                            <li class="footer-social list-inline">
                                <a href="https://www.facebook.com/perxirewards/" class="footer-fb fa-stack" target="_BLANK">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="footer-social">
                                <a href="https://twitter.com/PerxiRewards" class="footer-tw fa-stack" target="_BLANK">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('login') }}" title="Referrals" class="footer-logo"><img src="{{ isset($_company->logo) ? $_company->logo : '/images/logo-main.png' }}" alt=""></a>
                    </div>
                </div>
                <div class="row">
                    <div class="middle-content">
                        <span>Need a marketing solution for your business? Visit <a href="https://www.exults.com/">exults.com</a>.</span>
                    </div>
                </div> 
            </div>    
            <div class="row">
                <div class="bottom-content text-center">
                    <span>All rights reserved &copy; {{ date('Y') }} Perxi.</span>
                </div>
            </div> 
        </footer>
    
        @include('layouts.scripts')
    </body>
</html>