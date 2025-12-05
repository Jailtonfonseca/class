<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * Test the directory traversal vulnerability in revert method.
     */
    public function test_revert_method_vulnerability()
    {
        // 1. Create a dummy file that should NOT be deleted.
        $targetFileName = 'vulnerable_test.txt';
        $targetFile = base_path($targetFileName);
        File::put($targetFile, 'This file should not be deleted');

        $this->assertTrue(File::exists($targetFile), 'Target file was not created');

        // 2. Construct the malicious payload.
        // We assume we are trying to traverse up from storage/products/thumb/
        // Depending on where base_path is relative to public/storage/products/thumb/,
        // we use enough ../ to get to the root.
        $payload = '../../../../' . $targetFileName;

        // 3. Make the request using $this->call to properly send raw body content
        $response = $this->call('POST', '/posts/revert', [], [], [], ['CONTENT_TYPE' => 'text/plain'], $payload);

        // 4. Assert response
        $response->assertStatus(200);

        // 5. Assert the file still exists (This confirms the vulnerability is fixed)
        $this->assertTrue(File::exists($targetFile), 'Vulnerability fixed: File was NOT deleted via path traversal');

        // Cleanup
        if (File::exists($targetFile)) {
            File::delete($targetFile);
        }
    }
}
