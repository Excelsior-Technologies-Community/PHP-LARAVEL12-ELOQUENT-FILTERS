<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Premium Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

    <div class="max-w-6xl mx-auto px-4 py-12">
        
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">📦 Product Inventory</h1>
                <p class="text-slate-500 mt-1">Manage your products with Eloquent filters.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 flex items-center gap-3">
                <span class="text-sm font-medium text-slate-600">Total Records:</span>
                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">{{ $products->count() }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden sticky top-8">
                    <div class="bg-slate-900 p-4 text-white flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        <h2 class="font-bold">Add New Product</h2>
                    </div>
                    
                    <form action="{{ route('products.store') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @if(session('success'))
                            <div class="bg-emerald-50 text-emerald-700 p-3 rounded-lg text-sm border border-emerald-100 flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('success') }}
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Product Name</label>
                            <input type="text" name="name" placeholder="e.g. Gold Necklace" required 
                                class="w-full bg-slate-50 border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all border text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Category</label>
                            <select name="category" required class="w-full bg-slate-50 border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 outline-none transition-all border text-sm appearance-none">
                                <option value="Jewelry">💎 Jewelry</option>
                                <option value="Electronics">💻 Electronics</option>
                                <option value="Fashion">👕 Fashion</option>
                                <option value="Home">🏠 Home</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Price (INR)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-400">₹</span>
                                <input type="number" name="price" step="0.01" placeholder="0.00" required 
                                    class="w-full bg-slate-50 border-slate-200 rounded-xl p-3 pl-8 focus:ring-2 focus:ring-indigo-500 outline-none transition-all border text-sm font-semibold">
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 group">
                            Submit Product
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
                    <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap items-center gap-3">
                        <div class="relative flex-1 min-w-[150px]">
                            <i data-lucide="tag" class="w-4 h-4 absolute left-3 top-3.5 text-slate-400"></i>
                            <select name="category" class="w-full bg-slate-50 border-transparent rounded-xl p-2.5 pl-10 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none border transition-all">
                                <option value="">All Categories</option>
                                <option value="Jewelry" {{ request('category') == 'Jewelry' ? 'selected' : '' }}>Jewelry</option>
                                <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Fashion" {{ request('category') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                                <option value="Home" {{ request('category') == 'Home' ? 'selected' : '' }}>Home</option>
                            </select>
                        </div>

                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min ₹" 
                            class="w-24 bg-slate-50 border-transparent rounded-xl p-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none border transition-all">
                        
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max ₹" 
                            class="w-24 bg-slate-50 border-transparent rounded-xl p-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none border transition-all">

                        <button type="submit" class="bg-slate-900 text-white p-2.5 rounded-xl hover:bg-slate-800 transition-all shadow-md">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                        
                        @if(request()->anyFilled(['category', 'min_price', 'max_price']))
                            <a href="{{ route('products.index') }}" class="text-slate-500 hover:text-red-500 p-2 text-sm font-medium transition-colors">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-slate-500">Product Details</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-slate-500">Category</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($products as $product)
                            <tr class="group hover:bg-indigo-50/30 transition-colors">
                                <td class="p-4">
                                    <div class="font-semibold text-slate-800">{{ $product->name }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">ID: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 group-hover:bg-indigo-100 group-hover:text-indigo-700 transition-colors">
                                        {{ $product->category }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <span class="text-lg font-bold text-slate-900 italic">₹{{ number_format($product->price, 2) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <i data-lucide="package-search" class="w-12 h-12 text-slate-300"></i>
                                        <p class="text-slate-400 font-medium text-lg">No matches found for your criteria.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Icons initialize karva mate
        lucide.createIcons();
    </script>
</body>
</html>