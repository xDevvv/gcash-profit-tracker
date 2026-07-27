<?php

declare(strict_types=1);

namespace App\Core\Services\Audit;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

final class AuditLogger
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    /**
     * Create an audit log entry.
     *
     * @param array<string, mixed> $metadata
     */
    public function log(
        User $user,
        string $module,
        string $action,
        string $description,
        array $metadata = [],
    ): AuditLog {
        return AuditLog::query()->create([
            'user_id' => $user->id,
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'metadata' => $metadata,
        ]);
    }
}
