<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProviderPatientFileUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_provider_can_upload_patient_files_when_creating_a_patient(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'provider',
            'is_active' => true,
        ]);

        $provider = Provider::create([
            'user_id' => $user->id,
            'provider_type' => 'doctor',
            'clinic_name' => 'Clínica Test',
            'contact_name' => 'Afiliado Test',
            'first_name' => 'Afiliado',
            'last_name' => 'Test',
            'phone' => '5551234567',
            'email' => 'afiliado@example.com',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->create('expediente.pdf', 128, 'application/pdf');

        $response = $this->actingAs($user)->post(route('provider.patients.store'), [
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'phone' => '5559876543',
            'email' => 'juan@example.com',
            'birth_date' => '1990-01-01',
            'referral_type' => 'consulta_general',
            'files' => [$file],
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Paciente agregado correctamente',
            ]);

        $patient = Patient::where('provider_id', $provider->id)->firstOrFail();
        $patientFile = $patient->files()->firstOrFail();

        $this->assertSame('expediente.pdf', $patientFile->file_name);
        $this->assertSame('application/pdf', $patientFile->file_type);
        Storage::disk('public')->assertExists($patientFile->file_path);
    }
}
