<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public static function getCard($folderCd = null, $userId = null) {
        $cards = DB::table('cards')
                ->select(
                    'cards.id AS id',
                    'folders.name AS folder_name',
                    'titles.title AS title',
                    'title_cd',
                    'card_no AS card_no',
                    'symbols.name AS symbol',
                    'cards.symbol_cd AS symbol_cd',
                    'rarities.name AS rarity',
                    'cards.rarity_cd AS rarity_cd',
                    'symbols.color_code AS symbol_color',
                    'cards.name AS name', 'amount'
                )
                ->leftJoin('titles','cards.title_cd','=','titles.id')
                ->leftJoin('symbols','cards.symbol_cd','=','symbols.id')
                ->leftJoin('rarities','cards.rarity_cd','=','rarities.id')
                ->leftJoin('folders','cards.folder_id', '=','folders.id')
                ->whereNull ('cards.deleted_at');

        if($folderCd) {
            $cards->where('folder_cd', '=', $folderCd);
        }

        if($userId) {
            $cards->where('user_id', '=', $userId);
        }

        return $cards->get();
    }
}
