<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('components.status-badge');
    }

    public function badgeClass()
    {
        return $this->status === 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }
}
