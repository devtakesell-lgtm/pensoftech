<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the agency and system settings page.
     */
    public function index(): View
    {
        Gate::authorize('view-settings');

        $currencies = Currency::where('is_active', true)->get();

        return view('admin.pages.settings')->with([
            'currencies' => $currencies,
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
            Currency::query()->update(['is_default' => false]);

            // Set the selected one as default
            Currency::where('id', $currencyId)->update(['is_default' => true]);

            // Remove from $data so it doesn't get saved in the settings table
            unset($data['default_currency_id']);
        }

        // Handle file uploads (e.g. seo_og_image, company_logo)
        $fileUploads = ['seo_og_image', 'company_logo'];

        foreach ($fileUploads as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $oldImage = setting($fileKey);

                if ($oldImage) {
                    $oldImagePath = str_replace('/storage/', '', $oldImage);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }

                $path = $request->file($fileKey)->store('settings', 'public');
                $data[$fileKey] = '/storage/'.$path;
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Clear the settings cache if we are using it
        Cache::forget('global_settings');

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
