<?php

namespace App\Http\Controllers;

use App\Models\GoodsComments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response;

class GoodsCommentsController extends Controller
{
    /**
     * Просмотр комментариев
     */
    public function index(): Response
    {
        //return response('Привет! Вам стоит зарегистрироваться:)');
         return Inertia::render('Comments/Index', [
            'comments' => GoodsComments::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Добавление комментария
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->comments()->create($validated);
 
        return redirect(route('comments.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(GoodsComments $goodsComments): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodsComments $goodsComments): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoodsComments $goodsComments): RedirectResponse
    {
        $this->authorize('update', $goodsComments);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $goodsComments->update($validated);
 
        return redirect(route('comments.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodsComments $goodsComments): RedirectResponse
    {
        $this->authorize('delete', $goodsComments);
        
        $goodsComments->delete();
 
        return redirect(route('comments.index'));
    }
}
