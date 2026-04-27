@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo; Попередня</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Попередня</a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Наступна &raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Наступна &raquo;</span></li>
            @endif
        </ul>
        <div class="text-center mt-2">
            <small>Показано з {{ $paginator->firstItem() }} до {{ $paginator->lastItem() }} із {{ $paginator->total() }} товарів</small>
        </div>
    </nav>
@endif
