<?php

namespace MtSettings\LaravelSettings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use MtSettings\LaravelSettings\Models\Setting;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('laravel-settings::settings.index');
    }
    
    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $section = $request->input('section');
        
        // Validate based on section
        switch ($section) {
            case 'general':
                $validator = Validator::make($request->all(), [
                    'site_name' => 'required|string|max:255',
                    'items_per_page' => 'required|integer|min:5|max:100',
                    'maintenance_mode' => 'nullable',
                ]);
                break;
                
            case 'seo':
                $validator = Validator::make($request->all(), [
                    'meta_title' => 'nullable|string|max:255',
                    'meta_description' => 'nullable|string|max:500',
                    'meta_keywords' => 'nullable|string|max:500',
                ]);
                break;
                
            case 'contact':
                $validator = Validator::make($request->all(), [
                    'contact_email' => 'required|email|max:255',
                    'phone_number' => 'nullable|string|max:20',
                    'address' => 'nullable|string|max:500',
                ]);
                break;
                
            case 'social':
                $validator = Validator::make($request->all(), [
                    'facebook_url' => 'nullable|url|max:255',
                    'twitter_url' => 'nullable|url|max:255',
                    'instagram_url' => 'nullable|url|max:255',
                    'linkedin_url' => 'nullable|url|max:255',
                ]);
                break;
                
            case 'advanced':
                $validator = Validator::make($request->all(), [
                    'cache_enabled' => 'nullable',
                    'cache_expiration' => 'nullable|integer|min:300',
                    'google_analytics_id' => 'nullable|string|max:50',
                    'custom_header_scripts' => 'nullable|string',
                ]);
                break;
                
            default:
                return redirect()->back()->with('error', config('settings.messages.unknown_section', 'Unknown section.'));
        }
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Save settings
        $fields = $validator->validated();
        unset($fields['section']); // Remove the section field
        
        foreach ($fields as $key => $value) {
            // Handle checkboxes that may not be in the request
            if (in_array($key, ['maintenance_mode', 'cache_enabled']) && !isset($fields[$key])) {
                $value = false;
            }
            
            Setting::set($key, $value);
        }
        
        // Clear settings cache
        Setting::clearCache();
        
        return redirect()->back()->with('success', config('settings.messages.settings_updated', 'Settings updated successfully.'));
    }
    
    /**
     * Clear the settings cache.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        Setting::clearCache();
        
        return redirect()->back()->with('success', config('settings.messages.cache_cleared', 'Settings cache cleared successfully.'));
    }
}