<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Clegginabox\PDFMerger\PDFMerger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required',
            'cv' => 'required|mimes:pdf'
        ]);

        // Simpan file foto dan CV ke storage sementara
        $photoPath = $request->file('photo')->store('public/photos');
        $cvPath = $request->file('cv')->store('public/cvs');

        // Ambil path asli untuk file PDF dengan Storage::url agar sesuai dengan sistem operasi
        $photoUrl = Storage::path($photoPath);
        $cvUrl = Storage::path($cvPath);

        // Cek apakah file CV ada
        if (!file_exists($cvUrl)) {
            return response()->json(['error' => 'File CV tidak ditemukan di ' . $cvUrl], 404);
        }

        // Buat halaman pertama dengan nama dan foto menggunakan DomPDF
        $pdf = Pdf::loadView('pdf_template', [
            'name' => $request->name,
            'photoUrl' => $photoUrl
        ]);
        $pdf->setPaper('a4');

        // Simpan halaman pertama ke file PDF sementara
        $firstPagePath = storage_path('app/public/temp_first_page.pdf');
        $pdf->save($firstPagePath);

        // Gabungkan halaman pertama dengan CV yang sudah diupload
        $finalPdf = new PDFMerger();
        $finalPdf->addPDF($firstPagePath, 'all');
        $finalPdf->addPDF($cvUrl, 'all');

        // Simpan file PDF hasil gabungan
        $outputPath = storage_path('app/public/combined.pdf');
        $finalPdf->merge('file', $outputPath);

        // Hapus file sementara setelah penggabungan
        unlink($firstPagePath);

        // Kembalikan PDF hasil gabungan sebagai response download
        return response()->download($outputPath);
    }
}
