<div>

    @push('meta')
        <title>{{ $meta['seo_title'] ?? $blog->title }}</title>

        <meta name="description" content="{{ $meta['seo_description'] ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}">
        <meta name="keywords" content="{{ $meta['seo_keywords'] ?? $blog->tags->pluck('tag_name')->join(', ') }}">

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $meta['seo_title'] ?? $blog->title }}">
        <meta property="og:description" content="{{ $meta['seo_description'] ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}">
        <meta property="og:image" content="{{ asset('storage/' . $blog->featured_img) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $meta['seo_title'] ?? $blog->title }}">
        <meta name="twitter:description" content="{{ $meta['seo_description'] ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}">
        <meta name="twitter:image" content="{{ asset('storage/' . $blog->featured_img) }}">
        <title>{{ $meta['seo_title'] ?? $blog->title }}</title>
    @endpush


    <!-- Blog Article -->
    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid lg:grid-cols-3 gap-y-8 lg:gap-y-0 lg:gap-x-6">
            <!-- Content -->
            <div class="lg:col-span-2">
                <div class="py-8 lg:pe-8">
                    <div class="space-y-5 lg:space-y-8">
                        <a class="inline-flex flex-row items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline dark:text-red-500" href="{{ route('page.blog') }}">
                        <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"><path d="m15 18-6-6 6-6"/></svg>
                        {{ __('Back to Blog') }}
                        </a>

                        <h2 class="text-3xl font-bold lg:text-5xl dark:text-white">
                        {{ $blog->title }}
                        </h2>

                        <div class="flex flex-row items-center justify-items-start gap-x-2">
                            <svg class="shrink-0 size-6 text-neutral-800 dark:text-neutral-200" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>

                            <p class="text-xs sm:text-sm text-gray-800 dark:text-neutral-200">
                                {{ $blog->created_at->format('F d, Y') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-x-5">
                            @foreach ($blog->categories as $category)
                                <a href="{{ route('page.blog.category', $category->cat_slug) }}" class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-hidden focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20">
                                {{ $category->cat_name }}
                                </a>
                            @endforeach

                        </div>

                        @if($blog->featured_img)
                        <div class="text-center">
                            <img class="w-full rounded-xl my-6 h-90 object-cover" src="{{ asset(Storage::url($blog->featured_img)) }}" alt="{{ $blog->title }}">
                        </div>
                        @endif

                        <div class="text-lg text-gray-800 dark:text-neutral-200">
                        {!! str($blog->content)->sanitizeHtml() !!}
                        </div>

                        @if(is_array($blog->images))
                        <div class="grid lg:grid-cols-3 gap-4 mt-6">
                            @foreach($blog->images as $img)
                            <figure class="relative w-full h-60">
                                <img class="absolute w-full h-full object-cover rounded-xl" src="{{ asset('storage/' . $img) }}" alt="Blog Image">
                            </figure>
                            @endforeach
                        </div>
                        @endif

                        <!-- You can extend more dynamic paragraphs/sections if needed -->
                    </div>

                    <div class="mt-6">
                        <div class="flex flex-wrap gap-2">
                        @foreach($blog->tags ?? [] as $tag)
                            <a class="inline-flex items-center gap-1.5 py-2 px-3 rounded-full text-sm bg-gray-200 text-gray-800 dark:bg-neutral-800 dark:text-neutral-200" href="{{ route('page.blog.tag', $tag->tag_slug) }}">
                            {{ $tag->tag_name }}
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <!-- Sidebar -->
            <div class="lg:col-span-1 lg:w-full lg:h-full lg:bg-linear-to-r lg:from-gray-50 lg:via-transparent lg:to-transparent dark:from-neutral-800">
                <div class="sticky top-0 start-0 py-8 lg:ps-8">
                    <!-- Avatar Media -->
                    <div class="group flex items-center gap-x-3 border-b border-gray-200 pb-8 mb-8 dark:border-neutral-700">
                        <a class="block shrink-0 focus:outline-hidden" href="#">
                        <img class="size-10 rounded-full" src="{{ 'https://ui-avatars.com/api/?name=' . $blog->user->name . '&background=f44336&color=fff' }}" alt="{{ $blog->user->name }}">
                        </a>

                        <a class="group grow block focus:outline-hidden" href="">
                        <h5 class="group-hover:text-gray-600 group-focus:text-gray-600 text-sm font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:group-focus:text-neutral-400 dark:text-neutral-200">
                            {{ $blog->user->name }}
                        </h5>
                        <p class="text-sm text-gray-500 dark:text-neutral-500">
                            {{ $blog->user->email }}
                        </p>
                        </a>

                    </div>
                    <!-- End Avatar Media -->

                    <div class="space-y-6">

                        @foreach ($relatedBlogs as $related)
                        <a class="group flex items-center gap-x-6 focus:outline-hidden" href="{{ route('page.blog.show', $related->slug) }}">
                            <div class="grow">
                                <span class="text-sm font-bold text-gray-800 group-hover:text-red-600 group-focus:text-red-600 dark:text-neutral-200 dark:group-hover:text-red-500 dark:group-focus:text-red-500">
                                    {{ $related->title }}
                                </span>
                            </div>

                            <div class="shrink-0 relative rounded-lg overflow-hidden size-20">
                                <img class="size-full absolute top-0 start-0 object-cover rounded-lg"
                                    src="{{ asset(Storage::url($related->featured_img)) ?? 'https://via.placeholder.com/150' }}"
                                    alt="Blog Image">
                            </div>
                        </a>
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- End Sidebar -->
        </div>
    </div>


</div>
