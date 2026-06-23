<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPatientStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_mark_pending_patient_as_no_response(): void
    {
        $admin = $this->adminUser();
        $patient = $this->patient(['status' => 'pendiente']);

        $response = $this->actingAs($admin)->put(route('admin.patients.no-response', $patient));

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame('sin_respuesta', $patient->fresh()->status);
    }

    public function test_no_response_only_applies_from_pending_status(): void
    {
        $admin = $this->adminUser();
        $patient = $this->patient(['status' => 'cita_agendada']);

        $response = $this->actingAs($admin)->put(route('admin.patients.no-response', $patient));

        $response->assertForbidden();
        $this->assertSame('cita_agendada', $patient->fresh()->status);
    }

    public function test_rescheduling_an_existing_appointment_updates_datetime_and_status(): void
    {
        $admin = $this->adminUser();
        $patient = $this->patient([
            'status' => 'cita_agendada',
            'appointment_date' => '2026-07-01',
            'appointment_time' => '09:00',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.patients.schedule', $patient), [
            'appointment_date' => '2026-07-08',
            'appointment_time' => '11:30',
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $patient->refresh();

        $this->assertSame('reagendada', $patient->status);
        $this->assertSame('2026-07-08', $patient->appointment_date->format('Y-m-d'));
        $this->assertSame('11:30', substr($patient->appointment_time, 0, 5));
    }

    private function adminUser(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    private function patient(array $attributes = []): Patient
    {
        $user = User::factory()->create([
            'role' => 'provider',
            'is_active' => true,
        ]);

        $provider = Provider::create([
            'user_id' => $user->id,
            'provider_type' => 'doctor',
            'clinic_name' => 'Clinica Test',
            'contact_name' => 'Afiliado Test',
            'first_name' => 'Afiliado',
            'last_name' => 'Test',
            'phone' => '5551234567',
            'email' => 'afiliado@example.com',
            'is_active' => true,
        ]);

        return Patient::create(array_merge([
            'provider_id' => $provider->id,
            'first_name' => 'Juan',
            'last_name' => 'Perez',
            'phone' => '5559876543',
            'email' => 'juan@example.com',
            'referrer' => 'medico_general',
            'referral_type' => 'consulta_general',
            'status' => 'pendiente',
        ], $attributes));
    }
}
