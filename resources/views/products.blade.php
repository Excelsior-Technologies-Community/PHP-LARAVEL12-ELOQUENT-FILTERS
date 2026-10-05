<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Laravel 12 Eloquent Filters - Product Manager
    </title>


    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Lucide -->
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


<div class="min-h-screen">


    <!-- ========================================================= -->
    <!-- HEADER -->
    <!-- ========================================================= -->

    <header class="bg-white border-b border-slate-200">

        <div class="max-w-7xl mx-auto px-6 py-5">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


                <div>

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center">

                            <i
                                data-lucide="package"
                                class="w-6 h-6 text-white"
                            ></i>

                        </div>


                        <div>

                            <h1 class="text-2xl font-extrabold">
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


    <!-- ========================================================= -->
    <!-- MAIN -->
    <!-- ========================================================= -->

    <main class="max-w-7xl mx-auto px-6 py-8">


        <!-- ===================================================== -->
        <!-- SUCCESS -->
        <!-- ===================================================== -->

        @if(session('success'))

            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 flex items-center gap-3">

                <i
                    data-lucide="check-circle"
                    class="w-5 h-5"
                ></i>

                <span class="font-medium">
                    {{ session('success') }}
                </span>

            </div>

        @endif


        <!-- ===================================================== -->
        <!-- VALIDATION -->
        <!-- ===================================================== -->

        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">

                <div class="flex items-center gap-3 mb-2">

                    <i
                        data-lucide="alert-circle"
                        class="w-5 h-5"
                    ></i>

                    <span class="font-bold">
                        Please fix the following errors:
                    </span>

                </div>


                <ul class="list-disc ml-8 text-sm space-y-1">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- ========================================================= -->
        <!-- STATISTICS -->
        <!-- ========================================================= -->

        <section class="mb-8">


            <div class="mb-4">

                <h2 class="text-xl font-bold">
                    Product Statistics
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Statistics based on your current filters
                </p>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">


                <!-- Total -->

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                    <p class="text-sm text-slate-500">
                        Total Products
                    </p>

                    <p class="text-2xl font-extrabold mt-2">
                        {{ number_format($statistics['total_products']) }}
                    </p>

                </div>


                <!-- Total Value -->

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                    <p class="text-sm text-slate-500">
                        Total Value
                    </p>

                    <p class="text-2xl font-extrabold mt-2">
                        ₹{{ number_format($statistics['total_value'] ?? 0, 2) }}
                    </p>

                </div>


                <!-- Lowest -->

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                    <p class="text-sm text-slate-500">
                        Lowest Price
                    </p>

                    <p class="text-2xl font-extrabold mt-2">

                        ₹{{ number_format($statistics['lowest_price'] ?? 0, 2) }}

                    </p>

                </div>


                <!-- Highest -->

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                    <p class="text-sm text-slate-500">
                        Highest Price
                    </p>

                    <p class="text-2xl font-extrabold mt-2">

                        ₹{{ number_format($statistics['highest_price'] ?? 0, 2) }}

                    </p>

                </div>


                <!-- Average -->

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

                    <p class="text-sm text-slate-500">
                        Average Price
                    </p>

                    <p class="text-2xl font-extrabold mt-2">

                        ₹{{ number_format($statistics['average_price'] ?? 0, 2) }}

                    </p>

                </div>

            </div>

        </section>


        <!-- ========================================================= -->
        <!-- ADD PRODUCT -->
        <!-- ========================================================= -->

        <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">


            <div class="flex items-center gap-3 mb-6">

                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">

                    <i
                        data-lucide="plus"
                        class="w-5 h-5 text-indigo-600"
                    ></i>

                </div>


                <div>

                    <h2 class="text-lg font-bold">
                        Add New Product
                    </h2>

                    <p class="text-sm text-slate-500">
                        Add a new product to your inventory
                    </p>

                </div>

            </div>


            <form
                action="{{ route('products.store') }}"
                method="POST"
            >

                @csrf


                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                    <!-- Name -->

                    <div>

                        <label class="block text-sm font-semibold mb-2">
                            Product Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Gold Necklace"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                    </div>


                    <!-- Category -->

                    <div>

                        <label class="block text-sm font-semibold mb-2">
                            Category
                        </label>

                        <select
                            name="category"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                            <option value="">
                                Select Category
                            </option>

                            <option value="Jewelry">
                                Jewelry
                            </option>

                            <option value="Electronics">
                                Electronics
                            </option>

                            <option value="Fashion">
                                Fashion
                            </option>

                            <option value="Home">
                                Home
                            </option>

                        </select>

                    </div>


                    <!-- Price -->

                    <div>

                        <label class="block text-sm font-semibold mb-2">
                            Price
                        </label>

                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            min="0"
                            step="0.01"
                            placeholder="e.g. 100000"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                    </div>

                </div>


                <div class="mt-5">

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700"
                    >

                        <i
                            data-lucide="plus"
                            class="w-4 h-4"
                        ></i>

                        Add Product

                    </button>

                </div>

            </form>

        </section>


        <!-- ========================================================= -->
        <!-- SEARCH / FILTER -->
        <!-- ========================================================= -->

        <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">


            <div class="flex items-center gap-3 mb-6">

                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center">

                    <i
                        data-lucide="filter"
                        class="w-5 h-5 text-slate-600"
                    ></i>

                </div>


                <div>

                    <h2 class="text-lg font-bold">
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

                        <label class="block text-sm font-semibold mb-2">
                            Search Product
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by product name..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                    </div>


                    <!-- Category -->

                    <div>

                        <label class="block text-sm font-semibold mb-2">
                            Category
                        </label>

                        <select
                            name="category"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                            <option value="">
                                All Categories
                            </option>

                            <option
                                value="Jewelry"
                                {{ request('category') == 'Jewelry' ? 'selected' : '' }}
                            >
                                Jewelry
                            </option>

                            <option
                                value="Electronics"
                                {{ request('category') == 'Electronics' ? 'selected' : '' }}
                            >
                                Electronics
                            </option>

                            <option
                                value="Fashion"
                                {{ request('category') == 'Fashion' ? 'selected' : '' }}
                            >
                                Fashion
                            </option>

                            <option
                                value="Home"
                                {{ request('category') == 'Home' ? 'selected' : '' }}
                            >
                                Home
                            </option>

                        </select>

                    </div>


                    <!-- Min -->

                    <div>

                        <label class="block text-sm font-semibold mb-2">
                            Min Price
                        </label>

                        <input
                            type="number"
                            name="min_price"
                            value="{{ request('min_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="₹ Min"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                    </div>


                    <!-- Max -->

                    <div>

                        <label class="block text-sm font-semibold mb-2">
                            Max Price
                        </label>

                        <input
                            type="number"
                            name="max_price"
                            value="{{ request('max_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="₹ Max"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                    </div>

                </div>


                <!-- Sort -->

                <div class="mt-5 flex flex-col md:flex-row md:items-end gap-4">


                    <div class="w-full md:w-72">

                        <label class="block text-sm font-semibold mb-2">
                            Sort Products
                        </label>

                        <select
                            name="sort"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                        >

                            <option
                                value="latest"
                                {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}
                            >
                                Latest Added
                            </option>

                            <option
                                value="oldest"
                                {{ request('sort') == 'oldest' ? 'selected' : '' }}
                            >
                                Oldest Added
                            </option>

                            <option
                                value="price_low"
                                {{ request('sort') == 'price_low' ? 'selected' : '' }}
                            >
                                Price: Low to High
                            </option>

                            <option
                                value="price_high"
                                {{ request('sort') == 'price_high' ? 'selected' : '' }}
                            >
                                Price: High to Low
                            </option>

                            <option
                                value="name_az"
                                {{ request('sort') == 'name_az' ? 'selected' : '' }}
                            >
                                Name: A to Z
                            </option>

                            <option
                                value="name_za"
                                {{ request('sort') == 'name_za' ? 'selected' : '' }}
                            >
                                Name: Z to A
                            </option>

                        </select>

                    </div>


                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white hover:bg-indigo-700"
                        >
                            Apply Filters
                        </button>


                        <a
                            href="{{ route('products.index') }}"
                            class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50"
                        >
                            Clear
                        </a>

                    </div>

                </div>

            </form>


            <!-- Export -->

            <div class="mt-5 pt-5 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">


                <div class="text-sm text-slate-500">

                    Export the currently filtered products.

                </div>


                <a
                    href="{{ route('products.export', request()->query()) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700"
                >

                    <i
                        data-lucide="download"
                        class="w-4 h-4"
                    ></i>

                    Export CSV

                </a>

            </div>

        </section>


        <!-- ========================================================= -->
        <!-- PRODUCT TABLE -->
        <!-- ========================================================= -->

        <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">


            <!-- Table Header -->

            <div class="px-6 py-5 border-b border-slate-200">


                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


                    <div>

                        <h2 class="text-lg font-bold">
                            Product List
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">

                            @if($products->total() > 0)

                                Showing
                                {{ $products->firstItem() }}
                                -
                                {{ $products->lastItem() }}
                                of
                                {{ $products->total() }}

                            @else

                                No products found

                            @endif

                        </p>

                    </div>


                    <!-- Bulk Delete -->

                    <form
                        id="bulkDeleteForm"
                        action="{{ route('products.bulkDelete') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            id="bulkDeleteButton"
                            disabled
                            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white opacity-50 cursor-not-allowed"
                        >

                            <i
                                data-lucide="trash-2"
                                class="w-4 h-4"
                            ></i>

                            Delete Selected

                        </button>

                    </form>

                </div>

            </div>


            @if($products->count() > 0)


                <div class="overflow-x-auto">

                    <table class="w-full">


                        <!-- THEAD -->

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>


                                <th class="px-6 py-4 text-left">

                                    <input
                                        type="checkbox"
                                        id="selectAll"
                                        class="w-4 h-4"
                                    >

                                </th>


                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    #
                                </th>


                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Product
                                </th>


                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Category
                                </th>


                                <th class="px-6 py-4 text-right text-xs font-bold uppercase text-slate-500">
                                    Price
                                </th>


                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Added
                                </th>


                                <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                    Actions
                                </th>


                            </tr>

                        </thead>


                        <!-- TBODY -->

                        <tbody class="divide-y divide-slate-100">


                            @foreach($products as $product)


                                <tr class="hover:bg-slate-50">


                                    <!-- CHECKBOX -->

                                    <td class="px-6 py-4">

                                        <input
                                            type="checkbox"
                                            name="product_ids[]"
                                            value="{{ $product->id }}"
                                            form="bulkDeleteForm"
                                            class="product-checkbox w-4 h-4"
                                        >

                                    </td>


                                    <!-- NUMBER -->

                                    <td class="px-6 py-4 text-sm text-slate-500">

                                        {{ $products->firstItem() + $loop->index }}

                                    </td>


                                    <!-- PRODUCT -->

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">


                                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">

                                                <i
                                                    data-lucide="package"
                                                    class="w-5 h-5 text-indigo-600"
                                                ></i>

                                            </div>


                                            <div>

                                                <p class="font-semibold text-slate-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="text-xs text-slate-400">
                                                    ID #{{ $product->id }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- CATEGORY -->

                                    <td class="px-6 py-4">

                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold">

                                            {{ $product->category }}

                                        </span>

                                    </td>


                                    <!-- PRICE -->

                                    <td class="px-6 py-4 text-right">

                                        <span class="font-bold">

                                            ₹{{ number_format($product->price, 2) }}

                                        </span>

                                    </td>


                                    <!-- DATE -->

                                    <td class="px-6 py-4 text-sm text-slate-500">

                                        {{ $product->created_at->format('d M Y') }}

                                    </td>


                                    <!-- ACTIONS -->

                                    <td class="px-6 py-4">


                                        <div class="flex justify-center items-center gap-2">


                                            <!-- EDIT -->

                                            <button
                                                type="button"
                                                onclick="openEditModal(
                                                    {{ $product->id }},
                                                    @js($product->name),
                                                    @js($product->category),
                                                    {{ $product->price }}
                                                )"
                                                class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600 hover:bg-blue-100"
                                            >

                                                <i
                                                    data-lucide="edit"
                                                    class="w-4 h-4"
                                                ></i>

                                                Edit

                                            </button>


                                            <!-- DELETE -->

                                            <form
                                                action="{{ route('products.destroy', $product) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-100"
                                                >

                                                    <i
                                                        data-lucide="trash-2"
                                                        class="w-4 h-4"
                                                    ></i>

                                                    Delete

                                                </button>

                                            </form>

                                        </div>

                                    </td>


                                </tr>


                            @endforeach

                        </tbody>

                    </table>

                </div>


                <!-- PAGINATION -->

                @if($products->hasPages())

                    <div class="px-6 py-5 border-t border-slate-200">

                        {{ $products->onEachSide(1)->links() }}

                    </div>

                @endif


            @else


                <!-- EMPTY -->

                <div class="px-6 py-16 text-center">


                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-5">

                        <i
                            data-lucide="package-x"
                            class="w-8 h-8 text-slate-400"
                        ></i>

                    </div>


                    <h3 class="text-lg font-bold">
                        No products found
                    </h3>


                    <p class="text-sm text-slate-500 mt-2">
                        Try changing your search or filters.
                    </p>


                    <a
                        href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-2 mt-5 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white"
                    >

                        Clear Filters

                    </a>

                </div>

            @endif

        </section>


        <!-- ========================================================= -->
        <!-- FOOTER -->
        <!-- ========================================================= -->

        <div class="mt-6 text-center text-sm text-slate-400">

            Laravel 12 • Eloquent Filters • Search • Sorting • Pagination
            • Statistics • Edit • Delete • Bulk Delete • CSV Export

        </div>


    </main>

