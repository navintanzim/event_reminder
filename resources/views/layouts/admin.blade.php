
     

@extends (auth()->check() ? 'layouts.plane' : 'layouts.home-plane')


@section('body')
    <style>
        .modal {
            text-align: center;
        }

        @media screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }
         input[type="checkbox"] {
             cursor: pointer;
         }
        input[type="radio"] {
            cursor: pointer;
        }

    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="{{ !env('IS_MOBILE') ? 'content-wrapper' : '' }}" style="@if(!env('IS_MOBILE')) @else background: white; @endif">

        <!-- Main content -->
        <section class="content container-fluid">
            <!--------------------------
              | Your Page Content Here |
              -------------------------->
            @yield('content')
        </section>
        <!-- /.content -->
    </div>

@stop

