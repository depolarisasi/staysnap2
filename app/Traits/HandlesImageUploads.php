<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

trait HandlesImageUploads
{
    /**
     * Validasi upload gambar
     */
    protected function validateImage($request, $rules = [])
    {
        $defaultRules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=2000,max_height=2000'
        ];

        return $request->validate(array_merge($defaultRules, $rules));
    }

    /**
     * Proses upload dan optimasi gambar
     */
    protected function processAndStoreImage($image, $directory = null, $fieldName = null)
        {
        $directory = $directory ?: $this->imageDirectory;
        $fieldName = $fieldName ?: $this->imageFieldName;
        try {
            // Generate nama file aman
            $filename = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                . '_' . uniqid()
                . '.' . $image->getClientOriginalExtension();

            // Buat direktori jika belum ada
            Storage::makeDirectory("public/{$directory}");

            // Proses gambar
            $img = Image::make($image)
                ->orientate()
                ->resize(
                    $this->imageWidth ?? 800, 
                    $this->imageHeight ?? 800, 
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }
                )
                ->encode(null, $this->imageQuality ?? 80);

            // Simpan ke storage
            Storage::put("public/{$directory}/{$filename}", $img);

            return "{$directory}/{$filename}";

        } catch (Exception $e) {
            throw new Exception("Gagal memproses gambar: " . $e->getMessage());
        }
    }

    /**
     * Hapus gambar lama
     */
    protected function deleteOldImage($path)
    {
        try {
            if ($path && Storage::exists("public/{$path}")) {
                Storage::delete("public/{$path}");
            }
        } catch (Exception $e) {
            throw new Exception("Gagal menghapus gambar: " . $e->getMessage());
        }
    }

    protected function imageValidationRules()
{
    return [
        $this->imageFieldName => 'nullable|image|mimes:jpeg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000'
    ];
}
}