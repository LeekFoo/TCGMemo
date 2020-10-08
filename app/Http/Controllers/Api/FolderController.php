<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Folder;

class FolderController extends Controller
{
    public function index()
    {
        $folders = Folder::all();

        return $folders;
    }

    public function show($id) {
        $folder = Folder::with('cards')
                    ->where('id', $id)
                    ->first();

        return $folder;
    }

    /**
     * 新規追加
     */
    public function store(Request $request) {
        $folder = new Folder;
        $folder->user_id = 1;
        $folder->name = $request->input('name','');

        $folder->save();

        return $folder;
    }

    /**
     * 削除
     */
    public function destroy($id) {
        $folder = Folder::find($id);
        $folder->delete();

        $folders = Folder::all();

        return $folders;
    }
}
