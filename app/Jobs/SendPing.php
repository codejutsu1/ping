<?php

namespace App\Jobs;

use App\Models\Check;
use App\Models\Report;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPing implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Check $check
    ) {}

    public function handle(DatabaseManager $database): void
    {
        $start = now();

        $request = Http::baseUrl(
            url: $this->check->service->url
        );

        if ($this->check->credential) {
            //Attach the credentials to the request
        }

        if ($this->check->parameters) {
            $request->withQueryParameters(
                parameters: $this->check->parameters,
            );
        }

        if ($this->check->headers) {
            $request->withHeaders(
                headers: $this->check->headers->toArray(),
            );
        }

        try {
            $response = $request->send(
                method: $this->check->method,
                url: $this->check->path,
                options: [
                    'json' => $this->check->json,
                ]
            );
        } catch (\Throwable $th) {
        }

        $stats = $response->transferStats->getHandlerStats();

        $database->transaction(
            callback: fn() => $this->check->reports()->create(
                attributes: [
                    'url' => $stats['url'],
                    'content_type' => $stats['content_type'],
                    'status' => $stats['http_code'],
                    'header_size' => $stats['header_size'],
                    'request_size' => $stats['request_size'],
                    'redirect_count' => $stats['redirect_count'],
                    'http_version' => $stats['http_version'],
                    'appconnect_time' => $stats['appconnect_time_us'],
                    'connect_time' => $stats['connect_time_us'],
                    'namelookup_time' => $stats['namelookup_time_us'],
                    'pretransfer_time' => $stats['pretransfer_time_us'],
                    'redirect_time' => $stats['redirect_time_us'],
                    'starttransfer_time' => $stats['starttransfer_time_us'],
                    'total_time' => $stats['total_time_us'],
                    'started_at' => $start,
                    'finished_at' => now(),
                ],
            ),

            attempts: 3,
        );
    }
}