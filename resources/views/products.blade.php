<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laravel 12 Eloquent Filters - Product Manager</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- Main Container -->
    <div class="min-h-screen">

        <!-- Header -->
        <header class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-6 py-5">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center">
                                <i data-lucide="package" class="w-6 h-6 text-white"></i>
                            </div>

                            <div>
                                <h1 class="text-2xl font-extrabold text-slate-900">
                                    Product Inventory
                                </h1>

                                <p class="text-sm text-slate-500">
                                    Laravel 12 Eloquent Filters
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-slate-500">
                        Showing
                        <span class="font-bold text-slate-900">
                            {{ $products->total() }}
                        </span>
                        products
                    </div>

                </div>

            </div>
        </header>


        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-6 py-8">


            <!-- Success Message -->
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 flex items-center gap-3">

                    <i data-lucide="check-circle" class="w-5 h-5"></i>

                    <span class="font-medium">
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            <!-- Validation Errors -->
            @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">

                    <div class="flex items-center gap-3 mb-2">

                        <i data-lucide="alert-circle" class="w-5 h-5"></i>

                        <span class="font-bold">
                            Please fix the following errors:
                        </span>

                    </div>

                    <ul class="list-disc ml-8 text-sm space-y-1">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- ========================================================= -->
            <!-- PRICE STATISTICS DASHBOARD -->
            <!-- ========================================================= -->

            <section class="mb-8">

                <div class="mb-4">

                    <h2 class="text-xl font-bold text-slate-900">
                        Product Statistics
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Statistics based on your current search and filters
                    </p>

                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">


                    <!-- Total Products -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Total Products
                                </p>

                                <p class="text-2xl font-extrabold text-slate-900 mt-2">
                                    {{ number_format($statistics['total_products']) }}
                                </p>
                            </div>

                            <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">

                                <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>

                            </div>

                        </div>

                    </div>


                    <!-- Total Inventory Value -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Total Value
                                </p>

                                <p class="text-2xl font-extrabold text-slate-900 mt-2">
                                    ₹{{ number_format($statistics['total_value'] ?? 0, 2) }}
                                </p>
                            </div>

                            <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center">

                                <i data-lucide="wallet" class="w-5 h-5 text-emerald-600"></i>

                            </div>

                        </div>

                    </div>


                    <!-- Lowest Price -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Lowest Price
                                </p>

                                <p class="text-2xl font-extrabold text-slate-900 mt-2">

                                    @if($statistics['lowest_price'] !== null)

                                        ₹{{ number_format($statistics['lowest_price'], 2) }}

                                    @else

                                        ₹0.00

                                    @endif

                                </p>
                            </div>

                            <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">

                                <i data-lucide="trending-down" class="w-5 h-5 text-blue-600"></i>

                            </div>

                        </div>

                    </div>


                    <!-- Highest Price -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Highest Price
                                </p>

                                <p class="text-2xl font-extrabold text-slate-900 mt-2">

                                    @if($statistics['highest_price'] !== null)

                                        ₹{{ number_format($statistics['highest_price'], 2) }}

                                    @else

                                        ₹0.00

                                    @endif

                                </p>
                            </div>

                            <div class="w-11 h-11 rounded-xl bg-orange-100 flex items-center justify-center">

                                <i data-lucide="trending-up" class="w-5 h-5 text-orange-600"></i>

                            </div>

                        </div>

                    </div>


                    <!-- Average Price -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Average Price
                                </p>

                                <p class="text-2xl font-extrabold text-slate-900 mt-2">

                                    @if($statistics['average_price'] !== null)

                                        ₹{{ number_format($statistics['average_price'], 2) }}

                                    @else

                                        ₹0.00

                                    @endif

                                </p>
                            </div>

                            <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center">

                                <i data-lucide="bar-chart-3" class="w-5 h-5 text-purple-600"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- ========================================================= -->
            <!-- ADD PRODUCT -->
            <!-- ========================================================= -->

            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">

                <div class="flex items-center gap-3 mb-6">

                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">

                        <i data-lucide="plus" class="w-5 h-5 text-indigo-600"></i>

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Add New Product
                        </h2>

                        <p class="text-sm text-slate-500">
                            Add a new product to your inventory
                        </p>

                    </div>

                </div>


                <form action="{{ route('products.store') }}" method="POST">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                        <!-- Product Name -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. Gold Necklace"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                        </div>


                        <!-- Category -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Category
                            </label>

                            <select
                                name="category"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                                <option value="">Select Category</option>

                                <option value="Jewelry" {{ old('category') == 'Jewelry' ? 'selected' : '' }}>
                                    Jewelry
                                </option>

                                <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>
                                    Electronics
                                </option>

                                <option value="Fashion" {{ old('category') == 'Fashion' ? 'selected' : '' }}>
                                    Fashion
                                </option>

                                <option value="Home" {{ old('category') == 'Home' ? 'selected' : '' }}>
                                    Home
                                </option>

                            </select>

                        </div>


                        <!-- Price -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Price
                            </label>

                            <input
                                type="number"
                                name="price"
                                value="{{ old('price') }}"
                                placeholder="e.g. 100000"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                        </div>

                    </div>


                    <div class="mt-5">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition"
                        >

                            <i data-lucide="plus" class="w-4 h-4"></i>

                            Add Product

                        </button>

                    </div>

                </form>

            </section>


            <!-- ========================================================= -->
            <!-- SEARCH & FILTERS -->
            <!-- ========================================================= -->

            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">

                <div class="flex items-center gap-3 mb-6">

                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center">

                        <i data-lucide="filter" class="w-5 h-5 text-slate-600"></i>

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Search & Filter Products
                        </h2>

                        <p class="text-sm text-slate-500">
                            Search, filter and sort your products
                        </p>

                    </div>

                </div>


                <form
                    action="{{ route('products.index') }}"
                    method="GET"
                >

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">


                        <!-- Search -->
                        <div class="lg:col-span-2">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Search Product
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="search"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                ></i>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by product name..."
                                    class="w-full rounded-xl border border-slate-300 pl-10 pr-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                                >

                            </div>

                        </div>


                        <!-- Category -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Category
                            </label>

                            <select
                                name="category"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                                <option value="">
                                    All Categories
                                </option>

                                <option value="Jewelry" {{ request('category') == 'Jewelry' ? 'selected' : '' }}>
                                    Jewelry
                                </option>

                                <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>
                                    Electronics
                                </option>

                                <option value="Fashion" {{ request('category') == 'Fashion' ? 'selected' : '' }}>
                                    Fashion
                                </option>

                                <option value="Home" {{ request('category') == 'Home' ? 'selected' : '' }}>
                                    Home
                                </option>

                            </select>

                        </div>


                        <!-- Min Price -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Min Price
                            </label>

                            <input
                                type="number"
                                name="min_price"
                                value="{{ request('min_price') }}"
                                placeholder="₹ Min"
                                min="0"
                                step="0.01"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                        </div>


                        <!-- Max Price -->
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Max Price
                            </label>

                            <input
                                type="number"
                                name="max_price"
                                value="{{ request('max_price') }}"
                                placeholder="₹ Max"
                                min="0"
                                step="0.01"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                        </div>

                    </div>


                    <!-- Sort -->
                    <div class="mt-5 flex flex-col md:flex-row md:items-end gap-4">

                        <div class="w-full md:w-72">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Sort Products
                            </label>

                            <select
                                name="sort"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            >

                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    Latest Added
                                </option>

                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    Oldest Added
                                </option>

                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                    Price: Low to High
                                </option>

                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                    Price: High to Low
                                </option>

                                <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>
                                    Name: A to Z
                                </option>

                                <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>
                                    Name: Z to A
                                </option>

                            </select>

                        </div>


                        <div class="flex gap-3">

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition"
                            >

                                <i data-lucide="search" class="w-4 h-4"></i>

                                Apply Filters

                            </button>


                            <a
                                href="{{ route('products.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition"
                            >

                                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>

                                Clear

                            </a>

                        </div>

                    </div>

                </form>


                <!-- Active Filters -->
                @if(request('search') || request('category') || request('min_price') || request('max_price') || request('sort'))

                    <div class="mt-5 pt-5 border-t border-slate-200">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-600">
                                Active:
                            </span>


                            @if(request('search'))

                                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 text-indigo-700 px-3 py-1 text-xs font-semibold">

                                    Search: {{ request('search') }}

                                </span>

                            @endif


                            @if(request('category'))

                                <span class="inline-flex items-center gap-1 rounded-full bg-purple-50 text-purple-700 px-3 py-1 text-xs font-semibold">

                                    Category: {{ request('category') }}

                                </span>

                            @endif


                            @if(request('min_price'))

                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1 text-xs font-semibold">

                                    Min: ₹{{ number_format((float) request('min_price'), 2) }}

                                </span>

                            @endif


                            @if(request('max_price'))

                                <span class="inline-flex items-center gap-1 rounded-full bg-orange-50 text-orange-700 px-3 py-1 text-xs font-semibold">

                                    Max: ₹{{ number_format((float) request('max_price'), 2) }}

                                </span>

                            @endif


                            @if(request('sort'))

                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-700 px-3 py-1 text-xs font-semibold">

                                    Sort: {{ str_replace('_', ' ', ucfirst(request('sort'))) }}

                                </span>

                            @endif

                        </div>

                    </div>

                @endif

            </section>


            <!-- ========================================================= -->
            <!-- PRODUCT TABLE -->
            <!-- ========================================================= -->

            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Product List
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">

                            @if($products->total() > 0)

                                Showing
                                {{ $products->firstItem() }}
                                to
                                {{ $products->lastItem() }}
                                of
                                {{ $products->total() }}
                                products

                            @else

                                No products found

                            @endif

                        </p>

                    </div>

                    <div class="text-sm text-slate-500">

                        Current Page:
                        <span class="font-bold text-slate-900">
                            {{ $products->currentPage() }}
                        </span>

                    </div>

                </div>


                @if($products->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-slate-50 border-b border-slate-200">

                                <tr>

                                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                        #
                                    </th>

                                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Product Name
                                    </th>

                                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Category
                                    </th>

                                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Price
                                    </th>

                                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Added
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @foreach($products as $product)

                                    <tr class="hover:bg-slate-50 transition">

                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ $products->firstItem() + $loop->index }}
                                        </td>


                                        <td class="px-6 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">

                                                    <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>

                                                </div>

                                                <div>

                                                    <p class="font-semibold text-slate-900">
                                                        {{ $product->name }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        <td class="px-6 py-4">

                                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">

                                                {{ $product->category }}

                                            </span>

                                        </td>


                                        <td class="px-6 py-4 text-right">

                                            <span class="font-bold text-slate-900">

                                                ₹{{ number_format($product->price, 2) }}

                                            </span>

                                        </td>


                                        <td class="px-6 py-4 text-sm text-slate-500">

                                            {{ $product->created_at->format('d M Y') }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    <!-- Pagination -->

                    @if($products->hasPages())

                        <div class="px-6 py-5 border-t border-slate-200">

                            {{ $products->onEachSide(1)->links() }}

                        </div>

                    @endif

                @else

                    <!-- Empty State -->

                    <div class="px-6 py-16 text-center">

                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-5">

                            <i data-lucide="package-x" class="w-8 h-8 text-slate-400"></i>

                        </div>

                        <h3 class="text-lg font-bold text-slate-900">
                            No products found
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Try changing your search or filter criteria.
                        </p>

                        <a
                            href="{{ route('products.index') }}"
                            class="inline-flex items-center gap-2 mt-5 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700"
                        >

                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>

                            Clear Filters

                        </a>

                    </div>

                @endif

            </section>


            <!-- Footer Information -->
            <div class="mt-6 text-center text-sm text-slate-400">

                Laravel 12 • Eloquent Filters • Search • Sorting • Pagination • Statistics

            </div>

        </main>

    </div>


    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

</body>

</html>