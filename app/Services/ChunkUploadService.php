<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChunkUploadService
{
    public function handle(Request $request): array
    {
        $fileName = $request->resumableFilename;
        $chunkNumber = $request->resumableChunkNumber;

        // Save chunk temporarily
        $chunkPath = "chunks/{$fileName}.part{$chunkNumber}";
        Storage::put($chunkPath, file_get_contents($request->file('file')));

        // Check if all chunks are uploaded
        $totalChunks = $request->resumableTotalChunks;
        $allUploaded = true;

        for ($i = 1; $i <= $totalChunks; $i++) {
            if (!Storage::exists("chunks/{$fileName}.part{$i}")) {
                $allUploaded = false;
                break;
            }
        }

        // Merge chunks into final file
        if ($allUploaded) {
            $finalPath = "uploads/" . uniqid() . '_' . $fileName;
            $final = fopen(storage_path("app/" . $finalPath), "w");

            for ($i = 1; $i <= $totalChunks; $i++) {
                $chunk = Storage::get("chunks/{$fileName}.part{$i}");
                fwrite($final, $chunk);
                Storage::delete("chunks/{$fileName}.part{$i}");
            }
            fclose($final);

            return [
                'success' => true,
                'path' => $finalPath
            ];
        }

        return [
            'chunkReceived' => $chunkNumber
        ];
    }
}
