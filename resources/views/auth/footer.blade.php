        <footer class="app-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-md-2 footer-list">
                        <h4>Services</h4>
                        <ul>
                            <li><a href="{{ route('how-it-works') }}">How it Works</a></li>
                            <li><a href="{{ route('features') }}">Features</a></li>
                            <li><a href="{{ route('about-us') }}">About Us</a></li>
                            <li><a href="{{ route('pricing') }}">Pricing</a></li>
                            <li><a href="javascript:void(0)">Blog</a></li>
                            <li><a href="{{ route('login') }}">Log In</a></li>
                        </ul>
                    </div>  
                    <div class="col-xs-4 col-md-2 footer-list">
                        <h4>Contact</h4>
                        <ul>
                            <li><a href="#">(866) 808-9902</a></li>
                            <li><a href="#">info@perxi.com</a></li>
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
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                        <figure class="logo-footer col-xs-3 col-md-2"><a href="{{ route('login') }}" title="Referrals"><img src="{{ isset($_company->logo) ? $_company->logo : '/images/logo-main.png' }}" alt=""></a></figure>
                    </div>
                </div>
                <div class="row">
                    <div class="middle-content">
                        <span>Need a marketing solution for your business? Visit <a href="">exults.com</a>.</span>
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