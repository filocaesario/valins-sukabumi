<?php

namespace App\Http\Controllers;

use App\Models\NavbarTab;
use Illuminate\Http\Request;

class NavbarTabController extends Controller
{
    public function update(Request $request, $id)
    {
        $tab = NavbarTab::findOrFail($id);

        $request->validate([
            'nama_tab'  => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $tab->update([
            'nama_tab'  => $request->nama_tab,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', "Penamaan menu '{$request->nama_tab}' berhasil diperbarui!");
    }
}