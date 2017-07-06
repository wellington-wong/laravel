@section('pageTitle', 'Contact Us')
@include('auth.document-top')
        <!-- Start Header -->
        <header>
        @include('auth.header')
        </header>
        <!-- End Header -->
        <!-- Start Main -->
		<main>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 main-content">
                        <div class="panel panel-default">
							
                            <div class="panel-header">
									<h3>Contact Us</h3>
                            </div>
								@if(session()->has('success'))
									<div class="alert alert-success">
									{{ session()->get('success') }}
									</div>
								@endif
                            <div class="panel-body">                            	
                            	{!! Form::open(array('route' => 'contact', 'class' => 'form', 'id' => 'contact-form')) !!}
								<div class="form-group">
								    {!! Form::label('Your Name') !!}
								    {!! Form::text('name', null, 
								        array('required', 
								              'class'=>'form-control', 
								              'placeholder'=>'Your name')) !!}
								</div>

								<div class="form-group">
								    {!! Form::label('Your E-mail Address') !!}
								    {!! Form::email('email', null, 
								        array('required', 
								              'class'=>'form-control', 
								              'placeholder'=>'Your e-mail address')) !!}
								</div>

								<div class="form-group">
								    {!! Form::label('Your Message') !!}
								    {!! Form::textarea('message', null, 
								        array('required', 
								              'class'=>'form-control', 
								              'placeholder'=>'Your message')) !!}
								</div>

								<div class="form-group">
								    {!! Form::submit('Contact Us!', 
								      array('class'=>'btn btn-primary')) !!}
								</div>
								{!! Form::close() !!}
			    			</div>
			    		</div>
			    	</div>
    			</div>
    		</div>
        </main>
        <!-- End Main -->
<!-- Start Footer -->
@include('auth.footer')
<!-- End Footer -->