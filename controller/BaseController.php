<?php

class BaseController {
    public function handleAction(bool $result, string $errorMessage): string {
        if ($result) {
            return json_encode([
                'success' => true,
            ]);
        }
        http_response_code(400);
        return json_encode([
            'success' => false,
            'error' => $errorMessage,
        ]);
    }
}