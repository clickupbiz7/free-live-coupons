<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Store;
use App\Models\Blog;
use App\Models\Setting;

class HomeController extends Controller
{
    // ================= HOME =================
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->take(8)->get();

        $categories = Category::orderBy('id', 'DESC')->take(20)->get();
        $stores     = Store::orderBy('id', 'DESC')->take(20)->get();
        $blogs      = Blog::orderBy('id', 'DESC')->take(4)->get();

        return view('frontend.home', compact(
            'coupons',
            'categories',
            'stores',
            'blogs'
        ));
    }

    // ================= ALL COUPONS =================
    public function allCoupons(Request $request)
    {
        $query = Coupon::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->store) {
            $query->where('store_id', $request->store);
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->alpha) {
            $query->where('title', 'like', $request->alpha . '%');
        }

        $coupons = $query->orderBy('id', 'DESC')->paginate(12);

        $stores = Store::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('frontend.coupons', compact(
            'coupons',
            'stores',
            'categories'
        ));
    }

    // ================= STORE DETAIL =================
    public function store(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->firstOrFail();

        $query = Coupon::where('store_id', $store->id);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->alpha) {
            $query->where('title', 'like', $request->alpha . '%');
        }

        $coupons = $query->orderBy('id', 'DESC')->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('frontend.store', compact(
            'store',
            'coupons',
            'categories'
        ));
    }

    // ================= CATEGORY DETAIL =================
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = Coupon::where('category_id', $category->id);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->store) {
            $query->where('store_id', $request->store);
        }

        if ($request->alpha) {
            $query->where('title', 'like', $request->alpha . '%');
        }

        $coupons = $query->orderBy('id', 'DESC')->paginate(12);
        $stores = Store::orderBy('name')->get();

        return view('frontend.category', compact(
            'category',
            'coupons',
            'stores'
        ));
    }

    // ================= ALL STORES =================
    public function allStores(Request $request)
    {
        $query = Store::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->alpha) {
            $query->where('name', 'like', $request->alpha . '%');
        }

        $stores = $query->orderBy('id', 'DESC')->paginate(12);

        return view('frontend.stores', compact('stores'));
    }

    // ================= ALL CATEGORIES =================
    public function allCategories(Request $request)
    {
        $query = Category::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->alpha) {
            $query->where('name', 'like', $request->alpha . '%');
        }

        $categories = $query->orderBy('id', 'DESC')->paginate(12);

        return view('frontend.categories', compact('categories'));
    }

    // ================= ALL BLOGS =================
    public function allBlogs(Request $request)
    {
        $query = Blog::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->orderBy('id', 'DESC')->paginate(9);

        return view('frontend.blogs', compact('blogs'));
    }

    // ================= SINGLE BLOG =================
    public function singleBlog($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();

        return view('frontend.blog-single', compact(
            'blog',
            'relatedBlogs'
        ));
    }

    // ================= ABOUT =================
    public function about()
    {
        $content = Setting::get('about_us');
        return view('frontend.about', compact('content'));
    }

    // ================= CONTACT =================
    public function contact()
    {
        $content = Setting::get('contact_us');
        return view('frontend.contact', compact('content'));
    }

    // ================= PRIVACY POLICY =================
    public function privacy()
    {
        $content = Setting::get('privacy_policy');
        return view('frontend.privacy', compact('content'));
    }

    // ================= TERMS =================
    public function terms()
    {
        $content = Setting::get('terms_condition');
        return view('frontend.terms', compact('content'));
    }

    // ================= FAQ =================
    public function faq()
    {
        $content = Setting::get('faq');
        return view('frontend.faq', compact('content'));
    }
}