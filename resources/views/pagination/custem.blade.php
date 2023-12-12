@if ($paginator->hasPages())
    <div class="flex justify-around">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{-- Disable --}}
            <a href="#" class="px-4 py-2 mx-1 text-gray-500 capitalize bg-white rounded-md cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                <div class="flex items-center -mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-1 rtl:-scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>

                    <span class="mx-1">
                        previous
                    </span>
                </div>
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-4 py-2 mx-1 text-gray-500 capitalize transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-600  hover:bg-blue-500 dark:hover:bg-blue-500 hover:text-white dark:hover:text-gray-200">
                <div class="flex items-center -mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-1 rtl:-scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>

                    <span class="mx-1">
                        previous
                    </span>
                </div>
            </a>
        @endif


        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                {{-- <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li> --}}
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="" class="hidden px-4 py-2 mx-1 text-gray-700 transition-colors duration-300  rounded-md sm:inline dark:bg-gray-800 dark:text-gray-200 bg-blue-500 dark:bg-blue-500 text-white dark:text-gray-200">
                            {{ $page }}
                        </a>
                    @else
                        <a href="{{ $url }}"
                            class="hidden px-4 py-2 mx-1 text-gray-700 transition-colors duration-300 transform bg-white rounded-md sm:inline dark:bg-gray-800 dark:text-gray-200 hover:bg-blue-500 dark:hover:bg-blue-500 hover:text-white dark:hover:text-gray-200">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach


        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-4 py-2 mx-1 text-gray-700 transition-colors duration-300 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-blue-500 dark:hover:bg-blue-500 hover:text-white dark:hover:text-gray-200">
                <div class="flex items-center -mx-1">
                    <span class="mx-1">
                        Next
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-1 rtl:-scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </a>
        @else
            <a href="#"
                class="px-4 py-2 mx-1 text-gray-700 transition-colors duration-300 cursor-not-allowed bg-white rounded-md dark:bg-gray-800 dark:text-gray-200">
                <div class="flex items-center -mx-1">
                    <span class="mx-1">
                        Next
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-1 rtl:-scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </a>
        @endif
    </div>
@endif