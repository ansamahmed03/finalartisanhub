@extends('cms.parent')

@section('title', 'Contact Us')

@section('style')
<style>
    /* لمسة فنية بسيطة لتناسب روح Artisan Hub */
    .contact-card {
        border-radius: 15px;
        border-top: 5px solid #3498db;
    }
    .info-box-icon {
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Contact us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Contact us</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card contact-card shadow">
        <div class="card-body row">
            <div class="col-5 text-center d-flex align-items-center justify-content-center">
                <div class="">
                    <h2>Artisan<strong>Hub</strong></h2>
                    <p class="lead mb-5">Gaza, Palestine<br>
                        Phone: +1 234 5678901
                    </p>
                </div>
            </div>
            <div class="col-7">
                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input type="text" id="inputName" class="form-control" placeholder="Enter your name" />
                </div>
                <div class="form-group">
                    <label for="inputEmail">E-Mail</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Enter your email" />
                </div>
                <div class="form-group">
                    <label for="inputSubject">Subject</label>
                    <input type="text" id="inputSubject" class="form-control" placeholder="Message subject" />
                </div>
                <div class="form-group">
                    <label for="inputMessage">Message</label>
                    <textarea id="inputMessage" class="form-control" rows="4" placeholder="How can we help you?"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Send message">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
