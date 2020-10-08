<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Card;

class CardController extends Controller
{
    /**
     * 全件取得
     */
    public function index()
    {
        $cards = Card::getCard();

        return $cards;
    }

    /**
     * 新規追加
     */
    public function store(Request $request) {
        $card = new Card;
        $card->folder_id = $request->input('folder_id', 0);
        $card->title_cd = $request->input('title_cd', null);
        $card->card_no = $request->input('card_no', null);
        $card->symbol_cd = $request->input('symbol_cd', null);
        $card->rarity_cd = $request->input('rarity_cd', null);
        $card->name = $request->input('name','');
        $card->get_flg = $request->input('get_flg', false);

        $amount = $request->input('amount', 0);
        $card->amount = $amount ? $amount : 0;

        $card->save();

        return $card;
    }

    /**
     * 更新
     */
    public function update(Request $request) {
        $card = Card::find($request->input('id'));

        if(empty($card)) {
            return;
        }

        $card->id = $request->input('id', 0);
        $card->folder_id = $request->input('folderId', 0);
        $card->title_cd = $request->input('titleCd', null);
        $card->card_no = $request->input('cardNo', null);
        $card->symbol_cd = $request->input('symbolCd', null);
        $card->rarity_cd = $request->input('rarityCd', null);
        $card->name = $request->input('name','');
        $card->get_flg = $request->input('getFlg', false);

        $amount = $request->input('amount', 0);
        $card->amount = $amount ? $amount : 0;

        $card->save();

        return $card->id;
    }

    /**
     * 削除
     */
    public function destroy($id) {
        $card = Card::find($id);
        $card->delete();

        $cards = Card::getCard();

        return $cards;
    }
}
