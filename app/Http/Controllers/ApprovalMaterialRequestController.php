<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApprovalMaterialRequestController extends Controller
{
    /**
     * Menampilkan daftar Material Request yang menunggu approval.
     */
    public function index(): View
    {
        $requests = MaterialRequest::with([
                'proyek',
                'user',
                'details.barang'
            ])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view(
            'approval.index',
            compact('requests')
        );
    }

    /**
     * Approve Material Request
     */
    public function approve(int $id): RedirectResponse
    {
        $materialRequest = MaterialRequest::findOrFail($id);

        if ($materialRequest->status !== 'pending') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Material Request sudah diproses.'
                );
        }

        $materialRequest->update([
            'status'       => 'approved',
            'approved_by'  => Auth::id(),
            'approved_at'  => now(),
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Material Request berhasil disetujui.'
            );
    }

    /**
     * Reject Material Request
     */
    public function reject(int $id): RedirectResponse
    {
        $materialRequest = MaterialRequest::findOrFail($id);

        if ($materialRequest->status !== 'pending') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Material Request sudah diproses.'
                );
        }

        $materialRequest->update([
            'status'       => 'rejected',
            'approved_by'  => Auth::id(),
            'approved_at'  => now(),
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Material Request berhasil ditolak.'
            );
    }

    /**
     * Detail Material Request
     */
   public function show(int $id)
{
    $materialRequest = MaterialRequest::with([
        'user',
        'details.barang'
    ])->findOrFail($id);

    return view(
        'approval.show',
        compact('materialRequest')
    );
}
}