</div>


<!-- ========================================================= -->
<!-- EDIT MODAL -->
<!-- ========================================================= -->

<div
    id="editModal"
    class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-5"
>


    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg">


        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">


            <div>

                <h2 class="text-lg font-bold">
                    Edit Product
                </h2>

                <p class="text-sm text-slate-500">
                    Update product information
                </p>

            </div>


            <button
                type="button"
                onclick="closeEditModal()"
                class="text-slate-400 hover:text-slate-700"
            >

                <i
                    data-lucide="x"
                    class="w-5 h-5"
                ></i>

            </button>

        </div>


        <form
            id="editForm"
            method="POST"
            class="p-6"
        >

            @csrf

            @method('PUT')


            <!-- Name -->

            <div class="mb-5">

                <label class="block text-sm font-semibold mb-2">
                    Product Name
                </label>

                <input
                    type="text"
                    id="editName"
                    name="name"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                >

            </div>


            <!-- Category -->

            <div class="mb-5">

                <label class="block text-sm font-semibold mb-2">
                    Category
                </label>

                <select
                    id="editCategory"
                    name="category"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                >

                    <option value="Jewelry">
                        Jewelry
                    </option>

                    <option value="Electronics">
                        Electronics
                    </option>

                    <option value="Fashion">
                        Fashion
                    </option>

                    <option value="Home">
                        Home
                    </option>

                </select>

            </div>


            <!-- Price -->

            <div class="mb-6">

                <label class="block text-sm font-semibold mb-2">
                    Price
                </label>

                <input
                    type="number"
                    id="editPrice"
                    name="price"
                    min="0"
                    step="0.01"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500"
                >

            </div>


            <div class="flex justify-end gap-3">


                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold"
                >

                    Cancel

                </button>


                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700"
                >

                    Update Product

                </button>

            </div>

        </form>

    </div>

