<?php

namespace App\Services;

use App\Enums\LeadStatus;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LeadConversionService
{
    /**
     * Convert a Lead into a Client, create a User account, and link them.
     */
    public function convert(Lead $lead, array $validatedData): Client
    {
        return DB::transaction(function () use ($lead, $validatedData) {
            // Generate a random password for the new client user
            $password = Str::random(12);

            $role = Role::where('name', 'client')->first();

            // Create the User account
            $user = User::create([
                'name' => $validatedData['contact_person'],
                'email' => $validatedData['email'],
                'password' => Hash::make($password),
                'role_id' => $role ? $role->id : null,
                'is_active' => true,
            ]);

            if ($role) {
                $user->assignRole($role);
            }

            // fire an event or job to send the email with the $password here.

            // Create the Client profile linked to the User
            $client = Client::create([
                'user_id' => $user->id,
                'company_name' => $validatedData['company_name'],
                'contact_person' => $validatedData['contact_person'],
                'website' => $validatedData['website'],
                'phone' => $validatedData['phone'],
                'is_active' => true,
            ]);

            // Update the Lead to point to the new Client
            $lead->update([
                'client_id' => $client->id,
                'status' => LeadStatus::Converted,
            ]);

            return $client;
        });
    }
}
