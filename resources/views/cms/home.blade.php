@extends('cms.parent')

@section('title', 'Home') {{-- عنوان الصفحة --}}

@section('page-lg', 'Dashboard') {{-- العنوان الكبير فوق --}}
@section('page-sm', 'Home')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">



@section('style')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
    section.content,
    .welcome-card, h1, h3, p {
        font-family: 'Poppins', sans-serif !important;
    }

    /* كارت الترحيب الملون والفخم */
    .welcome-card {
        background: linear-gradient(135deg, #3498db, #2ecc71);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    /* حركة الدوائر الشفافة في الخلفية لتعطي لمسة فنية */
    .welcome-card::after {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    .user-name {
        font-weight: bold;
        text-transform: capitalize;
        border-bottom: 2px solid #fff;
    }
    .small-box {
        border-radius: 15px !important;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .small-box .inner h3 {
        font-weight: 800;
        font-size: 2.5rem;
    }

    .small-box-footer {
        background: rgba(0,0,0,0.1) !important;
        padding: 10px !important;
        font-weight: 600;
    }

    .badge-role {
        background: rgba(255,255,255,0.2);
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 400;
        border: 1px solid rgba(255,255,255,0.4);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="welcome-card text-center">
                <h1 class="display-4">Hello, <span class="user-name">{{ auth()->user()->name }}</span>!</h1>
                <h3>Welcome back to <span style="font-weight: 800">Artisan Hub</span></h3>
                <p class="lead mt-3">
    You are logged in as:
    <span class="badge badge-light">
        {{ ucfirst($guard) }} ({{ auth()->user()->name }})
    </span>
</p>
                @if($guard == 'admin')
                    <p><i class="fas fa-shield-alt"></i> You have full administrative access to the system.</p>
                @elseif($guard == 'team')
                    <p><i class="fas fa-tasks"></i> Focus on your assigned tasks and enjoy your work!</p>
                @endif
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info shadow">
                <div class="inner">
                    <h3>{{ \App\Models\Team::count() }}</h3>
                    <p>Total Teams</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <a href="{{ route('teams.index', ['guard' => $guard]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success shadow">
                <div class="inner">
                    <h3>{{ \App\Models\Customer::count() }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="{{ route('customers.index', ['guard' => $guard]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning shadow">
                <div class="inner text-white">
                    <h3 class="text-white">{{ \App\Models\Artisan::count() }}</h3>
                    <p class="text-white">Active Artisans</p>
                </div>
                <div class="icon">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <a href="{{ route('artisans.index', ['guard' => $guard]) }}" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>
    {{-- <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Team::count() }}</h3>
                    <p>Total Teams</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <a href="{{ route('teams.index', ['guard' => $guard]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Customer::count() }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="{{ route('customers.index', ['guard' => $guard]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning text-white">
                <div class="inner">
                    <h3 class="text-white">{{ \App\Models\Artisan::count() }}</h3>
                    <p class="text-white">Active Artisans</p>
                </div>
                <div class="icon">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <a href="{{ route('artisans.index', ['guard' => $guard]) }}" class="small-box-footer" style="color: white !important;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}

        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\Category::count() }}</h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-th"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}
    </div>
</div>
@endsection


{{-- @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome to your Dashboard!</h5>
                        <p class="card-text">
                            <h1>hello  {{ ucfirst($guard) }}</h1>

@if($guard == 'admin')
    <p>لديك صلاحيات كاملة لإدارة النظام.</p>
@elseif($guard == 'team')
    <p>يمكنك إدارة المهام الموكلة إليك فقط.</p>
@endif
                            You are logged in as: <b>{{ auth()->user()?->name }}</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
