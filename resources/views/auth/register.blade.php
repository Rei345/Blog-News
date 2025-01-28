<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reinhard Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Aturan dasar */
        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #ffffff;
            padding: 30px;
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    
        /* Placeholder */
        ::placeholder {
            font-family: inherit;
        }
    
        .form button {
            align-self: flex-end;
        }
    
        .inputForm {
            border: 1.5px solid #ecedec;
            border-radius: 10px;
            height: 50px;
            display: flex;
            align-items: center;
            padding-left: 10px;
            transition: 0.2s ease-in-out;
        }
    
        .input {
            margin-left: 10px;
            border-radius: 10px;
            border: none;
            width: 100%;
            height: 100%;
        }
    
        .input:focus {
            outline: none;
        }
    
        .inputForm:focus-within {
            border: 1.5px solid #2d79f3;
        }
    
        .flex-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
        }
    
        .button-submit {
            margin: 20px 0 10px 0;
            background-color: #151717;
            border: none;
            color: white;
            font-size: 15px;
            font-weight: 500;
            border-radius: 10px;
            height: 50px;
            width: 100%;
            cursor: pointer;
        }
    
        .btn {
            margin-top: 10px;
            width: 100%;
            height: 50px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
            gap: 10px;
            border: 1px solid #ededef;
            background-color: white;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }
    
        .btn:hover {
            border: 1px solid #2d79f3;
        }

        label {
            font-weight: 500;
            color: #000;
        }

        .btn.facebook:hover {
            background-color: #155cbb;
        }
    
        /* Aturan responsif untuk layar kecil */
        @media (max-width: 768px) {
            .form {
                padding: 20px;
            }
    
            .inputForm {
                height: 45px;
            }
    
            .button-submit {
                height: 45px;
                font-size: 14px;
            }
    
            .btn {
                height: 45px;
            }
        }
    
        /* Aturan responsif untuk layar yang lebih kecil (ponsel) */
        @media (max-width: 480px) {
            .form {
                padding: 15px;
            }
    
            .inputForm {
                padding-left: 8px;
            }
    
            .button-submit {
                font-size: 13px;
            }
    
            .btn {
                font-size: 13px;
            }
        }
    </style>   

</head>

<body class="bg-gradient-muted">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-2">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mt-3">Create an Account!</h1>
                            </div>

                            @if (session()->has('pesan'))
                                <div class="alert alert-{{ session()->get('pesan')[0] }}">
                                    {{ session()->get('pesan')[1] }}
                                </div>
                            @endif

                            <form class="form" method="POST" action="{{ route('auth.register') }}">
                                @csrf
                                <div class="flex-column">
                                    <label>Name</label>
                                </div>
                                <div class="inputForm">
                                    <div class="fa fa-user"></div>                                    
                                    <input placeholder="Enter your Name" class="input" name="name" type="text" required>
                                </div>
                                <div class="flex-column">
                                    <label>Email </label>
                                </div>
                                <div class="inputForm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20"><g data-name="Layer 3" id="Layer_3">
                                        <path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
                                    <input placeholder="Enter your Email" class="input" name="email" type="text" required>
                                </div>
                                <div class="flex-column">
                                    <label>Password </label>
                                </div>
                                <div class="inputForm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                                        <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                                        <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                                    </svg>        
                                    <input placeholder="Enter your Password" class="input" name="password" type="password" required>
                                </div>
                                <div class="flex-column">
                                    <label>Password Confirmation</label>
                                </div>
                                <div class="inputForm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                                        <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                                        <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                                    </svg>        
                                    <input placeholder="Enter your Password Confirmation" class="input" id="password_confirmation" name="password_confirmation" type="password" required>
                                </div>
                                <div class="flex-row">
                                    <div>
                                        <input type="radio">
                                        <label>Remember me </label>
                                    </div>
                                    <span class="span">Forgot password?</span>
                                </div>
                                <button class="button-submit">Sign Up</button>
                                <p class="text-center">Already have an account? 
                                    <a class="span" href="{{ route('auth.index') }}">Sign In</a>
                                </p>
                                <p class="text-center">Or With</p>

                                <div class="flex-row">
                                    <a class="btn google" href="{{ route('auth.google') }}">
                                        <svg xml:space="preserve" style="enable-background:new 0 0 512 512;" viewBox="0 0 512 512" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" width="20" version="1.1">
                                        <path d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
                                            c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
                                            C103.821,274.792,107.225,292.797,113.47,309.408z" style="fill:#FBBB00;"></path>
                                        <path d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
                                            c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
                                            c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z" style="fill:#518EF8;"></path>
                                        <path d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
                                            c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
                                            c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z" style="fill:#28B446;"></path>
                                        <path d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
                                            c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
                                            C318.115,0,375.068,22.126,419.404,58.936z" style="fill:#F14336;"></path>
                                        </svg>
                                        Google 
                                    </a>
                                    <a class="btn facebook" style="background-color: #1877F2; color: white; display: flex; align-items: center; gap: 10px; padding: 10px 15px; border: none; border-radius: 5px;" href="{{route('auth.facebook')}}">
                                        <svg xml:space="preserve" style="enable-background:new 0 0 30 30;" viewBox="0 0 30 30" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="20" height="20" version="1.1">
                                            <path fill="#ffffff" d="M15,0C6.716,0,0,6.716,0,15c0,7.49,5.447,13.688,12.688,14.827V19.31h-3.828v-4.31h3.828v-3.289 c0-3.78,2.312-5.853,5.694-5.853c1.649,0,3.369,0.303,3.369,0.303v3.703h-1.897c-1.868,0-2.451,1.162-2.451,2.353v2.782h4.166 l-0.665,4.31h-3.501v10.517C24.553,28.688,30,22.49,30,15C30,6.716,23.284,0,15,0z"/>
                                        </svg>
                                        Facebook
                                    </a>                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>