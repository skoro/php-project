<?php

declare(strict_types=1);

namespace My\Project\Http\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StatusAction implements Action
{
    public function __invoke(Request $request): Response
    {
        return json_response([
            'status' => 'ok',
            'php' => [
                'ver'    => PHP_VERSION,
                'time'   => defined('START_TIME') ? (hrtime(true) - START_TIME)/1e+6 : null,
                'memory' => number_format(memory_get_peak_usage()),
            ],
            'disk'     => $this->getDiskStats(),
            'sysload'  => sys_getloadavg(),
        ]);
    }

    /**
     * @return array{"total":string, "free":string, "used":string, "used_%":integer}
     */
    private function getDiskStats(): array
    {
        $total = ceil((disk_total_space('/') / 1024) / 1024);
        $free = ceil((disk_free_space('/') / 1024) / 1024);
        $used = $total - $free;

        return [
            'total'  => number_format($total),
            'free'   => number_format($free),
            'used'   => number_format($used),
            'used_%' => (int)ceil(($used/$total)*100),
        ];
    }
}
