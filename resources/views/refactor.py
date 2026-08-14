import os

path = r'c:\VocaMarket-666-main\VocaMarket-666-main\resources\views\welcome.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

start_idx = content.find('<!-- Carousel Section -->')
end_idx = content.find('</main>')

if start_idx != -1 and end_idx != -1:
    body = content[start_idx:end_idx]
    new_content = "@extends('layouts.app')\n@section('title', 'Beranda - VocaMarket')\n@section('content')\n" + body + "\n@endsection\n"
    with open(path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print("Successfully refactored welcome.blade.php")
else:
    print("Could not find markers")
