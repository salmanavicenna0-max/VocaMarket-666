$path = "c:\VocaMarket-666-main\VocaMarket-666-main\resources\views\welcome.blade.php"
$content = Get-Content -Path $path -Raw
$start = $content.IndexOf("<!-- Product Grid -->")
$end = $content.IndexOf("<div class=`"flex justify-center mt-8`">")

if ($start -ge 0 -and $end -ge 0) {
    $before = $content.Substring(0, $start)
    $after = $content.Substring($end)
    
    $grid = @"
<!-- Product Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2 mb-8">
                @foreach(`$products as `$product)
                <a href="{{ url('/product/' . `$product->id) }}" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="{{ `$product->image_path }}" alt="Product" class="w-full h-full object-cover">
                        @if(`$product->is_promo)
                        <!-- Top left badge -->
                        <div class="absolute top-0 left-0 bg-accent text-gray-900 text-[9px] font-bold px-1.5 py-0.5 z-10 flex flex-col items-center uppercase shadow-sm">
                            <span>Promo</span>
                            <span>Extra</span>
                        </div>
                        @endif
                        @if(`$product->discount_percentage)
                        <!-- Top right badge -->
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-1 z-10 shadow-sm rounded-bl-sm">
                            -{{ `$product->discount_percentage }}%
                        </div>
                        @endif
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            @if(`$product->is_star)
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star+</span>
                            @endif
                            {{ `$product->name }}
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp{{ number_format(`$product->price, 0, ',', '.') }}</span>
                            <span class="text-[11px] text-gray-500">{{ `$product->sales_count >= 10000 ? floor(`$product->sales_count / 1000) . 'RB+' : `$product->sales_count }} terjual</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
"@
            
    $newContent = $before + $grid + $after
    Set-Content -Path $path -Value $newContent -Encoding UTF8
    Write-Host "Success"
} else {
    Write-Host "Fail: Cannot find boundaries."
}
