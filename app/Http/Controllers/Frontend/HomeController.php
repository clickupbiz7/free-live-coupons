<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Store;
use App\Models\Blog;
use App\Models\Ad;
use App\Models\Setting;
use App\Models\ContactMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // ================= HOME =================
    public function index()
    {
        $coupons = Coupon::where('status', 1)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhereDate('expiry_date', '>=', now()->toDateString());
            })
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::latest()->take(20)->get();

        $stores = Store::where('status', 1)
            ->latest()
            ->take(20)
            ->get();

        $blogs = Blog::where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        $homeTopAd = Ad::active()->where('placement', 'home_top')->first();
        $homeMiddleAd = Ad::active()->where('placement', 'home_middle')->first();
        $homeBottomAd = Ad::active()->where('placement', 'home_bottom')->first();

        return view('frontend.home', compact(
            'coupons',
            'categories',
            'stores',
            'blogs',
            'homeTopAd',
            'homeMiddleAd',
            'homeBottomAd'
        ));
    }

    // ================= ALL BLOGS =================
    public function allBlogs(Request $request)
    {
        $featuredPost = Blog::where('status', 1)
            ->latest()
            ->first();

        $blogs = Blog::where('status', 1);

        if ($request->search) {
            $blogs->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $blogs->where('category_id', $request->category);
        }

        if ($featuredPost) {
            $blogs->where('id', '!=', $featuredPost->id);
        }

        $blogs = $blogs->latest()->paginate(9);

        $latestPosts = Blog::where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        $categories = collect();

        if (Schema::hasTable('blog_categories')) {

            $categories = DB::table('blog_categories')
                ->leftJoin(
                    'blogs',
                    'blog_categories.id',
                    '=',
                    'blogs.category_id'
                )
                ->select(
                    'blog_categories.id',
                    'blog_categories.name',
                    DB::raw('COUNT(blogs.id) as blogs_count')
                )
                ->groupBy(
                    'blog_categories.id',
                    'blog_categories.name'
                )
                ->orderBy('blog_categories.name')
                ->get();
        }

        $blogTopAd = Ad::active()
            ->where('placement', 'blogs_top')
            ->first();

        $blogMiddleAd = Ad::active()
            ->where('placement', 'blogs_middle')
            ->first();

        return view('frontend.blogs', compact(
            'featuredPost',
            'blogs',
            'latestPosts',
            'categories',
            'blogTopAd',
            'blogMiddleAd'
        ));
    }

    // ================= SINGLE BLOG =================

public function singleBlog($slug)
{
    $blog = Blog::where('slug', $slug)->firstOrFail();

    $relatedBlogs = Blog::where('status', 1)
        ->where('id', '!=', $blog->id)
        ->where('category_id', $blog->category_id)
        ->latest()
        ->take(3)
        ->get();

    $latestPosts = Blog::where('status', 1)
        ->latest()
        ->take(5)
        ->get();

    $categories = collect();

    if (Schema::hasTable('blog_categories')) {

        $categories = DB::table('blog_categories')
            ->leftJoin(
                'blogs',
                'blog_categories.id',
                '=',
                'blogs.category_id'
            )
            ->select(
                'blog_categories.id',
                'blog_categories.name',
                DB::raw('COUNT(blogs.id) as blogs_count')
            )
            ->groupBy(
                'blog_categories.id',
                'blog_categories.name'
            )
            ->orderBy('blog_categories.name')
            ->get();
    }

    $singleBlogTopAd = Ad::active()
        ->where('placement', 'single_blog_top')
        ->first();

    $singleBlogMiddleAd = Ad::active()
        ->where('placement', 'single_blog_middle')
        ->first();

    $blogSidebarAd = Ad::active()
        ->where('placement', 'blog_sidebar')
        ->first();

    AdminNotification::create([
        'title'   => 'Blog Viewed',
        'message' => $blog->title . ' was opened by a visitor',
        'type'    => 'blog',
        'url'     => route('admin.blogs.index'),
        'is_read' => 0
    ]);

    return view('frontend.blog-single', compact(
        'blog',
        'relatedBlogs',
        'latestPosts',
        'categories',
        'singleBlogTopAd',
        'singleBlogMiddleAd',
        'blogSidebarAd'
    ));
}

// ================= blogCategory =================

public function blogCategory($category)
{
    $blogs = Blog::where('status',1)
        ->where('category_id',$category)
        ->latest()
        ->paginate(9);

    $latestPosts = Blog::where('status',1)
        ->latest()
        ->take(5)
        ->get();

    $categories = DB::table('blog_categories')
        ->leftJoin(
            'blogs',
            'blog_categories.id',
            '=',
            'blogs.category_id'
        )
        ->select(
            'blog_categories.id',
            'blog_categories.name',
            DB::raw('COUNT(blogs.id) as blogs_count')
        )
        ->groupBy(
            'blog_categories.id',
            'blog_categories.name'
        )
        ->orderBy('blog_categories.name')
        ->get();

    return view('frontend.blogs', compact(
        'blogs',
        'latestPosts',
        'categories'
    ));
}

    // ================= ALL COUPONS =================
    public function allCoupons(Request $request)
    {
        $query = Coupon::where('status', 1)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhereDate('expiry_date', '>=', now()->toDateString());
            });

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $coupons = $query->latest()->paginate(12);

        $stores = Store::where('status', 1)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('frontend.coupons', compact(
            'coupons',
            'stores',
            'categories'
        ));
    }

    // ================= STORES =================
    public function allStores(Request $request)
    {
        $query = Store::where('status', 1);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stores = $query->latest()->paginate(12);

        return view('frontend.stores', compact('stores'));
    }

    // ================= CATEGORIES =================
    public function allCategories(Request $request)
    {
        $query = Category::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(12);

        return view('frontend.categories', compact('categories'));
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

    // ================= CONTACT SEND =================
    public function contactSend(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        AdminNotification::create([
            'title'   => 'New Contact Message',
            'message' => $request->name . ' sent a message',
            'type'    => 'message',
            'url'     => route('admin.contact.messages'),
            'is_read' => 0
        ]);

        return back()->with('success', 'Message Sent Successfully');
    }

    // ================= PRIVACY =================
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
