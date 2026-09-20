<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the agency and system settings page.
     */
    public function index(): View
    {
        Gate::authorize('view-settings');

        $currencies = \App\Models\Currency::where('is_active', true)->get();

        return view('admin.pages.settings')->with([
            'currencies' => $currencies
        ]);
    }

    /**
     * Update the agency settings.
     */
    public function update(Request $request): RedirectResponse
    {
        Gate::authorize('edit-settings');

        $data = $request->except(['_token', '_method']);

        // Handle Default Currency Update
        if (isset($data['default_currency_id'])) {
            $currencyId = $data['default_currency_id'];
            
            // Set all to non-default
            \App\Models\Currency::query()->update(['is_default' => false]);
            
            // Set the selected one as default
            \App\Models\Currency::where('id', $currencyId)->update(['is_default' => true]);
            
            // Remove from $data so it doesn't get saved in the settings table
            unset($data['default_currency_id']);
        }

        // Handle file uploads (e.g. seo_og_image)
        if ($request->hasFile('seo_og_image')) {
            $oldImage = setting('seo_og_image');
            
            if ($oldImage) {
                $oldImagePath = str_replace('/storage/', '', $oldImage);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $path = $request->file('seo_og_image')->store('settings', 'public');
            $data['seo_og_image'] = '/storage/' . $path;
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Clear the settings cache if we are using it
        Cache::forget('global_settings');

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
