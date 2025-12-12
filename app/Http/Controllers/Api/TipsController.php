<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TipsController extends Controller
{
    /**
     * Get all tips
     */
    public function index()
    {
        $tips = [
            [
                'id' => 1,
                'title' => 'Tips Menghemat Energi Listrik',
                'content' => 'Matikan perangkat elektronik yang tidak digunakan untuk mengurangi konsumsi listrik',
                'category' => 'energy',
                'difficulty' => 'easy',
                'impact' => 'Hemat hingga 20% biaya listrik',
            ],
            [
                'id' => 2,
                'title' => 'Mengurangi Plastik Sekali Pakai',
                'content' => 'Gunakan tas belanja yang dapat digunakan kembali dan hindari produk plastik sekali pakai',
                'category' => 'waste',
                'difficulty' => 'easy',
                'impact' => 'Kurangi limbah plastik hingga 50kg per tahun',
            ],
            [
                'id' => 3,
                'title' => 'Memulai Kompos di Rumah',
                'content' => 'Pisahkan limbah organik dan buat kompos untuk tanaman Anda',
                'category' => 'waste',
                'difficulty' => 'medium',
                'impact' => 'Kurangi limbah organik dan dapatkan pupuk gratis',
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $tips,
            'total' => count($tips),
        ]);
    }

    /**
     * Get single tip
     */
    public function show($id)
    {
        $tips = [
            1 => [
                'id' => 1,
                'title' => 'Tips Menghemat Energi Listrik',
                'content' => 'Matikan perangkat elektronik yang tidak digunakan untuk mengurangi konsumsi listrik',
                'detailed_tips' => [
                    'Matikan lampu saat meninggalkan ruangan',
                    'Gunakan lampu LED yang lebih efisien',
                    'Atur suhu AC ke 24-25 derajat Celsius',
                    'Matikan charger saat tidak digunakan',
                ],
                'category' => 'energy',
                'difficulty' => 'easy',
                'impact' => 'Hemat hingga 20% biaya listrik',
            ],
            2 => [
                'id' => 2,
                'title' => 'Mengurangi Plastik Sekali Pakai',
                'content' => 'Gunakan tas belanja yang dapat digunakan kembali dan hindari produk plastik sekali pakai',
                'detailed_tips' => [
                    'Bawa tas belanja sendiri saat berbelanja',
                    'Gunakan sedotan stainless steel',
                    'Pilih kemasan yang dapat didaur ulang',
                    'Hindari botol plastik, gunakan botol isi ulang',
                ],
                'category' => 'waste',
                'difficulty' => 'easy',
                'impact' => 'Kurangi limbah plastik hingga 50kg per tahun',
            ],
        ];

        if (!isset($tips[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Tip not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tips[$id],
        ]);
    }
}
