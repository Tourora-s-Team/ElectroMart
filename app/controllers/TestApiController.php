<?php

class TestApiController
{
    /**
     * Test endpoint for JSON response
     */
    public function test()
    {
        // Clear ALL output buffers to ensure clean JSON
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Disable error display for clean JSON
        ini_set('display_errors', 0);

        try {
            header('Content-Type: application/json');

            echo json_encode([
                'success' => true,
                'message' => 'Test API working',
                'timestamp' => date('Y-m-d H:i:s'),
                'data' => [
                    'status' => 'OK',
                    'version' => '1.0'
                ]
            ]);
            die();

        } catch (Exception $e) {
            // Clear any output in case of error
            while (ob_get_level()) {
                ob_end_clean();
            }

            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Test API error',
                'error' => $e->getMessage()
            ]);
            die();
        }
    }
}
