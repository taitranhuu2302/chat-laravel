<?php

function handleImageBase64($base64)
{
    $folderPath = 'public/images';
    // data:image/png;base64,9jas65d4a...
    // image_parts[0] = data:image/png
    // image_parts[1] = 9jas65d4a... => image
    $image_parts = explode(";base64,", $base64);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . time() . '.' . $image_type;
    $path_file = env('URL_SERVER') . '/storage/images/' . $file_name;

    return [
        'path_file' => $path_file,
        'file_name' => $file_name,
        'image_base64' => $image_base64,
    ];
}

function isBase64(string $base64): bool
{

    try {
        $image_parts = explode(";base64,", $base64);

        if (base64_encode(base64_decode($image_parts[1], true)) === $image_parts[1]) {
            return true;
        } else {
            return false;
        }
    } catch (\Exception $e) {
        return false;
    }
}
