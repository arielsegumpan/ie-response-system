<?php

use App\Livewire\Pages\Blog;
use App\Livewire\Pages\About;
use App\Livewire\Pages\BlogShow;
use App\Livewire\Pages\Isugid;
use App\Livewire\Pages\Contact;
use App\Livewire\Pages\IndexPage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', IndexPage::class)->name('page.home');
Route::get('/isugid', Isugid::class)->name('page.isugid');
Route::get('/blog', Blog::class)->name('page.blog');
Route::get('/blog/{slug}', BlogShow::class)->name('page.blog.show');
Route::get('/about', About::class)->name('page.about');
Route::get('/contact', Contact::class)->name('page.contact');
