@extends('layouts.auth')

@section('title', 'Iniciar sesión | Videre')

@section('content')
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
        <!--begin::Card-->
        <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
            <!--begin::Wrapper-->
            <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                <!--begin::Form-->
                {{-- FORM --}}
                <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate>

                    @csrf

                    {{-- HEADING --}}
                    <div class="text-center mb-11">
                        <h1 class="text-gray-900 fw-bolder mb-3">
                            Sign In
                        </h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Your Social Campaigns
                        </div>
                    </div>

                    {{-- SOCIAL LOGIN (SOLO UI) --}}
                    <div class="row g-3 mb-9">
                        <div class="col-md-6">
                            <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Google" src="{{ asset('metronic/assets/media/svg/brand-logos/google-icon.svg') }}"
                                    class="h-15px me-3" />
                                Sign in with Google
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Apple" src="{{ asset('metronic/assets/media/svg/brand-logos/apple-black.svg') }}"
                                    class="theme-light-show h-15px me-3" />
                                <img alt="Apple"
                                    src="{{ asset('metronic/assets/media/svg/brand-logos/apple-black-dark.svg') }}"
                                    class="theme-dark-show h-15px me-3" />
                                Sign in with Apple
                            </a>
                        </div>
                    </div>

                    {{-- SEPARATOR --}}
                    <div class="separator separator-content my-14">
                        <span class="w-125px text-gray-500 fw-semibold fs-7">
                            Or with email
                        </span>
                    </div>

                    {{-- EMAIL --}}
                    <div class="fv-row mb-8">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                            autocomplete="username" class="form-control bg-transparent @error('email') is-invalid @enderror"
                            required autofocus />
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="fv-row mb-3">
                        <input type="password" name="password" placeholder="Password" autocomplete="current-password"
                            class="form-control bg-transparent @error('password') is-invalid @enderror" required />
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- REMEMBER + FORGOT --}}
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-primary">
                                Forgot Password ?
                            </a>
                        @endif
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Sign In
                            </span>
                        </button>
                    </div>

                    {{-- REGISTER --}}
                    @if (Route::has('register'))
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            Not a Member yet?
                            <a href="{{ route('register') }}" class="link-primary">
                                Sign up
                            </a>
                        </div>
                    @endif

                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Footer-->
            <div class="d-flex flex-stack px-lg-10">
                <!--begin::Languages-->
                <div class="me-0">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                            src="/metronic/assets/media/flags/united-states.svg" alt="" />
                        <span data-kt-element="current-lang-name" class="me-1">English</span>
                        <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
                    </button>
                    <!--end::Toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                        data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="/metronic/assets/media/flags/united-states.svg" alt="" />
                                </span>
                                <span data-kt-element="lang-name">English</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="/metronic/assets/media/flags/spain.svg" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Spanish</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="/metronic/assets/media/flags/germany.svg" alt="" />
                                </span>
                                <span data-kt-element="lang-name">German</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="/metronic/assets/media/flags/japan.svg" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Japanese</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="/metronic/assets/media/flags/france.svg" alt="" />
                                </span>
                                <span data-kt-element="lang-name">French</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Languages-->
                <!--begin::Links-->
                <div class="d-flex fw-semibold text-primary fs-base gap-5">
                    <a href="pages/team.html" target="_blank">Terms</a>
                    <a href="pages/pricing/column.html" target="_blank">Plans</a>
                    <a href="pages/contact.html" target="_blank">Contact Us</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Card-->
    </div>
@endsection