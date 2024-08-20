<?php

namespace App\Services;

class ResponseService
{
    public function getPaginationResponse($rows, $paginator): array
    {
        return [
            'data' => $rows,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total()
            ]
        ];
    }
}
