<?php

function handleImage($base64)
{
    $folderPath = 'public/images';
    // data:image/png;base64,9jas65d4a...
    // image_parts[0] = data:image/png
    // image_parts[1] = 9jas65d4a... => image
    $image_parts = explode(";base64,", $base64);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . '.' . $image_type;
    $file = $folderPath . uniqid() . '.' . $image_type;

    return [
        'file_name' => $file_name,
        'image_base64' => $image_base64,
    ];
}
