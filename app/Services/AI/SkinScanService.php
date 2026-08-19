<?php

namespace App\Services\AI;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SkinScanService
{
    protected string $baseUrl;
    protected int $timeout;
    protected string $infoEndpoint;

    public function __construct()
    {
        $this->baseUrl = config('services.ai_skin_diagnosis.base_url', 'https://drhakeemapi-production.up.railway.app');
        $this->timeout = config('services.ai_skin_diagnosis.timeout', 30);
        $this->infoEndpoint = config('services.ai_skin_diagnosis.info_endpoint', '/model-info');
    }

    /**
     * Send skin image to AI model endpoint for diagnosis prediction.
     *
     * @param string|UploadedFile $image File path on disk or UploadedFile instance
     * @param bool $tta Test-Time Augmentation flag
     * @return array
     * @throws Exception
     */
    public function predict(string|UploadedFile $image, bool $tta = true): array
    {
        $url = rtrim($this->baseUrl, '/') . '/predict?tta=' . ($tta ? 'true' : 'false');

        try {
            $request = Http::timeout($this->timeout);

            if ($image instanceof UploadedFile) {
                $fileContents = file_get_contents($image->getRealPath());
                $fileName = $image->getClientOriginalName();
                $request->attach('file', $fileContents, $fileName);
            } else {
                $fileContents = file_get_contents($image);
                $fileName = basename($image);
                $request->attach('file', $fileContents, $fileName);
            }

            $response = $request->post($url);

            if ($response->failed()) {
                Log::error('AI Prediction API Failed', [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw new Exception('فشل الاتصال بخدمة الذكاء الاصطناعي الخارجية: ' . $response->status());
            }

            $data = $response->json();

            if (!isset($data['success']) || $data['success'] !== true) {
                Log::warning('AI Prediction returned unsuccessful payload', [
                    'response' => $data,
                ]);
            }

            return $data;
        } catch (Exception $e) {
            Log::error('AI Prediction Exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Fetch external AI model status and metadata info.
     *
     * @return array
     */
    public function getModelInfo(): array
    {
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($this->infoEndpoint, '/');

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return [
                    'status'  => 'online',
                    'details' => $response->json(),
                ];
            }

            // Fallback attempt to /model-info
            $fallbackUrl = rtrim($this->baseUrl, '/') . '/model-info';
            $fallbackResponse = Http::timeout(10)->get($fallbackUrl);

            if ($fallbackResponse->successful()) {
                return [
                    'status'  => 'online',
                    'details' => $fallbackResponse->json(),
                ];
            }

            return [
                'status'  => 'degraded',
                'code'    => $response->status(),
                'message' => 'تعذر الحصول على معلومات الموديل بنجاح',
            ];
        } catch (Exception $e) {
            Log::error('AI Info Endpoint Error', ['message' => $e->getMessage()]);

            return [
                'status'  => 'offline',
                'message' => $e->getMessage(),
            ];
        }
    }
}
