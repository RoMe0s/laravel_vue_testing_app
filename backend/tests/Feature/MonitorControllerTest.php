<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\UptimeMonitor\Models\Monitor;

class MonitorControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    // INDEX

    public function test_index_should_throw_unauthorized_exception_when_no_user_is_signed_in()
    {
        $response = $this->getJson('/api/monitors');

        $response->assertUnauthorized();
    }

    public function test_index_should_return_paginated_monitors_when_user_is_signed_in()
    {
        $this->signIn();
        $monitors = factory(Monitor::class, 15)->create();

        $response = $this->getJson('/api/monitors');

        $response->assertJsonFragment([
            'page' => 1,
            'per_page' => 10,
            'total' => 15,
            'monitors' => $monitors->take(10)
                ->map(fn(Monitor $monitor) => [
                    'id' => $monitor->id,
                    'url' => (string)$monitor->url,
                    'last_checked_at' => null,
                    'status' => 'not yet checked',
                    'certificate_status' => 'not yet checked',
                ])->toArray(),
        ]);
    }

    // STORE

    public function test_store_should_throw_unauthorized_exception_when_no_user_is_signed_in()
    {
        $response = $this->postJson('/api/monitors');

        $response->assertUnauthorized();
    }

    public function test_store_should_throw_validation_exception_when_no_data_is_passed()
    {
        $this->signIn();
        $response = $this->postJson('/api/monitors');

        $response->assertJsonValidationErrors(['url']);
    }

    public function test_store_should_throw_validation_exception_when_wrong_data_is_passed()
    {
        $this->signIn();
        $response = $this->postJson('/api/monitors', [
            'url' => 'wrong url string',
        ]);

        $response->assertJsonValidationErrors(['url']);
    }

    public function test_store_should_return_new_monitor_when_right_data_is_passed()
    {
        $this->signIn();
        $response = $this->postJson('/api/monitors', [
            'url' => 'http://test.url',
        ]);

        $response->assertOk()->assertJsonFragment([
            'url' => 'http://test.url',
        ]);
    }

    // DESTROY

    public function test_destroy_should_throw_unauthorized_exception_when_no_user_is_signed_in()
    {
        $response = $this->deleteJson('/api/monitors/1');

        $response->assertUnauthorized();
    }

    public function test_destroy_should_return_not_found_when_wrong_monitor_is_passed()
    {
        $this->signIn();
        $response = $this->deleteJson('/api/monitors/1');

        $response->assertNotFound();
    }

    public function test_destroy_should_return_ok_when_right_monitor_is_passed()
    {
        $this->signIn();
        $monitor = factory(Monitor::class)->create();
        $response = $this->deleteJson('/api/monitors/' . $monitor->id);

        $response->assertOk();
    }

    // CHECK

    public function test_check_should_throw_unauthorized_exception_when_no_user_is_signed_in()
    {
        $response = $this->postJson('/api/monitors/check');

        $response->assertUnauthorized();
    }

    public function test_check_should_throw_validation_exception_when_no_data_is_passed()
    {
        $this->signIn();
        $response = $this->postJson('/api/monitors/check');

        $response->assertJsonValidationErrors(['check_uptime', 'check_certificates']);
    }

    public function test_check_should_return_ok_when_check_uptime_is_passed()
    {
        $this->signIn();
        $response = $this->postJson('/api/monitors/check', [
            'check_uptime' => true,
        ]);

        $response->assertOk();
    }

    public function test_check_should_return_ok_when_check_certificates_is_passed()
    {
        $this->signIn();
        $response = $this->postJson('/api/monitors/check', [
            'check_certificates' => true,
        ]);

        $response->assertOk();
    }
}
