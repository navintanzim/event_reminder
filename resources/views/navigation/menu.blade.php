@if(in_array($type[0], [1,2,4,5,7,8]))

@endif

@if(in_array($type[0], [1,4,6]))
    <li class="{{ ((Request::is('visa-assistance/*') || Request::is('process/visa-assistance/*')) ? 'active' : '') }}">
        <a class="@if (Request::is('visa-assistance/*'))  active @endif" href="{{ url ('/visa-assistance/list/'.\App\Libraries\Encryption::encodeId(7)) }}">
            <i class="fa fa-file fa-fw"></i> Visa Assistance
        </a>
    </li>
@endif


