<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Faq;
use App\Models\Ingredient;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Services\SeoService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $processSteps = ProcessStep::where('status', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('status', true)->orderBy('sort_order')->get();
        $seo = SeoService::getMeta('about-us');

        return view('pages.about', compact('processSteps', 'testimonials', 'seo'));
    }

    public function agentLocator()
    {
        $agents = Agent::where('status', true)->orderBy('sort_order')->get();
        $totalAgents = $agents->sum('agent_count');
        $rwandaAgents = $agents->where('market', 'rwanda')->sum('agent_count');
        $regionalAgents = $agents->where('market', 'regional')->sum('agent_count');

        $seo = SeoService::getMeta('agent-locator');

        return view('pages.agent-locator', compact('agents', 'totalAgents', 'rwandaAgents', 'regionalAgents', 'seo'));
    }

    public function agentPortal()
    {
        $seo = SeoService::getMeta('agent-portal');
        return view('pages.agent-portal', compact('seo'));
    }

    public function faq()
    {
        $faqs = Faq::where('status', true)->orderBy('sort_order')->get();
        $categories = $faqs->pluck('category')->unique();
        $seo = SeoService::getMeta('faq');
        $faqSchema = SeoService::generateFaqSchema($faqs);

        return view('pages.faq', compact('faqs', 'categories', 'seo', 'faqSchema'));
    }

    public function gallery()
    {
        $seo = SeoService::getMeta('gallery');
        return view('pages.gallery', compact('seo'));
    }

    public function policy($type)
    {
        $validPolicies = [
            'privacy-policy' => ['title' => 'Privacy Policy', 'key' => 'policy_privacy'],
            'terms-and-conditions' => ['title' => 'Terms & Conditions', 'key' => 'policy_terms'],
            'return-policy' => ['title' => 'Return Policy', 'key' => 'policy_returns'],
            'shipping-policy' => ['title' => 'Shipping Policy', 'key' => 'policy_shipping'],
        ];

        if (!array_key_exists($type, $validPolicies)) {
            abort(404);
        }

        $policyInfo = $validPolicies[$type];
        $title = $policyInfo['title'];
        $content = Setting::get($policyInfo['key'], $this->getDefaultPolicyContent($type));
        $seo = SeoService::getMeta($type);

        return view('pages.policies.show', compact('type', 'title', 'content', 'seo'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q', '');

        $products = Product::where('status', 'published')
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('short_description', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })->get();

        $seo = SeoService::getMeta('search');

        return view('pages.search', compact('q', 'products', 'seo'));
    }

    private function getDefaultPolicyContent($type)
    {
        $siteName = Setting::get('site_name', 'Aura Soaps');
        $email = Setting::get('contact_email', 'hello@aurasoaps.com');
        $phone = Setting::get('contact_phone', '+1 (800) 555-2872');

        switch ($type) {
            case 'privacy-policy':
                return '
                <h3 class="fw-bold mb-3">1. Information We Collect</h3>
                <p class="mb-4">At <strong>' . e($siteName) . '</strong>, we respect your privacy and process personal information necessary to deliver products, process wholesale applications, and improve your browsing experience.</p>

                <h3 class="fw-bold mb-3">2. How We Use Data</h3>
                <p class="mb-4">Collected information is strictly used for order fulfillment, distributor inquiry responses, and sending opt-in newsletter updates.</p>

                <h3 class="fw-bold mb-3">3. Data Protection & Security</h3>
                <p class="mb-4">We implement industry-standard encryption protocols and never sell, rent, or lease customer data to third-party advertisers.</p>';

            case 'terms-and-conditions':
                return '
                <h3 class="fw-bold mb-3">1. Terms of Service</h3>
                <p class="mb-4">By accessing <strong>' . e($siteName) . '</strong>, you agree to bound by these terms, all applicable laws and regulations.</p>';

            case 'return-policy':
                return '
                <h3 class="fw-bold mb-3">Satisfaction Guarantee & Returns</h3>
                <p class="mb-4">Unopened items in original packaging may be returned within 14 days of delivery for store credit or replacement.</p>';

            case 'shipping-policy':
                return '
                <h3 class="fw-bold mb-3">Dispatch & Delivery Times</h3>
                <p class="mb-4">Orders are processed and dispatched within 24 to 48 business hours via carbon-neutral carriers.</p>';
        }

        return '';
    }
}
