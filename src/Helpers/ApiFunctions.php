<?php

use Inertia\Inertia;

if (!function_exists('renderDashboard')) {
    function renderDashboard() {
        return Inertia::render('Dashboard');
    }
}

// Define otras funciones aquí
