$path = "c:\VocaMarket-666-main\VocaMarket-666-main\resources\views\welcome.blade.php"
$content = Get-Content -Path $path -Raw
$start = $content.IndexOf("<!-- Carousel Section -->")
$end = $content.IndexOf("</main>")
if ($start -ge 0 -and $end -ge 0) {
    $body = $content.Substring($start, $end - $start)
    $newContent = "@extends('layouts.app')`n@section('title', 'Beranda - VocaMarket')`n@section('content')`n" + $body + "`n@endsection`n"
    Set-Content -Path $path -Value $newContent -Encoding UTF8
    Write-Host "Success"
} else {
    Write-Host "Fail"
}
