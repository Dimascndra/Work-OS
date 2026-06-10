<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortScannerTest extends TestCase
{
    public function test_port_scanner_index_page_loads()
    {
        $response = $this->get(route('port-scanner.index'));
        $response->assertStatus(200);
        $response->assertSee('Pemindai Port Jaringan');
        $response->assertSee('Tentang Alat');
    }

    public function test_port_scanner_validation_fails_for_invalid_target()
    {
        $response = $this->post(route('port-scanner.scan'), [
            'target' => 'invalid-target!!'
        ]);

        $response->assertSessionHasErrors(['target']);
    }

    public function test_port_scanner_ajax_validation_fails_for_invalid_target()
    {
        $response = $this->postJson(route('port-scanner.scan'), [
            'target' => 'invalid-target!!'
        ], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertJson([
            'success' => false,
            'error' => 'Target IP atau Domain tidak valid.'
        ]);
    }

    public function test_port_scanner_performs_scan_on_localhost()
    {
        // Scan localhost (should run fast)
        $response = $this->post(route('port-scanner.scan'), [
            'target' => '127.0.0.1'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('port_result');

        $result = session('port_result');
        $this->assertEquals('127.0.0.1', $result['target']);
        $this->assertCount(12, $result['ports']);
    }

    public function test_port_scanner_performs_ajax_scan_on_localhost()
    {
        $response = $this->postJson(route('port-scanner.scan'), [
            'target' => '127.0.0.1'
        ], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'html'
        ]);
        $this->assertTrue($response['success']);
        $this->assertStringContainsString('Hasil Pemindaian untuk 127.0.0.1', $response['html']);
    }
}
