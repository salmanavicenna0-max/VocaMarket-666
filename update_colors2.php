<?php
$dir = new RecursiveDirectoryIterator('C:\VocaMarket-666\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    "'#004AAD'" => "'#3A86FF'",
    "#004AAD" => "#3A86FF",
    "rgba(0, 74, 173" => "rgba(58, 134, 255"
];

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $newContent = strtr($content, $replacements);
    if($newContent !== $content) {
        file_put_contents($path, $newContent);
        echo "Updated: " . $path . PHP_EOL;
    }
}
echo "Done.";
