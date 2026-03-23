<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Contracts\View\View;

class InquiryController extends Controller
{
    public function indexContact(): View
    {
        $query = Inquiry::contact();
        
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        if (request()->filled('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }
        
        if (request()->filled('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }
        
        $inquiries = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        return view('admin.lien-he.index', compact('inquiries'));
    }

    public function indexRequest(): View
    {
        $query = Inquiry::request();
        
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        if (request()->filled('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }
        
        if (request()->filled('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }
        
        $inquiries = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        return view('admin.noi-dung-yeu-cau.index', compact('inquiries'));
    }
}