</div>


<!-- ========================================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================================= -->

<script>


    /*
    |--------------------------------------------------------------------------
    | Lucide Icons
    |--------------------------------------------------------------------------
    */

    lucide.createIcons();


    /*
    |--------------------------------------------------------------------------
    | Select All
    |--------------------------------------------------------------------------
    */

    const selectAll = document.getElementById('selectAll');

    const checkboxes = document.querySelectorAll('.product-checkbox');

    const bulkDeleteButton =
        document.getElementById('bulkDeleteButton');


    function updateBulkButton()
    {
        const selected =
            document.querySelectorAll(
                '.product-checkbox:checked'
            ).length;


        if (selected > 0)
        {
            bulkDeleteButton.disabled = false;

            bulkDeleteButton.classList.remove(
                'opacity-50',
                'cursor-not-allowed'
            );
        }
        else
        {
            bulkDeleteButton.disabled = true;

            bulkDeleteButton.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            );
        }
    }


    if (selectAll)
    {
        selectAll.addEventListener('change', function ()
        {
            checkboxes.forEach(function (checkbox)
            {
                checkbox.checked = selectAll.checked;
            });

            updateBulkButton();
        });
    }


    checkboxes.forEach(function (checkbox)
    {
        checkbox.addEventListener('change', function ()
        {
            const total =
                document.querySelectorAll(
                    '.product-checkbox'
                ).length;


            const selected =
                document.querySelectorAll(
                    '.product-checkbox:checked'
                ).length;


            selectAll.checked =
                total > 0 && total === selected;


            updateBulkButton();
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Bulk Delete Confirmation
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('bulkDeleteForm')
        .addEventListener('submit', function (event)
        {
            const selected =
                document.querySelectorAll(
                    '.product-checkbox:checked'
                ).length;


            if (selected === 0)
            {
                event.preventDefault();

                return;
            }


            const confirmed = confirm(
                'Are you sure you want to delete ' +
                selected +
                ' selected product(s)?'
            );


            if (!confirmed)
            {
                event.preventDefault();
            }
        });


    /*
    |--------------------------------------------------------------------------
    | Edit Modal
    |--------------------------------------------------------------------------
    */

    function openEditModal(
        id,
        name,
        category,
        price
    )
    {
        document
            .getElementById('editModal')
            .classList.remove('hidden');


        document
            .getElementById('editName')
            .value = name;


        document
            .getElementById('editCategory')
            .value = category;


        document
            .getElementById('editPrice')
            .value = price;


        document
            .getElementById('editForm')
            .action =
            '/products/' + id;
    }


    function closeEditModal()
    {
        document
            .getElementById('editModal')
            .classList.add('hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | Close modal when clicking outside
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('editModal')
        .addEventListener('click', function (event)
        {
            if (event.target === this)
            {
                closeEditModal();
            }
        });


</script>


</body>

</html>