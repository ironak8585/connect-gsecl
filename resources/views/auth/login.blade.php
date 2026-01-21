<x-boarding-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-3 px-3 pb-2">
        <div class="card-body">
            <div class="pt-2 text-center">
                <a href="{{ route('home') }}">
                <x-application-logo height="50%" width="40%"></x-application-logo>
                </a>
            </div>
            <div class="">
                <h5 class="card-title text-center pb-0 fs-5">Login</h5>
                <p class="text-center small">Use e-Urja Credentials</p>
            </div>

            <hr class="my-2 pb-2">

            <!-- <form class="row g-3 needs-validation" novalidate> -->
            <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}">
                @csrf
                <!-- <div class="col-12">
                    <x-form.select-input name="company" label="Company" :options="$companies"
                        :defaultSelected="'gsecl'" />
                </div> -->

                <div class="col-12">
                    <x-form.number label="Employee Number" name="employee_number" :value="__('Employee Number')" :required="true"/>
                </div>

                <div class="col-12">
                    <x-form.password label="Password" name="password" :value="__('Password')" :required="true"/>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                </div>
                <div class="col-12">
                    <x-form.submit label="Login" class="w-100" />
                </div>
            </form>

        </div>
    </div>

</x-boarding-layout>