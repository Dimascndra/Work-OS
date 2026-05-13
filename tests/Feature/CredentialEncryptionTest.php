<?php

namespace Tests\Feature;

use App\Models\Credential;
use Tests\TestCase;

class CredentialEncryptionTest extends TestCase
{
    public function test_credential_passwords_are_encrypted_and_read_back(): void
    {
        $credential = new Credential();

        $credential->password = 'secret-password';

        $this->assertNotSame('secret-password', $credential->getAttributes()['password']);
        $this->assertSame('secret-password', $credential->password);
        $this->assertTrue($credential->passwordIsDecryptable());
    }

    public function test_invalid_encrypted_values_do_not_throw_when_read(): void
    {
        $credential = new Credential();
        $credential->setRawAttributes([
            'password' => 'not-a-valid-encrypted-payload',
            'notes' => 'not-a-valid-encrypted-payload',
        ]);

        $this->assertNull($credential->password);
        $this->assertNull($credential->notes);
        $this->assertFalse($credential->passwordIsDecryptable());
        $this->assertFalse($credential->notesIsDecryptable());
    }
}
