<?php

namespace App\Services;

use App\Models\DomainMonitor;
use Illuminate\Database\Eloquent\Collection;

class DomainMonitorService
{
    public function getAll(): Collection
    {
        return DomainMonitor::with('server')->latest()->get();
    }

    public function create(array $data): DomainMonitor
    {
        return DomainMonitor::create($data);
    }

    public function update(DomainMonitor $domainMonitor, array $data): DomainMonitor
    {
        $domainMonitor->update($data);
        return $domainMonitor->refresh();
    }

    public function delete(DomainMonitor $domainMonitor): bool
    {
        return $domainMonitor->delete();
    }
}
