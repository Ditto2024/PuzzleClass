<?php

namespace App\Http\Controllers;

use App\Models\ShopItem;
use Illuminate\Http\RedirectResponse;

class ShopController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');
        $items = ShopItem::orderBy('price')->get();

        return view('shop.index', compact('user', 'items'));
    }

    public function buy(ShopItem $item): RedirectResponse
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;

        if (! $profile || $profile->coins < $item->price) {
            return back()->with('error', 'Coins tidak cukup.');
        }

        $profile->coins -= $item->price;

        if ($item->type === 'hint') {
            $profile->hints += $item->value;
        }

        $profile->save();

        return back()->with('success', $item->name . ' berhasil dibeli.');
    }
}