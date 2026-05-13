<?php

namespace Database\Seeders;

use App\Models\Credential;
use Illuminate\Database\Seeder;

class CredentialSeeder extends Seeder
{
    public function run(): void
    {
        $json = '{
            "success": true,
            "data": [
                {"id": 14, "user_id": 1, "category": "personal", "service_name": "OSS", "url": "https://ui-login.oss.go.id/login", "username": "livasya62222552024g", "password": "@LIvasya060604", "notes": "OSS KOPERASI LIVASYA", "is_favorite": 0},
                {"id": 13, "user_id": 1, "category": "personal", "service_name": "Google", "url": "http://accounts.google.com/", "username": "lia.vallini007@gmail.com", "password": "Livasya123", "notes": "MPP IBU LIA", "is_favorite": 0},
                {"id": 12, "user_id": 1, "category": "personal", "service_name": "Satu Sehat", "url": "https://satusehat.kemkes.go.id/sdmk/login", "username": "syapeisudjono@gmail.com", "password": "Livasya01", "notes": "SATU SEHAT DR.IING", "is_favorite": 0},
                {"id": 11, "user_id": 1, "category": "personal", "service_name": "Satu Sehat", "url": "https://satusehat.kemkes.go.id/sdmk/login", "username": "lia.vallini007@gmail.com", "password": "Mentari01", "notes": "SATU SEHAT IBU LIA", "is_favorite": 0},
                {"id": 10, "user_id": 1, "category": "personal", "service_name": "EDLINK", "url": "https://edlink.id/login", "username": "liavallini2@gmail.com", "password": "Vallini1", "notes": "AKUN EDLINK IBU", "is_favorite": 0},
                {"id": 9, "user_id": 1, "category": "personal", "service_name": "Google", "url": "https://accounts.google.com/", "username": "livasya@gmail.com", "password": "Livasyapt123", "notes": "PUPR", "is_favorite": 0},
                {"id": 8, "user_id": 1, "category": "personal", "service_name": "OSS", "url": "https://ui-login.oss.go.id/login", "username": "082127869727", "password": "Yosvilisandi123@", "notes": "OSS APOTEK", "is_favorite": 0},
                {"id": 7, "user_id": 1, "category": "personal", "service_name": "OSS", "url": "https://ui-login.oss.go.id/login", "username": "ptlivasya@gmail.com", "password": "Ptlivasya123@", "notes": "OSS RS LIVASYA", "is_favorite": 0},
                {"id": 6, "user_id": 1, "category": "personal", "service_name": "Google", "url": "https://accounts.google.com/", "username": "livasyapt@gmail.com", "password": "livasya123", "notes": "PAJAK", "is_favorite": 0},
                {"id": 5, "user_id": 1, "category": "personal", "service_name": "Google", "url": "https://accounts.google.com/", "username": "rsialivasya114@gmail.com", "password": "rsialivasya114", "notes": "TIM ASURANSI", "is_favorite": 0},
                {"id": 4, "user_id": 1, "category": "personal", "service_name": "Google", "url": "https://accounts.google.com/?hl=id", "username": "livasya114@gmail.com", "password": "livasyakdptnbaru2021", "notes": "BIG FAMILY", "is_favorite": 0},
                {"id": 3, "user_id": 1, "category": "personal", "service_name": "SIAp", "url": "https://apoteker.or.id/", "username": "07121973023017", "password": "Liavallini07", "notes": "AKUN SIAP APOTEKER IBU LIA", "is_favorite": 0},
                {"id": 2, "user_id": 1, "category": "personal", "service_name": "Google", "url": "https://accounts.google.com/", "username": "lia.vallini007@gmail.com", "password": "Mentari001", "notes": "GOOGLE DRIVE IBU LIA", "is_favorite": 0}
            ]
        }';

        $decoded = json_decode($json, true);

        foreach ($decoded['data'] as $item) {
            // Menggunakan withoutEvents() agar logic 'booted' (auth()->id()) diabaikan saat seeding
            Credential::withoutEvents(function () use ($item) {
                Credential::create([
                    'user_id'      => $item['user_id'],
                    'category'     => $item['category'],
                    'service_name' => $item['service_name'],
                    'url'          => $item['url'],
                    'username'     => $item['username'],
                    'password'     => $item['password'], // Akan otomatis terenkripsi karena 'casts' di model
                    'notes'        => $item['notes'],    // Akan otomatis terenkripsi karena 'casts' di model
                    'is_favorite'  => $item['is_favorite'],
                ]);
            });
        }
    }
}
