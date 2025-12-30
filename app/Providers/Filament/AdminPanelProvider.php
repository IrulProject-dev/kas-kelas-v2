<?php

namespace App\Providers\Filament;

use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->defaultThemeMode(ThemeMode::Dark)
            ->brandLogo(asset('images/kelas-logo.png'))
            ->brandLogoHeight('3rem')
            ->brandName('Kas Kelas TRPLA125')
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->renderHook(
            'panels::head.end',
            fn (): string => new HtmlString('
                <style>
                    /* --- CSS BACKGROUND & GLASSMORPHISM (Biarkan yang lama) --- */
                    body, .fi-body {
                        background-color: #030014 !important;
                        background-image:
                            radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%),
                            radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%),
                            radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%) !important;
                        background-attachment: fixed !important;
                        background-size: cover !important;
                    }

                    /* ... (kode glassmorphism yang lama biarkan saja) ... */
                    .fi-section, .fi-wi-stats-overview-stat, .fi-ta-ctn, .fi-widget {
                        background-color: rgba(255, 255, 255, 0.03) !important;
                        backdrop-filter: blur(10px) !important;
                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1) !important;
                    }
                    /* ... */

                    /* --- BAGIAN INI YANG DI-UPDATE UNTUK MENGHILANGKAN TOMBOL --- */

                    /* 1. Hilangkan Container Switcher (Kotak pilihan tema) di SEMUA tempat */
                    .fi-theme-switcher,             /* Class umum container switcher */
                    .fi-dropdown .fi-theme-switcher /* Target spesifik di dalam dropdown */
                    {
                        display: none !important;
                    }

                    /* 2. Hilangkan Tombol di Topbar (Jaga-jaga jika ada sisa) */
                    .fi-topbar-item-theme-switcher,
                    button[aria-label="Switch to light mode"],
                    button[aria-label="Switch to dark mode"],
                    button[aria-label="Switch to system theme"] {
                        display: none !important;
                    }
                </style>
                '),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->assets([
                Css::make('custom-stylesheet', asset('css/filament-custom.css')),
            ]);
    }
}
